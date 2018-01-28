<?php
/**
 * Author: AWSM3
 * AbstractMethod.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Api\FileSystem\Method;

/** @uses */
use App\Api\FileSystem\Client;
use App\Api\FileSystem\Exception\BadResponseException;
use App\Api\FileSystem\Exception\InvalidResponseJson;
use App\Api\FileSystem\Interfaces\ResponseInterface;
use App\Api\FileSystem\Request;
use App\Api\FileSystem\Response;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;

/**
 * Class AbstractMethod
 *
 * @package App\Api\FileSystem\Methods
 */
abstract class AbstractMethod
{
    /** @var Client */
    private $client;
    /** @var \GuzzleHttp\Client */
    protected $httpClient;
    /** @var string */
    protected $baseUrl;

    /**
     * AbstractMethod constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->httpClient = $client->getHttpClient();
        $this->baseUrl = $client->getBaseUrl();
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    abstract public function makeRequest(Request $request);

    /**
     * @param HttpResponseInterface $response
     *
     * @throws InvalidResponseJson
     * @return array
     */
    protected function makeResponseData(HttpResponseInterface $response): array
    {
        if ($response->getStatusCode() !== ResponseInterface::SUCCESS_CODE) {
            throw new BadResponseException('Не получен требуемый ответ от файлового сервиса.', $response);
        }

        $responseContent = $response->getBody()->getContents();
        try {
            $responseArray = \GuzzleHttp\json_decode($responseContent, true);
        } catch (\InvalidArgumentException $e) {
            throw new InvalidResponseJson('Ответ файлового сервиса не является валидным JSON-объектом.', $response);
        }

        return $responseArray;
    }
}