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
    Log::info('Wallet Job Started: ', [
      'user_id'  => $this->userId,
      'amount'   => $this->amount,
      'order_id' => $this->orderId,
      'type'     => $this->type
    ]);

    $result = null;
    $params = [
      'user_id'  => $this->userId,
      'amount'   => $this->amount,
      'order_id' => $this->orderId
    ];

    if ($this->type === $wallet::DEPOSIT) {
      Log::info('Wallet Job Deposit: ', $params);

      $result = $wallet->deposit($params);
    } elseif ($this->type === $wallet::WITHDRAW) {
      Log::info('Wallet Job Withdraw: ', $params);

      $result = $wallet->withdraw($params);
    }

    Log::info('Wallet Job Finished: ', [
      'user_id'  => $this->userId,
      'amount'   => $this->amount,
      'order_id' => $this->orderId,
      'type'     => $this->type,
      'result'   => $result
    ]);

    return $result;
  }
}
