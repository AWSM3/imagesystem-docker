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

/**
 * Class Manager
 *
 * @package App\Service\ImageProcessing
 */
class Manager
{
    /** @var Server */
    private $imageServer;

    public function __construct()
    {
//        $this->imageServer = ServerFactory::create([]);
    }

    public function crop(int $width, int $height) {
        $this->imageServer->outputImage();
    }
}