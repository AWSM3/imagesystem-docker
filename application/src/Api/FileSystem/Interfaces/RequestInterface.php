<?php
/**
 * Author: AWSM3
 * RequestInterface.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Api\FileSystem\Interfaces;

/**
 * Interface RequestInterface
 *
 * @package App\Api\FileSystem\Interfaces
 */
interface RequestInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @param string $id
     *
     * @return $this
     */
    public function setId(string $id);

    /**
     * @return array
     */
    public function getQuery(): array;
}