<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Services\Auth\Login as LoginService;
use App\DTO\LoginDTO;

class Login extends Component
{
    public $title = 'Login - Cocol Payment';
    public $email;
    public $password;

    public function login(LoginService $loginService)
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $dto = new LoginDTO($this->email, $this->password);

        $auth = $loginService->authenticate($dto);

        if ($auth['status']) {
            return redirect()->route('dashboard');
        } else {
            session()->flash('error', $auth['message']);
            return redirect()->back();
        }
    }

    public function render()
    {
        return view('livewire.auth.login')
            ->layout(
                'layouts.auth',
                [
                    'title' => $this->title
                ]
            );
    }
}
