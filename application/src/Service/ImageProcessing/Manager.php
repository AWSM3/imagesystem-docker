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
    public function crop(File $file, int $width, int $height): void {
        $publicPath = $this->getPublicPath($file);

        $this->imageServer->outputImage($publicPath, ['w' => $width, 'h' => $height, 'fit' => 'crop-center']);
    }

    /**
     * @param File $file
     *
     * @return mixed
     */
    private function getPublicPath(File $file): mixed
    {
        $publicPath = str_replace($this->sourcePath, '', $file->getRealPath());

        return $publicPath;
    }
}