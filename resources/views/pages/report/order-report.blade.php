@extends('pages.panel')

@section('content')

<div class="card mt-5">
        <div class="card-body">
            <div class="container-fluid w-75">
                <form class="row g-3" method="post" action="{{ route('sendReport') }}">
                    @csrf
                    <div class="col-12">
                        <label for="time" class="form-label">زمان</label>
                    </div>
                    <div class="col-md-3">
                        <label for="year" class="form-label">سال</label><br>
                        <select id="year" name="year" class="selectpicker" aria-label="size 3 select example" data-live-search="true">
                            <option disabled selected>Nothing selected</option>
                            @foreach(Illuminate\Support\Facades\Config::get('constants.ReportYear') as $year)
                                <option id="{{ $year }}" value="{{ $year }}" >{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="month" class="form-label">ماه</label><br>
                        <select id="month" name="month" class="selectpicker" aria-label="size 3 select example" data-live-search="true">
                            <option disabled selected>Nothing selected</option>
                            @foreach(Illuminate\Support\Facades\Config::get('constants.ReportMonth') as $key => $value)
                                <option id="{{ $key }}" value="{{ $key }}" >{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="startDay" class="form-label">روز شروع</label><br>
                        <select id="startDay" name="startDay" class="selectpicker" aria-label="size 3 select example" data-live-search="true">
                            <option disabled selected>Nothing selected</option>
                            @foreach(Illuminate\Support\Facades\Config::get('constants.ReportDay') as $key => $value)
                                <option id="{{ $key }}" value="{{ $key }}" >{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="endDay" class="form-label">روز پایان</label><br>
                        <select id="endDay" name="endDay" class="selectpicker" aria-label="size 3 select example" data-live-search="true">
                            <option disabled selected>Nothing selected</option>
                            @foreach(Illuminate\Support\Facades\Config::get('constants.ReportDay') as $day)
                                <option id="{{ $day }}" value="{{ $day }}" >{{ $day }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 mt-5">
                        <label for="product" class="form-label">محصول</label>
                    </div>
                    <div class="col-md-3">
                        <label for="productName" class="form-label">نام</label><br>
                        <select id="productNameId[]" name="productNameId[]" class="selectpicker" multiple aria-label="size 3 select example" data-live-search="true">
                            @foreach($products as $product)
                                <option id="{{ $product->ID }}" value="{{ $product->ID }}" >{{ $product->post_title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="productSku" class="form-label">بارکد</label><br>
                        <select id="productSkuId[]" name="productSkuId[]" class="selectpicker" multiple aria-label="size 3 select example" data-live-search="true">
                            @foreach($products as $product)
                                <option id="{{ $product->ID }}" value="{{ $product->ID }}" >{{ $product->sku }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="productCategory" class="form-label">دسته بندی</label><br>
                        <select id="productCategoryId[]" name="productCategoryId[]" class="selectpicker" multiple aria-label="size 3 select example" data-live-search="true">
                            @foreach($categories as $category)
                                <option id="{{ $category->term_id }}" value="{{ $category->term_id }}" >{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="productBrand" class="form-label">برند</label><br>
                        <select id="productBrandId[]" name="productBrandId[]" class="selectpicker" multiple aria-label="size 3 select example" data-live-search="true">
                            @foreach($brands as $brand)
                                <option id="{{ $brand['term_id'] }}" value="{{ $brand['term_id'] }}" >{{ $brand['term']['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 mt-5">
                        <label for="customer" class="form-label">مشتری</label>
                    </div>
                    <div class="col-md-3">
                        <label for="customerName" class="form-label">نام</label><br>
                        <select id="customerNameId[]" name="customerNameId[]" class="selectpicker" multiple aria-label="size 3 select example" data-live-search="true">
                            @foreach($customers as $customer)
                                    <option id="{{ $customer->customer_id }}" value="{{ $customer->customer_id }}" >
                                        {{ $customer->first_name.' '.$customer->last_name }}
                                    </option>
                                @if($customer->first_name && $customer->last_name == ''){
                                    <option id="{{ $customer->customer_id }}" value="{{ $customer->customer_id }}" >
                                        {{ $customer->username }}
                                    </option>
                                }
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="customerGender" class="form-label">جنسیت</label><br>
                        <select disabled id="customerGender" name="customerGender" class="selectpicker" multiple aria-label="size 3 select example" data-live-search="true">
                            <option name="female">زن</option>
                            <option name="male">مرد</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="customerAge" class="form-label">سن</label><br>
                        <select disabled id="customerAge" name="customerAge" class="selectpicker" multiple aria-label="size 3 select example" data-live-search="true">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="customerOrderFrom" class="form-label">از تاریخ...</label><br>
                        <input type="datetime-local" class="form-control" id="customerOrderFrom" name="customerOrderFrom">
                    </div>

                    <div class="col-12 mt-5">
                        <label for="order" class="form-label">سفارش</label>
                    </div>
                    <div class="col-md-3">
                        <label for="orderDateFrom" class="form-label">از تاریخ</label>
                        <input type="datetime-local" class="form-control" id="orderDateFrom" name="orderDateFrom">
                    </div>
                    <div class="col-md-3">
                        <label for="orderDateTo" class="form-label">تا تاریخ</label>
                        <input type="datetime-local" class="form-control" id="orderDateTo" name="orderDateTo">
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary" style="position: absolute;left: 50px;bottom: 20px;">ایجاد گزارش</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection



