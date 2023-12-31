<?php

namespace App\Livewire\Dashboard;

use Livewire\WithPagination;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Services\Payment\ListTransactions as ListTransactionsService;
use App\DTO\TransactionListDTO;
use Illuminate\Database\Eloquent\Builder;

class Home extends Component
{
  use WithPagination;

  #[Title('Dashboard')]

  /**
   * @var int
   */
  public $perPage = 10;

  /**
   * @var string
   */
  public $search  = '';

  /**
   * @var float
   */
  public $balance = 0;

  public function mount()
  {
    $this->balance = auth()->user()->balance;
  }

  /**
   * Reload Data if any search input
   * @return void
   */
  public function updatedSearch()
  {
    $this->resetPage();
  }

  /**
   * @return Builder|bool
   */
  public function loadTransactions(): Builder
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
    return view('livewire.dashboard.home', [
      'transactions' => $this->loadTransactions()->paginate($this->perPage),
      'balance'      => $this->balance,
    ]);
  }
}
