# unsplash-php
An unofficial PHP wrapper to access the [Unsplash API](https://unsplash.com/documentation), focused on API call efficiency and ease of use.

*Note:* This wrapper only supports [public actions](https://unsplash.com/documentation#public-actions).

## Installation

`Unsplash-PHP` uses [Composer](https://getcomposer.org/). To use it, require the library

```
composer require cetteup/unsplash
```

## Usage

### Configuration

Before you can start making calls to the API, you need to configure the client with your application ID.

```php
$unsplash = new Cetteup\Unsplash\HttpClient('YOUR APPLICATION ID');
```

### API methods

Please refer to the [official documentation](https://unsplash.com/documentation) for more detailed information on the response structures.

#### Cetteup\Unsplash\HttpClient->user_find($username)
Retrieve public details on a given user.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required
---------------|------|--------------
`$username`    | string  | Required

**Example**

```php
$unsplash = new Cetteup\Unsplash\HttpClient('YOUR APPLICATION ID');
$user = $unsplash->user_find('cetteup');
```

----

#### Cetteup\Unsplash\HttpClient->user_portfolio_link($username)
Retrieve a single user’s portfolio link.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required
---------------|------|--------------
`$username`    | string  | Required

**Example**

```php
$unsplash = new Cetteup\Unsplash\HttpClient('YOUR APPLICATION ID');
$link = $unsplash->user_portfolio_link('cetteup');
```

----

#### Cetteup\Unsplash\HttpClient->user_photos($username, $page, $per_page, $order_by, $stats, $resolution, $quantity, $orientation)
Get a list of photos uploaded by a user.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required | Note
---------------|------|--------------|------
`$username`    | string  | Required
`$page`        | int  | Opt *(Default: 1)*
`$per_page`    | int  | Opt *(Default: 10 / Maximum: 30)*
`$order_by`    | string | Opt *(Default: latest)* | Accepted values: `latest`, `oldest`, `popular`
`$stats`       | bool | Opt *(Default: false)*
`$resolution`  | string | Opt *(Default: days)* | Accepted values: `days`
`$quantity`    | int | Opt *(Default: 30)*
`$orientation` | string | Opt | Accepted values: `landscape`, `portrait`, `squarish`

**Example**

```php
$unsplash = new Cetteup\Unsplash\HttpClient('YOUR APPLICATION ID');
$photos = $unsplash->user_photos('cetteup', 2, 30, 'oldest');
```

----

#### Cetteup\Unsplash\HttpClient->user_likes($username, $page, $per_page, $order_by, $orientation)
Get a list of photos liked by a user.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required | Note
---------------|------|--------------|------
`$username`    | string  | Required
`$page`        | int  | Opt *(Default: 1)*
`$per_page`    | int  | Opt *(Default: 10 / Maximum: 30)*
`$order_by`    | string | Opt *(Default: latest)* | Accepted values: `latest`, `oldest`, `popular`
`$orientation` | string | Opt | Accepted values: `landscape`, `portrait`, `squarish`

**Example**

```php
$unsplash = new Cetteup\Unsplash\HttpClient('YOUR APPLICATION ID');
$photos = $unsplash->user_likes('cetteup', 2, 20, 'popular');
```

----

#### Cetteup\Unsplash\HttpClient->user_collections($username, $page, $per_page)
Get a list of collections created by a user.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required
---------------|------|--------------
`$username`    | string  | Required
`$page`        | int  | Opt *(Default: 1)*
`$per_page`    | int  | Opt *(Default: 10 / Maximum: 30)*

**Example**

```php
$unsplash = new Cetteup\Unsplash\HttpClient('YOUR APPLICATION ID');
$collections = $unsplash->user_collections('jlantunez', 3, 5);
```

----

#### Cetteup\Unsplash\HttpClient->user_statistics($username, $resolution, $quantity)
Retrieve the consolidated number of downloads, views and likes of all user’s photos, as well as the historical breakdown and average of these stats in a specific timeframe.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required | Note
---------------|------|--------------|------
`$username`    | string  | Required
`$resolution`  | string  | Opt *(Default: days)* | Accepted values: `days`
`$quantity`    | int  | Opt *(Default: 30 / Minimum: 1 / Maximum: 30)*

**Example**

```php
$unsplash = new Cetteup\Unsplash\HttpClient('YOUR APPLICATION ID');
$collections = $unsplash->user_statistics('cetteup', 'days', 10);
```

----

#### Cetteup\Unsplash\HttpClient->photo_all($page, $per_page, $order_by)
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
$unsplash = new Cetteup\Unsplash\HttpClient('YOUR APPLICATION ID');
$photos = $unsplash->photo_all(2, 30, 'oldest');
```

----

#### Cetteup\Unsplash\HttpClient->photo_find($id)
Retrieve a single photo.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required
---------------|------|--------------
`$id`          | string | Required

**Example**

```php
$unsplash = new Cetteup\Unsplash\HttpClient('YOUR APPLICATION ID');
$photo = $unsplash->photo_find('54t5rivyAiI');
```

----

#### Cetteup\Unsplash\HttpClient->photo_random($params)
Retrieve a single random photo, given [optional filters](https://unsplash.com/documentation#get-a-random-photo).

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required
---------------|------|--------------
`$params`      | array | Opt

**Example**

```php
$unsplash = new Cetteup\Unsplash\HttpClient('YOUR APPLICATION ID');
$photo = $unsplash->photo_random(['orientation' => 'portrait']);
```

----

#### Cetteup\Unsplash\HttpClient->photo_statistics($id, $resolution, $quantity)
Retrieve total number of downloads, views and likes of a single photo, as well as the historical breakdown of these stats in a specific timeframe.

*Note:* You need to instantiate an httpclient object first

**Arguments**

Argument     | Type | Opt/Required | Note
---------------|------|--------------|------
`$id`          | string | Required
`$resolution`  | string  | Opt *(Default: days)* | Accepted values: `days`
`$quantity`    | int  | Opt *(Default: 30 / Minimum: 1 / Maximum: 30)*

**Example**

```php
$unsplash = new Cetteup\Unsplash\HttpClient('YOUR APPLICATION ID');
$stats = $unsplash->photo_statistics('54t5rivyAiI', 'days', 14);
```

----

#### Cetteup\Unsplash\HttpClient->photo_download($id)
Track a photo download.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required
---------------|------|--------------
`$id`          | string | Required

**Example**

```php
$unsplash = new Cetteup\Unsplash\HttpClient('YOUR APPLICATION ID');
$unsplash->photo_download('54t5rivyAiI');
```

----

#### Cetteup\Unsplash\HttpClient->search_photos($search, $page, $per_page, $order_by, $content_filter, $collections, $color, $orientation)
Get a single page of photo results for a query.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required | Note
---------------|------|--------------|------
`$search`      | string | Required | Multiple search terms need to be separated by ` `, `,` or `+`
`$page`        | int  | Opt *(Default: 1)*
`$per_page`    | int  | Opt *(Default: 10 / Maximum: 30)*
`$order_by`    | string | Opt *(Default: relevant)* | Accepted values: `latest`, `relevant`
`$content_filter` | string | Opt *(Default: low)* | Accepted values: `low`, `high`
`$collections` | string | Opt | Multiple IDs need to be comma-separated
`$color`       | string | Opt | Accepted values: `black_and_white`, `black`, `white`, `yellow`, `orange`, `red`, `purple`, `magenta`, `green`, `teal`, `and` `blueblack_and_white`, `black`, `white`, `yellow`, `orange`, `red`, `purple`, `magenta`, `green`, `teal`, `blue`
`$orientation` | string | Opt | Accepted values: `landscape`, `portrait`, `squarish`

**Example**

```php
$unsplash = new Cetteup\Unsplash\HttpClient('YOUR APPLICATION ID');
$results = $unsplash->search_photos('cats', 5, 30);
```

----

#### Cetteup\Unsplash\HttpClient->search_collections($search, $page, $per_page)
Get a single page of collection results for a query.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required | Note
---------------|------|--------------|------
`$search`      | string | Required | Multiple search terms need to be separated by ` `, `,` or `+`
`$page`        | int  | Opt *(Default: 1)*
`$per_page`    | int  | Opt *(Default: 10 / Maximum: 30)*

**Example**

```php
$unsplash = new Cetteup\Unsplash\HttpClient('YOUR APPLICATION ID');
$results = $unsplash->search_collections('dogs', 10, 25);
```

----

#### Cetteup\Unsplash\HttpClient->search_users($search, $page, $per_page)
Get a single page of user results for a query.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required | Note
---------------|------|--------------|------
`$search`      | string | Required | Multiple search terms need to be separated by ` `, `,` or `+`
`$page`        | int  | Opt *(Default: 1)*
`$per_page`    | int  | Opt *(Default: 10 / Maximum: 30)*

**Example**

```php
$unsplash = new Cetteup\Unsplash\HttpClient('YOUR APPLICATION ID');
$results = $unsplash->search_users('photography', 1, 15);
```

----

#### Cetteup\Unsplash\HttpClient->collection_all($page, $per_page)
Get a single page from the list of all collections.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required
---------------|------|--------------
`$page`        | int  | Opt *(Default: 1)*
`$per_page`    | int  | Opt *(Default: 10 / Maximum: 30)*

**Example**

```php
$unsplash = new Cetteup\Unsplash\HttpClient('YOUR APPLICATION ID');
$collections = $unsplash->collection_all(10, 30);
```

----

#### Cetteup\Unsplash\HttpClient->collection_featured($page, $per_page)
Get a single page from the list of featured collections.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required
---------------|------|--------------
`$page`        | int  | Opt *(Default: 1)*
`$per_page`    | int  | Opt *(Default: 10 / Maximum: 30)*

**Example**

```php
$unsplash = new Cetteup\Unsplash\HttpClient('YOUR APPLICATION ID');
$collections = $unsplash->collection_featured(2, 10);
```

----

#### Cetteup\Unsplash\HttpClient->collection_find($id)
Retrieve a single collection.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required | Note
---------------|------|--------------|------
`$id`          | int | Required

**Example**

```php
$unsplash = new Cetteup\Unsplash\HttpClient('YOUR APPLICATION ID');
$collection = $unsplash->collection_find(1121542);
```

----

#### Cetteup\Unsplash\HttpClient->collection_photos($id, $page, $per_page, $orientation)
Retrieve a collection’s photos.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required | Note
---------------|------|--------------|------
`$id`          | int | Required
`$page`        | int  | Opt *(Default: 1)*
`$per_page`    | int  | Opt *(Default: 10 / Maximum: 30)*
`$orientation` | string | Opt | Accepted values: `landscape`, `portrait`, `squarish`

**Example**

```php
$unsplash = new Cetteup\Unsplash\HttpClient('YOUR APPLICATION ID');
$photos = $unsplash->collection_photos(1121542, 1, 10, 'squarish');
```

----

#### Cetteup\Unsplash\HttpClient->collection_related($id)
Retrieve a list of related collections.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required
---------------|------|--------------
`$id`          | int | Required

**Example**

```php
$unsplash = new Cetteup\Unsplash\HttpClient('YOUR APPLICATION ID');
$collections = $unsplash->collection_related(1121542);
```

----

#### Cetteup\Unsplash\HttpClient->stats_total()
Get a list of stats for all of Unsplash.

*Note:* You need to instantiate an httpclient object first

**Example**

```php
$unsplash = new Cetteup\Unsplash\HttpClient('YOUR APPLICATION ID');
$stats = $unsplash->stats_total();
```

----

#### Cetteup\Unsplash\HttpClient->stats_month()
Get the overall Unsplash stats for the past 30 days.

*Note:* You need to instantiate an httpclient object first

**Example**

```php
$unsplash = new Cetteup\Unsplash\HttpClient('YOUR APPLICATION ID');
$stats = $unsplash->stats_month();
```
