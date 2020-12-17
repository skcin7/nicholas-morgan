<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Writing;

class WritingsController extends Controller
{
    /**
     * Show the writings index.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $writingsQuery = Writing::query();

        if(admin()) {
            $writingsQuery->withTrashed();
        }

        if(! admin()) {
            $writingsQuery->where('is_published', true);
        }

        switch(strtoupper($request->input('order_by'))) {
            case 'NEWEST':
            default:
                $writingsQuery->orderBy('created_at', 'desc');
                break;
            case 'OLDEST':
                $writingsQuery->orderBy('created_at', 'asc');
                break;
            case 'RANDOM':
                $writingsQuery->inRandomOrder();
                break;
        }

        // if the request has a custom per_page value, use it to set the amount to show per page
        if($request->has('per_page')) {
            $this->setPerPageAmount($request->input('per_page'));
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
            ->with('title_prefix', 'My Writings');
    }

    /**
     * Retrieve the validation rules which all writing must pass.
     *
     * @return array
     */
    private function validationRules()
    {
        return [
            'title' => [
                'required',
                'string',
            ],
            'body' => [
                'required',
                'string',
            ],
            'is_published' => [
                'nullable',
            ],
        ];
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
        $request->validate($this->validationRules());

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

        if(admin()) {
            $writingQuery->withTrashed();
        }

        if(! admin()) {
            $writingQuery->where('is_published', true);
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
    public function writing(Request $request, $id)
    {
        $writing = $this->getWritingById($id);

        return view('writing')
            ->with('writing', $writing)
            ->with('title_prefix', $writing->title);
    }

    /**
     * Edit a writing.
     *
     * @param Request $request
     * @param $id
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function edit(Request $request, $id)
    {
        $writing = $this->getWritingById($id);

        return view('writing_edit')
            ->with('writing', $writing)
            ->with('title_prefix', 'Edit ' . $writing->title);
    }

    /**
     * Process editing a writing.
     *
     * @param Request $request
     * @param $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function processEdit(Request $request, $id)
    {
        $request->validate($this->validationRules());

        $writing = $this->getWritingById($id);

        if($request->input('cancel')) {
            return redirect()->route('writings.writing', ['id' => $writing->getSlug()]);
        }

        //dd($request->input('is_published'));

        $writing->fill($request->input());
        $writing->is_published = filter_var($request->input('is_published'), FILTER_VALIDATE_BOOL);
        $writing->save();

        return redirect()->route('writings.writing.edit', ['id' => $writing->getSlug()])
            ->with('flash_message', [
                'message' => $this->getCompletedSuccessfullyMessage('writing', 'updated'),
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

        return redirect()->route('writings', ['id' => $writing->getSlug()])
            ->with('flash_message', [
                'message' => 'The writing has been permanently deleted!',
                'type' => 'success',
            ]);
    }


}
