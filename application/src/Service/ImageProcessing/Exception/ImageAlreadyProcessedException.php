<?php
/**
 * Author: AWSM3
 * ImageAlreadyProcessedException.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Service\ImageProcessing\Exception;

/** @uses */
use App\Service\ImageProcessing\Interfaces\ProcessedImageInterface;
use Throwable;

/**
 * Class ImageAlreadyProcessedException
 *
 * @package App\Service\ImageProcessing\Exception
 */
class ImageAlreadyProcessedException extends \RuntimeException
{
    /** @var ProcessedImageInterface */
    private $processedImage;

    /**
     * ImageAlreadyProcessedException constructor.
     *
     * @param string $message
     * @param ProcessedImageInterface $processedImage
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", ProcessedImageInterface $processedImage, int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->processedImage = $processedImage;
    }

    /**
     * @return ProcessedImageInterface
     */
    public function getProcessedImage(): ProcessedImageInterface
    {
        return $this->processedImage;
    }

    /**
     * @param ProcessedImageInterface $processedImage
     */
    public function setProcessedImage(ProcessedImageInterface $processedImage): void
    {
        $this->processedImage = $processedImage;
    }
}