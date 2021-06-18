<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show the admin page.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('admin.admin_home')
            ->with('title_prefix', 'Administration');
    }

    /**
     * Show the phpinfo page.
     *
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
