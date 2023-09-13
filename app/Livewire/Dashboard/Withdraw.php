<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Services\Payment\Withdraw as WithdrawService;
use App\DTO\WithdrawDTO;

class Withdraw extends Component
{
  #[Title('Withdraw')]

  /**
   * @var float
   */
  public $amount;

  /**
   * @return void
   */
  public function withdraw()
  {
    try {
      $this->validate([
        'amount' => 'required|numeric|min:1'
      ]);

      if ($this->amount > auth()->user()->balance) {
        throw new \Exception('Insufficient balance');
      }

      $withdraw = new WithdrawService();
      $result = $withdraw->withdraw(new WithdrawDTO($this->amount));

      session()->flash('wds', $result['message']);
    } catch (\Exception $e) {
      session()->flash('wde', 'Withdraw failed. Error: ' . $e->getMessage());
    }

    $this->amount = null;
  }

  public function render()
  {
    return view('livewire.dashboard.withdraw');
  }
}
