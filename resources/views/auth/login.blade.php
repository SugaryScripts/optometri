
<x-slot name="page_title">
    Login
</x-slot>
{{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}


<div class="auth-main">
    <div class="auth-wrapper v1">
        <div class="auth-form">
            <div class="card my-5">
                <div class="card-body">

                    <div class="text-center mb-3">
                        <a href=""><img src="{{ asset('assets/images/logo-dark.svg') }}" alt="img" /></a>
                    </div>

                    @if(session('info'))
                        <div class="alert alert-info my-3" role="alert">
                            <h5 class="alert-heading">Gagal!</h5>
                            <p class="mb-0">{{ session('info') }}</p>
                        </div>
                    @elseif(session('error'))
                        <div class="alert alert-danger my-3" role="alert">
                            <h5 class="alert-heading">Gagal!</h5>
                            <p class="mb-0">{{ session('error') }}</p>
                        </div>
                    @endif

                    <h4 class="text-center f-w-500 mb-3">Login with your email</h4>

                    <form wire:submit="login">
                        <div class="mb-3">
                            <x-form.input wire:model="email" placeholder="Email Address" />
                        </div>
                        <div class="mb-3">
                            <x-form.input wire:model="password" type="password" placeholder="Password" />
                        </div>
                        <div class="d-flex mt-1 justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input input-primary" type="checkbox" id="remember" checked="" wire:model="remember" />
                                <label class="form-check-label text-muted" for="remember">Remember me?</label>
                            </div>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                        <div class="d-flex justify-content-between align-items-end mt-4">
                            <h6 class="f-w-500 mb-0">Don't have an Account?</h6>
                            <a href="{{ route('register') }}" class="link-primary">Create Account</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
