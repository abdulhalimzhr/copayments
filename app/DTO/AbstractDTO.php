<?php

namespace App\DTO;

class AbstractDTO
{
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
}
