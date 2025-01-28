<div class="modal fade" id="brand-modal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">

    {{-- Close your eyes. Count to one. That is how long forever feels. --}}

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="mb-0">{{ $brand->name ?? '' }}</h5>
                <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default ms-auto" data-bs-dismiss="modal">
                    <i class="ti ti-x f-20"></i>
                </a>
            </div>
            <div class="modal-body">
                <div class="row align-items-center">
                    <div class="col-sm-4">
                        <div class="bg-light rounded position-relative">
                            <div class="text-center">
                                <div class="chat-avtar d-inline-flex mx-auto">
                                    @if(isset($filename))
                                        <img class="img-fluid rounded" src="{{ Storage::url($filename) }}" alt="User image" />
                                    @endif
                                </div>
                            </div>
                            {{--<div class="position-absolute end-0 top-0 p-3">
                                <span class="badge bg-success">In Stock</span>
                            </div>--}}
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <p class="text-muted"
                        >{{ $brand->description ?? '' }}</p
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('closeModal', event => {
            $('#brand-modal').modal('hide');
        })

        window.addEventListener('showModal', event => {
            $('#brand-modal').modal('show');
        })

        $('#brand-modal').on('hidden.bs.modal', function () {
            Livewire.dispatch('clearVars');
        })
    </script>
@endpush
