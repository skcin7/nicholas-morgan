<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookmarklet;
use App\Http\Resources\Bookmarklet as BookmarkletResource;
use App\Http\Resources\BookmarkletCollection;

class ExamplesController extends Controller
{
    /**
     * Show the examples index page
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('examples')
            ->with('title_prefix', 'Examples');
    }

    public function menubar(Request $request)
    {
        return view('examples_menubar')
            ->with('title_prefix', 'Menubar');
    }

}
