<?php
/**
 * Author: AWSM3
 * Request.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Utils\Http;

/** @uses */

use App\Api\FileSystem\Interfaces\GetFileResponseInterface;
use GuzzleHttp\Client;

/**
 * Class Request
 *
 * @package App\Utils\Http
 */
class Request
{
    /** @var Client */
    private $httpClient;

    /**
     * Request constructor.
     *
     * @param Client $httpClient
     */
    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }


    /**
     * @param GetFileResponseInterface $getFileResponse
     *
     * @return string
     */
    public function getFileContent(GetFileResponseInterface $getFileResponse): string
    {
        $response = $this->httpClient->get($getFileResponse->getData(GetFileResponseInterface::KEY_DATA_URL));
        $content = $response->getBody()->getContents();

        return $content;
    }
}