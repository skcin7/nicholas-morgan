<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Writing;

class WritingController extends Controller
{
    /**
     * Show the writings.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $writingsQuery = Writing::query();

        // if the request has a custom per_page value, use it to set the amount to show per page
        if($request->has('per_page')) {
            $this->setPerPageAmount($request->input('per_page'));
        }

        $writings = $writingsQuery->paginate($this->getPerPageAmount());

        return view('writings')
            ->with('writings', $writings)
            ->with('title_prefix', 'Writing');
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
        $writing->save();

        return redirect()->route('writing.writing', ['id' => $writing->getSlug()])
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
     * Update a writing.
     *
     * @param Request $request
     * @param $id
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function update(Request $request, $id)
    {
        $writing = $this->getWritingById($id);

        return view('writing_edit')
            ->with('writing', $writing)
            ->with('title_prefix', 'Update ' . $writing->title);
    }

    /**
     * Process updating a writing.
     *
     * @param Request $request
     * @param $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function processUpdate(Request $request, $id)
    {
        $request->validate($this->validationRules());

        $writing = $this->getWritingById($id);
        $writing->fill($request->input());
        $writing->save();

        return redirect()->route('writing.writing', ['id' => $writing->getSlug()])
            ->with('flash_message', [
                'message' => $this->getCompletedSuccessfullyMessage('writing', 'updated'),
                'type' => 'success',
            ]);
    }


}
