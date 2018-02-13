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
     * @param string $originalPath
     * @param string $destinationPath
     *
     * @throws \Exception
     * @return StoredFileInterface
     */
    public function copyFile(string $originalPath, string $destinationPath): StoredFileInterface
    {
        $this->checkFileExists($originalPath);
        $file = new File($originalPath);
        try {
            $this->filesystem->copy($originalPath, $destinationPath);
        } catch (\Exception $e) {
            throw $e;
        }

        return $this->getFile($destinationPath);
    }

    /**
     * @param StoredFileInterface $storedFile
     *
     * @return string
     */
    public function getPublicPath(StoredFileInterface $storedFile): string
    {
        $sourcePath = $this->container->getParameter('imagestorage_dir');
        $publicImagePath = $this->container->getParameter('publicimagestorage_dir');
        $publicPath = $publicImagePath . str_replace($sourcePath, '', $storedFile->getFile()->getRealPath());

        return $this->requestUtil->makeAbsolutePublicPath($publicPath);
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
     * @param string|null $sharding
     */
    protected function checkFileExists(string $filename, string $sharding = null)
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
     * @param string|null $sharding
     *
     * @return string
     */
    protected function makeFilePath(string $filename, string $sharding = null): string
    {
        $storagePath = $this->container->getParameter('imagestorage_dir');
        $filePath = $storagePath.DIRECTORY_SEPARATOR.static::SHARDING_PLACEHOLDER.$filename;
        if ($sharding) {
            $sharding .= DIRECTORY_SEPARATOR;
        }

        return str_replace(static::SHARDING_PLACEHOLDER, $sharding, $filePath);
    }
}