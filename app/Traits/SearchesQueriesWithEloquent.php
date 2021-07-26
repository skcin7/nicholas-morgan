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

trait SearchesQueriesWithEloquent
{
    /*
    |--------------------------------------------------------------------------
    | Get Parts From Query
    |--------------------------------------------------------------------------
    |
    |
    |
    */

    /**
     * Get all the individual isolated parts from a full search query.
     *
     * @param $full_query
     * @return array
     */
    protected function getPartsFromQuery($full_query)
    {
        return [
            'query' => $full_query,
            'flags' => $this->getIndividualPartFromQuery($full_query, 'flags'),
            'text' => $this->getIndividualPartFromQuery($full_query, 'text'),
            'words' => $this->getIndividualPartFromQuery($full_query, 'words'),
            'exact_phrases' => $this->getIndividualPartFromQuery($full_query, 'exact_phrases'),
            'exclude_words' => $this->getIndividualPartFromQuery($full_query, 'exclude_words'),
            'exclude_exact_phrases' => $this->getIndividualPartFromQuery($full_query, 'exclude_exact_phrases'),
        ];
    }

    /**
     * Get a single part from a full query.
     *
     * @param $full_query
     * @param string $part_to_get
     * @return mixed
     */
    protected function getIndividualPartFromQuery($full_query, $part_to_get = '')
    {
        if($part_to_get === "flags") {
            return $this->getFlagsFromQuery($full_query);
        }
        else if($part_to_get === "text") {
            return $this->getTextFromQuery($full_query);
        }
        else if($part_to_get === "words") {
            return $this->getWordsFromQuery($full_query);
        }
        else if($part_to_get === "exact_phrases") {
            return $this->getExactPhrasesFromQuery($full_query);
        }
        else if($part_to_get === "exclude_words") {
            return $this->getExcludeWordsFromQuery($full_query);
        }
        else if($part_to_get === "exclude_exact_phrases") {
            return $this->getExcludeExactPhrasesFromQuery($full_query);
        }

        // Failsafe. Just return the full query.
        return $full_query;
    }

    /*
    |--------------------------------------------------------------------------
    |
    |--------------------------------------------------------------------------
    |
    | Everything below is the actual implementation.
    |
    */

    /**
     * The regular expression used for isolating search flags from the rest of a search query.
     *
     * @var string
     */
    protected $flags_regex = '([a-zA-Z_0-9]+)[:]([a-zA-Z_0-9,|!]+)';

    /**
     * Get just the flags from a search query (with any text removed).
     *
     * @param $search_query
     * @return array
     */
    protected function getFlagsFromQuery($search_query)
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
    protected function getTextFromQuery($search_query)
    {
        return trim(preg_replace('/' . $this->flags_regex . '/', "", $search_query));
    }

    /**
     * Get the list of individual words that can be matched from a search query.
     *
     * @param $search_query
     * @return false|string[]
     */
    protected function getWordsFromQuery($search_query)
    {
        $search_query_text = $this->getTextFromQuery($search_query);
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
    protected function getExactPhrasesFromQuery($search_query)
    {
        $search_query_text = $this->getTextFromQuery($search_query);
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
    protected function getExcludeWordsFromQuery($search_query)
    {
        // TODO
    }

    /**
     * Get the list of exact phrases to be excluded from a search query.
     *
     * @param $search_query
     * @return false|string[]
     */
    protected function getExcludeExactPhrasesFromQuery($search_query)
    {
        // TODO
    }





}
