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
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class Request
 *
 * @package App\Utils\Http
 */
class Request
{
    /** @var Client */
    private $httpClient;
    /** @var null|HttpFoundationRequest */
    private $request;

    /**
     * Request constructor.
     *
     * @param Client $httpClient
     * @param RequestStack $requestStack
     */
    public function __construct(Client $httpClient, RequestStack $requestStack)
    {
        $this->httpClient = $httpClient;
        $this->request = $requestStack->getCurrentRequest();
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

    /**
     * @param string $path
     *
     * @return string
     */
    public function makeAbsolutePublicPath(string $path): string
    {
        return "//{$this->request->getHttpHost()}".$path;
    }
}