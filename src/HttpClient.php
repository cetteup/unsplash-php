<?php
namespace Cetteup\Unsplash;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class HttpClient
{
    private $client;
    private $app_id;

    const API_ROOT = 'https://api.unsplash.com';

    /**
     * @param string $app_id Your application ID
     */
    public function __construct($app_id = null)
    {
        $this->client = new Client(['base_uri' => self::API_ROOT]);
        if (!is_string($app_id) || empty($app_id)) {
            throw new Exception('Missing/incorrect parameter "app_id"');
        }
        $this->app_id = $app_id;
    }


    // +++ User endpoints +++

    /**
     * Retrieve public details on a given user
     * https://unsplash.com/documentation#get-a-users-public-profile
     *
     * @param  string $username The user’s username
     * @return array Array with user details
     */
    public function user_find($username)
    {
        if (!is_string($username)) return null;
        $user = $this->send_request('GET','users/'.$username);

        return $user;
    }

    /**
     * Retrieve a single user’s portfolio link
     * https://unsplash.com/documentation#get-a-users-portfolio-link
     *
     * @param  string $username The user’s username
     * @return array Array with portfolio link
     */
    public function user_portfolio_link($username)
    {
        if (!is_string($username)) return null;
        $link = $this->send_request('GET','users/'.$username.'/portfolio');

        return $link;
    }

    /**
     * Get a list of photos uploaded by a user
     * https://unsplash.com/documentation#list-a-users-photos
     *
     * @param  string $username The user’s username
     * @param  int    $page Page number to retrieve
     * @param  int    $per_page Number of items per page
     * @param  string $order_by How to sort the photos
     * @return array Array of photos
     */
    public function user_photos($username, $page = 1, $per_page = 10, $order_by = 'latest')
    {
        if (!is_string($username) || !is_int($page) || !is_int($per_page) || !is_string($order_by)) return null;
        $photos = $this->send_request('GET','users/'.$username.'/photos',['page' => $page, 'per_page' => $per_page, 'order_by' => $order_by]);

        return $photos;
    }

    /**
     * Get a list of photos liked by a user
     * https://unsplash.com/documentation#list-a-users-liked-photos
     *
     * @param  string $username The user’s username
     * @param  int    $page Page number to retrieve
     * @param  int    $per_page Number of items per page
     * @param  string $order_by How to sort the photos
     * @return array Array of photos
     */
    public function user_likes($username, $page = 1, $per_page = 10, $order_by = 'latest')
    {
        if (!is_string($username) || !is_int($page) || !is_int($per_page) || !is_string($order_by)) return null;
        $photos = $this->send_request('GET','users/'.$username.'/likes',['page' => $page, 'per_page' => $per_page, 'order_by' => $order_by]);

        return $photos;
    }

    /**
     * Get a list of collections created by a user
     * https://unsplash.com/documentation#list-a-users-collections
     *
     * @param  string $username The user’s username
     * @param  int    $page Page number to retrieve
     * @param  int    $per_page Number of items per page
     * @return array Array of collections
     */
    public function user_collections($username, $page = 1, $per_page = 10)
    {
        if (!is_string($username) || !is_int($page) || !is_int($per_page)) return null;
        $collections = $this->send_request('GET','users/'.$username.'/collections',['page' => $page, 'per_page' => $per_page]);

        return $collections;
    }

    /**
     * Retrieve the consolidated number of downloads, views and likes of all user’s photos, as well as the historical breakdown and average of these stats in a specific timeframe
     * https://unsplash.com/documentation#get-a-users-statistics
     *
     * @param  string $username The user’s username
     * @param  string $resolution The frequency of the stats
     * @param  int    $quantity The amount of for each stat
     * @return array Array of statistics
     */
    public function user_statistics($username, $resolution = 'days', $quantity = 30)
    {
        if (!is_string($username) || !is_string($resolution) || !is_int($quantity)) return null;
        $statistics = $this->send_request('GET','users/'.$username.'/statistics',['resolution' => $resolution, 'quantity' => $quantity]);

        return $statistics;
    }

    // +++ Photo endpoints +++

    /**
     * Get a single page from the list of all photos
     * https://unsplash.com/documentation#list-photos
     *
     * @param  int    $page Page number to retrieve
     * @param  int    $per_page Number of items per page
     * @param  string $order_by How to sort the photos
     * @return array Array of photos
     */
    public function photo_all($page = 1, $per_page = 10, $order_by = 'latest')
    {
        if (!is_int($page) || !is_int($per_page) || !is_string($order_by)) return null;
        $photos = $this->send_request('GET','photos',['page' => $page, 'per_page' => $per_page, 'order_by' => $order_by]);

        return $photos;
    }

    /**
     * Get a single page from the list of the curated photos
     * https://unsplash.com/documentation#list-curated-photos
     *
     * @param  int    $page Page number to retrieve
     * @param  int    $per_page Number of items per page
     * @param  string $order_by How to sort the photos
     * @return array Array of photos
     */
    public function photo_curated($page = 1, $per_page = 10, $order_by = 'latest')
    {
        if (!is_int($page) || !is_int($per_page) || !is_string($order_by)) return null;
        $photos = $this->send_request('GET','photos/curated',['page' => $page, 'per_page' => $per_page, 'order_by' => $order_by]);

        return $photos;
    }

    /**
     * Retrieve a single photo
     * https://unsplash.com/documentation#get-a-photo
     *
     * @param  int $id The photo’s ID
     * @return array Array with photo details
     */
    public function photo_find($id)
    {
        if (!is_string($id)) return null;
        $photo = $this->send_request('GET','photos/'.$id);

        return $photo;
    }

    /**
     * Retrieve a single random photo, given optional filters
     * https://unsplash.com/documentation#get-a-random-photo
     *
     * @param  array $params Filter parameters
     * @return array Array of photos
     */
    public function photo_random($params = [])
    {
        if (!is_array($params)) return null;
        $photos = $this->send_request('GET','photos/random',$params);

        return $photos;
    }

    /**
     * Retrieve a single photo’s stats
     * https://unsplash.com/documentation#get-a-photos-stats
     *
     * @param  int    $id The photo’s ID
     * @param  string $resolution The frequency of the stats
     * @param  int    $quantity The amount of for each stat
     * @return array Array with stats
     */
    public function photo_statistics($id, $resolution = 'days', $quantity = 30)
    {
        if (!is_string($id) || !is_string($resolution) || !is_int($quantity)) return null;
        $statistics = $this->send_request('GET','photos/'.$id.'/statistics',['resolution' => $resolution, 'quantity' => $quantity]);

        return $statistics;
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
        if (!is_string($id)) return null;
        $this->send_request('GET','photos/'.$id.'/download');
    }


    // +++ Search endpoints +++

    /**
     * Get a single page of photo results for a query
     * https://unsplash.com/documentation#search-photos
     *
     * @param  string $query Search terms
     * @param  int    $page Page number to retrieve
     * @param  int    $per_page Number of items per page
     * @param  string $colletions Collection ID(‘s) to narrow search. If multiple, comma-separated.
     * @return array Array of collections
     */
    public function search_photos($query, $page = 1, $per_page = 10, $collections)
    {
        if (!is_string($query) || !is_int($page) || !is_int($per_page)) return null;
        $photos = $this->send_request('GET','search/photos',['query' => $query, 'page' => $page, 'per_page' => $per_page, 'collections' => $collections]);

        return $photos;
    }

    /**
     * Get a single page of collection results for a query
     * https://unsplash.com/documentation#search-collections
     *
     * @param  string $query Search terms
     * @param  int    $page Page number to retrieve
     * @param  int    $per_page Number of items per page
     * @return array Array of collections
     */
    public function search_collections($query, $page = 1, $per_page = 10)
    {
        if (!is_string($query) || !is_int($page) || !is_int($per_page)) return null;
        $photos = $this->send_request('GET','search/collections',['query' => $query, 'page' => $page, 'per_page' => $per_page]);

        return $photos;
    }

    /**
     * Get a single page of user results for a query
     * https://unsplash.com/documentation#search-users
     *
     * @param  string $query Search terms
     * @param  int    $page Page number to retrieve
     * @param  int    $per_page Number of items per page
     * @return array Array of users
     */
    public function search_users($query, $page = 1, $per_page = 10)
    {
        if (!is_string($query) || !is_int($page) || !is_int($per_page)) return null;
        $users = $this->send_request('GET','search/users',['query' => $query, 'page' => $page, 'per_page' => $per_page]);

        return $users;
    }


    // +++ Collection endpoints +++

    /**
     * Get a single page from the list of all collections
     * https://unsplash.com/documentation#list-collections
     *
     * @param  int  $page Page number to retrieve
     * @param  int  $per_page Number of items per page
     * @return array Array of collections
     */
    public function collection_all($page = 1, $per_page = 10)
    {
        if (!is_int($page) || !is_int($per_page)) return null;
        $collections = $this->send_request('GET','collections',['page' => $page, 'per_page' => $per_page]);

        return $collections;
    }

    /**
     * Get a single page from the list of featured collections
     * https://unsplash.com/documentation#list-featured-collections
     *
     * @param  int  $page Page number to retrieve
     * @param  int  $per_page Number of items per page
     * @return array Array of collections
     */
    public function collection_featured($page = 1, $per_page = 10)
    {
        if (!is_int($page) || !is_int($per_page)) return null;
        $collections = $this->send_request('GET','collections/featured',['page' => $page, 'per_page' => $per_page]);

        return $collections;
    }

    /**
     * Get a single page from the list of curated collections
     * https://unsplash.com/documentation#list-curated-collections
     *
     * @param  int  $page Page number to retrieve
     * @param  int  $per_page Number of items per page
     * @return array Array of collections
     */
    public function collection_curated($page = 1, $per_page = 10)
    {
        if (!is_int($page) || !is_int($per_page)) return null;
        $collections = $this->send_request('GET','collections/curated',['page' => $page, 'per_page' => $per_page]);

        return $collections;
    }

    /**
     * Retrieve a single collection
     * https://unsplash.com/documentation#get-a-collection
     *
     * @param  int  $id Id of the collection
     * @param  bool $curated When TRUE, retrieves a curated collection
     * @return array Array with collection details
     */
    public function collection_find($id, $curated = false)
    {
        if (!is_int($id)) return null;
        if (!$curated) {
            $collection = $this->send_request('GET','collections/'.$id);
        } else {
            $collection = $this->send_request('GET','collections/curated/'.$id);
        }

        return $collection;
    }

    /**
     * Retrieve a (curated) collection’s photos
     * https://unsplash.com/documentation#get-a-collections-photos
     *
     * @param  int  $id Id of the collection
     * @param  int  $page Page number to retrieve
     * @param  int  $per_page Number of items per page
     * @param  bool $curated When TRUE, retrieves photos of curated collection
     * @return array Array of photos
     */
    public function collection_photos($id, $page = 1, $per_page = 10, $curated = false)
    {
        if (!is_int($id) || !is_int($page) || !is_int($per_page) || !is_bool($curated)) return null;
        if (!$curated) {
            $photos = $this->send_request('GET','collections/'.$id.'/photos',['page' => $page, 'per_page' => $per_page]);
        } else {
            $photos = $this->send_request('GET','collections/curated/'.$id.'/photos',['page' => $page, 'per_page' => $per_page]);
        }

        return $photos;
    }

    /**
     * Retrieve a list of collections related to a specific collection
     * https://unsplash.com/documentation#list-a-collections-related-collections
     *
     * @param  int $id Id of the collection
     * @return array Array of collections
     */
    public function collection_related($id)
    {
        if (!is_int($id)) return null;
        $collections = $this->send_request('GET','collections/'.$id.'/related');

        return $collections;
    }


    // +++ Other endpoints +++

    /**
     * Get a list of stats for all of Unsplash
     * https://unsplash.com/documentation#stats
     *
     * @return array Array with stats
     */
    public function stats()
    {
        $stats = $this->send_request('GET','stats/total');

        return $stats;
    }


    // +++ Request handling +++

    private function send_request($method, $endpoint, $params = array())
    {
        try {
            $request = new Request($method, $endpoint);
            $response = $this->client->send($request, [
              'headers' => ['Authorization'      => 'Client-ID '.$this->app_id],
              'query' => $params
            ]);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                throw new Exception(implode(', ',$this->get_error_message($response)).' ['.$response->getStatusCode().' '.$response->getReasonPhrase().']');
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
