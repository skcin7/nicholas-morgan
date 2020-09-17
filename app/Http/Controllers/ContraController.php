<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class ContraController extends Controller
{
    /**
     * Show the NES emulator page.
     *
     * @param Request $request
     * @param $rom_filename
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contra(Request $request, $rom_filename = 'contra.nes')
    {
        return view('contra')
            ->with('rom_filename', $rom_filename);
    }

    /**
     * Get the NES ROM used to play in the Contra/NES emulator.
     *
     * @param Request $request
     * @param $rom_filename
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getRom(Request $request, $rom_filename = 'contra.nes')
    {
        $path = 'NESRoms/' . $rom_filename;

        // Check and see if the file exists. If it doesn't return a graceful 404 response:
        if(! Storage::disk('public')->exists($path)) {
            abort(404);
        }

        // The NES ROM file has been found, so download it:
        return Storage::disk('public')->download($path);
    }
}
