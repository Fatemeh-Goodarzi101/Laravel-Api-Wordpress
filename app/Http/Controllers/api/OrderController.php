<?php

namespace App\Http\Controllers\api;

use App\Exports\OrderExport;
use Corcel\Model\Taxonomy;
use Corcel\WooCommerce\Model\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Corcel\WooCommerce\Model\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Facades\Excel;
use Morilog\Jalali\Jalalian;

class OrderController extends Controller
{
    use Exportable;

    public function showOrderReportForm(Request $request)
    {
        $products = Product::get();
        $categories = Taxonomy::where('taxonomy', 'product_cat')->get();
        $brands = Taxonomy::where('taxonomy', 'product_brand')->get();
        $customers = DB::table('wp_wc_customer_lookup')->orderBy('customer_id', 'ASC')->get(['customer_id', 'first_name', 'last_name', 'username']);

        return view('pages.report.order-report', compact('products', 'categories', 'brands', 'customers'));
    }

    public function sendOrderReport(Request $request)
    {
        set_time_limit(600);
        $finalOrderId = array();
        $finalOrder = array();
        $finalOrders = array();


        if (Cache::has('users')) {
            $finalOrders = Cache::get('users');
        } else {
            // reports of selected productName
            if ($request->has('productNameId')) {
                $reportProductName = DB::table('wp_wc_order_product_lookup')->whereIn('product_id', $request->input(['productNameId']))->get(['order_item_id', 'order_id', 'product_id'])->toArray();
                $finalOrderId = array_merge($finalOrderId, $reportProductName);
            }

            // reports of selected productSku
            if ($request->has('productSkuId')) {
                $reportProductSku = DB::table('wp_wc_order_product_lookup')->whereIn('product_id', $request->input('productSkuId'))->get(['order_item_id', 'order_id', 'product_id'])->toArray();
                $finalOrderId = array_merge($finalOrderId, $reportProductSku);
            }

            // reports of selected category
            if ($request->has('productCategoryId')) {
                $productCategory = DB::table('wp_term_relationships')->whereIn('term_taxonomy_id', $request->input('productCategoryId'))->get(['object_id'])->map(function ($item) {
                    return $item->object_id;
                })->toArray();
                $productCategory = array_values($productCategory);
                $reportProductCategory = DB::table('wp_wc_order_product_lookup')->whereIn('product_id', $productCategory)->get(['order_item_id', 'order_id', 'product_id'])->toArray();
                $finalOrderId = array_merge($finalOrderId, $reportProductCategory);
            }

            // reports of selected brand
            if ($request->has('productBrandId')) {
                $productBrand = DB::table('wp_term_relationships')->whereIn('term_taxonomy_id', $request->input('productBrandId'))->get(['object_id'])->map(function ($item) {
                    return $item->object_id;
                })->toArray();
                $productBrand = array_values($productBrand);
                $reportProductBrand = DB::table('wp_wc_order_product_lookup')->whereIn('product_id', $productBrand)->get(['order_item_id', 'order_id', 'product_id'])->toArray();
                $finalOrderId = array_merge($finalOrderId, $reportProductBrand);
            }

            $from = date('Y-m-d h:i:s', strtotime($request->input('orderDateFrom')));
            $to = date('Y-m-d h:i:s', strtotime($request->input('orderDateTo')));

            // reports of selected orderDateFrom
            if (!is_null($request->input('orderDateFrom'))) {
                $newFrom = date('Y-m-d', strtotime('-1 day', strtotime($request->input('orderDateFrom'))));
                $reportOrderDateFrom = DB::table('wp_wc_order_product_lookup')->whereDate('date_created', '>', $newFrom)->get(['order_item_id', 'order_id', 'product_id'])->toArray();
                $finalOrderId = array_merge($finalOrderId, $reportOrderDateFrom);
            }

            // reports of selected orderDateTo
            if (!is_null($request->input('orderDateTo'))) {
                $reportOrderDateTo = DB::table('wp_wc_order_product_lookup')->whereDate('date_created', '<=', $to)->get(['order_item_id', 'order_id', 'product_id'])->toArray();
                $finalOrderId = array_merge($finalOrderId, $reportOrderDateTo);
            }

            // reports of selected orderDateBetween
            if (!is_null($request->input('orderDateTo')) && !is_null($request->input('orderDateFrom'))) {
                $finalOrderId = array();
                $reportOrderDateBetween = DB::table('wp_wc_order_product_lookup')->whereBetween('date_created', [$from , $to])->get(['order_item_id', 'order_id', 'product_id'])->toArray();
                $finalOrderId = array_merge($finalOrderId, $reportOrderDateBetween);
            }

            // reports of selected orderCustomerId
            if ($request->has('customerNameId')) {
                $customerId = DB::table('wp_wc_customer_lookup')->whereIn('user_id', $request->input('customerNameId'))->get(['customer_id'])->map(function ($item) {
                    return $item->customer_id;
                })->toArray();
                $customerId = array_values($customerId);
                $reportCustomerId = DB::table('wp_wc_order_product_lookup')->whereIn('customer_id', $customerId)->get(['order_item_id', 'order_id', 'product_id'])->toArray();
                $finalOrderId = array_merge($finalOrderId, $reportCustomerId);
            }

            // reports of selected orderCustomerId and selected date
            if (!is_null($request->input('customerOrderFrom')) && $request->has('customerNameId')) {
                $customerId = DB::table('wp_wc_customer_lookup')->whereIn('user_id', $request->input('customerNameId'))->get(['customer_id'])->map(function ($item) {
                    return $item->customer_id;
                })->toArray();
                $customerId = array_values($customerId);
                $reportCustomerIdWithDate = DB::table('wp_wc_order_product_lookup')->whereIn('customer_id', $customerId)->whereDate('date_created', '>=', $request->input('customerOrderFrom'))->get(['order_item_id', 'order_id', 'product_id'])->toArray();
                $finalOrderId = array_merge($finalOrderId, $reportCustomerIdWithDate);
            }

            // reports of selected orderYearDate
            if ($request->has('year')) {
                $year = $request->input('year');
                $yearInput['startYear'] = (new Jalalian($year, 01, 01))->toCarbon()->toDateTimeString();
                $yearInput['endYear'] = (new Jalalian($year, 01, 01))->addYears(1)->toCarbon()->toDateTimeString();
                $reportOrderYearBetween = DB::table('wp_wc_order_product_lookup')->whereBetween('date_created', [$yearInput['startYear'], $yearInput['endYear']])->get(['order_item_id', 'order_id', 'product_id'])->toArray();
                $finalOrderId = array_merge($finalOrderId, $reportOrderYearBetween);
            }

            // reports of selected orderYearMonthDate
            if ($request->has('year') && $request->has('month')) {
                $year = $request->input('year');
                $month = $request->input('month');
                $monthInput['startMonth'] = (new Jalalian($year, $month, 01))->toCarbon()->toDateTimeString();
                $monthInput['endMonth'] = (new Jalalian($year, $month, 01))->addMonths(1)->toCarbon()->toDateTimeString();
                $reportOrderMonthBetween = DB::table('wp_wc_order_product_lookup')->whereBetween('date_created', [$monthInput['startMonth'], $monthInput['endMonth']])->get(['order_item_id', 'order_id', 'product_id'])->toArray();
                $finalOrderId = array_merge($finalOrderId, $reportOrderMonthBetween);
            }

            // reports of selected orderDateWithStartDay
            if ($request->has('year') && $request->has('month') && $request->has('startDay')) {
                $year = $request->input('year');
                $month = $request->input('month');
                $startDay = $request->input('startDay');
                $dayInput = (new Jalalian($year, $month, $startDay))->toCarbon()->toDateTimeString();
                $reportOrderDay = DB::table('wp_wc_order_product_lookup')->whereDate('date_created', '>=', $dayInput)->get(['order_item_id', 'order_id', 'product_id'])->toArray();
                $finalOrderId = array_merge($finalOrderId, $reportOrderDay);
            }

            // reports of selected orderDateComplete
            if ($request->has('year') && $request->has('month') && $request->has('startDay') && $request->has('endDay')) {
                $year = $request->input('year');
                $month = $request->input('month');
                $startDay = $request->input('startDay');
                $endDay = $request->input('endDay');
                $dayToDayInput['startDay'] = (new Jalalian($year, $month, $startDay))->toCarbon()->toDateTimeString();
                $dayToDayInput['endDay'] = (new Jalalian($year, $month, $endDay))->toCarbon()->toDateTimeString();
                $reportOrderDayBetween = DB::table('wp_wc_order_product_lookup')->whereBetween('date_created', [$dayToDayInput['startDay'], $dayToDayInput['endDay']])->get(['order_item_id', 'order_id', 'product_id'])->toArray();
                $finalOrderId = array_merge($finalOrderId, $reportOrderDayBetween);
            }

            $finalOrderId = array_unique($finalOrderId, SORT_REGULAR);

            foreach ($finalOrderId as $item) {
                $data = DB::select(DB::raw("SELECT items.order_id,items.order_item_id,items.order_item_name,
                    status.status,status.date_created,status.returning_customer,
                    coupon.discount_amount,couponTitle.post_title AS coupon_title,
                    customer.customer_id,customer.first_name,customer.last_name,customer.date_registered,customer.city,customer.state,customer.postcode
                    FROM wp_woocommerce_order_items AS items
                    LEFT JOIN wp_wc_order_stats AS status ON items.order_id = status.order_id
                    LEFT JOIN wp_wc_customer_lookup AS customer ON status.customer_id = customer.customer_id
                    LEFT JOIN wp_wc_order_coupon_lookup AS coupon ON items.order_id = coupon.order_id
                    LEFT JOIN wp_posts AS couponTitle ON coupon.coupon_id = couponTitle.ID
                    WHERE items.order_id = '$item->order_id' AND status.order_id = '$item->order_id' AND items.order_item_id = '$item->order_item_id' AND items.order_item_type = 'line_item' "));

                $finalOrder['order_id'] = $data[0]->order_id;
                $finalOrder['order_item_name'] = $data[0]->order_item_name;

                $product = Product::find($item->product_id);
                if (isset($product->sku)) {
                    $finalOrder['gs1'] = $product->sku;
                }

                if (isset($product)) {
                    $category = $product->categories[0]->term->name;
                    $finalOrder['category'] = $category;
                }

                $metas = DB::table('wp_woocommerce_order_itemmeta')->where('order_item_id', $item->order_item_id)->get(['meta_key', 'meta_value'])->toArray();
                foreach ($metas as $meta) {
                    if ($meta->meta_key == '_line_total')
                        $finalOrder['total'] = $meta->meta_value;
                    elseif ($meta->meta_key == '_line_subtotal')
                        $finalOrder['sub-total'] = $meta->meta_value;
                    elseif ($meta->meta_key == '_qty')
                        $finalOrder['quantity'] = $meta->meta_value;
                }

                $data[0]->status = str_replace("wc-", "", $data[0]->status);
                $statusTitle = DB::table('wp_posts')->where('post_type', 'wc_order_status')->where('post_name', $data[0]->status)->get(['post_title']);

                $finalOrder['date_created'] = $data[0]->date_created;
                $finalOrder['statusTitle'] = $statusTitle[0]->post_title;
                $finalOrder['discount_amount'] = $data[0]->discount_amount;
                $finalOrder['coupon_title'] = $data[0]->coupon_title;
                $finalOrder['first_name'] = $data[0]->first_name;
                $finalOrder['last_name'] = $data[0]->last_name;
                $finalOrder['date_registered'] = $data[0]->date_registered;
                $finalOrder['city'] = $data[0]->city;
                $finalOrder['state'] = $data[0]->state;
                $finalOrder['postcode'] = $data[0]->postcode;
                $finalOrder['returning_customer'] = $data[0]->returning_customer;

                $customer = Customer::find($data[0]->customer_id);
                if ($customer != []) {
                    $phone = $customer->billing_address->phone;
                    $finalOrder['phone'] = $phone;
                }

                array_push($finalOrders, $finalOrder);
            }
           $finalOrders=array_reverse($finalOrders);
        }

        if ($finalOrders != []) {
            if ($request->has('page'))
                $page = $request->input('page');
            else
                $page = 1;
            $value = Cache::remember('users', 2*60 ,function () use ($finalOrders) {
                return $finalOrders;
            });

           (int) $pageCount = (new Collection($value))->count()/30+1;
            $finalOrders = (new Collection($value))->forPage($page, 30)->all();

            return view('pages.showExport', compact('finalOrders' , 'pageCount'));

        } else
            return "گزارشی وجود ندارد";
    }


    public function export(Request $request)
    {
        return Excel::download(new OrderExport($request->input('data')), 'export.xlsx');
    }

}
