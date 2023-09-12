<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Title;

class Withdraw extends Component
{
    #[Title('Withdraw')]
    public function render()
    {
        return view('livewire.dashboard.withdraw');
    }
}
