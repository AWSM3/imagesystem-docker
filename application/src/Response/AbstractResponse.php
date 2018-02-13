<?php
/**
 * @filename: AbstractResponse.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Response;

/** @uses */

/**
 * Class AbstractResponse
 * @package App\Response
 */
abstract class AbstractResponse implements ResponseInterface
{
    /** @var int */
    private $httpStatus = ResponseInterface::HTTP_OK;
    /** @var bool */
    private $status = false;
    /** @var array */
    private $messages = [];
    /** @var mixed */
    private $data  = [];

    /**
     * В конструктор вынесены параметры, которые можно назначить сеттерами,
     * но иногда удобнее через вызов класса как функции
     *
     * @param bool $status
     * @param array $data
     * @param array $messages
     *
     * @return ResponseInterface
     */
    public function __invoke(bool $status = false, $data = [], $messages = [], int $httpStatus = ResponseInterface::HTTP_OK): ResponseInterface
    {
        $this->setStatus($status);
        $this->setHttpStatus($httpStatus);
        $this->setData($data);
        $this->setMessages($messages);

        return $this;
    }

    /**
     * @return int
     */
    public function getHttpStatus(): int
    {
        return $this->httpStatus;
    }

    /**
     * @param int $httpStatus
     *
     * @return ResponseInterface
     */
    public function setHttpStatus(int $httpStatus): ResponseInterface
    {
        $this->httpStatus = $httpStatus;

        return $this;
    }

    /**
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->status;
    }

    /**
     * @param bool $status
     *
     * @return AbstractResponse
     */
    public function setStatus(bool $status): ResponseInterface
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * @param array $messages
     *
     * @return AbstractResponse
     */
    public function setMessages(array $messages): ResponseInterface
    {
        $this->messages = $messages;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     *
     * @return AbstractResponse
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
}