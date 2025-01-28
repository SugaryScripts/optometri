
<x-slot name="page_title">
    Catalog
</x-slot>
{{-- Stop trying to control. --}}

<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page">Catalog</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Products</h2>
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
            <div class="ecom-wrapper">

                @include('home.catalog-search')

                <div class="ecom-content">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="d-sm-flex align-items-center">
                                <ul class="list-inline me-auto my-1">
                                    <li class="list-inline-item">
                                        <div class="form-search">
                                            <i class="ti ti-search"></i>
                                            <input type="search" class="form-control" placeholder="Search Products" />
                                        </div>
                                    </li>
                                </ul>
                                <ul class="list-inline ms-auto my-1">
                                    <li class="list-inline-item">
                                        <select class="form-select">
                                            <option>Price: High To Low</option>
                                            <option>Price: Low To High</option>
                                            <option>Popularity</option>
                                            <option>Discount</option>
                                            <option>Fresh Arrivals</option>
                                        </select>
                                    </li>
                                    <li class="list-inline-item align-bottom">
                                        <a
                                            href="#"
                                            class="d-inline-flex d-xxl-none btn btn-link-secondary align-items-center"
                                            data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvas_mail_filter"
                                        >
                                            <i class="ti ti-filter f-16"></i> Filter
                                        </a>
                                        <a
                                            href="#"
                                            class="d-none d-xxl-inline-flex btn btn-link-secondary align-items-center"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#ecom-filter"
                                        >
                                            <i class="ti ti-filter f-16"></i> Filter
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @forelse($products as $product)
                            <div class="col-sm-6 col-xl-4">
                                <div class="card product-card">
                                    <div class="card-img-top">
                                        <a href="{{ route('catalog.detail', ['hashed' => $product->hashed]) }}">
                                            @if($product->coverImage)
                                                <img src="{{ Storage::url(config('file_path.product') . $product->hashed . '/' . $product->coverImage->file_name) }}"
                                                     alt="{{ $product->name }}"
                                                     class="img-prod img-fluid"
                                                >
                                            @endif
                                        </a>

                                        {{-- TODO: Bookmark button? --}}
                                        {{--<div class="card-body position-absolute end-0 top-0">
                                            <div class="form-check prod-likes">
                                                <input type="checkbox" class="form-check-input" checked />
                                                <i data-feather="heart" class="prod-likes-icon"></i>
                                            </div>
                                        </div>--}}
                                        <div class="btn-prod-cart card-body position-absolute end-0 bottom-0">
                                            <div class="btn btn-warning">
                                                <svg class="pc-icon">
                                                    <use xlink:href="#custom-bag"></use>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <a href="../application/ecom_product-details.html">
                                            <p class="prod-content mb-0 text-muted">{{ $product->name }}</p>
                                        </a>
                                        <div class="d-flex align-items-center justify-content-between mt-2">
                                            <h4 class="mb-0 text-truncate"><b>Rp. {{ number_format($product->price, 0, ',', ',') }}</b></h4>
                                            <div class="prod-color">
                                                <span class="bg-success"></span>
                                                <span class="bg-dark"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <p class="text-gray-500">No products found matching your criteria.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>
    <!-- [ Main Content ] end -->
</div>
