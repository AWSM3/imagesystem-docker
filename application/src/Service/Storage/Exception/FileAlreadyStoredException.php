<?php
/**
 * Author: AWSM3
 * FileAlreadyStoredException.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Service\Storage\Exception;

/** @uses */
use App\Service\Storage\Interfaces\StoredFileInterface;
use Throwable;

/**
 * Class FileAlreadyStored
 *
 * @package App\Service\Storage\Exception
 */
class FileAlreadyStoredException extends \RuntimeException
{
    /** @var StoredFileInterface */
    private $storedFile;

    /**
     * FileAlreadyStoredException constructor.
     *
     * @param string $message
     * @param StoredFileInterface $storedFile
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", StoredFileInterface $storedFile, int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->storedFile = $storedFile;
    }

    /**
     * @return StoredFileInterface
     */
    public function getStoredFile(): StoredFileInterface
    {
        return $this->storedFile;
    }

    /**
     * @param StoredFileInterface $storedFile
     */
    public function setStoredFile(StoredFileInterface $storedFile): void
    {
        $this->storedFile = $storedFile;
    }
}