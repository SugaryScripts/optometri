<?php

namespace App\Livewire\Auth;

use App\Livewire\BaseComponent;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;

class Register extends BaseComponent {

    #[Validate('required|string|max:255')]
    public string $name;
    #[Validate('required|email|unique:users,email|max:255')]
    public string $email;

    #[Validate('required|confirmed|min:5')]
    public string $password;
    #[Validate('required|same:password')]
    public string $password_confirmation;

    public function mount() {
        if (Auth::check()){
            $this->toApp();
        }
    }

    public function render() {
        return view('auth.register')
            ->layout('layouts.guest');
    }

    public function register() {
        $this->validate();

        $result = $this->safeDbOperation(function () {
            $staff = Staff::create([
                'name' => $this->name,
                'email' => $this->email,
            ]);

            User::create([
                'email' => $this->email,
                'password' => bcrypt($this->password),
                'staff_id' => $staff->id,
            ]);

            return $staff;
        });

        // Handle successful creation
        if ($result) {
            session()->flash('success', 'Akun berhasil didaftarkan! Namun, Akun Anda belum memiliki hak akses! Hubungi staff untuk dapat akses');
            $this->clearVars();
        }else {
            session()->flash('error', 'Terjadi kesalahan tidak terduga. Hubungi developer untuk diperbaiki!');
        }
    }

    private function clearVars(){
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->resetErrorBag();
        $this->resetValidation();
    }

    private function toApp() {
        $this->redirect('/');
    }
}
