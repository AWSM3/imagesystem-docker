<?php
/**
 * @filename: ArrayResponse.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Response\Types;

/** @uses */
use App\Response\AbstractResponse;

/**
 * Class ArrayResponse
 * @package App\Response\Types
 */
class ArrayResponse extends AbstractResponse
{
    const
        STATUS_KEY = 'status',
        MESSAGES_KEY = 'messages',
        DATA_KEY = 'data';

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            self::STATUS_KEY   => $this->getStatus(),
            self::MESSAGES_KEY => $this->getMessages(),
            self::DATA_KEY     => $this->getData(),
        ];
    }
}