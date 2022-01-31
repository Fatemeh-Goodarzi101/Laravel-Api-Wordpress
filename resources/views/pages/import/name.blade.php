@extends('pages.panel')

@section('content')

    <div class="card mt-5" style="width: 50%; margin: auto;box-shadow: 1px 1px 1px #00000020;">
        <div class="card-body">
            <div class="container-fluid w-75">
                <form class="row g-3" method="post" enctype="multipart/form-data" action="{{ route('importNameFile') }}">
                    {{ csrf_field() }}
                    <div class="col-12">
                        <label for="formFile" class="form-label">آپلود فایل تغییر نام محصولات:</label>
                        <input class="form-control form-control-lg" id="formFile" name="formFile" type="file">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary" style="position: absolute;left: 30px;bottom: 10px;">آپلود فایل</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
