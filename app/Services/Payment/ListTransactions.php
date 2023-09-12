<?php

namespace App\Services\Payment;

use App\Models\Transaction;
use App\DTO\TransactionListDTO;

class ListTransactions
{
  /**
   * @param TransactionListDTO $dto
   * @return array
   */
  public function getList(TransactionListDTO $dto): array
  {
    try {
      $transaction = new Transaction();

      $user = auth()->user();
      $data = $transaction->where('user_id', $user->id);

      if (!empty($dto->getSearch())) {
        $data = $data->where('description', 'like', '%' . $dto->getSearch() . '%')
          ->orWhere('amount', 'like', '%' . $dto->getSearch() . '%')
          ->orWhere('type', 'like', '%' . $dto->getSearch() . '%')
          ->orWhere('status', 'like', '%' . $dto->getSearch() . '%')
          ->orWhere('id', $dto->getSearch());
      }

      $data = $data->isNotEmpty() ? $data->paginate($dto->getPerPage()) : null;

      return [
        'status' => true,
        'data'   => $data,
      ];
    } catch (\Exception $e) {
      return [
        'status'  => false,
        'message' => $e->getMessage(),
      ];
    }
  }
}
