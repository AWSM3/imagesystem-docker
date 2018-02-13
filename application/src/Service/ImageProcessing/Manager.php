<?php
/**
 * Author: AWSM3
 * ...description...
 * Manager.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Service\ImageProcessing;

/** @uses */
use App\Service\ImageProcessing\Exception\NotAllowedSizesException;
use League\Glide\Server;
use League\Glide\ServerFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class Manager
 *
 * @package App\Service\ImageProcessing
 */
class Manager
{
    const
        MAX_WIDTH = 1000,
        MAX_HEIGHT = 1000;

    /** @var Server */
    private $imageServer;
    /** @var ContainerInterface */
    private $container;
    /** @var string */
    private $sourcePath;
    /** @var string */
    private $cachePath;

    /**
     * Manager constructor.
     *
     * @param ContainerInterface $container
     * @param ServerFactory $imageServerFactory
     */
    public function __construct(ContainerInterface $container, ServerFactory $imageServerFactory)
    {
        $this->sourcePath = $container->getParameter('imagestorage_dir');
        $this->cachePath = $container->getParameter('imagecachestorage_dir');
        $this->imageServer = $imageServerFactory->create(
            [
                'source' => $container->getParameter('imagestorage_dir'),
                'cache'  => $container->getParameter('imagecachestorage_dir'),
                'driver' => $container->getParameter('glide_driver')
            ]
        );
        $this->container = $container;
    }

    /**
     * @param File $file
     * @param int $width
     * @param int $height
     *
     * @return string
     * @throws \Exception
     */
    public function crop(File $file, int $width, int $height): string
    {
        $publicPath = $this->getPublicPath($file);
        $this->checkSizes($width, $height);

        try {
            $cachedImagePath = $this->imageServer->makeImage($publicPath, ['w' => $width, 'h' => $height, 'fit' => 'crop-center']);
        } catch (\Exception $e) {
            throw $e;
        }

        return $this->getCachedPath($cachedImagePath);
    }

    /**
     * @param File $file
     * @param int $width
     * @param int $height
     *
     * @return string
     * @throws \Exception
     */
    public function resize(File $file, int $width, int $height): string
    {
        $publicPath = $this->getPublicPath($file);
        $this->checkSizes($width, $height);

        try {
            $cachedImagePath = $this->imageServer->makeImage($publicPath, ['w' => $width, 'h' => $height]);
        } catch (\Exception $e) {
            throw $e;
        }

        return $this->getCachedPath($cachedImagePath);
    }

    /**
     * @param File $file
     *
     * @return mixed
     */
    public function getPublicPath(File $file): string
    {
        $publicPath = str_replace($this->sourcePath, '', $file->getRealPath());

        return $publicPath;
    }

    /**
     * @param $width
     * @param $height
     *
     * @throws NotAllowedSizesException
     */
    private function checkSizes($width, $height)
    {
        if ($width > self::MAX_WIDTH || $height > self::MAX_HEIGHT) {
            throw new NotAllowedSizesException(
                'Недопустимые значения размеров. Максимальная высота:'.self::MAX_HEIGHT.'. Максимальная ширина:'.self::MAX_WIDTH
            );
        }
    }

    /**
     * @param string $path
     *
     * @return string
     */
    private function getCachedPath(string $path): string
    {
        return $this->cachePath.DIRECTORY_SEPARATOR.$path;
    }
}