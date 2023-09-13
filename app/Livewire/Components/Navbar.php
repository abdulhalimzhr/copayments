<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Navbar extends Component
{
  /**
   * @var string
   */
  public $page = '';

  public function render()
  {
    return view('livewire.components.navbar');
  }
}
