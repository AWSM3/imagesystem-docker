<?php
/**
 * @filename: ResponseInterface.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Response;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface ResponseInterface
 * @package App\Response
 */
interface ResponseInterface
{
    const
        HTTP_OK           = Response::HTTP_OK,
        HTTP_CREATED      = Response::HTTP_CREATED,
        HTTP_BAD_REQUEST  = Response::HTTP_BAD_REQUEST,
        HTTP_UNAUTHORIZED = Response::HTTP_UNAUTHORIZED;


    /**
     * @return int
     */
    public function getHttpStatus(): int;

    /**
     * @param int $httpStatus
     *
     * @return ResponseInterface
     */
    public function setHttpStatus(int $httpStatus): ResponseInterface;

    /**
     * @return bool
     */
    public function getStatus(): bool;

    /**
     * @param bool $status
     *
     * @return AbstractResponse
     */
    public function setStatus(bool $status): ResponseInterface;

    /**
     * @return array
     */
    public function getMessages(): array;

    /**
     * @param array $messages
     *
     * @return AbstractResponse
     */
    public function setMessages(array $messages): ResponseInterface;

    /**
     * @return mixed
     */
    public function getData();

    /**
     * @param mixed $data
     *
     * @return AbstractResponse
     */
    public function setData($data);
}