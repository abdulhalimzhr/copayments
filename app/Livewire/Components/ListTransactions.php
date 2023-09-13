<?php

namespace App\Livewire\Components;

use Livewire\Component;

class ListTransactions extends Component
{
  /**
   * @var null|LengthAwarePaginator
   */
  public $transactions = null;

  /**
   * @var string
   */
  public $search = '';

  public function render()
  {
    return view('livewire.components.list-transactions', [
      'transactions' => $this->transactions,
      'search'       => $this->search,
    ]);
  }
}
