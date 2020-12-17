<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class AppController extends Controller
{
    /**
     * Show the welcome page.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function welcome(Request $request)
    {
        return view('welcome');
    }

    /**
     * Show the contact page.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contact(Request $request)
    {
        return view('contact')
            ->with('title_prefix', 'How To Contact');
    }

    /**
     * Show the about page.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about(Request $request)
    {
        return view('about')
            ->with('title_prefix', 'About');
    }

    /**
     * Show the PGP key page.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pgp(Request $request)
    {
        $public_key = Storage::disk('local')->get('public.gpg');
        $fingerprint = "26F6 9EDA 6E47 65BA A077  C2E8 EC71 B630 B7F7 377D";

        return view('pgp')
            ->with('public_key', $public_key)
            ->with('fingerprint', $fingerprint)
            ->with('title_prefix', 'PGP');
    }
}
