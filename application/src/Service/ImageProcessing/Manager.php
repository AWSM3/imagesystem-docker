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

    /**
     * Manager constructor.
     *
     * @param ContainerInterface $container
     * @param ServerFactory $imageServerFactory
     */
    public function __construct(ContainerInterface $container, ServerFactory $imageServerFactory)
    {
        $this->sourcePath = $container->getParameter('imagestorage_dir');
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
     * @return void
     */
    public function crop(File $file, int $width, int $height): void
    {
        $publicPath = $this->getPublicPath($file);
        $this->checkSizes($width, $height);

        $this->imageServer->outputImage($publicPath, ['w' => $width, 'h' => $height, 'fit' => 'crop-center']);
    }

    /**
     * @param File $file
     * @param int $width
     * @param int $height
     *
     * @return void
     */
    public function resize(File $file, int $width, int $height): void
    {
        $publicPath = $this->getPublicPath($file);
        $this->checkSizes($width, $height);

        $this->imageServer->outputImage($publicPath, ['w' => $width, 'h' => $height]);
    }

    /**
     * @param File $file
     *
     * @return mixed
     */
    private function getPublicPath(File $file): string
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
}