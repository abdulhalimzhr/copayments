<?php

namespace App\Services\Payment;

use App\DTO\SimulateDepositDTO;
use App\Services\AbstractService;

class SimulateDeposit extends AbstractService
{
  /**
   * @param array $data
   * 
   * @return array
   */
  public function deposit(SimulateDepositDTO $dto): array
  {
    return [
      'status' => true,
      'message' => 'Deposit queued successfully',
      'data' => [
        'order_id' => $dto->getOrderId(),
        'amount'   => $dto->getAmount(),
        'status'   => self::SUCCESS,
      ]
    ];
  }
}
