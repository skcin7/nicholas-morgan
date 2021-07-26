<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookmarklet;
use App\Http\Resources\Bookmarklet as BookmarkletResource;
use App\Http\Resources\BookmarkletCollection;

class BookmarkletsController extends Controller
{
    /**
     * Show the alphabetizer index page
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $matched_bookmarklets_query = $this->retrieveManyEntitiesQuery(Bookmarklet::class, $request->only([
            'name',
            'javascript_code',
            'status',
        ]), $eager_load = $request->input('include', []), $order_by = $request->input('order_by', 'created_at'));
        $matched_bookmarklets_query->where('status', '!=', 'DISABLED');
        $matched_bookmarklets = $matched_bookmarklets_query->get();

        // API response:
        if($request->expectsJson()) {
            return $this->respondWithJson(
                new BookmarkletCollection($matched_bookmarklets),
                number_format($matched_bookmarklets->total()) . ' matched bookmarklet ' . ($matched_bookmarklets->total() === 1 ? 'record was' : 'records were') . ' found  (showing ' . $matched_bookmarklets->perPage() . ' per page)!',
                200
            );
        }

        // Regular HTTP response:
        return view('bookmarklets')
            ->with('title_prefix', 'Bookmarklets')
            ->with('bookmarklets', $matched_bookmarklets);
    }

    /**
     * Get a single Bookmarklet.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request, $id)
    {
        $bookmarklet = $this->retrieveSingleEntity(Bookmarklet::class, $id, 'id', []);

        // API response:
        if($request->expectsJson()) {
            return $this->respondWithJson(
                new BookmarkletResource($bookmarklet),
                'The bookmarklet has been successfully retrieved!',
                200
            );
        }

        // Regular HTTP response:
        dd('TODO');
    }

    /**
     * Get a random Bookmarklet.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRandom(Request $request)
    {
        $random_bookmarklet = $this->retrieveSingleEntity(Bookmarklet::model, 'RANDOM', 'id', []);

        // API response:
        if($request->expectsJson()) {
            return $this->respondWithJson(
                new BookmarkletResource($random_bookmarklet),
                'The random bookmarklet has been successfully retrieved!',
                200
            );
        }

        // Regular HTTP response:
        dd('TODO');
    }

    /**
     * Create a Bookmarklet.
     *
     * @param Request $request
     * @param int|null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request, $id = null)
    {
        // If an ID is passed, then just update it instead.
        if(! is_null($id)) {
            return $this->update($request, $id);
        }

        $request->validate([
            'name' => [
                'required',
                'string',
            ],
            'javascript_code' => [
                'required',
                'string',
            ],
            'status' => [
                'required',
                'string',
                'in:ENABLED,ENABLED_ONLY_FOR_ADMINS,DISABLED',
            ],
        ]);

        $bookmarklet = new Bookmarklet();
        $bookmarklet->fill($request->only([
            'name',
            'javascript_code',
            'status',
        ]));
        $bookmarklet->save();

        if($request->expectsJson()) {
            return $this->respondWithJson(
                new BookmarkletResource($bookmarklet),
                'The bookmarklet has been successfully created!',
                201
            );
        }
    }

    /**
     * Update a Bookmarklet.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
            ],
            'javascript_code' => [
                'required',
                'string',
            ],
            'status' => [
                'required',
                'string',
                'in:ENABLED,ENABLED_ONLY_FOR_ADMINS,DISABLED',
            ],
        ]);

        $bookmarklet = $this->retrieveSingleEntity(Bookmarklet::class, $id, 'id');
        $bookmarklet->fill($request->only([
            'name',
            'javascript_code',
            'status',
        ]));
        $bookmarklet->save();

        if($request->expectsJson()) {
            return $this->respondWithJson(
                new BookmarkletResource($bookmarklet),
                'The bookmarklet has been successfully updated!',
                200
            );
        }
    }

    /**
     * Delete a Bookmarklet.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, $id)
    {
        $bookmarklet = $this->retrieveSingleEntity(Bookmarklet::class, $id, 'id');
        $bookmarklet->delete();

        if($request->expectsJson()) {
            return $this->respondWithJson(
                new BookmarkletResource($bookmarklet),
                'The bookmarklet has been successfully deleted!',
                200
            );
        }
    }

}
