<?php
/**
 * Author: AWSM3
 * GetFile.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Api\FileSystem\Method;

/** @uses */
use App\Api\FileSystem\Interfaces\GetFileResponseInterface;
use App\Api\FileSystem\Request;
use App\Api\FileSystem\Response\GetFileResponse;
use GuzzleHttp\Psr7\Response;

/**
 * Class GetFile
 *
 * @package App\Api\FileSystem\Methods
 */
class GetFile extends AbstractMethod
{
    const
        METHOD_URL = 'file';

    /**
     * @param Request $request
     *
     * @return GetFileResponseInterface
     */
    public function makeRequest(Request $request): GetFileResponseInterface
    {
        $url = $this->baseUrl.static::METHOD_URL."/".$request->getId();
        /** @var Response $httpResponse */
        $httpResponse = $this->httpClient->get($url);

        $responseData = $this->makeResponseData($httpResponse);

        return new GetFileResponse($responseData);
    }
}