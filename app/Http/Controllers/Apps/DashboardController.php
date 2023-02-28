<?php

namespace App\Http\Controllers\Apps;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Profit;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //day
        $day    = date('d');

        //week
        $week = Carbon::now()->subDays(7);

        //chart sales 7 days
        $chart_sales_week = DB::table('transactions')
            ->addSelect(DB::raw('DATE(created_at) as date, SUM(grand_total) as grand_total'))
            ->where('created_at', '>=', $week)
            ->groupBy('date')
            ->get();

        if(count($chart_sales_week)) {
            foreach ($chart_sales_week as $result) {
                $sales_date[]    = $result->date;
                $grand_total[]   = (int)$result->grand_total;
            }
        }else {
            $sales_date[]   = "";
            $grand_total[]  = "";
        }
        

        //count sales today
        $count_sales_today = Transaction::whereDay('created_at', $day)->count();

        //sum sales today
        $sum_sales_today = Transaction::whereDay('created_at', $day)->sum('grand_total');

        //sum profits today
        $sum_profits_today = Profit::whereDay('created_at', $day)->sum('total');

        //get product limit stock
        $products_limit_stock = Product::with('category')->where('stock', '<=', 10)->get();

        //chart best selling product
        $chart_best_products = DB::table('transaction_details')
            ->addSelect(DB::raw('products.title as title, SUM(transaction_details.qty) as total'))
            ->join('products', 'products.id', '=', 'transaction_details.product_id')
            ->groupBy('transaction_details.product_id')
            ->orderBy('total', 'DESC')
            ->limit(5)
            ->get();

        if(count($chart_best_products)) {
            foreach ($chart_best_products as $data) {
                $product[] = $data->title;
                $total[]   = (int)$data->total;
            }
        }else {
            $product[]   = "";
            $total[]  = "";
        }

        return Inertia::render('Apps/Dashboard/Index', [
            'sales_date'           => $sales_date,
            'grand_total'          => $grand_total,
            'count_sales_today'    => (int) $count_sales_today,
            'sum_sales_today'      => (int) $sum_sales_today,
            'sum_profits_today'    => (int) $sum_profits_today,
            'products_limit_stock' => $products_limit_stock,
            'product'              => $product,
            'total'                => $total
        ]);
    }
}
