<?php

namespace App\Exports;

use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;

class OrderExport implements HasLocalePreference
{
    use Exportable;
    protected $finalOrders;

    public function __construct($finalOrders)
    {
        $this->finalOrders = $finalOrders;
    }

//    public function view(): View
//    {
//        return view('pages.showExport' , [
//           'data' => $this->finalOrders
//        ]);
//    }

//    public function query()
//    {
//        return $this->finalOrders;
//    }

    public function preferredLocale()
    {
        return $this->finalOrders;
    }
}
