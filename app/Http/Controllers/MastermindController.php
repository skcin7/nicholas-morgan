<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class MastermindController extends Controller
{
    /**
     * Show the mastermind home page.
     * @param Request $request
     * @return View
     */
    public function mastermindHome(Request $request): View
    {
        return view('mastermind')
            ->with('title_prefix', 'Mastermind');
    }

    /**
     * Show the phpinfo page.
     * @return bool
     */
    public function phpinfo()
    {
        return phpinfo();
    }

    /**
     * Show the Adminer page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminer()
    {
        return redirect()->to(url('adminer/4.7.8/adminer-4.7.8-en.php'));
    }
}
