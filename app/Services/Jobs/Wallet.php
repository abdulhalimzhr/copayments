<?php

namespace App\Services\Jobs;

use App\Services\AbstractService;
use App\Models\Transaction;
use App\Models\User;

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
            $user = $this->user->find($data['user_id']);

            if ($user->balance < $data['amount']) {
                return [
                    'status'  => false,
                    'message' => 'Insufficient balance'
                ];
            }

            $user->balance -= $data['amount'];
            $user->save();

            $this->transaction->create([
                'order_id'    => $data['order_id'],
                'user_id'     => $data['user_id'],
                'amount'      => $data['amount'],
                'type'        => self::WITHDRAW,
                'status'      => self::SUCCESS,
                'description' => 'Withdraw success.'
            ]);

            return [
                'status'  => true,
                'message' => 'Withdraw successful'
            ];
        } catch (\Exception $e) {
            $this->transaction->create([
                'order_id'    => $data['order_id'],
                'user_id'     => $data['user_id'],
                'amount'      => $data['amount'],
                'type'        => self::WITHDRAW,
                'status'      => self::FAILED,
                'description' => 'Withdraw failed. Error: ' . $e->getMessage()
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
            $user = $this->user->find($data['user_id']);

            $user->balance += $data['amount'];
            $user->save();

            $this->transaction->create([
                'order_id'    => $data['order_id'],
                'user_id'     => $data['user_id'],
                'amount'      => $data['amount'],
                'type'        => self::DEPOSIT,
                'status'      => self::SUCCESS,
                'description' => 'Deposit success.'
            ]);

            return [
                'status'  => true,
                'message' => 'Deposit successful'
            ];
        } catch (\Exception $e) {
            $this->transaction->create([
                'order_id'    => $data['order_id'],
                'user_id'     => $data['user_id'],
                'amount'      => $data['amount'],
                'type'        => self::DEPOSIT,
                'status'      => self::FAILED,
                'description' => 'Deposit failed. Error: ' . $e->getMessage()
            ]);

            return [
                'status'  => false,
                'message' => 'Deposit failed. Error: ' . $e->getMessage()
            ];
        }
    }
}
