<?php
/**
 * Author: AWSM3
 * StoredFileInterface.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Service\Storage\Interfaces;

/** @uses */

use Symfony\Component\HttpFoundation\File\File;

/**
 * Interface StoredFileInterface
 *
 * @package App\Service\Storage\Interfaces
 */
interface StoredFileInterface
{
    /**
     * @return File
     */
    public function getFile(): File;
}