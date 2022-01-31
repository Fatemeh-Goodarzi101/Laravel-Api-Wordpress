<?php

namespace App\Http\Controllers\api;
use App\Exports\ProductExport;
use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use Automattic\WooCommerce\Client;
use Corcel\WooCommerce\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class ProductController extends Controller
{

    public function sendImportRegularPriceFile(Request $request)
    {
        $this->validate($request, [
            'formFile' => 'required|mimes:xls,xlsx'
        ]);

        $rows = Excel::toArray(new ProductImport(), $request->file('formFile'))[0];

        foreach ($rows as $key => $value) {
            $post_id = DB::table('wp_postmeta')->where('meta_key' , '_sku')->where('meta_value' , $value[0])->first();
            if($post_id == '') {
                echo 'بارکد محصول معتبر نمی باشد: ' . $value[0];
                return false;
            } else {
                $post_id = $post_id->post_id;
                $sale_price =  DB::table('wp_postmeta')->where('post_id' , $post_id)->where('meta_key' , '_sale_price')->first();
            }

            // set price
            if ($sale_price == '') {
                DB::table('wp_postmeta')->where('post_id' , $post_id)->where('meta_key' , '_price')->update([
                    'meta_value' => $value[1]
                ]);
            }else {
                DB::table('wp_postmeta')->where('post_id' , $post_id)->where('meta_key' , '_regular_price')->update([
                    'meta_value' => $value[1]
                ]);
            }

        }

        return 'عملیات با موفقیت انجام شد';

    }

    public function sendImportSalePriceFile(Request $request)
    {
        $this->validate($request, [
            'formFile' => 'required|mimes:xls,xlsx'
        ]);

        $rows = Excel::toArray(new ProductImport(), $request->file('formFile'))[0];

        foreach ($rows as $key => $value) {
            $post_id = DB::table('wp_postmeta')->where('meta_key' , '_sku')->where('meta_value' , $value[0])->first();
            if($post_id == '') {
                echo 'بارکد محصول معتبر نمی باشد: ' . $value[0];
                return false;
            } else {
                $post_id = $post_id->post_id;
                DB::table('wp_postmeta')->where('post_id' , $post_id)->where('meta_key' , '_sale_price')->update([
                    'meta_value' => $value[1]
                ]);
                DB::table('wp_postmeta')->where('post_id' , $post_id)->where('meta_key' , '_price')->update([
                    'meta_value' => $value[1]
                ]);
            }

        }

        return 'عملیات با موفقیت انجام شد';

    }

    public function sendImportPriceFile(Request $request)
    {
        $this->validate($request, [
            'formFile' => 'required|mimes:xls,xlsx'
        ]);

        $rows = Excel::toArray(new ProductImport(), $request->file('formFile'))[0];

        foreach ($rows as $key => $value) {
            $post_id = DB::table('wp_postmeta')->where('meta_key' , '_sku')->where('meta_value' , $value[0])->first();
            if($post_id == '') {
                echo 'بارکد محصول معتبر نمی باشد: ' . $value[0];
                return false;
            } else {
                $post_id = $post_id->post_id;
                $regular_price =  DB::table('wp_postmeta')->where('post_id' , $post_id)->where('meta_key' , '_regular_price')->first();
                $sale_price =  DB::table('wp_postmeta')->where('post_id' , $post_id)->where('meta_key' , '_sale_price')->first();
                $price =  DB::table('wp_postmeta')->where('post_id' , $post_id)->where('meta_key' , '_price')->first();
            }

            // set regular price
            if ($regular_price == '') {
                DB::table('wp_postmeta')->where('post_id' , $post_id)->insert([
                    'post_id' => $post_id,
                    'meta_key' => '_regular_price',
                    'meta_value' => $value[1]
                ]);
            } else {
                DB::table('wp_postmeta')->where('post_id' , $post_id)->where('meta_key' , '_regular_price')->update([
                    'meta_value' => $value[1]
                ]);
            }

            // set sale price
            if ($sale_price == '') {
                DB::table('wp_postmeta')->where('post_id' , $post_id)->insert([
                    'post_id' => $post_id,
                    'meta_key' => '_sale_price',
                    'meta_value' => $value[2]
                ]);
            } else {
                DB::table('wp_postmeta')->where('post_id' , $post_id)->where('meta_key' , '_sale_price')->update([
                    'meta_value' => $value[2]
                ]);
            }

            // set price
            if ($price == '') {
                DB::table('wp_postmeta')->where('post_id' , $post_id)->insert([
                    'post_id' => $post_id,
                    'meta_key' => '_price',
                    'meta_value' => $value[2]
                ]);
            } else {
                DB::table('wp_postmeta')->where('post_id' , $post_id)->where('meta_key' , '_price')->update([
                    'meta_value' => $value[2]
                ]);
            }

        }

        return 'عملیات با موفقیت انجام شد';

    }

    public function sendImportQuantityFile(Request $request)
    {
        $this->validate($request, [
            'formFile2' => 'required|mimes:xls,xlsx'
        ]);

        $rows = Excel::toArray(new ProductImport(), $request->file('formFile2'))[0];
        foreach ($rows as $key => $value) {
            $post_id = DB::table('wp_postmeta')->where('meta_key' , '_sku')->where('meta_value' , $value[0])->first();
            if($post_id == '') {
                echo 'بارکد محصول معتبر نمی باشد: ' . $value[0];
                return false;
            } else {
                $post_id = $post_id->post_id;
                $stock =  DB::table('wp_postmeta')->where('post_id' , $post_id)->where('meta_key' , '_stock')->first();
            }

            // set stock
            if ($stock == '') {
                DB::table('wp_postmeta')->where('post_id' , $post_id)->insert([
                    'post_id' => $post_id,
                    'meta_key' => '_stock',
                    'meta_value' => $value[1]
                ]);
            } else {
                DB::table('wp_postmeta')->where('post_id' , $post_id)->where('meta_key' , '_stock')->update([
                    'meta_value' => $value[1]
                ]);
            }

        }

        return 'عملیات با موفقیت انجام شد';
    }

    public function sendImportNameFile(Request $request)
    {
        $this->validate($request, [
            'formFile' => 'required|mimes:xls,xlsx'
        ]);

        $rows = Excel::toArray(new ProductImport(), $request->file('formFile'))[0];
        foreach ($rows as $key => $value) {
            $post_id = DB::table('wp_postmeta')->where('meta_key' , '_sku')->where('meta_value' , $value[0])->first();
            if($post_id == '') {
                echo 'بارکد محصول معتبر نمی باشد: ' . $value[0];
                return false;
            } else {
                $post_id = $post_id->post_id;
                DB::table('wp_posts')->where('ID' , $post_id)->update([
                    'post_title' => $value[1]
                ]);
            }
        }

        return 'عملیات با موفقیت انجام شد';
    }



    public function showProductReportForm(Request $request)
    {
        $products = Product::where('post_status' , 'publish')->get();
        return view('pages.report.product-report' , compact('products'));
    }

    public function sendProductReport(Request $request)
    {
        set_time_limit(600);

        $finalOrderId = array();
        $finalOrder = array();
        $finalOrders = array();

        // reports of selected productName
        if ($request->has('productNameId')) {
            $requestData = $request->input(['productNameId']);
            if($requestData == ["allProducts"]) {
                $reportProductName = DB::table('wp_posts')->where('post_type', 'product')->where('post_status' , 'publish')->get(['ID'])->toArray();
                $finalOrderId = array_merge($finalOrderId, $reportProductName);
            } else {
                $reportProductName = DB::table('wp_posts')->whereIn('ID', $request->input(['productNameId']))->get(['ID'])->toArray();
                $finalOrderId = array_merge($finalOrderId, $reportProductName);
            }
        }

        // reports of selected productSku
        if ($request->has('productSkuId')) {
            $reportProductSku = DB::table('wp_posts')->whereIn('ID', $request->input('productSkuId'))->get(['ID'])->toArray();
            $finalOrderId = array_merge($finalOrderId, $reportProductSku);
        }

        $finalOrderId = array_unique($finalOrderId, SORT_REGULAR);

        foreach ($finalOrderId as $item) {

            $data = DB::select(DB::raw("SELECT product.ID,productSku.meta_value AS Gs1,product.post_title,
                    quantity.meta_value AS quantity
                    FROM wp_posts AS product
                    JOIN wp_postmeta AS productSku ON product.ID = productSku.post_id
                    JOIN wp_postmeta AS quantity ON product.ID = quantity.post_id
                    WHERE product.ID = '$item->ID' AND productSku.meta_key = '_sku' AND quantity.meta_key = '_stock' "));


            $finalOrder['product_id'] = count($data) == 0 ? '' : $data[0]->ID;
            $finalOrder['Gs1'] = count($data) == 0 ? '' : $data[0]->Gs1;
            $finalOrder['product_name'] = count($data) == 0 ? '' : $data[0]->post_title;
            if(count($data) != 0) {
                $product = Product::find($data[0]->ID);
                $category = $product->categories[0]->term->name;
                $finalOrder['category'] = $category;
            }
            $finalOrder['quantity'] = count($data) == 0 ? '' : $data[0]->quantity;

            array_push($finalOrders, $finalOrder);
        }

        if($finalOrders != [])
            return $this->export($finalOrders);
        else
            return "گزارشی وجود ندارد";
    }

    public function export($finalOrders)
    {
        return Excel::download(new ProductExport($finalOrders), 'export.xlsx');
    }

}


