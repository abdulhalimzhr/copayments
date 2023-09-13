<?php

namespace App\Services\Jobs;

use App\Services\AbstractService;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Wallet extends AbstractService
{
  /**
   * @var User
   */
  private $user;

  /**
   * @var Transaction
   */
  private $transaction;

  /**
   * @param User $user
   * @param Transaction $transaction
   */
  public function __construct(User $user, Transaction $transaction)
  {
    $this->user = $user;
    $this->transaction = $transaction;
  }

  /**
   * @param array $data
   * 
   * @return array
   */
  public function withdraw(array $data): array
  {
    $existing = null;

    try {
      DB::beginTransaction();
      Log::info('Withdraw Job Started: ', $data);

      $user = $this->user->findOrFail($data['user_id']);

      if ($user->balance < $data['amount']) {
        return [
          'status'  => false,
          'message' => 'Insufficient balance'
        ];
      }

      $existing = $this->checkExistingTransaction($data);

      if (!$existing) {
        $this->transaction->create([
          'order_id'    => $data['order_id'],
          'user_id'     => $data['user_id'],
          'amount'      => $data['amount'],
          'type'        => self::WITHDRAW,
          'status'      => self::SUCCESS,
          'description' => 'Withdraw success.'
        ]);
      } else {
        $existing->status       = self::SUCCESS;
        $existing->description .= ' - Retried at ' . date('Y-m-d H:i:s');
        $existing->save();
      }

      $user->balance -= $data['amount'];
      $user->save();

      DB::commit();

      Log::info('Withdraw Job finished: ', $data);

      return [
        'status'  => true,
        'message' => 'Withdraw successful'
      ];
    } catch (\Exception $e) {
      DB::rollBack();

      if (!$existing) {
        $this->transaction->create([
          'order_id'    => $data['order_id'],
          'user_id'     => $data['user_id'],
          'amount'      => $data['amount'],
          'type'        => self::WITHDRAW,
          'status'      => self::FAILED,
          'description' => 'Withdraw failed. Error: ' . $e->getCode()
        ]);
      }

      Log::info('Withdraw Job Failed: ', [
        'user_id' => $data['user_id'],
        'amount'  => $data['amount'],
        'error'   => $e->getMessage()
      ]);

      return [
        'status'  => false,
        'message' => 'Withdraw failed. Error: ' . $e->getMessage()
      ];
    }
  }

  /**
   * @param array $data
   * 
   * @return array
   */
  public function deposit(array $data): array
  {
    $existing = null;

    try {
      DB::beginTransaction();
      Log::info('Deposit Job Started: ', $data);

      $existing = $this->checkExistingTransaction($data);

      if (!$existing) {
        $this->transaction->create([
          'order_id'    => $data['order_id'],
          'user_id'     => $data['user_id'],
          'amount'      => $data['amount'],
          'type'        => self::DEPOSIT,
          'status'      => self::SUCCESS,
          'description' => 'Deposit success.'
        ]);
      } else {
        $existing->status       = self::SUCCESS;
        $existing->description .= ' - Retried at ' . date('Y-m-d H:i:s');
        $existing->save();
      }

      $user = $this->user->findOrFail($data['user_id']);

      $user->balance += $data['amount'];
      $user->save();

      DB::commit();

      Log::info('Deposit Job Finished: ', [
        'user_id' => $data['user_id'],
        'amount'  => $data['amount'],
        'balance' => $user->balance
      ]);

      return [
        'status'  => true,
        'message' => 'Deposit successful'
      ];
    } catch (\Exception $e) {
      DB::rollBack();

      if (!$existing) {
        $this->transaction->create([
          'order_id'    => $data['order_id'],
          'user_id'     => $data['user_id'],
          'amount'      => $data['amount'],
          'type'        => self::DEPOSIT,
          'status'      => self::FAILED,
          'description' => 'Deposit failed. Error: ' . $e->getCode()
        ]);
      }

      Log::info('Deposit Job Failed: ', [
        'user_id' => $data['user_id'],
        'amount'  => $data['amount'],
        'error'   => $e->getMessage()
      ]);

      return [
        'status'  => false,
        'message' => 'Deposit failed. Error: ' . $e->getMessage()
      ];
    }
  }

  /**
   * Check existing transaction
   * @param array $data
   * 
   * @return object
   */
  private function checkExistingTransaction($data)
  {
    $result = $this->transaction->where('order_id', $data['order_id'])
      ->andWhere('user_id', $data['user_id'])
      ->andWhere('status', self::FAILED)
      ->first();

    Log::info('Failed Transaction Existing: ', [
      'existing' => $result
    ]);

    return $result;
  }
}
