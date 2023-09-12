<?php

namespace App\DTO;

class TransactionDTO extends AbstractDTO
{
    /**
     * @var int
     */
    private $perPage;

    /**
     * @var string|null
     */
    private $search;

    /**
     * @param int $perPage
     * @param string $search
     */
    public function __construct(int $perPage, ?string $search)
    {
        $this->perPage = $perPage;
        $this->search  = $search;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * @return string|null
     */
    public function getSearch(): ?string
    {
        return $this->search;
    }
}
