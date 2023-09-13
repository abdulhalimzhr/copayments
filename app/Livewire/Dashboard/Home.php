<?php

namespace App\Livewire\Dashboard;

use Livewire\WithPagination;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Services\Payment\ListTransactions as ListTransactionsService;
use App\DTO\TransactionListDTO;

class Home extends Component
{
  use WithPagination;

  #[Title('Dashboard')]

  public $perPage = 10;
  public $search  = '';
  public $balance = 0;
  protected $transactions = null;
  public $page;

  public function mount()
  {
    $this->transactions = $this->loadTransactions();
    $this->balance      = auth()->user()->balance;
  }

  /**
   * Reload Data if any search input
   * @return void
   */
  public function updatedSearch()
  {
    $this->resetPage();
    $this->transactions = $this->loadTransactions();
  }

  /**
   * @return Builder|bool
   */
  public function loadTransactions()
  {
    return (new ListTransactionsService())->getList(
      new TransactionListDTO(
        $this->perPage,
        $this->search
      )
    );
  }

  /**
   * @param float $value
   * 
   * @return string
   */
  public function currencyFormat(float $value): string
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
    $this->transactions = $this->loadTransactions();

    return view('livewire.dashboard.home', [
      'transactions' => $this->transactions->paginate($this->perPage),
      'balance'      => $this->balance,
    ]);
  }
}
