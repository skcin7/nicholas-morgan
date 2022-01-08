<?php

namespace App\Interfaces;

interface GeneratesEloquentQueries
{
    public static function addSearchFiltersToEloquentQuery($current_eloquent_query, array $search_input_parameters = []);
    public static function addOrderingToEloquentQuery($current_eloquent_query, string $order_by = '');
}
