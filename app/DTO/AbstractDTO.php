<?php

namespace App\DTO;

class AbstractDTO
{
    /**
     * @var int|null
     */
    protected $userId;

    /**
     * @param int|null $id
     */
    public function __construct(int $id = null)
    {
        $this->userId = $id ?? auth()->user()->id;
    }


    public function toArray()
    {
        $array = [];
        $reflection = new \ReflectionClass($this);

        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $array[$property->getName()] = $property->getValue($this);
        }

        return $array;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }
}
