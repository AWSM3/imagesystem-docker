<?php
/**
 * Author: AWSM3
 * ImageProcessingController.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Controller;

/** @uses */
use App\Service\ImageProcessing\Exception\ImageAlreadyProcessed;
use App\Service\ImageProcessing\Manager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ImageProcessingController
 *
 * @package App\Controller
 */
class ImageProcessingController extends Controller
{
    /** @var Manager */
    private $imageProcessingManager;

    /**
     * ImageProcessingController constructor.
     *
     * @param Manager $imageProcessingManager
     */
    public function __construct(Manager $imageProcessingManager)
    {
        // $this->imageProcessingManager = $imageProcessingManager;
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
     *     name="get_image"
     * )
     * @param int $width
     * @param int $height
     * @param string $id
     * @param string $extension
     *
     * @return RedirectResponse
     */
    public function crop(int $width, int $height, string $id, string $extension)
    {
        $src = 'http://filesystem.local/files/e0443_24_01_2018/e0443b2f-010c-11e8-aac4-0242ac190002.jpg';
        $options = [
            'http' => [
                'method'=>"GET",
                'header'=>"Accept-language: en\r\n".
                    "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.2 (KHTML, like Gecko) Chrome/22.0.1216.0 Safari/537.2\r\n"
            ]
        ];
        $context  = stream_context_create($options);
        $image = @file_get_contents($src, false, $context);
        $file = 'php://memory'; //full memory buffer
        $o = new \SplFileObject($file, 'w+');
        $o->fwrite($image);


        // $manager = \Intervention\Image\ImageManagerStatic::configure(['driver' => 'imagick']);
        return \Intervention\Image\ImageManagerStatic::make($o)->resize(100, 300)->response('jpeg');

        dd('asd', $manager->make($src)->resize(100, 50));


        try {
            $imagePublicPath = $this->imageProcessingManager->crop($id, $width, $id);
        } catch (ImageAlreadyProcessed $e) {
            $imagePublicPath = $e->getProcessedImage()->getAbsolutePublicPath();
        }

        return new RedirectResponse($imagePublicPath);
    }
}