<?php
/**
 * Author: AWSM3
 * ClientInterface.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Api\FileSystem\Interfaces;

/**
 * Interface ClientInterface
 *
 * @package App\Api\FileSystem\Interfaces
 */
interface ClientInterface
{
    /**
     * @param string $id
     *
     * @return ResponseInterface
     */
    public function getFile(string $id): ResponseInterface;
}