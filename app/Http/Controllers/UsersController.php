<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    /**
     * Show the users.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $usersQuery = User::query();

        // if the request has a custom per_page value, use it to set the amount to show per page
        if($request->has('per_page')) {
            $this->setPerPageAmount($request->input('per_page'));
        }

        $users = $usersQuery->paginate($this->getPerPageAmount());

        return view('users')
            ->with('users', $users)
            ->with('title_prefix', 'Users');
    }



    /**
     * Get a user by their ID.
     *
     * @param $id
     * @param $request
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    private function getUserById($id)
    {
        $userQuery = User::query();

        // We use "RANDOM" as a special id value to denote we want to retrieve a random release.
        // Otherwise, we retrieve the release by the corresponding ID.
        if($id === "RANDOM") {
            $userQuery->inRandomOrder();
        }
        else {
            $userQuery->where('name', $id);
        }

        return $userQuery->firstOrFail();
    }

    /**
     * Get a user.
     *
     * @param Request $request
     * @param $id
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function get(Request $request, $id)
    {
        $user = $this->getUserById($id);
        return $user; // temporary

//        return $this->respondWithJson(
//            new UserResource($user),
//            $this->getCompletedSuccessfullyMessage('user', 'retrieved'),
//            200
//        );

//        return view('user')
//            ->with('user', $user)
//            ->with('title_prefix', '@' . $user->name);
    }

    /**
     * Get a user's secret data.
     *
     * @param Request $request
     * @param $id
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function secret(Request $request, $id)
    {
        if(! mastermind()) {
            abort(404);
        }

        $user = $this->getUserById($id);
        return $this->respondWithJson(
            json_decode(decrypt($user->secret_json)),
            'Retrieved secret data for @' . $user->name . '.',
            200
        );
    }

    /**
     * Get a user's logins.
     *
     * @param Request $request
     * @param $id
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function logins(Request $request, $id)
    {
        if(! mastermind()) {
            abort(404);
        }

        $user = $this->getUserById($id);
        return $this->respondWithJson(
            $user->logins,
            'Retrieved logins for @' . $user->name . '.',
            200
        );
    }


}
