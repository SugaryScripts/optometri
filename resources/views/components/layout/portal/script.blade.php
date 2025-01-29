
<!-- Live as if you were to die tomorrow. Learn as if you were to live forever. - Mahatma Gandhi -->
<script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
<script src="{{ asset('assets/js/pcoded.js') }}"></script>
<script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>

<script src="{{ asset('vendor/sweetalert2-11.14.5/sweetalert2.all.min.js') }}"></script>

<script src="{{ asset('js/app.js') }}"></script>

<div class="floting-button">
    <a href="https://1.envato.market/zNkqj6" class="btn btn btn-danger buynowlinks d-inline-flex align-items-center gap-2" data-bs-toggle="tooltip" title="Buy Now">
        <i class="ph-duotone ph-shopping-cart"></i>
        <span>Buy Now</span>

    </a>
</div>

<x-layout.preset-theme />
<x-layout.customizer />
@livewireScripts
@stack('scripts')
