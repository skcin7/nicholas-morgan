<?php

namespace App\Traits;

/*
|--------------------------------------------------------------------------
| Retrieves Many Entities
|--------------------------------------------------------------------------
|
| A trait to retrieve collections of entities from the database.
|
*/

trait RetrievesManyEntities
{
    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    |
    | This area is for handling the per page stuff for paginated results.
    |
    */

    /**
     * Number of entities to show in each page of paginated results for a collection response.
     *
     * @var int
     */
    private $per_page_amount = 100;

    /**
     * Set the per page amount to a new amount.
     *
     * @param $newPerPageAmount
     */
    protected function setPerPageAmount($newPerPageAmount)
    {
        // Only let the per page amount be one of the valid amounts:
        switch($newPerPageAmount) {
            case 250:
            case 100:
            case 50:
            case 25:
            case 10:
                $this->per_page_amount = $newPerPageAmount;
        }
    }

    /**
     * Get the per page amount for each paginated collection response.
     *
     * @return int
     */
    protected function getPerPageAmount()
    {
        return $this->per_page_amount;
    }


    /*
    |--------------------------------------------------------------------------
    | Get Many Entities Eloquent Queries
    |--------------------------------------------------------------------------
    |
    | This area is for handling the per page stuff for paginated results.
    |
    */

    /**
     * Get the eloquent query that is used for retrieving many entities from the database.
     *
     * @param $model
     * @param array $search_input_params = []
     * @param array $relationships_to_eager_load = []
     * @param string $order_by
     * @return mixed
     */
    protected function retrieveManyEntitiesQuery($model, array $search_input_params = [], array $relationships_to_eager_load = [], $order_by = 'RANDOM')
    {
        $many_entities_eloquent_query = $model::query();

        // Add the searching filters to the eloquent query for this specific model.
        $model::addSearchFiltersToEloquentQuery($many_entities_eloquent_query, $search_input_params);

        // Include any relationships that are specified to be eagerly loaded here.
        foreach(array_intersect($relationships_to_eager_load, $model::getAvailableIncludes()) as $this_eager_loading_relationship) {
            $many_entities_eloquent_query->with($this_eager_loading_relationship);
        }

        // Add the ordering behavior to the eloquent query. If the order by value is one of the default ones (which all entities can be ordered by), then
        // do the ordering directly here. Otherwise, if some sort of custom ordering is to be done that is based on the model
        // specifically, then do the ordering there.
        if($order_by != '' && $order_by != 'created_at' && $order_by != 'updated_at' && $order_by != 'random') {
            $model::addOrderingToEloquentQuery($many_entities_eloquent_query, $order_by);
        }
        else {
            switch($order_by) {
                case 'created_at':
                    $many_entities_eloquent_query->orderBy('created_at');
                    break;
                case 'updated_at':
                    $many_entities_eloquent_query->orderBy('updated_at');
                    break;
                case 'random':
                    $many_entities_eloquent_query->inRandomOrder();
                    break;
            }
        }

        return $many_entities_eloquent_query;
    }

    /**
     * Retrieve a collection of many entities that match the eloquent query.
     *
     * @param $model
     * @param array $search_input_params
     * @param array $relationships_to_eager_load
     * @param string $order_by
     * @param null $limit
     * @param null $offset
     * @return mixed
     */
    protected function retrieveManyEntities($model, array $search_input_params = [], array $relationships_to_eager_load = [], $order_by = 'created_at', $limit = null, $offset = null)
    {
        // Get the many entities eloquent search query.
        $many_entities_eloquent_query = $this->retrieveManyEntitiesQuery($model, $search_input_params, $relationships_to_eager_load, $order_by);

        if(! is_null($offset)) {
            $many_entities_eloquent_query->offset($offset);
        }

        if(! is_null($limit)) {
            $many_entities_eloquent_query->offset($limit);
        }

        return $many_entities_eloquent_query->get();
    }

    /**
     * Retrieve a single page of paginated entities.
     *
     * @param $model
     * @param array $search_input_params
     * @param array $relationships_to_eager_load
     * @param string $order_by
     * @param null $per_page_amount
     * @return mixed
     */
    protected function retrieveManyEntitiesPage($model, array $search_input_params = [], array $relationships_to_eager_load = [], $order_by = 'CREATED_AT', $per_page_amount = null)
    {
        // Get the many entities eloquent search query.
        $many_entities_eloquent_query = $this->retrieveManyEntitiesQuery($model, $search_input_params, $relationships_to_eager_load, $order_by);

        // If an amount of results is specified to be get per page other than the default, set it here.
        if(! is_null($per_page_amount)) {
            $this->setPerPageAmount($per_page_amount);
        }

        // Get the current page of entities.
        return $many_entities_eloquent_query->paginate($this->getPerPageAmount());
    }

    /**
     * The regular expression used for isolating search flags from the rest of a search query.
     *
     * @var string
     */
    private $flags_regex = '([a-zA-Z_0-9]+)[:]([a-zA-Z_0-9,|!]+)';

    /**
     * Get a single isolated piece/property from the rest of a search query.
     *
     * @param $search_query
     * @param string $PART_TO_GET
     * @return mixed
     */
    protected function getIndividualPartFromQuery($search_query, $PART_TO_GET = '')
    {
        if($PART_TO_GET === "FLAGS") {
            return $this->getFlagsFromSearchQuery($search_query);
        }
        else if($PART_TO_GET === "TEXT") {
            return $this->getTextFromSearchQuery($search_query);
        }
        else if($PART_TO_GET === "WORDS") {
            return $this->getWordsFromSearchQuery($search_query);
        }
        else if($PART_TO_GET === "EXACT_PHRASES") {
            return $this->getExactPhrasesFromSearchQuery($search_query);
        }
        else if($PART_TO_GET === "EXCLUDE_WORDS") {
            return $this->getExcludeWordsFromSearchQuery($search_query);
        }
        else if($PART_TO_GET === "EXCLUDE_EXACT_PHRASES") {
            return $this->getExcludeExactPhrasesFromSearchQuery($search_query);
        }

        // Failsafe. Just return the full query.
        return $search_query;
    }

    /**
     * Get just the flags from a search query (with any text removed).
     *
     * @param $search_query
     * @return array
     */
    protected function getFlagsFromSearchQuery($search_query)
    {
        // Get full list of flags which matches the regular expression (stored in $matches).
        preg_match_all('/' . $this->flags_regex . '/', $search_query, $matches);

        if($matches === false) {
            return []; // No flags
        }

        // Combine keys and values together into an associative array.
        $flagsFound = array_combine($matches[1], $matches[2]);

        // Ensure all flag keys are lowercase to avoid confusions.
        $flagsFound = array_change_key_case($flagsFound, CASE_LOWER);

        return $flagsFound;
    }

    /**
     * Get just the text from a search query (with any search flags removed).
     *
     * @param $search_query
     * @return null|string|string[]
     */
    protected function getTextFromSearchQuery($search_query)
    {
        return trim(preg_replace('/' . $this->flags_regex . '/', "", $search_query));
    }

    /**
     * Get the list of individual words that can be matched from a search query.
     *
     * @param $search_query
     * @return false|string[]
     */
    protected function getWordsFromSearchQuery($search_query)
    {
        $search_query_text = $this->getTextFromSearchQuery($search_query);
        preg_match_all('`"([^"]*)"`', $search_query_text, $match);

        foreach($match[0] as $exact_phrase) {
            $search_query_text = str_replace($exact_phrase, "", $search_query_text);
        }

        $individual_words = explode(" ", trim($search_query_text));
        return $individual_words;
    }

    /**
     * Get just the exact phrases from a search query.
     *
     * @param $search_query
     * @return mixed
     */
    protected function getExactPhrasesFromSearchQuery($search_query)
    {
        $search_query_text = $this->getTextFromSearchQuery($search_query);
        preg_match_all('`"([^"]*)"`', $search_query_text, $match);
        $exact_phrases = $match[1];
        return $exact_phrases;
    }

    /**
     * Get the list of words to be excluded from a search query.
     *
     * @param $search_query
     * @return false|string[]
     */
    protected function getExcludeWordsFromSearchQuery($search_query)
    {
        // TODO
    }

    /**
     * Get the list of exact phrases to be excluded from a search query.
     *
     * @param $search_query
     * @return false|string[]
     */
    protected function getExcludeExactPhrasesFromSearchQuery($search_query)
    {
        // TODO
    }

//    /**
//     * Generate the eloquent query for retrieving records from the database.
//     *
//     * @param $model
//     * @return mixed
//     */
//    protected function retrieveManyEntities($model)
//    {
//
//    }





}
