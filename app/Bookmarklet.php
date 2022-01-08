<?php

namespace App;

use App\Traits\SearchesQueriesWithEloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\GeneratesEloquentQueries;

class Bookmarklet extends Model implements GeneratesEloquentQueries
{
    //use HasFactory;
    use SearchesQueriesWithEloquent;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    public $table = 'bookmarklets';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'name' => '',
        'javascript_code' => '',
        'status' => 'ENABLED',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'javascript_code' => 'string',
        'status' => 'string',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'javascript_code',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    /**
     * Relationships to always be eager-loaded
     *
     * @var array
     */
    protected $with = [
        //
    ];

    /**
     * The validation rules that all valid user records must pass
     *
     * @var \string[][]
     */
    public static $validationRules = [
        'name' => [
            'required',
            'string',
            'unique:bookmarklets,name',
        ],
        'javascript_code' => [
            'required',
            'string',
        ],
    ];

    /**
     * Get the validation rules that all valid user records must pass.
     *
     * @return array
     */
    public static function getValidationRules()
    {
        return self::$validationRules;
    }

    /**
     * Relationships which can be included for eager loading.
     *
     * @var array
     */
    public static $availableIncludes = [
        //
    ];

    /**
     * Get the available relationships that may be included for eager-loading
     *
     * @return array
     */
    public static function getAvailableIncludes()
    {
        return self::$availableIncludes;
    }

    /**
     * Set the name of this Bookmarklet.
     *
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Set the JavaScript code of this Bookmarklet.
     *
     * @param $javascript_code
     */
    public function setJavascriptCode($javascript_code)
    {
        $this->javascript_code = $javascript_code;
    }

    /**
     * Get the JavaScript code.
     *
     * @param string $behavior
     * @return array|mixed|string|string[]
     */
    public function getJavascriptCode($behavior = "")
    {
        if($behavior === "minify") {
            $javascript_code = $this->javascript_code;
            $javascript_code = str_replace("\n", "", $javascript_code);
            return $javascript_code;
        }

        return $this->javascript_code;
    }

    /**
     * Add search filters to a working eloquent query to narrow the results.
     *
     * @param $current_eloquent_query
     * @param array $search_input_parameters
     */
    public static function addSearchFiltersToEloquentQuery($current_eloquent_query, array $search_input_parameters = [])
    {
        // Filtering by the name
        if(array_key_exists('name', $search_input_parameters)) {
            $current_eloquent_query->where('name', $search_input_parameters['name']);
        }

        // Filtering by a search query
        if(array_key_exists('query', $search_input_parameters)) {
            // TODO
        }
    }

    /**
     * Add ordering to a current working eloquent search query.
     *
     * @param $current_eloquent_query
     * @param string $order_by
     */
    public static function addOrderingToEloquentQuery($current_eloquent_query, $order_by = '')
    {
        // Ordering behavior for the matched records
        switch($order_by) {
            case 'alphabetical':
            case 'name':
            default:
                $current_eloquent_query->orderBy('name', 'asc');
                break;
            case 'alphabetical_reverse':
            case 'name_reverse':
                $current_eloquent_query->orderBy('name', 'desc');
                break;
        }
    }
}
