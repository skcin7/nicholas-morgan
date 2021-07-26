<?php

namespace App\Traits;

/*
|--------------------------------------------------------------------------
| Retrieves Single Entity
|--------------------------------------------------------------------------
|
| A trait to retrieve single entity instances from the database.
|
*/

trait RetrievesSingleEntity
{
    /**
     * Get the query that is used for retrieving a single entity from the database.
     *
     * @param $model
     * @param $identifier
     * @param string $lookup_column
     * @param array $eager_load_relationships
     * @return mixed
     */
    protected function retrieveSingleEntityQuery($model, $identifier, string $lookup_column = 'id', array $eager_load_relationships = [])
    {
        $singleEntityQuery = $model::query();

        // Using "RANDOM" as a special value to denote that we want to retrieve a random record.
        // Otherwise, retrieve the record by its identifier lookup column.
        if($identifier === "RANDOM") {
            $singleEntityQuery->inRandomOrder();
        }
        else {
            $singleEntityQuery->where($lookup_column, $identifier);
        }

        // Eager load any relationships that are defined to be eager-loaded.
        // Filter to ensure only available possible relationships can be eager-loaded to prevent possible 5XX errors.
        foreach(array_intersect($eager_load_relationships, $model::getAvailableIncludes()) as $eager_load_relationship) {
            $singleEntityQuery->with($eager_load_relationship);
        }

        return $singleEntityQuery;
    }

    /**
     * Get the retrieved instance of a single entity from the database.
     *
     * @param $model
     * @param $identifier
     * @param string $lookup_column
     * @param array $eager_load_relationships
     * @return mixed
     */
    protected function retrieveSingleEntity($model, $identifier, string $lookup_column = 'id', array $eager_load_relationships = [])
    {
        $singleEntityQuery = $this->retrieveSingleEntityQuery($model, $identifier, $lookup_column, $eager_load_relationships);
        return $singleEntityQuery->firstOrFail();
    }

//    /**
//     * An alias function that does the exact same thing as retrieveSingleEntity().
//     * DEPRECIATE
//     * Function is only here because retrieveRecordQuery() is being depreciated in favor of retrieveSingleEntityQuery(), and to ensure nothing breaks in the depreciating process.
//     *
//     * @param $model
//     * @param $identifier
//     * @param string $lookup_column
//     * @param array $eager_load_relationships
//     * @return mixed
//     */
//    protected function retrieveRecordQuery($model, $identifier, string $lookup_column = 'id', array $eager_load_relationships = [])
//    {
//        return $this->retrieveSingleEntityQuery($model, $identifier, $lookup_column, $eager_load_relationships);
//    }
//
//    /**
//     * An alias function that does the exact same thing as retrieveSingleEntity().
//     * DEPRECIATE
//     * Function is only here because retrieveRecord() is being depreciated in favor of retrieveSingleEntity(), and to ensure nothing breaks in the depreciating process.
//     *
//     * @param $model
//     * @param $identifier
//     * @param string $lookup_column
//     * @param array $eager_load_relationships
//     * @return mixed
//     */
//    protected function retrieveRecord($model, $identifier, string $lookup_column = 'id', array $eager_load_relationships = [])
//    {
//        return $this->retrieveSingleEntity($model, $identifier, $lookup_column, $eager_load_relationships);
//    }


}
