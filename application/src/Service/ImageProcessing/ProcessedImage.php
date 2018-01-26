<?php
/**
 * Author: AWSM3
 * ProcessedImage.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Service\ImageProcessing;

/** @uses */
use App\Service\ImageProcessing\Interfaces\ProcessedImageInterface;

/**
 * Class ProcessedImage
 *
 * @package App\Service\ImageProcessing
 */
class ProcessedImage implements ProcessedImageInterface
{
    /** @var string */
    private $absolutePublicPath;

    /**
     * @return string
     */
    public function getAbsolutePublicPath(): string
    {
        return $this->absolutePublicPath;
    }

    /**
     * @param string $absolutePublicPath
     */
    public function setAbsolutePublicPath(string $absolutePublicPath): void
    {
        $this->absolutePublicPath = $absolutePublicPath;
    }
}