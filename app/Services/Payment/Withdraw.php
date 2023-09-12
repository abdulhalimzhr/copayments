<?php

namespace App\Services\Payment;

use App\Models\Transaction;
use App\Models\User;

class Withdraw
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
        $user = $this->user->find($data['user_id']);

        if ($user->balance < $data['amount']) {
            return [
                'status' => false,
                'message' => 'Insufficient balance'
            ];
        }

        $user->balance -= $data['amount'];
        $user->save();

        $this->transaction->create([
            'user_id' => $data['user_id'],
            'amount' => $data['amount'],
            'type' => 'withdraw'
        ]);

        return [
            'status' => true,
            'message' => 'Withdraw successful'
        ];
    }
}
