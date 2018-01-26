<?php
/**
 * Author: AWSM3
 * BadResponseException.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Api\FileSystem\Exception;

/** @uses */
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Class BadResponseException
 *
 * @package App\Api\FileSystem\Exception
 */
class BadResponseException extends \RuntimeException
{
    /** @var ResponseInterface */
    private $response;

    /**
     * BadResponseException constructor.
     *
     * @param string $message
     * @param ResponseInterface $response
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", ResponseInterface $response, int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->response = $response;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}