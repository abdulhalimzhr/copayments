<?php

namespace App\Services\Payment;

use App\Services\AbstractService;
use App\DTO\DepositDTO;
use App\Jobs\WalletJob;
use Illuminate\Support\Facades\Log;

class Deposit extends AbstractService
{
  /**
   * @param DepositDTO $dto
   * 
   * @return array
   */
  public function pay(DepositDTO $dto): array
  {
    try {
      $header = [
        'Content-Type'  => 'application/json',
        'Accept'        => 'application/json',
        'Authorization' => 'Bearer ' . env('THIRD_PARTY_API_TOKEN')
      ];

      $params = [
        'order_id'  => uniqid(),
        'amount'    => $dto->getAmount(),
        'type'      => self::DEPOSIT,
        'timestamp' => date('Y-m-d H:i:s', strtotime(now()->timestamp))
      ];

      $result = $this->callApi(env('THIRD_PARTY_API_URL'), self::POST, $header, $params);

      if (!$result['status']) {
        Log::error('Deposit Call API Failed: ', [
          'params' => $params,
          'header' => $header,
          'result' => $result
        ]);

        return [
          'status'  => false,
          'message' => 'Deposit failed'
        ];
      }

      Log::info('Deposit Call API Result: ', [
        'params' => $params,
        'header' => $header,
        'result' => $result
      ]);

      WalletJob::dispatch($dto->getUserId(), $params);

      Log::info('Deposit Queued: ', [
        'user_id' => $dto->getUserId(),
        'params'  => $params
      ]);

      return [
        'status'  => true,
        'message' => 'Deposit queued successfully'
      ];
    } catch (\Exception $e) {

      Log::error('Deposit Failed: ', [
        'params' => $params,
        'header' => $header,
        'error'  => $e->getMessage(),
        'trace'  => $e->getTraceAsString()
      ]);

      return [
        'status'  => false,
        'message' => 'Deposit failed',
        'error'   => $e->getMessage()
      ];
    }
  }
}
