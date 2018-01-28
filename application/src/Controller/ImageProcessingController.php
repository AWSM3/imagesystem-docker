<?php
/**
 * Author: AWSM3
 * ImageProcessingController.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Controller;

/** @uses */
use App\Api\FileSystem\Client;
use App\Service\ImageProcessing\Manager as ImageProcessingManager;
use App\Service\Storage\Manager\FileSystemManager as FileSystemStorageManager;
use App\Utils\Http\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ImageProcessingController
 *
 * @package App\Controller
 */
class ImageProcessingController extends Controller
{
    /** @var ImageProcessingManager */
    private $imageProcessingManager;
    /** @var Client */
    private $filesystemClient;
    /** @var Request */
    private $requestUtil;
    /** @var FileSystemStorageManager */
    private $storageManager;

    /**
     * ImageProcessingController constructor.
     *
     * @param ImageProcessingManager $imageProcessingManager
     * @param Client $filesystemClient
     * @param Request $requestUtil
     * @param FileSystemStorageManager $storageManager
     */
    public function __construct(
        ImageProcessingManager $imageProcessingManager,
        Client $filesystemClient,
        Request $requestUtil,
        FileSystemStorageManager $storageManager
    ) {
        $this->imageProcessingManager = $imageProcessingManager;
        $this->filesystemClient = $filesystemClient;
        $this->requestUtil = $requestUtil;
        $this->storageManager = $storageManager;
    }


    /**
     * @Route(
     *     "/crop/{width}:{height}/{id}.{extension}",
     *     requirements={
     *         "width": "[\d]{2,4}",
     *         "height": "[\d]{2,4}",
     *         "id": "[\w-]+",
     *         "extension": "[\w]+"
     *     },
     *     methods={"GET"},
     *     name="crop_image"
     * )
     * @param int $width
     * @param int $height
     * @param string $id
     * @param string $extension
     *
     * @return void
     */
    public function crop(int $width, int $height, string $id, string $extension)
    {
        $storedFile = $this->storageManager->getStoredFile($id);
        $this->imageProcessingManager->crop($storedFile->getFile(), $width, $height);

        /** @ToDo: сейчас файлы отдаются самим PHP, вероятно, это может вылезти боком, посмотрим.  */
//        try {
//            $storedFile = $this->storageManager->getStoredFile($id);
//            $processedImage = $this->imageProcessingManager->crop($storedFile->getFile(), $width, $height);
//        } catch (ImageAlreadyProcessed $e) {
//            $processedImage = $e->getProcessedImage();
//        }
//
//        return new RedirectResponse($processedImage->getAbsolutePublicPath());
    }

    /**
     * @Route(
     *     "/resize/{width}:{height}/{id}.{extension}",
     *     requirements={
     *         "width": "[\d]{2,4}",
     *         "height": "[\d]{2,4}",
     *         "id": "[\w-]+",
     *         "extension": "[\w]+"
     *     },
     *     methods={"GET"},
     *     name="resize_image"
     * )
     * @param int $width
     * @param int $height
     * @param string $id
     * @param string $extension
     *
     * @return void
     */
    public function resize(int $width, int $height, string $id, string $extension)
    {
        $storedFile = $this->storageManager->getStoredFile($id);
        $this->imageProcessingManager->resize($storedFile->getFile(), $width, $height);
    }
}