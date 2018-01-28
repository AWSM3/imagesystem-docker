<?php
/**
 * Author: AWSM3
 * Response.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Api\FileSystem;

/** @uses */
use App\Api\FileSystem\Exception\IncorrectDataItemException;
use App\Api\FileSystem\Interfaces\ResponseInterface;

/**
 * Class Response
 *
 * @package App\Api\FileSystem
 */
class Response implements ResponseInterface
{
    /** @var bool */
    private $status = false;

    /** @var array */
    private $messages = [];

    /** @var mixed */
    private $data = null;

    /**
     * Response constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->status = $data['status'] ?? $this->status;
        $this->messages = $data['messages'] ?? [];
        $this->data = $data['data'] ?? $this->data;
    }

    /**
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->status;
    }

    /**
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * @param string|null $key
     *
     * @throws IncorrectDataItemException
     * @return mixed
     */
    public function getData(string $key = null)
    {
        if (!$key) {
            return $this->data;
        }
        if (!isset($this->data[$key])) {
            throw new IncorrectDataItemException("Ключ модели данных `{$key}` не обнаружен.");
        }

        return $this->data[$key];
    }

    /**
     * @return string
     *
     * @throws \RuntimeException
     */
    public function getFileUrl(): string
    {
        $fileUrl = $this->data['url'];
        if (!$fileUrl) {
            throw new \RuntimeException('У файла не обнаружен пабличный URL.');
        }

        return $fileUrl;
    }
}