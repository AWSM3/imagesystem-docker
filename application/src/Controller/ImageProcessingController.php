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
use App\Response\ResponseInterface;
use App\Response\Types\ImageResponse;
use App\Service\ImageProcessing\Manager as ImageProcessingManager;
use App\Service\Storage\Manager\FileSystemManager as FileSystemStorageManager;
use App\Utils\Http\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    /** @var ImageResponse */
    private $imageResponse;

    /**
     * ImageProcessingController constructor.
     *
     * @param ImageProcessingManager $imageProcessingManager
     * @param Client $filesystemClient
     * @param Request $requestUtil
     * @param FileSystemStorageManager $storageManager
     * @param ImageResponse $imageResponse
     */
    public function __construct(
        ImageProcessingManager $imageProcessingManager,
        Client $filesystemClient,
        Request $requestUtil,
        FileSystemStorageManager $storageManager,
        ImageResponse $imageResponse
    ) {
        $this->imageProcessingManager = $imageProcessingManager;
        $this->filesystemClient = $filesystemClient;
        $this->requestUtil = $requestUtil;
        $this->storageManager = $storageManager;
        $this->imageResponse = $imageResponse;
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
     * @return JsonResponse|mixed
     */
    public function crop(int $width, int $height, string $id, string $extension)
    {
        $storedFile = $this->storageManager->getStoredFile($id);
        $imageResponse = $this->imageResponse;
        try {
            $cachedImagePath = $this->imageProcessingManager->crop($storedFile->getFile(), $width, $height);
            $destinationFilePath = $cachedImagePath.'.'.$storedFile->getFile()->getExtension();
            $storedFile = $this->storageManager->copyFile($cachedImagePath, $destinationFilePath);

            $imageResponse->setData($this->storageManager->getPublicPath($storedFile));
            $imageResponse->setStatus(true);
            $imageResponse->setHttpStatus(ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            $imageResponse->setStatus(false);
            $imageResponse->setHttpStatus(ResponseInterface::HTTP_BAD_REQUEST);
        }


        return new JsonResponse($imageResponse->toArray(), $imageResponse->getHttpStatus());
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
     * @return JsonResponse|mixed
     */
    public function resize(int $width, int $height, string $id, string $extension)
    {
        $storedFile = $this->storageManager->getStoredFile($id);
        $imageResponse = $this->imageResponse;
        try {
            $cachedImagePath = $this->imageProcessingManager->resize($storedFile->getFile(), $width, $height);
            $destinationFilePath = $cachedImagePath.'.'.$storedFile->getFile()->getExtension();
            $storedFile = $this->storageManager->copyFile($cachedImagePath, $destinationFilePath);

            $imageResponse->setStatus(true);
            $imageResponse->setData($this->storageManager->getPublicPath($storedFile));
            $imageResponse->setHttpStatus(ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            $imageResponse->setStatus(false);
            $imageResponse->setHttpStatus(ResponseInterface::HTTP_BAD_REQUEST);
        }


        return new JsonResponse($imageResponse->toArray(), $imageResponse->getHttpStatus());
    }
}