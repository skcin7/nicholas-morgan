<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlphabetizerController extends Controller
{
    /**
     * Show the alphabetizer index page
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('alphabetizer')
            ->with('title_prefix', 'Alphabetizer');
    }

}
