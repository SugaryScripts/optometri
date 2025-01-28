
<x-slot name="page_title">
    Catalog
</x-slot>
{{-- Nothing in the world is as soft and yielding as water. --}}

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
                        <h2 class="mb-0">Products Details</h2>
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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="sticky-md-top product-sticky">
                                <div id="carouselExampleCaptions" class="carousel slide ecomm-prod-slider" data-bs-ride="carousel">
                                    <div class="carousel-inner bg-light rounded position-relative">
                                        <div class="card-body position-absolute end-0 top-0">
                                            <div class="form-check prod-likes">
                                                <input type="checkbox" class="form-check-input" />
                                                <i data-feather="heart" class="prod-likes-icon"></i>
                                            </div>
                                        </div>
                                        <div class="card-body position-absolute bottom-0 end-0">
                                            <ul class="list-inline ms-auto mb-0 prod-likes">
                                                <li class="list-inline-item m-0">
                                                    <a href="#" class="avtar avtar-xs text-white text-hover-primary">
                                                        <i class="ti ti-zoom-in f-18"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item m-0">
                                                    <a href="#" class="avtar avtar-xs text-white text-hover-primary">
                                                        <i class="ti ti-zoom-out f-18"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item m-0">
                                                    <a href="#" class="avtar avtar-xs text-white text-hover-primary">
                                                        <i class="ti ti-rotate-clockwise f-18"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                        @foreach ($product->images as $index => $image)
                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                <img src="{{ Storage::url(config('file_path.product') . $product->hashed . '/' . $image->file_name) }}" class="d-block w-100" alt="Product images" />
                                            </div>
                                        @endforeach


                                    </div>
                                    <ol class="carousel-indicators position-relative product-carousel-indicators my-sm-3 mx-0">
                                        @foreach ($product->images as $index => $image)
                                            <li
                                                data-bs-target="#carouselExampleCaptions"
                                                data-bs-slide-to="{{ $index }}"
                                                class="w-25 h-auto {{ $index === 0 ? 'active' : '' }}">
                                                <img src="{{ Storage::url(config('file_path.product') . $product->hashed . '/' . $image->file_name) }}" class="d-block wid-50 rounded" alt="Product images" />
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <span class="badge bg-success f-14">In stock</span>
                            <h5 class="my-3">{{ $product->name }} (GPS, 40mm) (Heart Rate Monitoring)</h5>
                            <div class="star f-18 mb-3">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star-half-alt text-warning"></i>
                                <i class="far fa-star text-muted"></i>
                                <span class="text-sm text-muted">(4.0)</span>
                            </div>
                            @if($product->variants->isNotEmpty())
                                <h5 class="mt-4 mb-3">Variant</h5>

                                <div class="offer-check-block">
                                    @foreach($product->variants as $variant)
                                        <div class="offer-check border rounded p-3">
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input input-primary" id="variant-{{ $loop->index }}" checked=""
                                                       wire:model="selectedVariant" value="{{ $variant->id }}"/>
                                                <label class="form-check-label d-block" for="variant-{{ $loop->index }}">
                                                    <span class="h6 mb-0 d-block">No Cost EMI</span>
                                                    <span class="text-muted offer-details">
                                                        {{ $variant->attributeValues->map(function($av) {
                                                                return $av->productAttribute->name . ': ' . $av->value;
                                                            })->join(', ') }}
                                                            - ${{ number_format($variant->price, 2) }}
                                                    </span>
                                                    <span class="h6 mb-0 text-primary">1 Offer <i class="ti ti-arrow-narrow-right"></i></span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                            @endif


                            <h5 class="mt-4 mb-3 f-w-500">About this item</h5>
                            {{-- Selected Variant Details --}}
                            @if($product->variants->isNotEmpty())
                                @if(isset($selectedVariantModel))
                                    @if($groupedAttributes['variant']->isNotEmpty())
                                        <ul>
                                            @foreach($groupedAttributes['variant'] as $attribute)
                                                @php
                                                    $value = $selectedVariantModel->attributeValues
                                                        ->where('product_attribute_id', $attribute->id)
                                                        ->first();
                                                @endphp
                                                <li class="mb-2">{{ $attribute->name }}: {{ $value?->value }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                @endif
                            @endif



                            <div class="mb-3 row">
                                <label class="col-form-label col-lg-3 col-sm-12">Quantity <span class="text-danger">*</span></label>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="btn-group btn-group-sm mb-2 border" role="group">
                                        <button type="button" id="decrease" onclick="decreaseValue('number')" class="btn btn-link-secondary"
                                        ><i class="ti ti-minus"></i
                                            ></button>
                                        <input
                                            class="wid-35 text-center border-0 m-0 form-control rounded-0 shadow-none"
                                            type="text"
                                            id="number"
                                            value="0"
                                        />
                                        <button type="button" id="increase" onclick="increaseValue('number')" class="btn btn-link-secondary"
                                        ><i class="ti ti-plus"></i
                                            ></button>
                                    </div>
                                </div>
                            </div>
                            <h3 class="mb-4">
                                @if($product->variants->isNotEmpty())
                                    @if(isset($selectedVariantModel))
                                        <b>${{ number_format($selectedVariantModel->price, 2) }}</b>
                                    @else
                                        {{-- Base Product Price --}}
                                        <b>${{ number_format($product->price, 2) }}</b>
                                    @endif
                                @else
                                    {{-- Base Product Price --}}
                                    <b>${{ number_format($product->price, 2) }}</b>
                                @endif
                                    {{-- TODO: Discount --}}
                                {{--<span class="mx-2 f-16 text-muted f-w-400 text-decoration-line-through">$399.00</span>--}}
                            </h3>
                            <div class="row">
                                <div class="col-6">
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-primary">Buy Now</button>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-outline-secondary">Add to cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header pb-0">
                    <ul class="nav nav-tabs profile-tabs mb-0" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a
                                class="nav-link active"
                                id="ecomtab-tab-1"
                                data-bs-toggle="tab"
                                href="#ecomtab-1"
                                role="tab"
                                aria-controls="ecomtab-1"
                                aria-selected="true"
                            >Features
                            </a>
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                id="ecomtab-tab-2"
                                data-bs-toggle="tab"
                                href="#ecomtab-2"
                                role="tab"
                                aria-controls="ecomtab-2"
                                aria-selected="true"
                            >Specifications
                            </a>
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                id="ecomtab-tab-3"
                                data-bs-toggle="tab"
                                href="#ecomtab-3"
                                role="tab"
                                aria-controls="ecomtab-3"
                                aria-selected="true"
                            >Overview
                            </a>
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                id="ecomtab-tab-4"
                                data-bs-toggle="tab"
                                href="#ecomtab-4"
                                role="tab"
                                aria-controls="ecomtab-4"
                                aria-selected="true"
                            >Reviews<span class="badge bg-light-primary rounded-pill px-2 ms-2">275</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="ecomtab-1" role="tabpanel" aria-labelledby="ecomtab-tab-1">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                    <tr>
                                        <td class="text-muted py-1">Band :</td>
                                        <td class="py-1">Smart Band</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted py-1">Compatible Devices :</td>
                                        <td class="py-1">Smartphones</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted py-1">Ideal For :</td>
                                        <td class="py-1">Unisex</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted py-1">Lifestyle :</td>
                                        <td class="py-1">Fitness | Indoor | Sports | Swimming | Outdoor</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted py-1">Basic Features :</td>
                                        <td class="py-1">Calendar | Date & Time | Timer/Stop Watch</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted py-1">Health Tracker :</td>
                                        <td class="py-1">Heart Rate | Exercise Tracker</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="ecomtab-2" role="tabpanel" aria-labelledby="ecomtab-tab-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Product Category</h5>
                                    <hr class="my-3" />
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tbody>
                                            <tr>
                                                <td class="text-muted py-1">Wearable Device Type:</td>
                                                <td class="py-1">Smart Band</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted py-1">Compatible Devices :</td>
                                                <td class="py-1">Smartphones</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted py-1">Ideal For :</td>
                                                <td class="py-1">Unisex</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h5>Manufacturer Details</h5>
                                    <hr class="my-3" />
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tbody>
                                            <tr>
                                                <td class="text-muted py-1">Brand :</td>
                                                <td class="py-1">Apple</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted py-1">Model Series :</td>
                                                <td class="py-1">Watch SE</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted py-1">Model Number :</td>
                                                <td class="py-1">MYDT2HN/A</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="ecomtab-3" role="tabpanel" aria-labelledby="ecomtab-tab-3">
                            <div class="table-responsive">
                                <p class="text-muted"
                                >Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's
                                    standard dummy text ever since the 1500s,
                                    <strong class="text-body"
                                    >“When an unknown printer took a galley of type and scrambled it to make a type specimen book.”</strong
                                    >
                                    It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially
                                    unchanged. It was popularized in the 1960s with the release of Lestrade sheets containing Lorem Ipsum passages, and
                                    more recently with desktop publishing software like PageMaker including versions of Lorem Ipsum.
                                </p>
                                <p class="text-muted"
                                >It was popularized in the 1960s with the release of Learjet sheets containing Lorem Ipsum passages, and more
                                    recently with desktop publishing software like PageMaker including versions of Lorem Ipsum.</p
                                >
                            </div>
                        </div>
                        <div class="tab-pane" id="ecomtab-4" role="tabpanel" aria-labelledby="ecomtab-tab-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-xxl-4 col-xl-5">
                                            <h2 class="mb-3"
                                            ><b>3.5<small class="text-muted f-18">/5</small></b></h2
                                            >
                                            <p class="mb-2 text-muted">Based on 275 reviews</p>
                                            <div class="star mb-3 f-20">
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star-half-alt text-warning"></i>
                                                <i class="far fa-star text-muted"></i>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-xl-5">
                                            <div class="d-flex align-items-center">
                                                <div class="w-100">
                                                    <div class="row align-items-center my-2">
                                                        <div class="col">
                                                            <div class="progress" style="height: 4px">
                                                                <div class="progress-bar bg-warning" style="width: 30%"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <p class="mb-0 text-muted">5 Stars</p>
                                                        </div>
                                                    </div>
                                                    <div class="row align-items-center my-2">
                                                        <div class="col">
                                                            <div class="progress" style="height: 4px">
                                                                <div class="progress-bar bg-warning" style="width: 60%"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <p class="mb-0 text-muted">4 Stars</p>
                                                        </div>
                                                    </div>
                                                    <div class="row align-items-center my-2">
                                                        <div class="col">
                                                            <div class="progress" style="height: 4px">
                                                                <div class="progress-bar bg-warning" style="width: 75%"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <p class="mb-0 text-muted">3 Stars</p>
                                                        </div>
                                                    </div>
                                                    <div class="row align-items-center my-2">
                                                        <div class="col">
                                                            <div class="progress" style="height: 4px">
                                                                <div class="progress-bar bg-warning" style="width: 40%"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <p class="mb-0 text-muted">2 Stars</p>
                                                        </div>
                                                    </div>
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <div class="progress" style="height: 4px">
                                                                <div class="progress-bar bg-warning" style="width: 55%"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <p class="mb-0 text-muted">1 Stars</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-start">
                                        <div class="chat-avtar">
                                            <img class="img-radius img-fluid wid-40" src="../assets/images/user/avatar-1.jpg" alt="User image" />
                                            <div class="bg-success chat-badge"></div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">Harriet Wilson</h6>
                                            <p class="text-muted text-sm mb-1">2 hour ago</p>
                                            <div class="star">
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star-half-alt text-warning"></i>
                                                <i class="far fa-star text-muted"></i>
                                            </div>
                                            <p class="mb-0 text-muted mt-1"
                                            >Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                                                industry's standard dummy text ever since the 1500.</p
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-start">
                                        <div class="chat-avtar">
                                            <img class="img-radius img-fluid wid-40" src="../assets/images/user/avatar-2.jpg" alt="User image" />
                                            <div class="bg-success chat-badge"></div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">Lou Olson</h6>
                                            <p class="text-muted text-sm mb-1">2 hour ago</p>
                                            <div class="star">
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star-half-alt text-warning"></i>
                                                <i class="far fa-star text-muted"></i>
                                                <i class="far fa-star text-muted"></i>
                                            </div>
                                            <p class="mb-2 text-muted mt-1"
                                            >Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                                                industry's standard dummy text ever since the 1500.</p
                                            >
                                            <a href="#" class="link-primary mb-1">https://phoenixcoded.net/</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <button class="btn btn-link-primary">View more comments</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5>Related Product</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 col-xl-3">
                            <div class="card product-card">
                                <div class="card-img-top">
                                    <a href="../application/ecom_product-details.html">
                                        <img src="../assets/images/application/img-prod-1.jpg" alt="image" class="img-prod img-fluid" />
                                    </a>
                                    <div class="card-body position-absolute end-0 top-0">
                                        <div class="form-check prod-likes">
                                            <input type="checkbox" class="form-check-input" checked />
                                            <i data-feather="heart" class="prod-likes-icon"></i>
                                        </div>
                                    </div>
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
                                        <p class="prod-content mb-0 text-muted">Apple watch -4</p>
                                    </a>
                                    <div class="d-flex align-items-center justify-content-between mt-2">
                                        <h4 class="mb-0 text-truncate"><b>$399.00</b></h4>
                                        <div class="prod-color">
                                            <span class="bg-success"></span>
                                            <span class="bg-dark"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-3">
                            <div class="card product-card">
                                <div class="card-img-top">
                                    <a href="../application/ecom_product-details.html">
                                        <img src="../assets/images/application/img-prod-2.jpg" alt="image" class="img-prod img-fluid" />
                                    </a>
                                    <div class="card-body position-absolute end-0 top-0">
                                        <div class="form-check prod-likes">
                                            <input type="checkbox" class="form-check-input" />
                                            <i data-feather="heart" class="prod-likes-icon"></i>
                                        </div>
                                    </div>
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
                                        <p class="prod-content mb-0 text-muted">Apple watch -4</p>
                                    </a>
                                    <div class="d-flex align-items-center justify-content-between mt-2">
                                        <h4 class="mb-0 text-truncate"><b>$399.00</b></h4>
                                        <div class="prod-color">
                                            <span class="bg-primary"></span>
                                            <span class="bg-dark"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-3">
                            <div class="card product-card">
                                <div class="card-img-top">
                                    <a href="../application/ecom_product-details.html">
                                        <img src="../assets/images/application/img-prod-3.jpg" alt="image" class="img-prod img-fluid" />
                                    </a>
                                    <div class="card-body position-absolute end-0 top-0">
                                        <div class="form-check prod-likes">
                                            <input type="checkbox" class="form-check-input" />
                                            <i data-feather="heart" class="prod-likes-icon"></i>
                                        </div>
                                    </div>
                                    <div class="card-body position-absolute start-0 top-0">
                                        <span class="badge bg-success">30%</span>
                                    </div>
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
                                        <p class="prod-content mb-0 text-muted">Apple watch -4</p>
                                    </a>
                                    <div class="d-flex align-items-center justify-content-between mt-2">
                                        <h4 class="mb-0 text-truncate"
                                        ><b>$299.00</b> <span class="text-sm text-muted f-w-400 text-decoration-line-through">$399.00</span></h4
                                        >
                                        <div class="prod-color">
                                            <span class="bg-danger"></span>
                                            <span class="bg-dark"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-3">
                            <div class="card product-card">
                                <div class="card-img-top">
                                    <a href="../application/ecom_product-details.html">
                                        <img src="../assets/images/application/img-prod-4.jpg" alt="image" class="img-prod img-fluid" />
                                    </a>
                                    <div class="card-body position-absolute end-0 top-0">
                                        <div class="form-check prod-likes">
                                            <input type="checkbox" class="form-check-input" checked />
                                            <i data-feather="heart" class="prod-likes-icon"></i>
                                        </div>
                                    </div>
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
                                        <p class="prod-content mb-0 text-muted">Apple watch -4</p>
                                    </a>
                                    <div class="d-flex align-items-center justify-content-between mt-2">
                                        <h4 class="mb-0 text-truncate"><b>$399.00</b></h4>
                                        <div class="prod-color">
                                            <span class="bg-success"></span>
                                            <span class="bg-dark"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>
    <!-- [ Main Content ] end -->
</div>
