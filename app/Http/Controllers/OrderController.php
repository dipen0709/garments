<?php
namespace App\Http\Controllers;

/* * Laravel built-in or extened functionality/Utility class used* */

use Auth;
use File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Intervention\Image\Facades\Image;
use Redirect;
use App\User;
use App\Customer;
use App\Bill;
use App\ClothMaster;
use App\Sizewithprice;
use App\Order;
use App\AssignToCustomer;
use App\Storages;


class OrderController extends CommonController{

    /**
     * Create a new controller instance.
     * 
     * @return void
     */
    public function __construct(){
        parent::__construct();
        $this->middleware('auth');
    }

    public function index(Request $request){
        $return_data = array();
        $term = Session::get('search_value');
        
        $order_data = Order::select('bills.id as bill_number','bills.customer_bill_id as bill_number','orders.*','sizewithprices.serial_name','customers.name')
                    ->leftjoin('bills', 'orders.bill_id', '=', 'bills.id')
                    ->leftjoin('sizewithprices', 'orders.serial_id', '=', 'sizewithprices.id')
                    ->leftjoin('customers', 'orders.customer_id', '=', 'customers.id')
                    ->where('orders.chr_delete','=',0)->where('bills.chr_delete','=',0);
        if(isset($term) && $term != ''){
            $order_data->where(function ($query) use($term) {
                    $query->where('bills.customer_bill_id','like','%' .$term . '%')->orWhere('customers.name','like','%' .$term . '%');
            });
        }
        $return_data['order_data'] = $order_data->orderBy('orders.id','DESC')->paginate(50); 
        $return_data['title'] = 'Jama';
        $this->data['user'] = Auth::user();
        
        return View('order/orderlist', array_merge($this->data, $return_data))->with('term', $term)->render();
    }
    
     public function storage(Request $request){
        $return_data = array();
        $term = Session::get('search_value');
        
        $data = Storages::select('storages.*','cloth_masters.name')
                    ->leftjoin('cloth_masters', 'cloth_masters.id', '=', 'storages.cloth_id')
                    ->where('storages.chr_delete','=',0)->where('cloth_masters.chr_delete','=',0);
        if(isset($term) && $term != ''){
            $data->where(function ($query) use($term) {
                    $query->where('cloth_masters.name','like','%' .$term . '%');
            });
        }
        $return_data['storage'] = $data->orderBy('storages.id','DESC')->paginate(50); 
        $return_data['title'] = 'Storage';
        $this->data['user'] = Auth::user();
        $return_data['cloth_master'] = ClothMaster::select('id','name')->where('chr_delete','=',0)->get();
        return View('order/storage', array_merge($this->data, $return_data))->with('term', $term)->render();
    }
    
    public function saveStorage(Request $request){
        
        $Storages = new Storages();
        $Storages->cloth_id = $request->cloth_id;
        $Storages->cloth_meter = $request->cloth_meter;
        $Storages->assign_date = date('Y-m-d', strtotime($request->assign_date));
        $Storages->save();
        
        return redirect()->route('storage');
    }
    
    public function delete(Request $request){
        $bill           =  Storages::find($request->id);
        $bill->chr_delete = 1;
        $bill->save();
        return redirect()->route('storage');
    }
    
    public function  checkValidOrder(Request $request){
        $valid = 0;
        $bill_id = $request->bill_id;
        $serial_id = $request->serial_id;
        $qty = $request->qty_data;
        $size = $request->size_data;
        
        $avg_detail = OrderController::getAvgDetails($serial_id);
        $use_kapad_array = array();
        if(!empty($size) && count($size) > 0 && !empty($qty)){
            foreach($size as $key => $value){
                if(isset($avg_detail[$value]['use_kapad']) && count($avg_detail[$value]['use_kapad'])){
                    foreach($avg_detail[$value]['use_kapad'] as $i => $val){
                        if(isset($qty[$key])){
                            if(isset($use_kapad_array[$i])){
                                $x =  $val * $qty[$key];
                                $use_kapad_array[$i] = str_replace(".00","", $use_kapad_array[$i] + $x);
                            } else {
                                $x = $val * $qty[$key];
                                $use_kapad_array[$i] = str_replace(".00","", $x);
                            }
                        }
                    }
                }
            }
        }
        $remaining_kapad = OrderController::validMaxQtyBillWise($bill_id);
        
        $diff = array_diff_key($use_kapad_array,$remaining_kapad['remaining_kapad']); 
        
        if(empty($diff) && !empty($remaining_kapad['remaining_kapad']) && !empty($use_kapad_array)){
            $res = array();
            $valid = 1;
            foreach ($remaining_kapad['remaining_kapad'] as $key => $value) {
                if(isset($use_kapad_array[$key])){
                    $res[$key] = $value - $use_kapad_array[$key];
                } else {
                    $res[$key] = $value;
                }
                if($res[$key] < 0){
                    $valid = 0;
                }
            }
        }
        
//        echo '<pre>'; print_r($diff); 
////        echo '<pre>'; print_r($res); 
//        echo '<pre>'; print_r($use_kapad_array); 
//        echo '<pre>'; print_r($remaining_kapad); die;
        if($valid){
            $return_data['flag'] = 1;
        } else {
            $return_data['flag'] = 0;
        }
        return $return_data;
    }
    
    public static function getAvgDetails($id){
        $return_data = array();
        $sizenprice =  Sizewithprice::find($id);
        if(!empty($sizenprice) && !empty($sizenprice->cloth_details)){
            $detail = json_decode($sizenprice->cloth_details);
            $kapad_array = BillController::getKapadArray();
            foreach($detail as $key => $data){
                $return_data['count_size'] = $key + 1;
                $return_data[$data->size]['price'] = $data->price;
                $return_data[$data->size]['kapad_name'] = '';
                if(isset($data->avg->kapad) && count($data->avg->kapad) > 0){
                    $return_data[$data->size]['count_kapad'] = count($data->avg->kapad);
                    for($i = 0; $i < count($data->avg->kapad); $i++){
                        $return_data[$data->size]['kapad'][$kapad_array[$data->avg->kapad[$i]]] = $data->avg->use_kapad[$i];
                        $return_data[$data->size]['kapad_name'] .= $kapad_array[$data->avg->kapad[$i]];
                        
                        $return_data[$data->size]['use_kapad'][$data->avg->kapad[$i]] = $data->avg->use_kapad[$i];
                        
                        $k = count($data->avg->kapad) - 1;
                        if($i != $k){
                            $return_data[$data->size]['kapad_name'] .= ', ';
                        }
                    }
                }
                
            }
        }
//        echo '<pre>'; print_r($return_data); die;
        return $return_data;
    }
    
    public static function validMaxQtyBillWise($bill_id){
        $return_data = array();
        $return_data['remaining_kapad'] = array();
        $assign_kapad_array = array();
        $avg_detail = array();
        $temp = array();
        $total_with_name = array();
        $use_kapad_array = array();
        $kapad_array = BillController::getKapadArray();
        
        $data = AssignToCustomer::select('bills.id as bill_no','sizewithprices.id as avg_id','sizewithprices.cloth_details','sizewithprices.serial_name','assign_to_customers.cloth_id','cloth_masters.name as kapad_name',DB::raw("sum(assign_to_customers.cloth_meter) as assign_cloth"))
                ->leftjoin('bills', 'bills.id', '=', 'assign_to_customers.bill_id')
                ->leftjoin('sizewithprices', 'bills.serial_id', '=', 'sizewithprices.id')
                ->leftjoin('cloth_masters', 'cloth_masters.id', '=', 'assign_to_customers.cloth_id')
                ->where('bills.chr_delete','=',0)
                ->where('sizewithprices.chr_delete','=',0)
                ->where('assign_to_customers.chr_delete','=',0)
                ->where('cloth_masters.chr_delete','=',0)
                ->where('assign_to_customers.bill_id','=',$bill_id)
                ->groupBy('assign_to_customers.cloth_id')->groupBy('bills.id')->orderBy('assign_to_customers.bill_id')
                ->get();
        
        if(!empty($data) && $data->count() > 0){
            foreach($data as $key => $value){
                $temp[$value->cloth_id] = str_replace(".00","", $value->assign_cloth);
                $total_with_name[$kapad_array[$value->cloth_id]] = str_replace(".00","", $value->assign_cloth);
                if($key == 0){
                    $avg_detail = OrderController::getAvgDetails($value->avg_id);
                }
            }
            $assign_kapad_array = $temp;
        }
        
        // direct assigned
        $bills_data = Bill::find($bill_id);
        if(!empty($bills_data) && $bills_data->customer_id > 0){
            $direct_assign = AssignToCustomer::select('assign_to_customers.cloth_id',DB::raw("sum(assign_to_customers.cloth_meter) as assign_cloth"))->where('customer_id','=',$bills_data->customer_id)->where('bill_id','=',0)->where('chr_delete','=',0)->groupBy('assign_to_customers.cloth_id')->orderBy('assign_to_customers.cloth_id')->get();
            if(!empty($direct_assign) && $direct_assign->count() > 0){
                foreach($direct_assign as $d_data){
                    if(isset($assign_kapad_array[$d_data->cloth_id])){
                        $m = $assign_kapad_array[$d_data->cloth_id];
                        $assign_kapad_array[$d_data->cloth_id] = $m + $d_data->assign_cloth;
                    } else {
                        $assign_kapad_array[$d_data->cloth_id] = $d_data->assign_cloth;
                    }
                }
            }
        }
//        echo '<pre>'; print_r($assign_kapad_array); die;
        
        $order = Order::select('*')->where('bill_id','=',$bill_id)->where('chr_delete','=',0)->get();
        
        if(!empty($order) && $order->count() > 0){
            foreach($order as $key => $value){
                if(isset($avg_detail[$value->size]['use_kapad']) && count($avg_detail[$value->size]['use_kapad'])){
                    foreach($avg_detail[$value->size]['use_kapad'] as $i => $val){
                        if(isset($use_kapad_array[$i])){
                            $x =  $val * $value->qty;
                            $use_kapad_array[$i] = str_replace(".00","", $use_kapad_array[$i] + $x);
                        } else {
                            $x = $val * $value->qty;
                            $use_kapad_array[$i] = str_replace(".00","", $x);
                        }
                    }
                }
            }
        }
        $diff = array_diff_key($use_kapad_array,$assign_kapad_array); 
        if(empty($diff) && !empty($assign_kapad_array)){
            $res = array();
            $res_name = array();
            
            foreach ($assign_kapad_array as $key => $value) {
                if(isset($use_kapad_array[$key])){
                    $res[$key] = $assign_kapad_array[$key] - $use_kapad_array[$key];
                    $res_name[$kapad_array[$key]] = $assign_kapad_array[$key] - $use_kapad_array[$key];
                } else {
                    $res[$key] = $assign_kapad_array[$key];
                    $res_name[$kapad_array[$key]] = $assign_kapad_array[$key];
                }
            }
            $return_data['remaining_kapad'] = $res;
            $return_data['remaining_kapad_with_name'] = $res_name;
            $return_data['assign'] = $total_with_name;
        }
//        echo '<pre>'; print_r($return_data); die;
            return $return_data;
        }
        
   public function reportHtml(Request $request){
        $customer = Customer::find($request->customer_id);
        $return_data = array();
        $return_data['remaining_kapad'] = array();
        $assign_kapad_array = array();
        $avg_detail = array();
        $temp = array();
        $total_with_name = array();
        $use_kapad_array = array();
        $kapad_array = BillController::getKapadArray();
        
        $query = AssignToCustomer::select('cloth_id',DB::raw("sum(cloth_meter) as assign_cloth"))
                ->where('chr_delete','=',0);
        if($request->customer_id > 0){
            $query->where('customer_id','=',$request->customer_id);
        }
        $data = $query->groupBy('cloth_id')->orderBy('cloth_id')->get();
//        echo '<pre>'; print_r($data); die;
        if(!empty($data) && $data->count() > 0){
            foreach($data as $key => $value){
                $temp[$value->cloth_id] = str_replace(".00","", $value->assign_cloth);
                $total_with_name[$kapad_array[$value->cloth_id]] = str_replace(".00","", $value->assign_cloth);
                
            }
            $assign_kapad_array = $temp;
        }
        $query1 = Order::select('*');
        if($request->customer_id > 0){
            $query1->where('customer_id','=',$request->customer_id);
        } 
        $order = $query1->where('chr_delete','=',0)->get();
        
        if(!empty($order) && $order->count() > 0){
            foreach($order as $key => $value){
                if($value->serial_id){
                    $avg_detail = OrderController::getAvgDetails($value->serial_id);
                }
                if(isset($avg_detail[$value->size]['use_kapad']) && count($avg_detail[$value->size]['use_kapad'])){
                    foreach($avg_detail[$value->size]['use_kapad'] as $i => $val){
                        if(isset($use_kapad_array[$i])){
                            $x =  $val * $value->qty;
                            $use_kapad_array[$i] = str_replace(".00","", $use_kapad_array[$i] + $x);
                        } else {
                            $x = $val * $value->qty;
                            $use_kapad_array[$i] = str_replace(".00","", $x);
                        }
                    }
                }
            }
        }
        $diff = array_diff_key($use_kapad_array,$assign_kapad_array); 
        
//        echo '<pre>'; print_r($use_kapad_array);
//        echo '<pre>'; print_r($assign_kapad_array);
//        echo '<pre>'; print_r($avg_detail);
//        echo '<pre>'; print_r($diff); die;
        if(empty($diff) && !empty($assign_kapad_array)){
            $res = array();
            $res_name = array();
            
            foreach ($assign_kapad_array as $key => $value) {
                if(isset($use_kapad_array[$key])){
                    $res[$key] = $assign_kapad_array[$key] - $use_kapad_array[$key];
                    $res_name[$kapad_array[$key]] = $assign_kapad_array[$key] - $use_kapad_array[$key];
                } else {
                    $res[$key] = $assign_kapad_array[$key];
                    $res_name[$kapad_array[$key]] = $assign_kapad_array[$key];
                }
            }
//            $return_data['remaining_kapad'] = $res;
            $return_data['remaining_kapad_with_name'] = $res_name;
//            $return_data['used'] = $use_kapad_array;
//            $return_data['assign'] = $total_with_name;
        }
//        echo '<pre>'; print_r($total_with_name); die;
       
        $html = '<div class="card">
                                <div class="card-block">';
        
        if((!empty($return_data['remaining_kapad_with_name']) && count($return_data['remaining_kapad_with_name']) > 0)){
            
            $customer_name = 'All Customer';
            if(!empty($customer)){
                    $customer_name = $customer->name;
            }
            
            $html .= '<div class="col-lg-12"><div class="card-title mb-4" style=" font-size: 16px;">Karigar Name - '.$customer_name.'<small style="font-size: 10px; color: black;"> (Kapad baki)</small></div>';
            
                foreach($return_data['remaining_kapad_with_name'] as $key => $value){   
                    $html .= '<div class="card-title mb-3" >'.$key.': &nbsp;&nbsp;'.str_replace(".00","",$value).' </div>';
                }                       
             $html .= '</div>';
             $html .= '</div></div>';
        } else {
            $html .= 'No record(s) found.</div></div>';
        }
        return $html;
    }
}
?>