<x-slot name="page_title">
    Brand Editor
</x-slot>
{{-- If your happiness depends on money, you will never be happy with yourself. --}}

<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript: void(0)">Catalog</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('brand') }}">Brand</a></li>
                        <li class="breadcrumb-item" aria-current="page">Editor</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Brand Editor</h2>
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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <x-form.label for="name" value="{{ __('Name') }}" required/>
                                    <x-form.input wire:model="form.name" placeholder="Enter Brand Name" />
                                </div>
                                <div class="mb-3">
                                    <x-form.label for="description" value="{{ __('Description') }}"/>
                                    <x-form.input wire:model="form.description" placeholder="Enter Brand Description" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if(isset($form->uploaded_image))
                                    <div class="mb-3 form-group row">
                                        <div class="col-12 col-md-8">
                                            <x-form.uploaded-file
                                                file="{{ $form->uploaded_image }}"
                                                file_original_name="{{ $form->uploaded_image_name }}"
                                                wire:click="deleteImageConfirm"
                                            />
                                        </div>
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <x-form.label for="image_file" value="{{ __('Upload Logo') }}" required/>
                                    <x-form.file-upload
                                        name="form.image_file"
                                        w_label="false"
                                        validate="true"
                                        size="5MB"
                                        accept="image/*"
                                        wire:model="form.image_file"/>
                                </div>
                                <div class="text-end btn-page mt-4">
                                    <a href="{{ route('brand') }}" class="btn btn-outline-secondary">Cancel</a>
                                    <button class="btn btn-primary" type="submit">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>
    <!-- [ Main Content ] end -->
</div>
