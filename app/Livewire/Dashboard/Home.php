<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Reactive;
use App\Services\Payment\ListTransactions as ListTransactionsService;
use App\DTO\TransactionListDTO;
use Livewire\WithPagination;

class Home extends Component
{
  use WithPagination;

  #[Title('Dashboard')]

  public $perPage = 10;
  public $search  = '';
  public $balance = 0;
  public $transactions = null;

  public function mount()
  {
    $this->transactions = $this->loadTransactions();
    $this->balance = $this->currencyFormat(auth()->user()->balance);
  }

  /**
   * Reload Data if any search input
   * @return void
   */
  public function updatedSearch()
  {
    $this->transactions = $this->loadTransactions();
  }

  /**
   * @return LengthAwarePaginator|bool
   */
  public function loadTransactions()
  {
    $listTransaction = new ListTransactionsService();
    $result = $listTransaction->getList(
      new TransactionListDTO(
        $this->perPage,
        $this->search
      )
    );

    return $result;
  }

  /**
   * @param int $value
   * 
   * @return string
   */
  public function currencyFormat(int $value): string
  {
    return 'Rp' . number_format($value, 2, ',', '.');
  }

  /**
   * @param string $date
   * 
   * @return string
   */
  public function dateFormat(string $date): string
  {
    return date('l, j F Y h:i:s A', strtotime($date));
  }

  public function render()
  {
    $links              = $this->transactions;
    $this->transactions = collect($this->transactions->items());

    return view('livewire.dashboard.home', [
      'transactions' => $this->transactions,
      'balance'      => $this->balance,
      'links'        => $links
    ]);
  }
}
