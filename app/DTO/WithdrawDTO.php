<?php

namespace App\DTO;

class WithdrawDTO extends AbstractDTO
{
  /**
   * @var int
   */
  private $amount;

  /**
   * @param int $amount
   */
  public function __construct($amount)
  {
    parent::__construct(auth()->user->id ?? null);
    $this->amount = $amount;
  }

  /**
   * @return int
   */
  public function getAmount(): int
  {
    return $this->amount;
  }
}
