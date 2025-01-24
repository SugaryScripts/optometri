<x-slot name="page_title">
    Brand
</x-slot>
{{-- Do your work, then step back. --}}

<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript: void(0)">Catalog</a></li>
                        <li class="breadcrumb-item" aria-current="page">Brand</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Brand</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->


    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-12">
            <div class="card">

                {{-- Header --}}
                <div class="card-header d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <h5 class="mb-0">Brand List</h5>
                    <div class="d-flex flex-column flex-md-row pt-3 pt-md-0">
                        <div class="btn-group flex-wrap">
                            <a class="btn btn-primary" href="{{ route('brand.form') }}">
                                <i class="bx bx-plus bx-sm me-sm-2"></i>
                                <span class="d-none d-sm-inline-block">
                                    Add New Record
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- End Header --}}

                <div class="card-body pt-3">
                    <div class="row justify-content-between">
                        <div class="col-md-auto me-auto ">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <label for="sort" class="col-form-label m-0">Display</label>
                                </div>
                                <div class="col-auto p-0">
                                    <select name="sort" id="sort"
                                            class="form-select form-select-sm" wire:model.live="paginate_item">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <label for="sort" class="col-form-label m-0">entries</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-auto ms-auto my-auto">
                            <div
                                class="row align-items-center justify-content-lg-end justify-content-md-end justify-content-xl-end justify-content-xxl-end justify-content-sm-start">
                                <div class="col-auto ps-0">
                                    <x-form.input wire:model.live="search" placeholder="search..."
                                                  class="form-control-sm"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-hover" id="pc-dt-simple">
                            <thead>
                            <tr>
                                <th>Logo</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $item)
                                <tr>
                                    <td>
                                        <img
                                            src="{{ Storage::url(config('file_path.brand') . $item->hashed . '/' . $item->image_filename) }}"
                                            alt="{{ $item->image_original_name }}"
                                            class="wid-40 rounded"/>
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td class="text-wrap">
                                        {!! Str::limit($item->description, 150) !!}
                                    </td>
                                    <td class="text-center">
                                        <ul class="list-inline me-auto mb-0">
                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="View">
                                                <a
                                                    href=""
                                                    onclick="event.preventDefault()"
                                                    class="avtar avtar-xs btn-link-secondary btn-pc-default"
                                                    wire:click="selectItem('{{ $item->hashed }}')"
                                                >
                                                    <i class="ti ti-eye f-18"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Edit">
                                                <a href="{{ route('brand.form', $item->hashed) }}"
                                                   class="avtar avtar-xs btn-link-success btn-pc-default">
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
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row mx-2 mt-3">
                        {{ $data->links(data: ['scrollTo' => false]) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->


    <livewire:catalog.brand-modal />


</div>
