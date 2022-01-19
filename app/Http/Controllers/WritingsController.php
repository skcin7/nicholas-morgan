<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Writing;

class WritingsController extends Controller
{
    /**
     * Generate the eloquent query for retrieving records from the database
     *
     * @param $request
     * @return mixed
     */
    private function getWritingsQuery($request)
    {
        $writingsQuery = Writing::query();

        // Ordering behavior for the matched records
        switch(strtoupper($request->input('order'))) {
            case 'NEWEST':
                $writingsQuery->orderBy('id', 'DESC');
                break;
            case 'OLDEST':
            default:
                $writingsQuery->orderBy('id', 'ASC');
                break;
            case 'RANDOM':
                $writingsQuery->inRandomOrder();
                break;
        }

        // If additional relationships are specified to be included with the response, define them here
        if($request->input('include') && strlen($request->input('include')) > 0) {
            foreach(array_intersect(explode(",", $request->input('include')), Writing::getAvailableIncludes()) as $thisInclude) {
                $writingsQuery->with($thisInclude);
            }
        }

        // Change the number of results to show per page of search results
        if($request->input('per_page') && strlen($request->input('per_page')) > 0) {
            $this->setPerPageAmount($request->input('per_page'));
        }

        return $writingsQuery;
    }

    /**
     * Show the writings administration page.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function admin(Request $request)
    {
        $writingsQuery = $this->getWritingsQuery($request);

        // Get the matched records into paginated results
        $writings = $writingsQuery->paginate($this->getPerPageAmount());

        return view('admin.writings')
            ->with('title_prefix', 'Admin - Manage Writings')
            ->with('writings', $writings);
    }




    /**
     * Show the writings index.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $writingsQuery = $this->getWritingsQuery($request);

        // When not admin, only show the writings that should be shown.
        if(! admin()) {
            $writingsQuery->where('is_published', true)
                ->where('is_hidden', false)
                ->where('is_unlisted', false);
        }

        // Include trashed writings for admins.
        if(admin()) {
            $writingsQuery->withTrashed();
        }

        $writings = $writingsQuery->paginate($this->getPerPageAmount());

        // Put the writings into groups based on the year.
        $writings_by_years = [];
        if($writings->count()) {
            foreach($writings as $writing) {
                $year = $writing->created_at->format('Y');
                if(! isset($writings_by_years[$year])) {
                    $writings_by_years[$year] = [];
                }
                $writings_by_years[$year][] = $writing;
            }
        }

        return view('writings')
            ->with('writings', $writings)
            ->with('writings_by_years', $writings_by_years)
            ->with('title_prefix', 'Writings');
    }

    /**
     * Create a writing.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $writing = new Writing();

        return view('writing_edit')
            ->with('writing', $writing)
            ->with('title_prefix', 'Create Writing');
    }

    /**
     * Process creating a writing.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function processCreate(Request $request)
    {
        $request->validate(Writing::getValidationRules());

        $writing = new Writing();
        $writing->fill($request->input());
        $writing->is_published = filter_var($request->input('is_published'), FILTER_VALIDATE_BOOL);
        $writing->save();

        return redirect()->route('writings.writing', ['id' => $writing->getSlug()])
            ->with('flash_message', [
                'message' => $this->getCompletedSuccessfullyMessage('writing', 'created'),
                'type' => 'success',
            ]);
    }

    /**
     * Get writing by ID.
     *
     * @param $id
     * @param $request
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    private function getWritingById($id)
    {
        $writingQuery = Writing::query();

        // Include trashed (deleted) writings too but only for admins.
        if(admin()) {
            $writingQuery->withTrashed();
        }

        // If user is not an admin, then require the writing to be published in order to show it.
        if(! admin()) {
            // But also if writing is forced to be shown, then don't require it to be published anyway even for non-admins.
            if(! request()->input('show_unpublished')) {
                $writingQuery->where('is_published', true);
            }
        }

        // We use "RANDOM" as a special id value to denote we want to retrieve a random release.
        // Otherwise, we retrieve the release by the corresponding ID.
        if($id === "RANDOM") {
            $writingQuery->inRandomOrder();
        }
        else {
            $id = slug_parts($id, 0, '-');
            $writingQuery->where('id', $id);
        }

        return $writingQuery->firstOrFail();
    }

    /**
     * Show a writing.
     *
     * @param Request $request
     * @param $id
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function show(Request $request, $id)
    {
        $writing = $this->getWritingById($id);

        // If not published or hidden, show a 404 error if user is not an admin.
        if(! admin()) {
            if(! $writing->isPublished() || $writing->isHidden()) {
                abort(404, 'Writing could not be found.');
            }
        }

        return view('writing')
            ->with('writing', $writing)
            ->with('title_prefix', $writing->title);
    }

    /**
     * Show a writing to be edited.
     *
     * @param Request $request
     * @param $id
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function showEdit(Request $request, $id)
    {
        $writing = $this->getWritingById($id);

        return view('writing_edit')
            ->with('writing', $writing)
            ->with('title_prefix', 'Editing ' . $writing->title);
    }

//    /**
//     * Edit a writing.
//     *
//     * @param Request $request
//     * @param $id
//     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
//     */
//    public function edit(Request $request, $id)
//    {
//        $writing = $this->getWritingById($id);
//
//        return view('writing_edit')
//            ->with('writing', $writing)
//            ->with('title_prefix', 'Edit ' . $writing->title);
//    }

    /**
     * Process editing a writing.
     *
     * @param Request $request
     * @param $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Request $request, $id)
    {
        $request->validate(Writing::getValidationRules());

        $writing = $this->getWritingById($id);

//        if($request->input('cancel')) {
//            return redirect()->route('writings.writing', ['id' => $writing->getSlug()]);
//        }

        //dd($request->input('is_published'));

        $writing->fill([
            'title' => $request->input('title'),
            'is_published' => $request->input('is_published'),
            'is_hidden' => $request->input('is_hidden'),
            'is_unlisted' => $request->input('is_unlisted'),
//            'is_trashed' => filter_var($request->input('is_trashed'), FILTER_VALIDATE_BOOL),
            'body_html' => $request->input('body_html'),
            'css' => $request->input('css'),
        ]);
        $writing->save();

        if($request->input('trashed')) {
            $writing->delete();
        }

        return redirect()->route('writing.showEdit', ['id' => $writing->getSlug()])
            ->with('flash_message', [
                'message' => 'The writing has been updated successfully.',
                'type' => 'success',
            ]);
    }

    /**
     * Move a writing to the trash.
     *
     * @param Request $request
     * @param $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function trash(Request $request, $id)
    {
        $writing = $this->getWritingById($id);
        $writing->delete();

        return redirect()->route('writings.writing', ['id' => $writing->getSlug()])
            ->with('flash_message', [
                'message' => 'The writing has been moved to the trash!',
                'type' => 'success',
            ]);
    }

    /**
     * Remove a writing from the trash.
     *
     * @param Request $request
     * @param $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function untrash(Request $request, $id)
    {
        $writing = $this->getWritingById($id);
        $writing->restore();

        return redirect()->route('writings.writing', ['id' => $writing->getSlug()])
            ->with('flash_message', [
                'message' => 'The writing has been removed from the trash!',
                'type' => 'success',
            ]);
    }

    /**
     * Permanently delete a writing.
     *
     * @param Request $request
     * @param $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function permanentlyDelete(Request $request, $id)
    {
        $writing = $this->getWritingById($id);
        $writing->forceDelete();

        return redirect()->route('writings')
            ->with('flash_message', [
                'message' => 'The writing has been permanently deleted.',
                'type' => 'success',
            ]);
    }


}
