<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class OrderExport implements FromView
{
    use Exportable;
    protected $finalOrders;

    public function __construct($finalOrders)
    {
        $this->finalOrders = $finalOrders;
    }

    public function view(): View
    {
        return view('pages.downloadExport' , [
           'data' => $this->finalOrders
        ]);
    }
}
