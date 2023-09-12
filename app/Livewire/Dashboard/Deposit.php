<?php

namespace App\Livewire\Dashboard;

use App\Models\User;
use App\Models\Transaction;
use Livewire\Component;
use Livewire\Attributes\Title;

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

      $user = User::find(auth()->user()->id);

      Transaction::create([
        'user_id'     => $user->id,
        'amount'      => $this->amount,
        'type'        => 1, // 1 = deposit, 2 = withdraw
        'status'      => 'success',
        'description' => 'Deposit success.'
      ]);

      $user->balance += $this->amount;
      $user->save();

      session()->flash('deposits', 'Deposit success.');
    } catch (\Exception $e) {
      session()->flash('depositse', 'Deposit failed. Error: ' . $e->getMessage());
    }
  }

  public function render()
  {
    return view('livewire.dashboard.deposit');
  }
}
