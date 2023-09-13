<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\Jobs\Wallet;
use Illuminate\Support\Facades\Log;

class WalletJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public $amount;
  public $type;
  public $userId;
  public $orderId;

  /**
   * @param int $userId
   * @param array $data
   */
  public function __construct(int $userId, array $data)
  {
    $this->userId  = $userId;
    $this->amount  = $data['amount'];
    $this->orderId = $data['order_id'];
    $this->type    = $data['type'];
  }

  /**
   * Execute the job.
   */
  public function handle(Wallet $wallet): array
  {
    try {
      $params = [
        'user_id'  => $this->userId,
        'amount'   => $this->amount,
        'order_id' => $this->orderId
      ];

      Log::info('Wallet Job Started: ', $params);

      switch ($this->type) {
        case Wallet::WITHDRAW:
          $result = $wallet->withdraw($params);
          break;
        case Wallet::DEPOSIT:
          $result = $wallet->deposit($params);
          break;
        default:
          $result = [
            'status'  => false,
            'message' => 'Invalid transaction type'
          ];
          break;
      }

      Log::info('Wallet Job Result: ', $result);

      return $result;
    } catch (\Exception $e) {
      if ($this->attempts() > 3) {
        Log::error('Wallet Job Error: ', [
          'message' => $e->getMessage(),
          'trace'   => $e->getTraceAsString()
        ]);

        return [
          'status'  => false,
          'message' => 'An error occured while processing your request'
        ];
      } else {
        Log::info('Wallet Job Retrying: ', [
          'message' => $e->getMessage(),
          'trace'   => $e->getTraceAsString()
        ]);

        $this->release(60);
        return [
          'status'  => false,
          'message' => 'An error occured while processing your request. Retrying...'
        ];
      }
    }
  }

  /**
   * @return \DateTimeInterface
   */
  public function retryUntil()
  {
    return now()->addMinutes(30);
  }

  /**
   * Calculate the number of seconds to wait before retrying the job.
   *
   * @return array<int, int>
   */
  public function backoff(): array
  {
    return [60, 120, 240, 300];
  }
}
