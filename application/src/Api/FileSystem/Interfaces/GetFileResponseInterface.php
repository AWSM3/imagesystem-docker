<?php
/**
 * Author: AWSM3
 * GetFileResponseInterface.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Api\FileSystem\Interfaces;

/**
 * Interface GetFileResponseInterface
 *
 * @package App\Api\FileSystem\Interfaces
 */
interface GetFileResponseInterface extends ResponseInterface
{
    const
        KEY_DATA_URL = 'url',
        KEY_DATA_TITLE = 'title',
        KEY_DATA_ID = 'id',
        KEY_DATA_EXTENSION = 'extension',
        KEY_DATA_FILENAME = 'filename';
}
