<?php

namespace App\Livewire\Auth;

use App\Livewire\BaseComponent;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;

class Login extends BaseComponent {

    #[Validate('required|email')]
    public string $email = 'admin@mail.com';
    #[Validate('required')]
    public string $password = 'admin';
    #[Validate('nullable|boolean')]
    public ?bool $remember = false;


    public function mount() {
        if ((Auth::check())){
            if (Auth::user()->is_active) $this->toApp();
            else Auth::logout();
        }
    }


    public function render() {
        return view('auth.login')
            ->layout('layouts.guest');
    }

    public function login() {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            if (Auth::user()->is_active) return $this->toApp();
            else {
                session()->flash('error', 'Akun Anda belum aktif! Hubungi staff untuk mengaktifkan akun Anda');
                $this->password = '';
                Auth::logout();
            }
        } else session()->flash('error', 'Email atau Password Salah!');
        return '';
    }

    private function toApp() {
        $this->redirect('/');
    }
}
