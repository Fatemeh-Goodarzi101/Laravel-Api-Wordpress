<?php


namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductExport implements FromView
{
    protected $finalOrders;

    public function __construct($finalOrders)
    {
        $this->finalOrders = $finalOrders;
    }

    public function view(): View
    {
        return view('pages.showExport' , [
            'data' => $this->finalOrders
        ]);
    }
}
