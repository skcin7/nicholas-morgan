<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Number of results to show per paginated collection response.
     *
     * @var int
     */
    private $perPage = 100;

    /**
     * Set the per page amount to a new amount.
     *
     * @param $newPerPageAmount
     */
    public function setPerPageAmount($newPerPageAmount)
    {
        // Only let the per page amount be one of the valid amounts:
        switch($newPerPageAmount) {
            case 250:
            case 100:
            case 50:
            case 25:
            case 10:
                $this->perPage = $newPerPageAmount;
        }
    }

    /**
     * Get the per page amount for each paginated collection response.
     *
     * @return int
     */
    public function getPerPageAmount()
    {
        return $this->perPage;
    }

    /**
     * Respond to a request with JSON. Provides a unified way to respond using JSON format throughout the API.
     *
     * @param $resource = null
     * @param string $message
     * @param int $statusCode
     * @param $meta = null
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithJson($resource = null, $message = '', $statusCode = 200, $meta = null)
    {
        $data = [];

        // Attach the resource data (if any exists):
        if(! is_null($resource)) {
            $data['data'] = $resource;
        }

        // Attach the message:
        $data['message'] = $message;

        // Attach the status code and status text:
        $data['statusCode'] = $statusCode;
        $data['statusText'] = Response::$statusTexts[$statusCode];

        // Attach the meta data (if any exists):
        if(! is_null($meta)) {
            $data['meta'] = $meta;
        }

        // Respond to the API request:
        return response()->json($data, $statusCode);
    }

    /**
     * Get the message for when an action completes successfully.
     *
     * @param string $entity
     * @param string $actionVerb
     * @return string
     */
    public function getCompletedSuccessfullyMessage($entity = 'entity', $actionVerb = 'completed')
    {
        return 'The ' . $entity . ' has been ' . $actionVerb . ' successfully!';
    }
















    public function getRetrievedSuccessfullyMessage($entity = 'entity')
    {
        return 'The ' . $entity . ' has been retrieved successfully!';
    }

    public function getCreatedSuccessfullyMessage($entity = 'entity')
    {
        return 'The ' . $entity . ' has been created successfully!';
    }

    public function getUpdatedSuccessfullyMessage($entity = 'entity')
    {
        return 'The ' . $entity . ' has been updated successfully!';
    }

    public function getDeletedSuccessfullyMessage($entity = 'entity')
    {
        return 'The ' . $entity . ' has been deleted successfully!';
    }

    public function getSuccessfulContributionMessage($contribution_action = null)
    {
        return 'Thanks! The ' . (! is_null($contribution_action) ? $contribution_action . ' ' : '') . 'contribution has been successfully received! Allow up to 48 hours for the contribution to be processed.';
    }
}
