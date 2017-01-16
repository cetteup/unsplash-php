<?php
namespace Diza\Unsplash;

class ResponseArray extends \ArrayObject
{
    private $headers;

    const LAST = 'last';
    const PREV = 'prev';
    const NEXT = 'next';
    const FIRST = 'first';

    const LINK = 'Link';
    const TOTAL = 'X-Total';
    const PER_PAGE = 'X-Per-Page';
    const X_Ratelimit_Limit = 'X-Ratelimit-Limit';
    const X_Ratelimit_Remaining = 'X-Ratelimit-Remaining';

    /**
     * @param array $headers
     * @param array $body
     */
    public function __construct($headers, $body)
    {
        $this->headers = $headers;

        parent::__construct($body);
    }

    /**
     * Total number of pages for this call
     * Source: https://github.com/unsplash/unsplash-php
     * @return int Total page
     */
    public function totalPages()
    {
        $total = $this->totalObjects();
        $perPage = $this->objectsPerPage();

        return (int) ceil($total / $perPage);
    }

    /**
     * Total of object in the collections
     * Value come from X-Total header's value
     * Source: https://github.com/unsplash/unsplash-php
     * @return int Number of Objects
     */
    public function totalObjects()
    {
        $total = 0;
        if (!empty($this->headers[self::TOTAL]) && is_array($this->headers[self::TOTAL])) {
            $total = (int) $this->headers[self::TOTAL][0];
        }

        return $total;
    }

    /**
     * Number of element per page
     * Source: https://github.com/unsplash/unsplash-php
     * @return int element per page
     */
    public function objectsPerPage()
    {
        $perPage = 10;
        if (!empty($this->headers[self::PER_PAGE]) && is_array($this->headers[self::PER_PAGE])) {
            $perPage = (int) $this->headers[self::PER_PAGE][0];
        }

        return $perPage;
    }
}
?>
