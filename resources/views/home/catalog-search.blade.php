
<!-- When there is no desire, all things are at peace. - Laozi -->

<div class="offcanvas-xxl offcanvas-start ecom-offcanvas" tabindex="-1" id="offcanvas_mail_filter">
    <div class="offcanvas-body p-0 sticky-xxl-top">
        <div id="ecom-filter" class="show collapse collapse-horizontal">
            <div class="ecom-filter">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5>Filter</h5>
                        <a
                            href="#"
                            class="avtar avtar-s btn-link-danger btn-pc-default"
                            data-bs-dismiss="offcanvas"
                            data-bs-target="#offcanvas_mail_filter"
                        >
                            <i class="ti ti-x f-20"></i>
                        </a>
                    </div>
                    <div class="scroll-block">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0 py-2">
                                    <a class="btn border-0 px-0 text-start w-100" data-bs-toggle="collapse" href="#filtercollapse1">
                                        <div class="float-end"><i class="ti ti-chevron-down"></i></div>
                                        Brand
                                    </a>
                                    <div class="collapse show" id="filtercollapse1">
                                        <div class="py-3">
                                            @foreach($brands as $brand)
                                                <x-form.checkbox
                                                    class="my-2"
                                                    wire:model="selectedBrands"
                                                    :value="$brand->hashed"
                                                    :label="$brand->name"
                                                />
                                            @endforeach
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item px-0 py-2">
                                    <a class="btn border-0 px-0 text-start w-100" data-bs-toggle="collapse" href="#filtercollapse2">
                                        <div class="float-end"><i class="ti ti-chevron-down"></i></div>
                                        Product Types
                                    </a>
                                    <div class="collapse show" id="filtercollapse2">
                                        <div class="py-3">
                                            @foreach($productTypes as $type)
                                                <x-form.checkbox
                                                    class="my-2"
                                                    wire:model="selectedTypes"
                                                    :value="$type->hashed"
                                                    :label="$type->name"
                                                />
                                            @endforeach
                                        </div>
                                    </div>
                                </li>

                                <li class="list-group-item px-0 py-2">
                                    <a class="btn border-0 px-0 text-start w-100" data-bs-toggle="collapse" href="#filtercollapse4">
                                        <div class="float-end"><i class="ti ti-chevron-down"></i></div>
                                        Price
                                    </a>
                                    <div class="collapse show" id="filtercollapse4">
                                        <div class="row py-3">
                                            <div class="col-6">
                                                <div class="form-check my-2">
                                                    <input class="form-check-input" type="radio" name="price" id="pricefilter1" value="option1" />
                                                    <label class="form-check-label" for="pricefilter1">Below $10</label>
                                                </div>
                                                <div class="form-check my-2">
                                                    <input class="form-check-input" type="radio" name="price" id="pricefilter2" value="option2" />
                                                    <label class="form-check-label" for="pricefilter2">$50 - $100</label>
                                                </div>
                                                <div class="form-check my-2">
                                                    <input class="form-check-input" type="radio" name="price" id="pricefilter3" value="option3" />
                                                    <label class="form-check-label" for="pricefilter3">$150 - $200</label>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-check my-2">
                                                    <input class="form-check-input" type="radio" name="price" id="pricefilter4" value="option1" />
                                                    <label class="form-check-label" for="pricefilter4">$10 - $50</label>
                                                </div>
                                                <div class="form-check my-2">
                                                    <input class="form-check-input" type="radio" name="price" id="pricefilter5" value="option2" />
                                                    <label class="form-check-label" for="pricefilter5">$100 - $150</label>
                                                </div>
                                                <div class="form-check my-2">
                                                    <input class="form-check-input" type="radio" name="price" id="pricefilter6" value="option3" />
                                                    <label class="form-check-label" for="pricefilter6">Over $200</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li class="list-group-item px-0 py-2">
                                    <button class="btn btn-light-danger w-100" wire:click="resetFilters">Clear All</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
