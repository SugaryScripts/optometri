<x-slot name="page_title">
    User
</x-slot>
{{-- The best athlete wants his opponent at his best. --}}

<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript: void(0)">Employee</a></li>
                        <li class="breadcrumb-item" aria-current="page">User</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">User</h2>
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
                    <h5 class="mb-0">User List</h5>
                    <div class="d-flex flex-column flex-md-row pt-3 pt-md-0">
                        <div class="btn-group flex-wrap">
                            <button class="btn btn-primary">
                                <i class="bx bx-plus bx-sm me-sm-2"></i>
                                <span class="d-none d-sm-inline-block">
                                     Add New Record
                                 </span>
                            </button>
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
                                                  class="form-control-sm" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-hover" id="pc-dt-simple">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Account</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="{{ $item->staff->profile_photo_url }}" alt="user image"
                                                     class="img-radius wid-40"/>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0">{{ $item->staff->name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $item->email }}</td>
                                    <td>
                                        @if($item->is_active)
                                            <span class="text-success">
                                                    <i class="fas fa-circle f-10 m-r-10"></i> Active
                                                </span>
                                        @else
                                            <span class="text-primary">
                                                    <i class="fas fa-circle f-10 m-r-10"></i> Inactive
                                                </span>
                                        @endif
                                    </td>
                                    {{--<td class="text-success"><i class="fas fa-circle f-10 m-r-10"></i> Active</td>--}}
                                    {{--<td><span class="badge text-bg-success">Casual</span></td>--}}
                                    <td>
                                        <a href="#" class="avtar avtar-xs btn-link-secondary">
                                            <i class="ti ti-eye f-20"></i>
                                        </a>
                                        <a href="#" class="avtar avtar-xs btn-link-secondary">
                                            <i class="ti ti-edit f-20"></i>
                                        </a>
                                        <a href="" class="avtar avtar-xs btn-link-secondary"
                                           onclick="event.preventDefault()"
                                           wire:click="deleteConfirm('{{ $item->hashed }}')"
                                        >
                                            <i class="ti ti-trash f-20"></i>
                                        </a>
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
</div>

