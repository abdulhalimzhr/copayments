<?php

namespace App\DTO;

class DepositDTO extends AbstractDTO
{
  /**
   * @var float
   */
  private $amount;

  /**
   * @param float $amount
   */
  public function __construct($amount)
  {
    parent::__construct(auth()->user->id ?? null);
    $this->amount = $amount;
  }

  /**
   * @return float
   */
  public function getAmount(): float
  {
    return $this->amount;
  }
}
