<?php
/**
 * Author: AWSM3
 * ...description...
 * ProcessedImageInterface.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Service\ImageProcessing\Interfaces;

/**
 * Interface ProcessedImageInterface
 *
 * @package App\Service\ImageProcessing\Interfaces
 */
interface ProcessedImageInterface
{
    /**
     * @return string
     */
    public function getAbsolutePublicPath(): string;
}