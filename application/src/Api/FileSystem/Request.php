<?php
/**
 * Author: AWSM3
 * ...description...
 * Request.php
 */
declare(strict_types=1);

/** @namespace */

namespace App\Api\FileSystem;

/** @uses */

use App\Api\FileSystem\Interfaces\RequestInterface;

/**
 * Class Request
 *
 * @package App\Api\FileSystem
 */
class Request implements RequestInterface
{
    /** @var string */
    private $id;

    /**
     * Request constructor.
     *
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return $this
     */
    public function setId(string $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        return [
            'id' => $this->id
        ];
    }
}