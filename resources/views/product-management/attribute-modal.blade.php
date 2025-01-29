<div class="modal fade" id="attribute-modal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true"
     wire:ignore.self>

    {{-- Because she competes with no one, no one can compete with her. --}}


    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <form class="modal-content" wire:submit.prevent="save">
            <div class="modal-header">
                <h5 class="mb-0">{{ isset($form->attribute)?'Update ':'Add ' }} Attributes</h5>
                <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default ms-auto" data-bs-dismiss="modal">
                    <i class="ti ti-x f-20"></i>
                </a>
            </div>

                <div class="modal-body pt-0">

                    <div class="mb-1">
                        <x-form.label value="Name" for="name" required/>
                        <x-form.input wire:model="form.name" name="name"/>
                    </div>
                    <div class="mb-1">
                        <x-form.select label="Data Type"
                                       required
                                       wire:model="form.data_type">
                            <option value="string">String</option>
                            <option value="number">Number</option>
                            <option value="boolean">Boolean</option>
                        </x-form.select>
                    </div>
                    <div>
                        <x-form.select label="Required"
                                       required
                                       wire:model="form.required">
                            <option value="false">Optional</option>
                            <option value="true">Required</option>
                        </x-form.select>
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
            $('#attribute-modal').modal('hide');
        })

        window.addEventListener('showModal', event => {
            $('#attribute-modal').modal('show');
        })

        $('#attribute-modal').on('hidden.bs.modal', function () {
            Livewire.dispatch('clearVars');
        })
    </script>
@endpush
