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
use App\Api\FileSystem\Interfaces\ResponseInterface;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\RequestOptions;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class Client
 *
 * @package App\Api\FileSystem
 */
class Client implements ClientInterface
{
    /** @var HttpClient */
    private $client;
    /** @var string FileSystem service base API url */
    private $baseUrl;

    /**
     * Client constructor.
     *
     * @param HttpClient $client
     * @param ContainerInterface $container
     */
    public function __construct(HttpClient $client, ContainerInterface $container)
    {
        $this->client = $client;
        $this->baseUrl = $container->getParameter('filesystem_url');;
    }

    /**
     * @param string $id
     *
     * @return ResponseInterface
     */
    public function getFile(string $id): ResponseInterface
    {
        $request = new Request($id);

        $response = $this->client->get($this->baseUrl,
            [
                RequestOptions::QUERY => $request->getQuery()
            ]
        );

        if ($response->getStatusCode() !== ResponseInterface::SUCCESS_CODE) {
            throw new BadResponseException('Не получен требуемый ответ от файлового сервиса.', $response);
        }

        $responseContent = $response->getBody()->getContents();
        try {
            $responseArray = \GuzzleHttp\json_decode($responseContent, true);
        } catch (\InvalidArgumentException $e) {
            throw new InvalidResponseJson('Ответ файлового сервиса не является валидным JSON-объектом.', $response);
        }

        $responseObject = new Response($responseArray);

        return $responseObject;
    }
}