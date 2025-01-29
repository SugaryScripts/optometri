<x-slot name="page_title">
    Product Type Editor
</x-slot>
{{-- A good traveler has no fixed plans and is not intent upon arriving. --}}

<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript: void(0)">Product Management</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('type') }}">Type</a></li>
                        <li class="breadcrumb-item" aria-current="page">Editor</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Product Type Editor</h2>
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
                                <x-form.label for="name" value="{{ __('Type Name') }}" required/>
                                <x-form.input wire:model="form.name" placeholder="Enter Type Name" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <x-form.label for="description" value="{{ __('Description') }}"/>
                                <x-form.input wire:model="form.description" placeholder="Enter Type Description" />
                            </div>
                            <div class="col-md-12">
                                <div class="text-end btn-page mt-4">
                                    <a href="{{ route('type') }}" class="btn btn-outline-secondary">Cancel</a>
                                    <button class="btn btn-primary" type="submit">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- List attributes -->
        @if(isset($form->type))
            <div class="col-sm-12">
                <div class="card">
                    {{-- Header --}}
                    <div class="card-header d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <h5 class="mb-0">Attribute List</h5>
                        <div class="d-flex flex-column flex-md-row pt-3 pt-md-0">
                            <div class="btn-group flex-wrap">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#attribute-modal">
                                    <i class="bx bx-plus bx-sm me-sm-2"></i>
                                    <span class="d-none d-sm-inline-block">
                                     Add New Attribute
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
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Required</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($attributes as $item)
                                    <tr>
                                        <td>
                                            {{ $item->name }}
                                        </td>
                                        <td>
                                            {{ $item->data_type }}
                                        </td>
                                        <td>
                                            {{ $item->required }}
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

            <livewire:product-management.attribute-modal :hashed="$form->type->hashed"/>
        @endif

        <!-- [ sample-page ] end -->
    </div>
    <!-- [ Main Content ] end -->
</div>
