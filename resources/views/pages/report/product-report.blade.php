@extends('pages.panel')

@section('content')

<div class="card mt-5">
    <div class="card-body">
        <div class="container-fluid w-75">
            <form class="row g-3" method="post" action="{{ route('sendProductReport') }}">
                @csrf
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="col-12 mt-5">
                    <label for="product" class="form-label">محصول</label>
                </div>
                <div class="col-md-4">
                    <label for="productName" class="form-label">نام</label><br>
                    <select id="productNameId[]" name="productNameId[]" class="selectpicker" multiple aria-label="size 3 select example" data-live-search="true">
                        <option id="allProducts" value="allProducts" >تمام محصولات</option>
                        @foreach($products as $product)
                            <option id="{{ $product->ID }}" value="{{ $product->ID }}" >{{ $product->post_title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="productSku" class="form-label">بارکد</label><br>
                    <select id="productSkuId[]" name="productSkuId[]" class="selectpicker" multiple aria-label="size 3 select example" data-live-search="true">
                        @foreach($products as $product)
                            <option id="{{ $product->ID }}" value="{{ $product->ID }}" >{{ $product->sku }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary" style="position: absolute;left: 30%;bottom: 20px;">ایجاد گزارش</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
