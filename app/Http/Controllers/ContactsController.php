<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\Http\Resources\Contact as ContactResource;
use App\Http\Resources\ContactCollection;

class ContactsController extends Controller
{
    /**
     * Show the contacts index page.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $contacts = Contact::all();

        $this->showAvatar = false;
        $this->showHero = false;
        return $this->respondWithBladeView('contacts', [
            'title_prefix' => 'Contacts',
            'contacts' => $contacts,
        ]);
    }

}
