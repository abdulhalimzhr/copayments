<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class Withdraw extends Component
{
    public $page = 'Withdraw';

    public function render()
    {
        return view('livewire.dashboard.withdraw')
            ->layout(
                'layouts.app',
                [
                    'title' => $this->page
                ]
            );
    }
}
