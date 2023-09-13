<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Services\Payment\Deposit as DepositService;
use App\DTO\DepositDTO;

class Deposit extends Component
{
  #[Title('Deposit')]

  public $amount;

  public function deposit()
  {
    try {
      $this->validate([
        'amount' => 'required|numeric|min:1'
      ]);

      $deposit = new DepositService();
      $result  = $deposit->pay(new DepositDTO($this->amount));

      session()->flash('deposits', $result['message']);
    } catch (\Exception $e) {
      session()->flash('deposite', 'Deposit failed. Error: ' . $e->getMessage());
    }

    $this->amount = null;
  }

  public function render()
  {
    return view('livewire.dashboard.deposit');
  }
}
