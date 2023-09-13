<?php

namespace App\Services\Payment;

use App\Services\AbstractService;
use App\DTO\WithdrawDTO;
use App\Jobs\WalletJob;
use Illuminate\Support\Facades\Log;

class Withdraw extends AbstractService
{
  /**
   * @param WithdrawDTO $dto
   * 
   * @return array
   */
  public function withdraw($dto): array
  {
    $params = [
      'order_id' => uniqid('wd_'),
      'amount'   => $dto->getAmount(),
      'type'     => self::WITHDRAW
    ];

    WalletJob::dispatch($dto->getUserId(), $params);

    Log::info('Withdraw Queued: ', [
      'user_id' => $dto->getUserId(),
      'params'  => $params
    ]);

    return [
      'status' => true,
      'message' => 'Withdrawal in progress. Please wait up to a few minutes for the process to complete.'
    ];
  }
}
