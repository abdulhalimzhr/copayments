<?php

namespace App\Services\Payment;

use App\Services\AbstractService;
use App\Models\Transaction;
use App\DTO\TransactionListDTO;
use Illuminate\Database\Eloquent\Builder;

class ListTransactions extends AbstractService
{
  /**
   * Get List of Transactions
   * @param TransactionListDTO $dto
   * 
   * @return Builder|bool
   */
  public function getList(TransactionListDTO $dto): Builder|bool
  {
    try {
      $user = auth()->user();
      $data = Transaction::where('user_id', $user->id);

      if (!empty($dto->getSearch())) {
        $data = $data->where('description', 'like', '%' . $dto->getSearch() . '%')
          ->orWhere('amount', 'like', '%' . $dto->getSearch() . '%')
          ->orWhere('type', 'like', '%' . $dto->getSearch() . '%')
          ->orWhere('status', 'like', '%' . $dto->getSearch() . '%')
          ->orWhere('order_id', 'like', '%' . $dto->getSearch() . '%')
          ->orWhere('id', $dto->getSearch());
      }

      $data = $data->orderBy('created_at', 'desc');

      return $data;
    } catch (\Exception $e) {
      return false;
    }
  }
}
