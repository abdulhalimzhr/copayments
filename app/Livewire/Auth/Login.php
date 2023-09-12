<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Services\Auth\Login as LoginService;
use App\DTO\LoginDTO;

class Login extends Component
{
    /**
     * @var string
     */
    public $title = 'Login - Cocol Payment';

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
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
                'components.layouts.auth',
                [
                    'title' => $this->title
                ]
            );
    }
}
