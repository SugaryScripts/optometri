<div class="modal fade" id="variant-modal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true"
     wire:ignore.self>

    {{-- Because she competes with no one, no one can compete with her. --}}


    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <form class="modal-content" wire:submit.prevent="save">
            <div class="modal-header">
                <h5 class="mb-0">{{ isset($form->productVariant)?'Update ':'Add ' }} Attributes</h5>
                <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default ms-auto" data-bs-dismiss="modal">
                    <i class="ti ti-x f-20"></i>
                </a>
            </div>

            <div class="modal-body pt-0">
                <div class="row">
                    <div class="col-md-4 mb-1">
                        <x-form.label value="Name" for="form.name" required/>
                        <x-form.input wire:model="form.name"/>
                    </div>
                    <div class="col-md-4 mb-1">
                        <x-form.label value="SKU" for="form.sku" required/>
                        <x-form.input wire:model="form.sku"/>
                    </div>
                    <div class="col-md-4 mb-1">
                        <x-form.label value="Price" for="form.price" required/>
                        <x-form.input wire:model="form.price"/>
                    </div>
                    @foreach($variantAttributes as $item)
                        <div class="col-md-4 mb-1">
                            <x-form.label value="{{ $item->name }}"
                                          for="form.attributeValues.{{ $item->id }}"
                                          :required="$item->required"/>
                            <x-form.input wire:model="form.price"
                                          type="{{ $item->data_type }}"/>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer text-end">
                <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-primary">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('closeModal', event => {
            $('#variant-modal').modal('hide');
        })

        window.addEventListener('showModal', event => {
            $('#variant-modal').modal('show');
        })

        $('#variant-modal').on('hidden.bs.modal', function () {
            Livewire.dispatch('clearVars');
        })
    </script>
@endpush
