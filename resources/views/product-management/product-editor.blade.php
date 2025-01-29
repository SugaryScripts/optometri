<x-slot name="page_title">
    Product Editor
</x-slot>
{{-- Do your work, then step back. --}}

<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript: void(0)">Product Management</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('product') }}">Product</a></li>
                        <li class="breadcrumb-item" aria-current="page">Editor</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Product Editor</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->


    <!-- [ Main Content ] start -->
    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit="save">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <x-form.select label="Brand"
                                wire:model="form.brand_id">
                                    @foreach($brands as $item)
                                        <option value="{{ $item->hashed }}">{{ $item->name }}</option>
                                    @endforeach
                                </x-form.select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <x-form.select label="Product Type"
                                               wire:model="form.product_type_id">
                                    @foreach($productTypes as $item)
                                        <option value="{{ $item->hashed }}">{{ $item->name }}</option>
                                    @endforeach
                                </x-form.select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <x-form.label for="form.name" value="{{ __('Name') }}" required/>
                                <x-form.input wire:model="form.name" placeholder="Enter Product Name" />
                            </div>
                            <div class="col-md-3 mb-3">
                                <x-form.label for="form.sku" value="{{ __('SKU') }}" required/>
                                <x-form.input wire:model="form.sku" placeholder="Enter SKU" />
                            </div>
                            <div class="col-md-3 mb-3">
                                <x-form.label for="form.price" value="{{ __('Price') }}" required/>
                                <x-form.input wire:model="form.price" type="number" placeholder="Enter Price" />
                            </div>
                            <div class="col-md-12 mb-3">
                                <div wire:ignore>
                                    <x-form.label for="form.description" value="{{ __('Description') }}"/>
                                    <x-form.textarea wire:model="form.description" name="description"/>
                                </div>
                                @if ($errors->has('form.description'))
                                    <span class="text-danger font-size-12">
                                        {{ $errors->first('form.description') }}
                                    </span>
                                @endif
                            </div>

                            <!-- Product Attributes Section -->
                            @if(count($availableAttributes))
                                <div class="col-12 mt-3">
                                    <hr>
                                    <h5>Additional Attributes</h5>
                                </div>
                                @foreach($availableAttributes as $attribute)
                                    @if(!in_array($attribute->id, $form->selectedVariantAttributes))
                                        <div class="col-md-3 mb-3">
                                            <x-form.label for="form.attributeValues.{{ $attribute->id }}"
                                                          value="{{ $attribute->name }}"
                                                          :required="$attribute->required"/>
                                            <x-form.input wire:model="form.attributeValues.{{ $attribute->id }}"
                                                          type="{{ $attribute->data_type }}"
                                                          placeholder="Enter {{ $attribute->name }}" />
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                        <!-- Variant Attribute Selection -->
                            @if(count($availableAttributes))
                                <div class="col-12 mt-3">
                                    <hr>
                                    <h5>Select Variant Attributes</h5>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="row">
                                        @foreach($availableAttributes as $attribute)
                                            <div class="col-md-3 mb-2">
                                                <label class="form-check">
                                                    <input type="checkbox"
                                                           class="form-check-input"
                                                           wire:model.live="form.selectedVariantAttributes"
                                                           value="{{ $attribute->id }}">
                                                    <span class="form-check-label">{{ $attribute->name }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <x-form.error for="form.selectedVariantAttributes" />
                                </div>
                            @endif

                            <div class="col-12 mt-3">
                                <hr>
                                <h5>Images</h5>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="mb-3">
                                    <x-form.label for="form.image_file" value="{{ __('Upload Image') }}" required/>
                                    <x-form.file-upload
                                        name="form.image_file"
                                        multiple="true"
                                        preview="true"
                                        w_label="false"
                                        validate="true"
                                        size="5MB"
                                        accept="image/*"
                                        wire:model="form.image_file"/>
                                </div>
                                @if(isset($form->uploaded_image))
                                    <div class="mt-3 form-group row">
                                        @foreach($form->uploaded_image as $item)
                                            <div class="col-12 col-md-4">
                                                <x-form.uploaded-file
                                                    file="{{ $item }}"
                                                    file_original_name="{{ $form->uploaded_image_name[$loop->index] }}"
                                                    wire:click="deleteImageConfirm"
                                                />
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <div class="text-end btn-page mt-4">
                                    <a href="{{ route('product') }}" class="btn btn-outline-secondary">Cancel</a>
                                    <button class="btn btn-primary" type="submit">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- List variants -->
        @if(isset($form->product))
            <div class="col-sm-12">
                <div class="card">
                    {{-- Header --}}
                    <div class="card-header d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <h5 class="mb-0">Variant List</h5>
                        <div class="d-flex flex-column flex-md-row pt-3 pt-md-0">
                            <div class="btn-group flex-wrap">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#variant-modal">
                                    <i class="bx bx-plus bx-sm me-sm-2"></i>
                                    <span class="d-none d-sm-inline-block">
                                     Add New Variant
                                 </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    {{-- End Header --}}

                    <div class="card-body pt-3">
                        <div class="table-responsive mt-2">
                            <table class="table table-hover" id="pc-dt-simple">
                                <thead>
                                <tr>
                                    <th>SKU</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($variants as $item)
                                    <tr>
                                        <td>
                                            {{ $item->sku }}
                                        </td>
                                        <td>
                                            {{ $item->name }}
                                        </td>
                                        <td>
                                            {{ $item->price }}
                                        </td>
                                        <td class="text-center">
                                            <ul class="list-inline me-auto mb-0">
                                                <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Edit">
                                                    <a href="" onclick="event.preventDefault()"
                                                       class="avtar avtar-xs btn-link-success btn-pc-default"
                                                       wire:click="selectItem('{{ $item->hashed }}')"
                                                    >
                                                        <i class="ti ti-edit-circle f-18"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Delete">
                                                    <a href="" class="avtar avtar-xs btn-link-danger btn-pc-default"
                                                       onclick="event.preventDefault()"
                                                       wire:click="deleteConfirm('{{ $item->hashed }}')"
                                                    >
                                                        <i class="ti ti-trash f-18"></i>
                                                    </a>

                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            No entries found
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <livewire:product-management.variant-modal
                :hashed="$form->product->hashed"/>
    @endif

        <!-- [ sample-page ] end -->
    </div>
    <!-- [ Main Content ] end -->
</div>

@push('scripts')
    <script src="{{ asset('assets/js/plugins/ckeditor/classic/ckeditor.js') }}"></script>
    <script>
        document.addEventListener('livewire:init', function () {
            ClassicEditor
                .create(document.querySelector('#description'), {
                    toolbar: [ 'heading', '|', 'undo','redo', '|','bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
                })
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                        @this.set('form.description', editor.getData());
                    });
                    editor.setData(@this.get('form.description'));
                })
                .catch(error => {
                    console.error(error);
                });
        })

    </script>
@endpush
@push('styles')
    <style>
        .ck-editor__editable_inline {
            min-height: 200px;
        }
    </style>
@endpush
