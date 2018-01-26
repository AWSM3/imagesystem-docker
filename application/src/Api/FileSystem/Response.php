<?php
/**
 * Author: AWSM3
 * Response.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Api\FileSystem;

/** @uses */
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
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
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