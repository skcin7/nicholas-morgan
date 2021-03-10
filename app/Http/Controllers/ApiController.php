<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use App\Passport\Client;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApiController extends Controller
{
    /**
     * A general message to say hello.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function hello(Request $request)
    {
        return $this->respondWithJson(
            null,
            'Hello!'
        );
    }

    /**
     * Show a protected route.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function protected()
    {
        return $this->respondWithJson(
            null,
            'You are indeed able to access this protected route. Enjoy!'
        );
    }

    /**
     * Show the user that is accessing this protected route.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function user(Request $request)
    {
        return $this->respondWithJson(
            UserResource::make($request->user()),
            'This is the user that is accessing this protected route. Enjoy!'
        );
    }


}
