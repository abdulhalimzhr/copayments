<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class Home extends Component
{
    public $title = 'Dashboard';

    public function render()
    {
        return view('livewire.dashboard.home')
            ->layout(
                'layouts.app',
                [
                    'title' => $this->title
                ]
            );
    }
}
