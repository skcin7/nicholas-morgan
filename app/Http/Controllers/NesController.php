<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NesController extends Controller
{
    /**
     * Show the NES emulator page.
     *
     * @param Request $request
     * @param $rom = 'Contra.nes'
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, $rom = 'Contra.nes')
    {
        die('Sorry, the ability to play Contra is not currently working.');

        return view('nes')
            ->with('rom', $rom);
    }
}
