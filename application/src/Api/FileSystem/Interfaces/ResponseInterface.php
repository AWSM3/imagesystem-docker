<?php
/**
 * Author: AWSM3
 * ResponseInterface.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Api\FileSystem\Interfaces;

/**
 * Interface ResponseInterface
 *
 * @package App\Api\FileSystem\Interfaces
 */
interface ResponseInterface
{
    const
        SUCCESS_CODE = 200;

    /**
     * @return bool
     */
    public function getStatus(): bool;

    /**
     * @return array
     */
    public function getMessages(): array;

    /**
     * @param string|null $key
     *
     * @return mixed
     */
    public function getData(string $key = null);

    /**
     * @return string
     */
    public function getFileUrl(): string;
}
