<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Avatar;

class AvatarsController extends Controller
{
    /**
     * Generate the eloquent query for retrieving records from the database
     *
     * @param $request
     * @return mixed
     */
    private function getAvatarsQuery($request)
    {
        $avatarsQuery = Avatar::query();

        // Ordering behavior for the matched records
        switch(strtoupper($request->input('order'))) {
            case 'NEWEST':
            default:
                $avatarsQuery->orderBy('id', 'DESC');
                break;
            case 'OLDEST':
                $avatarsQuery->orderBy('id', 'ASC');
                break;
            case 'RANDOM':
                $avatarsQuery->inRandomOrder();
                break;
        }

        // If additional relationships are specified to be included with the response, define them here
        if($request->input('include') && strlen($request->input('include')) > 0) {
            foreach(array_intersect(explode(",", $request->input('include')), Avatar::getAvailableIncludes()) as $thisInclude) {
                $avatarsQuery->with($thisInclude);
            }
        }

        // Change the number of results to show per page of search results
        if($request->input('per_page') && strlen($request->input('per_page')) > 0) {
            $this->setPerPageAmount($request->input('per_page'));
        }

        return $avatarsQuery;
    }

    /**
     * Show the avatars administration page.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function admin(Request $request)
    {
        $avatarsQuery = $this->getAvatarsQuery($request);

        // Get the matched records into paginated results
        $avatars = $avatarsQuery->paginate($this->getPerPageAmount());

        return view('admin_avatars')
            ->with('title_prefix', 'Admin - Avatars')
            ->with('avatars', $avatars);
    }

    /**
     * Process creating a writing.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $request->validate(Avatar::getValidationRules());

        // Additional validation to ensure that the avatar file being uploaded is correct.
        $request->validate([
            'avatar_file' => [
                'required',
                'file',
                'image',
            ],
        ]);

        $avatar = new Avatar();
        $avatar->fill([
            'name' => $request->input('name', ''),
            'summary' => $request->input('summary', ''),
        ]);

        // Handle file Upload
        if($request->hasFile('avatar_file')) {

            //Storage::delete('/public/avatars/'.$user->avatar);

            // Get filename with the extension
            $filenameWithExt = $request->file('avatar_file')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('avatar_file')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename . '.' . $extension;
            // Upload Image
            $path = $request->file('avatar_file')->storeAs('public/avatars', $fileNameToStore);

            $avatar->filename = $fileNameToStore;
        }

        $avatar->save();

        return redirect()->route('admin.avatars')
            ->with('flash_message', [
                'message' => 'The avatar has been created successfully!',
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
    private function getAvatarByID($id)
    {
        $avatarQuery = Avatar::query();

        // We use "RANDOM" as a special id value to denote we want to retrieve a random release.
        // Otherwise, we retrieve the release by the corresponding ID.
        if($id === "RANDOM") {
            $avatarQuery->inRandomOrder();
        }
        else {
            $avatarQuery->where('id', $id);
        }

        return $avatarQuery->firstOrFail();
    }

//    /**
//     * Show an avatar.
//     *
//     * @param Request $request
//     * @param $id
//     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
//     */
//    public function show(Request $request, $id)
//    {
//        $avatar = $this->getAvatarByID($id);
//
//        return view('writing')
//            ->with('writing', $avatar)
//            ->with('title_prefix', $avatar->title);
//    }

    /**
     * Update an avatar..
     *
     * @param Request $request
     * @param $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Request $request, $id)
    {
        $request->validate(Avatar::getValidationRules());

        $avatar = $this->getAvatarByID($id);

        $avatar->fill([
            'name' => $request->input('name', ''),
            'summary' => $request->input('summary', ''),
        ]);
        $avatar->save();

        return redirect()->route('admin.avatars')
            ->with('flash_message', [
                'message' => 'The avatar has been updated successfully!',
                'type' => 'success',
            ]);
    }

    /**
     * Delete an avatar.
     *
     * @param Request $request
     * @param $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete(Request $request, $id)
    {
        $avatar = $this->getAvatarByID($id);
        $avatar->delete();

        return redirect()->route('admin.avatars')
            ->with('flash_message', [
                'message' => 'The avatar has been successfully deleted!',
                'type' => 'success',
            ]);
    }


}
