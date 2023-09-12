<?php

namespace App\Livewire\Components;

use Livewire\Component;

class ListTransactions extends Component
{
  public $transactions = null;
  public $search       = '';

  public function render()
  {
    return view('livewire.components.list-transactions', [
      'transactions' => $this->transactions,
      'search'      => $this->search,
    ]);
  }
}
