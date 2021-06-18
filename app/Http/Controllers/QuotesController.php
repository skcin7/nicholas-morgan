<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quote;
use App\Http\Resources\Quote as QuoteResource;
use App\Http\Resources\QuoteCollection;

class QuotesController extends Controller
{
    /**
     * Generate the eloquent query for retrieving records from the database
     *
     * @param $request
     * @return mixed
     */
    private function getQuotesSearchQuery($request)
    {
        $quotesQuery = Quote::query();

        // Ordering behavior for the matched records
        switch(strtoupper($request->input('order'))) {
            case 'AUTHOR':
                $quotesQuery->orderBy('author', 'ASC');
                break;
            case 'ALPHABETICAL':
                $quotesQuery->orderBy('quote', 'ASC');
                break;
            case 'ALPHABETICAL_REVERSE':
                $quotesQuery->orderBy('quote', 'DESC');
                break;
            case 'NEWEST':
                $quotesQuery->orderBy('id', 'DESC');
                break;
            case 'OLDEST':
            default:
                $quotesQuery->orderBy('id', 'ASC');
                break;
            case 'RANDOM':
                $quotesQuery->inRandomOrder();
                break;
        }

        // If additional relationships are specified to be included with the response, define them here
        if($request->input('include') && strlen($request->input('include')) > 0) {
            foreach(array_intersect(explode(",", $request->input('include')), Quote::getAvailableIncludes()) as $thisInclude) {
                $quotesQuery->with($thisInclude);
            }
        }

        // Change the number of results to show per page of search results
        if($request->input('per_page') && strlen($request->input('per_page')) > 0) {
            $this->setPerPageAmount($request->input('per_page'));
        }

        return $quotesQuery;
    }

//    /**
//     * Show quotes
//     *
//     * @param Request $request
//     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View|mixed
//     */
//    public function index(Request $request)
//    {
//        $quotesQuery = $this->getQuotesSearchQuery($request);
//
//        // Get the matched records into paginated results
//        $quotes = $quotesQuery->paginate($this->getPerPageAmount());
//
//        if($request->expectsJson()) {
//            return $this->respondWithJson(
//                new QuoteCollection($quotes),
//                number_format($quotes->total()) . ' matched quote ' . ($quotes->total() === 1 ? 'record was' : 'records were') . ' found  (showing ' . $quotes->perPage() . ' per page)!',
//                200
//            );
//        }
//
//        return view('quotes')
//            ->with('title_prefix', 'Quotes')
//            ->with('quotes', $quotes);
//    }

    /**
     * Show the quotes management page, which is only available for admins.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function manage(Request $request)
    {
        $quotesQuery = $this->getQuotesSearchQuery($request);

        // Get the matched records into paginated results
        $quotes = $quotesQuery->paginate($this->getPerPageAmount());

        return view('admin.admin_quotes')
            ->with('title_prefix', 'Manage Quotes')
            ->with('quotes', $quotes);
    }

    /**
     * Get a quote by its ID lookup column.
     *
     * @param $id
     * @param $request
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    private function getQuoteById($id, $request = null)
    {
        // Start the quote query.
        $quoteQuery = Quote::query();

        // We use "RANDOM" as a special id value to denote we want to retrieve a random quote.
        // Otherwise, we retreive the quote by the ID (which is the abbreviation as the lookup column).
        if($id === "RANDOM") {
            $quoteQuery->inRandomOrder();
        }
        else {
            // The quote's id is always the first segment of its slug.
            $quote_id = slug_parts($id, 0, '-');
            $quoteQuery->where('id', $quote_id);
        }

        // Eagerly-load any additional relationships that are defined to be eager-loaded from the HTTP request using the 'include' key
        if(! is_null($request)) {
            $include = explode(",", $request->input('include', ''));
            foreach(array_intersect($include, Quote::getAvailableIncludes()) as $thisInclude) {
                $quoteQuery->with($thisInclude);
            }
        }

        return $quoteQuery->firstOrFail();
    }

    /**
     * Get a random quote.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function random(Request $request)
    {
        $randomQuote = $this->getQuoteById('RANDOM', $request);

        if($request->expectsJson()) {
            return $this->respondWithJson(
                new QuoteResource($randomQuote),
                $this->getRetrievedSuccessfullyMessage('random quote'),
                200
            );
        }

        //return redirect()->route('quotes.quote', ['id' => $randomQuote->getSlug()]);
    }

    /**
     * Get a quote.
     *
     * @param Request $request
     * @param $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function get(Request $request, $id)
    {
        $quote = $this->getQuoteById($id, $request);

        if($request->expectsJson()) {
            return $this->respondWithJson(
                new QuoteResource($quote),
                $this->getRetrievedSuccessfullyMessage('quote'),
                200
            );
        }

        return view('quote')
            ->with('quote', $quote)
            ->with('title_prefix', 'Quote');
    }

    /**
     * Create a quote.
     *
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function create(Request $request, $id = null)
    {
        // if an identifier is passed, then just update it
        if(! is_null($id)) {
            return $this->update($request, $id);
        }

        $request->validate(Quote::getValidationRules());

        $quote = new Quote();
        $quote->fill($request->only([
            'quote',
            'author',
            'is_public',
        ]));
        $quote->save();

        return $this->respondWithJson(
            null,
            $this->getCreatedSuccessfullyMessage('quote'),
            201
        );
    }

    /**
     * Update a quote.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate(Quote::getValidationRules());

        $quote = $this->getQuoteById($id, $request);
        $quote->fill($request->only([
            'quote',
            'author',
            'is_public',
        ]));
        $quote->save();

        return $this->respondWithJson(
            QuoteResource::make($quote),
            $this->getUpdatedSuccessfullyMessage('quote'),
            200
        );
    }

    /**
     * Delete a quote.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete(Request $request, $id)
    {
        $quote = $this->getQuoteById($id, $request);
        $quote->delete();

        return $this->respondWithJson(
            QuoteResource::make($quote),
            $this->getDeletedSuccessfullyMessage('quote'),
            200
        );
    }
}
