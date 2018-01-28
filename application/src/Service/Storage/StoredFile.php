<?php
/**
 * Author: AWSM3
 * StoredFile.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Service\Storage;

/** @uses */
use App\Service\Storage\Interfaces\StoredFileInterface;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class StoredFile
 *
 * @package App\Service\Storage
 */
class StoredFile implements StoredFileInterface
{
    /** @var File */
    private $file;

    /**
     * @return File
     */
    public function getFile(): File
    {
        return $this->file;
    }

    /**
     * @param File $file
     */
    public function setFile(File $file): void
    {
        $this->file = $file;
    }
}