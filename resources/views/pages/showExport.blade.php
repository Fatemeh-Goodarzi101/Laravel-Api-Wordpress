@extends('pages.panel')

@section('content')
    <div class="col-lg-11">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>ORDER_ID</th>
                    <th>ORDER_ITEM_NAME</th>
                    <th>GS1</th>
                    <th>Category</th>
                    <th>QUANTITY</th>
                    <th>SUB-TOTAL</th>
                    <th>TOTAL</th>
                    <th>DATE_CREATED</th>
                    <th>STATUS-TITLE</th>
                    <th>DISCOUNT_AMOUNT</th>
                    <th>COUPON_TITLE</th>
                    <th>FIRST_NAME</th>
                    <th>LAST_NAME</th>
                    <th>DATE_REGISTERED</th>
                    <th>CITY</th>
                    <th>STATE</th>
                    <th>POSTCODE</th>
                    <th>RETURNING_CUSTOMER</th>
                    <th>PHONE</th>
                </tr>
                </thead>
                <tbody>
                @foreach($finalOrders as $row)
                    <tr>
                        @foreach ($row as $key => $value)
                            <td>{{ $value }}</td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <tr>
                  @for( $i = 1 ; $i <= $pageCount ; ++$i )
                    <form action=" {{ route('sendReport',["page"=>$i]) }} " method="post">
                        <td><button type="submit">{{ $i }}</button></td>
                    </form> 
          		  @endfor
                </tr>
            </table>
        </div>
        <hr>
        <br>
        <div class="d-flex">
            <div class="col-lg-2">
                <form class="row g-3" method="post" action="{{ route('downloadReport' , ["data" => $finalOrders ]) }}">
                    <button style="right: 80vh; bottom: 8vh;" type="submit" class="btn btn-primary" style="position: absolute;left: 50px;bottom: 20px;">دانلود</button>
                </form>
            </div>
        </div>
    </div>
@endsection
