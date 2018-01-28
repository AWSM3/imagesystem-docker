<?php
/**
 * Author: AWSM3
 * Manager.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Service\Storage;

/** @uses */
use App\Service\Storage\Exception\FileAlreadyStoredException;
use App\Service\Storage\Interfaces\StoredFileInterface;
use App\Utils\Http\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class Manager
 *
 * @package App\Service\Storage
 */
class Manager
{
    const
        SHARDING_PLACEHOLDER = '{sharding}';

    /** @var ContainerInterface */
    private $container;
    /** @var Filesystem */
    protected $filesystem;
    /** @var Request */
    protected $requestUtil;

    /**
     * Manager constructor.
     *
     * @param ContainerInterface $container
     * @param Filesystem $filesystem
     * @param Request $requestUtil
     */
    public function __construct(ContainerInterface $container, Filesystem $filesystem, Request $requestUtil)
    {
        $this->container = $container;
        $this->filesystem = $filesystem;
        $this->requestUtil = $requestUtil;
    }

    /**
     * @param string $content
     *
     * @param string $filename
     *
     * @param string|null $sharding
     *
     * @return StoredFileInterface
     */
    protected function storeFileFromContent(
        string $content,
        string $filename,
        string $sharding = null
    ): StoredFileInterface {
        $filePath = $this->makeFilePath($filename, $sharding);
        $this->filesystem->dumpFile($filePath, $content);

        return $this->getFile($filePath);
    }

    /**
     * @param string $filename
     * @param string $sharding
     */
    protected function checkFileExists(string $filename, string $sharding)
    {
        $filePath = $this->makeFilePath($filename, $sharding);
        if ($this->filesystem->exists($filePath)) {
            $storedFile = $this->getFile($filePath);
            throw new FileAlreadyStoredException('Файл уже существует.', $storedFile);
        }
    }

    /**
     * @param string $filePath
     *
     * @return StoredFileInterface
     */
    protected function getFile(string $filePath): StoredFileInterface
    {
        $storedFile = new StoredFile();
        $storedFile->setFile(new File($filePath));

        return $storedFile;
    }

    /**
     * @param string $filename
     * @param string $sharding
     *
     * @return string
     */
    protected function makeFilePath(string $filename, string $sharding): string
    {
        $storagePath = $this->container->getParameter('imagestorage_dir');
        $filePath = $storagePath.DIRECTORY_SEPARATOR.static::SHARDING_PLACEHOLDER.$filename;
        if ($sharding) {
            $sharding .= DIRECTORY_SEPARATOR;
        }

        return str_replace(static::SHARDING_PLACEHOLDER, $sharding, $filePath);
    }
}