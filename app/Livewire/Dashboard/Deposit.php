<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class Deposit extends Component
{
    public $page = 'Deposit';

    public function render()
    {
        return view('livewire.dashboard.deposit')
            ->layout(
                'layouts.app',
                [
                    'title' => $this->page
                ]
            );
    }
}
