<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\CommonController;
use Redirect;
use App\User;
use App\Bill;
use App\ClothMaster;

class HomeController extends CommonController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       parent::__construct();
       $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $return_data = array();
        $user =  Auth::user();
        if($user->chr_delete == 1){
            return redirect()->route('logout');
        }
        $today_date = date('Y-m-d');
        
        $bill_data = Bill::select('bills.*','customers.name')->leftjoin('customers', 'bills.customer_id', '=', 'customers.id');
//        $bill_data->leftjoin('orders', function($join)
//    {
//        $join->on('orders.bill_id', '=', 'bills.id');
//        $join->on('orders.chr_delete', '=', DB::raw("0"));
//
//    })->whereNull('orders.id');
            $bill_data->where('bills.chr_delete','=',0)
            ->where('bills.is_close','=',0)
                ->whereDate('bills.estimate_date', '<', $today_date);
        $result = $bill_data->groupBy('bills.id')->orderBy('customers.name','ASC')->orderBy('bills.bill_prefix','ASC')->orderBy('bills.customer_bill_id','ASC')->paginate(50);
        $return_data['bills'] = $result;
        $return_data['title'] = 'Dashboard';
//        echo '<pre>'; print_r($result); die;
        return view('home', array_merge($this->data, $return_data))->render();
    }
    
    public static function addCloth(Request $request){
        $cloth_name = $request->cloth_name;
        if($cloth_name){
            $check_cloth = ClothMaster::where('name','=',$cloth_name)->first();
            if(empty($check_cloth)){
                $cloth_master = new ClothMaster();
                $cloth_master->name = $cloth_name;
                $cloth_master->save();
                $return_data['flag'] = 1;
                $return_data['msg'] = 'Cloth type added successfully.';
                
                $cloths =  ClothMaster::select('name','id')->where('chr_delete','=',0)->get();
                $return_data['count'] =  $cloths->count();
                $return_data['cloth'] =  $cloths;
                
            } else {
                $return_data['flag'] = 0;
                $return_data['msg'] = 'Cloth type name already exist.';
            }
        } else {
            $return_data['flag'] = 0;
            $return_data['msg'] = 'Please enter Cloth type.';
        }
        return json_encode($return_data);
    }
}
