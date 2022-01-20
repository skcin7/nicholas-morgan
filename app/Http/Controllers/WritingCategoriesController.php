<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WritingCategory;

class WritingCategoriesController extends Controller
{
    /**
     * Generate the eloquent query for retrieving records from the database
     *
     * @param $request
     * @return mixed
     */
    private function getWritingCategoriesQuery($request)
    {
        $writingCategoriesQuery = WritingCategory::query();

        // Ordering behavior for the matched records
        switch(strtoupper($request->input('order'))) {
            case 'NEWEST':
            default:
                $writingCategoriesQuery->orderBy('id', 'DESC');
                break;
            case 'OLDEST':
                $writingCategoriesQuery->orderBy('id', 'ASC');
                break;
            case 'RANDOM':
                $writingCategoriesQuery->inRandomOrder();
                break;
        }

        // If additional relationships are specified to be included with the response, define them here
        if($request->input('include') && strlen($request->input('include')) > 0) {
            foreach(array_intersect(explode(",", $request->input('include')), WritingCategory::getAvailableIncludes()) as $thisInclude) {
                $writingCategoriesQuery->with($thisInclude);
            }
        }

        // Change the number of results to show per page of search results
        if($request->input('per_page') && strlen($request->input('per_page')) > 0) {
            $this->setPerPageAmount($request->input('per_page'));
        }

        return $writingCategoriesQuery;
    }

    /**
     * Show the writings administration page.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function admin(Request $request)
    {
        $writingCategoriesQuery = $this->getWritingCategoriesQuery($request);

        // Get the matched records into paginated results
        $writingCategories = $writingCategoriesQuery->paginate($this->getPerPageAmount());

        return view('admin.writing_categories')
            ->with('title_prefix', 'Admin - Manage Writing Categories')
            ->with('writingCategories', $writingCategories);
    }

    /**
     * Create a new writing category.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $request->validate(WritingCategory::getValidationRules());

        $writingCategory = new WritingCategory();
        $writingCategory->fill([
            'name' => $request->input('name'),
        ]);
        $writingCategory->save();

        return redirect()->route('admin.writing_categories')
            ->with('flash_message', [
                'message' => 'The writing category has been created successfully.',
                'type' => 'success',
            ]);
    }

    /**
     * Get a writing category by its name.
     *
     * @param $name
     * @param $request
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    private function getWritingCategoryByName($name)
    {
        $writingCategoryQuery = WritingCategory::query();

        // We use "RANDOM" as a special id value to denote we want to retrieve a random release.
        // Otherwise, we retrieve the release by the corresponding ID.
        if($name === "RANDOM") {
            $writingCategoryQuery->inRandomOrder();
        }
        else {
            $writingCategoryQuery->where('name', $name);
        }

        return $writingCategoryQuery->firstOrFail();
    }

    /**
     * Update a writing category.
     *
     * @param Request $request
     * @param $name
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Request $request, $name)
    {
        $request->validate(WritingCategory::getValidationRules());

        $writingCategory = $this->getWritingCategoryByName($name);

        $writingCategory->fill([
            'name' => $request->input('name'),
        ]);
        $writingCategory->save();

        return redirect()->route('admin.writing_categories')
            ->with('flash_message', [
                'message' => 'The writing category has been updated successfully.',
                'type' => 'success',
            ]);
    }

    /**
     * Delete a writing category.
     *
     * @param Request $request
     * @param $name
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete(Request $request, $name)
    {
        $writingCategory = $this->getWritingCategoryByName($name);

        $writingCategory->delete();

        return redirect()->route('admin.writing_categories')
            ->with('flash_message', [
                'message' => 'The writing category has been deleted successfully.',
                'type' => 'success',
            ]);
    }

}
