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
        // For now just redirect to the about page (until I get actual content on the Welcome page).
//        return redirect()->route('about');

        return view('welcome')
            ->with('title_prefix', 'Nick Morgan');
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
            ->with('title_prefix', 'Contact');
    }

    /**
     * Download my contact card.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function downloadContactCard(Request $request)
    {
        return \Storage::disk('local')->download('ContactCard.vcf');
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
        try {
            $public_key = \Storage::disk('local')->get('public_key.gpg');
            $fingerprint = "26F6 9EDA 6E47 65BA A077  C2E8 EC71 B630 B7F7 377D";

            return view('pgp')
                ->with('public_key', $public_key)
                ->with('fingerprint', $fingerprint)
                ->with('title_prefix', 'PGP');
        }
        catch(\Exception $ex) {
            abort(422, "There was an error retrieving the public PGP key.");
        }
    }

    /**
     * Get the difference between 2 lists of followers (calculate followers lost and followers gained).
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function followersDifference(Request $request)
    {
        // If we are POSTing, then process it.
        if($request->isMethod('post')) {
            $list_before_usernames = [];
            $list_before_contents = $request->file('list_before')->get();
            $list_before_lines = explode("\n", $list_before_contents);
            foreach($list_before_lines as $list_before_line) {
                $line_parts = explode(",", $list_before_line);
                if(isset($line_parts[1]) && $line_parts[1] !== "username" && strlen($line_parts[1]) > 0) {
                    $list_before_usernames[] = $line_parts[1];
                }
            }
//            dd($list_before_usernames);

            $list_after_usernames = [];
            $list_after_contents = $request->file('list_after')->get();
            $list_after_lines = explode("\n", $list_after_contents);
            foreach($list_after_lines as $list_after_line) {
                $line_parts = explode(",", $list_after_line);
                if(isset($line_parts[1]) && $line_parts[1] !== "username" && strlen($line_parts[1]) > 0) {
                    $list_after_usernames[] = $line_parts[1];
                }
            }
//            dd($list_after_usernames);


            $followers_lost = array_diff($list_before_usernames, $list_after_usernames);

            $followers_gained = array_diff($list_after_usernames, $list_before_usernames);
        }

        return view('followers_difference')
            ->with('followers_lost', isset($followers_lost) ? $followers_lost : null)
            ->with('followers_gained', isset($followers_gained) ? $followers_gained : null)
            ->with('title_prefix', 'Followers Difference');
    }

    /**
     * Redirect to gmail so that I can check my own email.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToGmail(Request $request)
    {
        return redirect()->to('https://gmail.com');
    }
}
