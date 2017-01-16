# unsplash-php
An unofficial PHP wrapper to access the [Unsplash API](https://unsplash.com/documentation), focused on API call efficiency and ease of use.

*Note:* This wrapper only supports [public actions](https://unsplash.com/documentation#public-actions).

## Installation

`Unsplash-PHP` uses [Composer](https://getcomposer.org/). To use it, require the library

```
composer require diza/unsplash
```

## Usage

### Configuration

Before you can start making calls to the API, you need to configure the client with your application ID.

```php
$unsplash = new Diza\Unsplash\HttpClient('YOUR APPLICATION ID');
```

### API methods

Please refer to the [official documentation](https://unsplash.com/documentation) for more detailed information on the response structures.

#### Diza\Unsplash\HttpClient->user_find($username)
Retrieve public details on a given user.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required
---------------|------|--------------
`$username`    | string  | Required

**Example**

```php
$unsplash = new Diza\Unsplash\HttpClient('YOUR APPLICATION ID');
$user = $unsplash->user_find($username);
```

===

#### Diza\Unsplash\HttpClient->user_portfolio_link($username)
Retrieve a single user’s portfolio link.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required
---------------|------|--------------
`$username`    | string  | Required

**Example**

```php
$unsplash = new Diza\Unsplash\HttpClient('YOUR APPLICATION ID');
$link = $unsplash->user_portfolio_link($username);
```

===

#### Diza\Unsplash\HttpClient->user_photos($username, $page, $per_page, $order_by)
Get a list of photos uploaded by a user.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required | Note
---------------|------|--------------|------
`$username`    | string  | Required
`$page`        | int  | Opt *(Default: 1)*
`$per_page`    | int  | Opt *(Default: 10 / Maximum: 30)*
`$order_by`    | string | Opt *(Default: latest)* | Accepted values: `latest`, `oldest`, `popular`

**Example**

```php
$unsplash = new Diza\Unsplash\HttpClient('YOUR APPLICATION ID');
$photos = $unsplash->user_photos($username, $page, $per_page, $order_by);
```

===

#### Diza\Unsplash\HttpClient->user_likes($username, $page, $per_page, $order_by)
Get a list of photos liked by a user.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required | Note
---------------|------|--------------|------
`$username`    | string  | Required
`$page`        | int  | Opt *(Default: 1)*
`$per_page`    | int  | Opt *(Default: 10 / Maximum: 30)*
`$order_by`    | string | Opt *(Default: latest)* | Accepted values: `latest`, `oldest`, `popular`

**Example**

```php
$unsplash = new Diza\Unsplash\HttpClient('YOUR APPLICATION ID');
$photos = $unsplash->user_likes($username, $page, $per_page, $order_by);
```

===

#### Diza\Unsplash\HttpClient->user_collections($username, $page, $per_page)
Get a list of collections created by the user.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required
---------------|------|--------------
`$username`    | string  | Required
`$page`        | int  | Opt *(Default: 1)*
`$per_page`    | int  | Opt *(Default: 10 / Maximum: 30)*

**Example**

```php
$unsplash = new Diza\Unsplash\HttpClient('YOUR APPLICATION ID');
$collections = $unsplash->user_collections($username, $page, $per_page);
```

===

#### Diza\Unsplash\HttpClient->photo_all($page, $per_page, $order_by)
Get a single page from the list of all photos.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required | Note
---------------|------|--------------|------
`$page`        | int  | Opt *(Default: 1)*
`$per_page`    | int  | Opt *(Default: 10 / Maximum: 30)*
`$order_by`    | string | Opt *(Default: latest)* | Accepted values: `latest`, `oldest`, `popular`

**Example**

```php
$unsplash = new Diza\Unsplash\HttpClient('YOUR APPLICATION ID');
$photos = $unsplash->photo_all($page, $per_page, $order_by);
```

===

#### Diza\Unsplash\HttpClient->photo_curated($page, $per_page, $order_by)
Get a single page from the list of the curated photos.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required | Note
---------------|------|--------------|------
`$page`        | int  | Opt *(Default: 1)*
`$per_page`    | int  | Opt *(Default: 10 / Maximum: 30)*
`$order_by`    | string | Opt *(Default: latest)* | Accepted values: `latest`, `oldest`, `popular`

**Example**

```php
$unsplash = new Diza\Unsplash\HttpClient('YOUR APPLICATION ID');
$photos = $unsplash->photo_curated($page, $per_page, $order_by);
```

===

#### Diza\Unsplash\HttpClient->photo_find($id)
Retrieve a single photo.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required
---------------|------|--------------
`$id`          | string | Required

**Example**

```php
$unsplash = new Diza\Unsplash\HttpClient('YOUR APPLICATION ID');
$photo = $unsplash->photo_find($id);
```

===

#### Diza\Unsplash\HttpClient->photo_random($params)
Retrieve a single random photo, given [optional filters](https://unsplash.com/documentation#get-a-random-photo).

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required
---------------|------|--------------
`$params`      | array | Opt

**Example**

```php
$unsplash = new Diza\Unsplash\HttpClient('YOUR APPLICATION ID');
$photo = $unsplash->photo_random($params);
```

===

#### Diza\Unsplash\HttpClient->photo_stats($id)
Retrieve a single photo’s stats.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required
---------------|------|--------------
`$id`          | string | Required

**Example**

```php
$unsplash = new Diza\Unsplash\HttpClient('YOUR APPLICATION ID');
$stats = $unsplash->photo_stats($id);
```

===

#### Diza\Unsplash\HttpClient->photo_download_link($id)
Retrieve a single photo’s download link.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required
---------------|------|--------------
`$id`          | string | Required

**Example**

```php
$unsplash = new Diza\Unsplash\HttpClient('YOUR APPLICATION ID');
$link = $unsplash->photo_download_link($id);
```

===

#### Diza\Unsplash\HttpClient->search_photos($query, $page, $per_page)
Get a single page of photo results for a query.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required | Note
---------------|------|--------------|------
`$query`       | string | Required | Multiple search terms need to be separated by ` `, `,` or `+`
`$page`        | int  | Opt *(Default: 1)*
`$per_page`    | int  | Opt *(Default: 10 / Maximum: 30)*

**Example**

```php
$unsplash = new Diza\Unsplash\HttpClient('YOUR APPLICATION ID');
$results = $unsplash->search_photos($query, $page, $per_page);
```

===

#### Diza\Unsplash\HttpClient->search_collections($query, $page, $per_page)
Get a single page of collection results for a query.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required | Note
---------------|------|--------------|------
`$query`       | string | Required | Multiple search terms need to be separated by ` `, `,` or `+`
`$page`        | int  | Opt *(Default: 1)*
`$per_page`    | int  | Opt *(Default: 10 / Maximum: 30)*

**Example**

```php
$unsplash = new Diza\Unsplash\HttpClient('YOUR APPLICATION ID');
$results = $unsplash->search_collections($query, $page, $per_page);
```

===

#### Diza\Unsplash\HttpClient->search_users($query, $page, $per_page)
Get a single page of user results for a query.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required | Note
---------------|------|--------------|------
`$query`       | string | Required | Multiple search terms need to be separated by ` `, `,` or `+`
`$page`        | int  | Opt *(Default: 1)*
`$per_page`    | int  | Opt *(Default: 10 / Maximum: 30)*

**Example**

```php
$unsplash = new Diza\Unsplash\HttpClient('YOUR APPLICATION ID');
$results = $unsplash->search_users($query, $page, $per_page);
```

===

#### Diza\Unsplash\HttpClient->collection_all($page, $per_page)
Get a single page from the list of all collections.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required
---------------|------|--------------
`$page`        | int  | Opt *(Default: 1)*
`$per_page`    | int  | Opt *(Default: 10 / Maximum: 30)*

**Example**

```php
$unsplash = new Diza\Unsplash\HttpClient('YOUR APPLICATION ID');
$collections = $unsplash->collection_all($page, $per_page);
```

===

#### Diza\Unsplash\HttpClient->collection_featured($page, $per_page)
Get a single page from the list of featured collections.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required
---------------|------|--------------
`$page`        | int  | Opt *(Default: 1)*
`$per_page`    | int  | Opt *(Default: 10 / Maximum: 30)*

**Example**

```php
$unsplash = new Diza\Unsplash\HttpClient('YOUR APPLICATION ID');
$collections = $unsplash->collection_featured($page, $per_page);
```

===

#### Diza\Unsplash\HttpClient->collection_curated($page, $per_page)
Get a single page from the list of curated collections.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required
---------------|------|--------------
`$page`        | int  | Opt *(Default: 1)*
`$per_page`    | int  | Opt *(Default: 10 / Maximum: 30)*

**Example**

```php
$unsplash = new Diza\Unsplash\HttpClient('YOUR APPLICATION ID');
$collections = $unsplash->collection_curated($page, $per_page);
```

===

#### Diza\Unsplash\HttpClient->collection_find($id, $curated)
Retrieve a single collection.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required | Note
---------------|------|--------------|------
`$id`          | int | Required
`$curated`     | bool  | Opt *(Default: false)* | When `TRUE`, retrieves a curated collection

**Example**

```php
$unsplash = new Diza\Unsplash\HttpClient('YOUR APPLICATION ID');
$collection = $unsplash->collection_find($id, $curated);
```

===

#### Diza\Unsplash\HttpClient->collection_photos($id, $page, $per_page, $curated)
Retrieve a collection’s photos.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required | Note
---------------|------|--------------|------
`$id`          | int | Required
`$page`        | int  | Opt *(Default: 1)*
`$per_page`    | int  | Opt *(Default: 10 / Maximum: 30)*
`$curated`     | bool  | Opt *(Default: false)* | When `TRUE`, retrieves photos of curated collection

**Example**

```php
$unsplash = new Diza\Unsplash\HttpClient('YOUR APPLICATION ID');
$photos = $unsplash->collection_photos($id, $page, $per_page, $curated);
```

===

#### Diza\Unsplash\HttpClient->collection_related($id)
Retrieve a list of related collections.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required
---------------|------|--------------
`$id`          | int | Required

**Example**

```php
$unsplash = new Diza\Unsplash\HttpClient('YOUR APPLICATION ID');
$collections = $unsplash->collection_related($id);
```

===

#### Diza\Unsplash\HttpClient->stats()
Get a list of stats for all of Unsplash.

*Note:* You need to instantiate an httpclient object first

**Example**

```php
$unsplash = new Diza\Unsplash\HttpClient('YOUR APPLICATION ID');
$stats = $unsplash->stats();
```
