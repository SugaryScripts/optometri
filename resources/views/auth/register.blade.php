
{{-- In work, do what you enjoy. --}}
<x-slot name="page_title">
    Register
</x-slot>

<div class="auth-main">
    <div class="auth-wrapper v1">
        <div class="auth-form">
            <div class="card my-5">
                <div class="card-body">

                    <div class="text-center mb-3">
                        <a href=""><img src="{{ asset('assets/images/logo-dark.svg') }}" alt="img" /></a>
                    </div>

                @if(session('success'))
                    <div class="alert alert-info my-3" role="alert">
                        <h5 class="alert-heading">Berhasil Daftar! Namun...</h5>
                        <p class="mb-0">{{ session('success') }}</p>
                    </div>
                @elseif(session('error'))
                    <div class="alert alert-error my-3" role="alert">
                        <h5 class="alert-heading">Gagal!</h5>
                        <p class="mb-0">{{ session('error') }}</p>
                    </div>
                @endif

                    <h4 class="text-center f-w-500 mb-3">Sign up with your work email.</h4>

                    <form wire:submit="register">
                        <div class="mb-3">
                            <x-form.input wire:model="name" placeholder="Full Name"/>
                        </div>
                        <div class="mb-3">
                            <x-form.input wire:model="email" placeholder="Email Address" />
                        </div>
                        <div class="mb-3">
                            <x-form.input wire:model="password" type="password" placeholder="Password" />
                        </div>
                        <div class="mb-3">
                            <x-form.input wire:model="password_confirmation" type="password"
                                          placeholder="Confirm Password" />
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary">Sign up</button>
                        </div>
                        <div class="d-flex justify-content-between align-items-end mt-4">
                            <h6 class="f-w-500 mb-0">Already have an Account?</h6>
                            <a href="{{ route('login') }}" class="link-primary">Login here</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
