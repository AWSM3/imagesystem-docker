<?php
/**
 * Author: AWSM3
 * Client.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Api\FileSystem;

/** @uses */
use App\Api\FileSystem\Exception\BadResponseException;
use App\Api\FileSystem\Exception\InvalidResponseJson;
use App\Api\FileSystem\Interfaces\ClientInterface;
use App\Api\FileSystem\Interfaces\GetFileResponseInterface;
use App\Api\FileSystem\Interfaces\ResponseInterface;
use App\Api\FileSystem\Method\GetFile;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\RequestOptions;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Client
 *
 * @package App\Api\FileSystem
 */
class Client implements ClientInterface
{
    /** @var HttpClient */
    private $httpClient;
    /** @var string FileSystem service base API url */
    private $baseUrl;

    /**
     * Client constructor.
     *
     * @param HttpClient $httpClient
     * @param ContainerInterface $container
     */
    public function __construct(HttpClient $httpClient, ContainerInterface $container)
    {
        $this->httpClient = $httpClient;
        $this->baseUrl = $container->getParameter('filesystem_url');
    }

    /**
     * @return HttpClient
     */
    public function getHttpClient(): HttpClient
    {
        return $this->httpClient;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }


    /**
     * @param string $id
     *
     * @return GetFileResponseInterface
     */
    public function getFile(string $id): GetFileResponseInterface
    {
        $request = new Request($id);
        $method = new GetFile($this);

        /** @throws \Exception */
        $response = $method->makeRequest($request);

        return $response;
    }
}