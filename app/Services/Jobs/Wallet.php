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
        try {
            DB::beginTransaction();

            $user = $this->user->findOrFail($data['user_id']);

            if ($user->balance < $data['amount']) {
                return [
                    'status'  => false,
                    'message' => 'Insufficient balance'
                ];
            }

            $existing = $this->transaction->where('order_id', $data['order_id'])->first();

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

            return [
                'status'  => true,
                'message' => 'Withdraw successful'
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            $this->transaction->create([
                'order_id'    => $data['order_id'],
                'user_id'     => $data['user_id'],
                'amount'      => $data['amount'],
                'type'        => self::WITHDRAW,
                'status'      => self::FAILED,
                'description' => 'Withdraw failed. Error: ' . $e->getCode()
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
        try {
            DB::beginTransaction();
            Log::info('Deposit Started: ', [
                'user_id'  => $data['user_id'],
                'amount'   => $data['amount'],
                'order_id' => $data['order_id'],
            ]);
            $existing = $this->transaction->where('order_id', $data['order_id'])->first();

            Log::info('Deposit Existing: ', [
                'existing' => $existing
            ]);

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

            return [
                'status'  => true,
                'message' => 'Deposit successful'
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            $this->transaction->create([
                'order_id'    => $data['order_id'],
                'user_id'     => $data['user_id'],
                'amount'      => $data['amount'],
                'type'        => self::DEPOSIT,
                'status'      => self::FAILED,
                'description' => 'Deposit failed. Error: ' . $e->getCode()
            ]);

            return [
                'status'  => false,
                'message' => 'Deposit failed. Error: ' . $e->getMessage()
            ];
        }
    }
}
