<?php
namespace Cetteup\Unsplash;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

/**
 * Class HttpClient
 * @package Cetteup\Unsplash
 */
class HttpClient
{
    /**
     * @var Client
     */
    private $client;
    /**
     * @var string
     */
    private $app_id;

    const API_ROOT = 'https://api.unsplash.com';

    /**
     * @param string $app_id Your application ID
     * @throws Exception
     */
    public function __construct($app_id = null)
    {
        $this->client = new Client(['base_uri' => self::API_ROOT]);

        if (!is_string($app_id) || empty($app_id)) {
            throw new Exception('Missing/incorrect parameter "app_id"');
        }

        $this->app_id = $app_id;
    }

    /**
     * Retrieve public details on a given user
     * https://unsplash.com/documentation#get-a-users-public-profile
     *
     * @param string $username The user’s username
     * @return ResponseArray Array with user details
     * @throws Exception
     */
    public function user_find($username)
    {
        return $this->send_request('GET', "users/{$username}");
    }

    /**
     * Retrieve a single user’s portfolio link
     * https://unsplash.com/documentation#get-a-users-portfolio-link
     *
     * @param string $username The user’s username
     * @return ResponseArray Array with portfolio link
     * @throws Exception
     */
    public function user_portfolio_link($username)
    {
        return $this->send_request('GET', "users/{$username}/portfolio");
    }

    /**
     * Get a list of photos uploaded by a user
     * https://unsplash.com/documentation#list-a-users-photos
     *
     * @param string $username The user’s username
     * @param int $page Page number to retrieve
     * @param int $per_page Number of items per page
     * @param string $order_by How to sort the photos
     * @param bool $stats Show the stats for each user’s photo
     * @param string $resolution The frequency of the stats
     * @param int $quantity The amount of for each stat
     * @param string $orientation Filter by photo orientation
     * @return ResponseArray Array of photos
     * @throws Exception
     */
    public function user_photos($username, $page = 1, $per_page = 10, $order_by = 'latest', $stats = false, $resolution = 'days', $quantity = 30, $orientation = null)
    {
        $query = [
            'page' => $page,
            'per_page' => $per_page,
            'order_by' => $order_by
        ];

        if ( $stats ) {
            $query['stats'] = $stats;
            $query['resolution'] = $resolution;
            $query['quantity'] = $quantity;
        }

        if ( ! empty($orientation) ) {
            $query['orientation'] = $orientation;
        }

        return $this->send_request('GET', "users/{$username}/photos", $query);
    }

    /**
     * Get a list of photos liked by a user
     * https://unsplash.com/documentation#list-a-users-liked-photos
     *
     * @param string $username The user’s username
     * @param int $page Page number to retrieve
     * @param int $per_page Number of items per page
     * @param string $order_by How to sort the photos
     * @param null $orientation Filter by photo orientation
     * @return ResponseArray Array of photos
     * @throws Exception
     */
    public function user_likes($username, $page = 1, $per_page = 10, $order_by = 'latest', $orientation = null)
    {
        $query = [
            'page' => $page,
            'per_page' => $per_page,
            'order_by' => $order_by
        ];

        if ( ! empty($orientation) ) {
            $query['orientation'] = $orientation;
        }

        return $this->send_request('GET', "users/{$username}/likes", $query);
    }

    /**
     * Get a list of collections created by a user
     * https://unsplash.com/documentation#list-a-users-collections
     *
     * @param string $username The user’s username
     * @param int $page Page number to retrieve
     * @param int $per_page Number of items per page
     * @return ResponseArray Array of collections
     * @throws Exception
     */
    public function user_collections($username, $page = 1, $per_page = 10)
    {
        return $this->send_request('GET', "users/{$username}/collections", ['page' => $page, 'per_page' => $per_page]);
    }

    /**
     * Retrieve the consolidated number of downloads, views and likes of all user’s photos, as well as the historical breakdown and average of these stats in a specific timeframe
     * https://unsplash.com/documentation#get-a-users-statistics
     *
     * @param string $username The user’s username
     * @param string $resolution The frequency of the stats
     * @param int $quantity The amount of for each stat
     * @return ResponseArray Array with statistics
     * @throws Exception
     */
    public function user_statistics($username, $resolution = 'days', $quantity = 30)
    {
        return $this->send_request('GET', "users/{$username}/statistics", ['resolution' => $resolution, 'quantity' => $quantity]);
    }

    /**
     * Get a single page from the list of all photos
     * https://unsplash.com/documentation#list-photos
     *
     * @param int $page Page number to retrieve
     * @param int $per_page Number of items per page
     * @param string $order_by How to sort the photos
     * @return ResponseArray Array of photos
     * @throws Exception
     */
    public function photo_all($page = 1, $per_page = 10, $order_by = 'latest')
    {
        return $this->send_request('GET',"photos", ['page' => $page, 'per_page' => $per_page, 'order_by' => $order_by]);
    }

    /**
     * Retrieve a single photo
     * https://unsplash.com/documentation#get-a-photo
     *
     * @param int $id The photo’s ID
     * @return ResponseArray Array with photo details
     * @throws Exception
     */
    public function photo_find($id)
    {
        return $this->send_request('GET',  "photos/{$id}");
    }

    /**
     * Retrieve a single random photo, given optional filters
     * https://unsplash.com/documentation#get-a-random-photo
     *
     * @param array $params Filter parameters
     * @return ResponseArray Array of photos
     * @throws Exception
     */
    public function photo_random($params = [])
    {
        return $this->send_request('GET',"photos/random", $params);
    }

    /**
     * Retrieve a single photo’s stats
     * https://unsplash.com/documentation#get-a-photos-stats
     *
     * @param int $id The photo’s ID
     * @param string $resolution The frequency of the stats
     * @param int $quantity The amount of for each stat
     * @return ResponseArray Array with stats
     * @throws Exception
     */
    public function photo_statistics($id, $resolution = 'days', $quantity = 30)
    {
        return $this->send_request('GET', "photos/{$id}/statistics", ['resolution' => $resolution, 'quantity' => $quantity]);
    }

    /**
     * Track a photo download
     * https://unsplash.com/documentation#track-a-photo-download
     *
     * @param int $id The photo’s ID
     * @return void
     * @throws Exception
     */
    public function photo_download($id)
    {
        $this->send_request('GET',"photos/{$id}/download");
    }

    /**
     * Get a single page of photo results for a query
     * https://unsplash.com/documentation#search-photos
     *
     * @param string $search Search terms
     * @param int $page Page number to retrieve
     * @param int $per_page Number of items per page
     * @param string $order_by How to sort the photos
     * @param string $content_filter Limit results by content safety
     * @param string $collections Collection ID(‘s) to narrow search. If multiple, comma-separated.
     * @param null $color Filter results by color
     * @param null $orientation Filter by photo orientation
     * @return ResponseArray Array of photos
     * @throws Exception
     */
    public function search_photos($search, $page = 1, $per_page = 10, $order_by = 'relevant', $content_filter = 'low', $collections = null, $color = null, $orientation = null)
    {
        $query = [
            'query' => $search,
            'page' => $page,
            'per_page' => $per_page,
            'order_by' => $order_by,
            'content_filter' => $content_filter
        ];

        if ( ! empty($collections)) {
            $query['collections'] = $collections;
        }

        if ( ! empty($color) ) {
            $query['color'] = $color;
        }

        if ( ! empty($orientation)) {
            $query['orientation'] = $orientation;
        }

        return $this->send_request('GET', "search/photos", $query);
    }

    /**
     * Get a single page of collection results for a query
     * https://unsplash.com/documentation#search-collections
     *
     * @param string $search Search terms
     * @param int $page Page number to retrieve
     * @param int $per_page Number of items per page
     * @return ResponseArray Array of collections
     * @throws Exception
     */
    public function search_collections($search, $page = 1, $per_page = 10)
    {
        return $this->send_request('GET', "search/collections", ['query' => $search, 'page' => $page, 'per_page' => $per_page]);
    }

    /**
     * Get a single page of user results for a query
     * https://unsplash.com/documentation#search-users
     *
     * @param string $search Search terms
     * @param int $page Page number to retrieve
     * @param int $per_page Number of items per page
     * @return ResponseArray Array of users
     * @throws Exception
     */
    public function search_users($search, $page = 1, $per_page = 10)
    {
        return $this->send_request('GET', "search/users", ['query' => $search, 'page' => $page, 'per_page' => $per_page]);
    }


    /**
     * Get a single page from the list of all collections
     * https://unsplash.com/documentation#list-collections
     *
     * @param int $page Page number to retrieve
     * @param int $per_page Number of items per page
     * @return ResponseArray Array of collections
     * @throws Exception
     */
    public function collection_all($page = 1, $per_page = 10)
    {
        return $this->send_request('GET', "collections", ['page' => $page, 'per_page' => $per_page]);
    }

    /**
     * Get a single page from the list of featured collections
     * https://unsplash.com/documentation#list-featured-collections
     *
     * @param int $page Page number to retrieve
     * @param int $per_page Number of items per page
     * @return ResponseArray Array of collections
     * @throws Exception
     */
    public function collection_featured($page = 1, $per_page = 10)
    {
        return $this->send_request('GET',"collections/featured", ['page' => $page, 'per_page' => $per_page]);
    }

    /**
     * Retrieve a single collection
     * https://unsplash.com/documentation#get-a-collection
     *
     * @param int $id Id of the collection
     * @return ResponseArray Array with collection details
     * @throws Exception
     */
    public function collection_find($id)
    {
        return $this->send_request('GET', "collections/{$id}");
    }

    /**
     * Retrieve a collection’s photos
     * https://unsplash.com/documentation#get-a-collections-photos
     *
     * @param int $id Id of the collection
     * @param int $page Page number to retrieve
     * @param int $per_page Number of items per page
     * @param null $orientation Filter by photo orientation
     * @return ResponseArray Array of photos
     * @throws Exception
     */
    public function collection_photos($id, $page = 1, $per_page = 10, $orientation = null)
    {
        $query = [
            'page' => $page,
            'per_page' => $per_page,
        ];

        if ( ! empty($orientation)) {
            $query['orientation'] = $orientation;
        }

        return $this->send_request('GET',"collections/{$id}/photos", $query);
    }

    /**
     * Retrieve a list of collections related to a specific collection
     * https://unsplash.com/documentation#list-a-collections-related-collections
     *
     * @param int $id Id of the collection
     * @return ResponseArray Array of collections
     * @throws Exception
     */
    public function collection_related($id)
    {
        return $this->send_request('GET',"collections/{$id}/related");
    }

    /**
     * Get a list of stats for all of Unsplash
     * https://unsplash.com/documentation#totals
     *
     * @return ResponseArray Array with stats
     * @throws Exception
     */
    public function stats()
    {
        trigger_error('stats method is deprecated, please use stats_total instead', E_USER_DEPRECATED);
        return $this->stats_total();
    }

    /**
     * Get a list of stats for all of Unsplash
     * https://unsplash.com/documentation#totals
     *
     * @return ResponseArray Array with stats
     * @throws Exception
     */
    public function stats_total()
    {
        return $this->send_request('GET', "stats/total");
    }

    /**
     * Get the overall Unsplash stats for the past 30 days
     * https://unsplash.com/documentation#month
     *
     * @return ResponseArray Array with stats
     * @throws Exception
     */
    public function stats_month()
    {
        return $this->send_request('GET', "stats/month");
    }


    /**
     * @param $method
     * @param $endpoint
     * @param array $params
     * @return ResponseArray
     * @throws Exception
     */
    private function send_request($method, $endpoint, $params = [])
    {
        try {
            $request = new Request($method, $endpoint);
            $response = $this->client->send($request, [
              'headers' => ["Authorization" => "Client-ID {$this->app_id}"],
              'query' => $params
            ]);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                throw new Exception(implode(', ', $this->get_error_message($response)) . ' [' . $response->getStatusCode() . ' ' . $response->getReasonPhrase() . ']');
            } else {
                throw new Exception('Empty response');
            }
        }

        return new ResponseArray(
            $response->getHeaders(),
            json_decode($response->getBody(),true)
        );
    }

    /**
     * Retrieve the error messages in the body
     * Source: https://github.com/unsplash/unsplash-php
     *
     * @param  \GuzzleHttp\Psr7\Response $response of the HTTP request
     * @return array Array of error messages
     */
    private function get_error_message($response)
    {
        $message = json_decode($response->getBody(), true);
        $errors = [];

        if (is_array($message) && isset($message['errors'])) {
            $errors = $message['errors'];
        }

        return $errors;
    }
}
