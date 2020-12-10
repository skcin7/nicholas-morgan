<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class NesEmulatorController extends Controller
{
    /**
     * Play the NES emulator.
     *
     * @param Request $request
     * @param $rom
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function play(Request $request, $rom = 'Contra')
    {
        return view('nes')
            ->with('rom', $rom);
    }

//    /**
//     * Get the NES ROM used to play in the Contra/NES emulator.
//     *
//     * @param Request $request
//     * @param $rom_filename
//     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
//     */
//    public function getRom(Request $request, $rom_filename = 'contra.nes')
//    {
//        $path = 'NESRoms/' . $rom_filename;
//
//        // Check and see if the file exists. If it doesn't return a graceful 404 response:
//        if(! Storage::disk('public')->exists($path)) {
//            abort(404);
//        }
//
//        // The NES ROM file has been found, so download it:
//        return Storage::disk('public')->download($path);
//    }
}
