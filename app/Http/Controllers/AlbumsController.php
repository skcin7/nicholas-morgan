<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Album;
use App\Http\Resources\Album as AlbumResource;
use App\Http\Resources\AlbumCollection;

class AlbumsController extends Controller
{
    /**
     * Show the albums index.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $albumsQuery = Album::query();

        switch(strtoupper($request->input('order_by'))) {
            case 'NEWEST':
            default:
                $albumsQuery->orderBy('created_at', 'desc');
                break;
            case 'OLDEST':
                $albumsQuery->orderBy('created_at', 'asc');
                break;
            case 'RANDOM':
                $albumsQuery->inRandomOrder();
                break;
        }

        // if the request has a custom per_page value, use it to set the amount to show per page
        if($request->has('per_page')) {
            $this->setPerPageAmount($request->input('per_page'));
        }

        $albums = $albumsQuery->paginate($this->getPerPageAmount());

        if($request->expectsJson()) {
            return $this->respondWithJson(
                new AlbumsCollection($albums),
                number_format($albums->total()) . ' total ' . ($albums->total() === 1 ? 'album was' : 'albums were') . ' found (showing ' . $albums->perPage() . ' per page).',
                200
            );
        }

        return view('albums')
            ->with('albums', $albums)
            ->with('title_prefix', 'Albums I Endorse');
    }

    /**
     * Get an album by its ID.
     *
     * @param $id
     * @param $request
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    private function getAlbumByID($id, $request)
    {
        $albumQuery = Album::query();

        // We use "RANDOM" as a special id value to denote we want to retrieve a random entry
        // Otherwise, we retrieve the entry by the corresponding ID
        if($id === "RANDOM") {
            $albumQuery->inRandomOrder();
        }
        else {
            $id = slug_parts($id, 0, '-');
            $albumQuery->where('id', $id);
        }

        return $albumQuery->firstOrFail();
    }

    /**
     * Get an album
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request, $id)
    {
        $album = $this->getAlbumByID($id, $request);

        return $this->respondWithJson(
            new AlbumResource($album),
            'The album has been successfully retrieved!',
            200
        );
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
            'artist' => [
                'required',
                'string',
            ],
            'year' => [
                'required',
                'string',
            ],
            'blurb' => [
                'nullable',
                'string',
            ],
            'cover' => [
                'nullable',
                'image',
            ],
        ];
    }

    /**
     * Creating an album.
     *
     * @param Request $request
     * @param $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request, $id = null)
    {
        // If an ID is set, then assume we want to update an existing album based on that ID
        if(! is_null($id)) {
            return $this->update($request, $id);
        }

        $request->validate($this->validationRules());

        $album = new Album();
        $album->fill($request->input());
        $album->save();

        if($request->hasFile('cover')) {
            $album->uploadCover($request->file('cover'));
        }

        return $this->respondWithJson(
            new AlbumResource($album),
            'The album has been successfully created!',
            201
        );
    }

    /**
     * Update an existing album
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate($this->validationRules());

        $album = $this->getAlbumByID($id, $request);

        // First check to see if it's being deleted, and if so delete
        if($request->input('delete_album')) {
            return $this->delete($request, $id);
        }

        $album->fill($request->only([
            'title',
            'artist',
            'year',
            'blurb',
        ]));
        $album->save();

        if($request->hasFile('cover')) {
            $album->uploadCover($request->file('cover'));
        }

        return $this->respondWithJson(
            new AlbumResource($album),
            'The album has been successfully updated!',
            200
        );
    }

    /**
     * Delete an album.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete(Request $request, $id)
    {
        $album = $this->getAlbumByID($id, $request);
        $album->delete();

        return $this->respondWithJson(
            new AlbumResource($album),
            'The album has been successfully deleted!',
            200
        );
    }


}
