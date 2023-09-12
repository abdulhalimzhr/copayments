<?php

namespace App\Services\Payment;

use App\Models\Transaction;
use App\DTO\TransactionListDTO;
use Illuminate\Pagination\LengthAwarePaginator;

class ListTransactions
{
  /**
   * @param TransactionListDTO $dto
   * @return LengthAwarePaginator|bool
   */
  public function getList(TransactionListDTO $dto): LengthAwarePaginator|bool
  {
    try {
      $user = auth()->user();
      $data = Transaction::where('user_id', $user->id);

      if (!empty($dto->getSearch())) {
        $data = $data->where('description', 'like', '%' . $dto->getSearch() . '%')
          ->orWhere('amount', 'like', '%' . $dto->getSearch() . '%')
          ->orWhere('type', 'like', '%' . $dto->getSearch() . '%')
          ->orWhere('status', 'like', '%' . $dto->getSearch() . '%')
          ->orWhere('id', $dto->getSearch());
      }

      $data = $data->orderBy('created_at', 'desc');
      $data = $data->paginate($dto->getPerPage());

      return $data;
    } catch (\Exception $e) {
      return false;
    }
  }
}
