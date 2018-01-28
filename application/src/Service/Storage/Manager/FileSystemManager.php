<?php
/**
 * Author: AWSM3
 * FileSystemManager.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Service\Storage\Manager;

/** @uses */
use App\Api\FileSystem\Interfaces\GetFileResponseInterface;
use App\Service\Storage\Exception\FileAlreadyStoredException;
use App\Service\Storage\Interfaces\StoredFileInterface;
use App\Service\Storage\Manager;
use App\Utils\Http\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use App\Api\FileSystem\Client as FileSystemClient;

/**
 * Class FileSystemManager
 *
 * @package App\Service\Storage\Manager
 */
class FileSystemManager extends Manager
{
    /** @var FileSystemClient */
    private $filesystemClient;

    /**
     * FileSystemManager constructor.
     *
     * @param ContainerInterface $container
     * @param Filesystem $filesystem
     * @param Request $requestUtil
     * @param FileSystemClient $filesystemClient
     */
    public function __construct(ContainerInterface $container, Filesystem $filesystem, Request $requestUtil, FileSystemClient $filesystemClient)
    {
        parent::__construct($container, $filesystem, $requestUtil);
        $this->filesystemClient = $filesystemClient;
    }

    /**
     * @param string $id
     * @param string|null $sharding
     *
     * @return StoredFileInterface
     */
    public function getStoredFile(string $id, string $sharding = null): StoredFileInterface
    {
        $getFileResponse = $this->filesystemClient->getFile($id);
        $preparedFilepathData = [
            $getFileResponse->getData(GetFileResponseInterface::KEY_DATA_FILENAME),
            $sharding ?? $getFileResponse->getData(GetFileResponseInterface::KEY_DATA_ID)
        ];
        try {
            $this->checkFileExists(...$preparedFilepathData);
            $fileContent = $this->requestUtil->getFileContent($getFileResponse);
            $storedFile = $this->storeFileFromContent(
                $fileContent,
                ...$preparedFilepathData
            );
        } catch (FileAlreadyStoredException $e) {
            $storedFile = $e->getStoredFile();
        }

        return $storedFile;
    }
}