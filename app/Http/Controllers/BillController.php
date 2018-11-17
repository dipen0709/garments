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


class BillController extends CommonController{

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
        $customer_search =  $request->customer;
        $bill_data = Bill::select('bills.*','customers.name', DB::raw("count(orders.id) as order_count"),'sizewithprices.serial_name')->leftjoin('customers', 'bills.customer_id', '=', 'customers.id')->leftjoin('sizewithprices', 'bills.serial_id', '=', 'sizewithprices.id');
        $bill_data->leftjoin('orders', function($join)
    {
        $join->on('orders.bill_id', '=', 'bills.id');
        $join->on('orders.chr_delete', '=', DB::raw("0"));

    })->where('bills.chr_delete','=',0)->where('bills.is_close','=',0);
        if(isset($term) && $term != ''){
            $bill_data->where(function ($query) use($term) {
                    $query->where('bills.customer_bill_id','like','%' .$term . '%')->orWhere('customers.name','like','%' .$term . '%');
            });
        }
        if(isset($customer_search) && $customer_search != ''){
            $bill_data->where(function ($query) use($customer_search) {
                    $query->where('bills.customer_id','=',$customer_search);
            });
            $return_data['customer_name'] = Customer::select('name')->where('id','=',$customer_search)->first();
        }
        $result = $bill_data->groupBy('bills.id')->orderBy('customers.name','ASC')->orderBy('bills.customer_bill_id','ASC')->paginate(100);
        $return_data['bills'] = $result;
        
        $return_data['title'] = 'Chitthi';
        $return_data['closed'] = 0;
        $this->data['user'] = Auth::user();
        
        return View('bill/index', array_merge($this->data, $return_data))->with('term', $term)->render();
    }
    
    public function closelist(Request $request){
//        OrderController::validMaxQtyBillWise(1);
        $return_data = array();
        $term = Session::get('search_value');
        
        $bill_data = Bill::select('bills.*','customers.name', DB::raw("count(orders.id) as order_count"),'sizewithprices.serial_name')->leftjoin('customers', 'bills.customer_id', '=', 'customers.id')->leftjoin('sizewithprices', 'bills.serial_id', '=', 'sizewithprices.id');
        $bill_data->leftjoin('orders', function($join)
    {
        $join->on('orders.bill_id', '=', 'bills.id');
        $join->on('orders.chr_delete', '=', DB::raw("0"));

    })->where('bills.chr_delete','=',0)->where('bills.is_close','=',1);
        if(isset($term) && $term != ''){
            $bill_data->where(function ($query) use($term) {
                    $query->where('bills.customer_bill_id','like','%' .$term . '%')->orWhere('customers.name','like','%' .$term . '%');
            });
        }
        $result = $bill_data->groupBy('bills.id')->orderBy('customers.name','ASC')->orderBy('bills.customer_bill_id','ASC')->paginate(100);
        $return_data['bills'] = $result;
        $return_data['title'] = 'Closed Chitthi';
        $return_data['closed'] = 1;
        $this->data['user'] = Auth::user();
        
        return View('bill/index', array_merge($this->data, $return_data))->with('term', $term)->render();
    }
    
    public function create(Request $request){
        $return_data = array();
        $this->data['customers'] = Customer::select('id','name','mobile')->where('chr_delete','=',0)->get();
        $this->data['sizewithprices'] = Sizewithprice::select('id','serial_name')->where('chr_delete','=',0)->get();
        return View('bill/create', array_merge($this->data, $return_data))->render();
    }
    
    public function edit(Request $request){
        $bills = Bill::find($request->id);
        if(!empty($bills) && count($bills) > 0) {
            $return_data['bills'] = $bills;
            $order_count = Order::where('chr_delete','=',0)->where('bill_id','=',$request->id)->count();
            
            $customer = Customer::select('id','name','mobile')->where('chr_delete','=',0);
            if($bills->customer_id){
              $customer->where('id','=',$bills->customer_id);
            }
            $return_data['customers'] = $customer->get();
            
            $sizewithprices = Sizewithprice::select('id','serial_name')->where('chr_delete','=',0);
            if($bills->serial_id && $order_count > 0){
               $sizewithprices->where('id','=',$bills->serial_id);
            }
            $return_data['sizewithprices'] = $sizewithprices->get();
            return View('bill/edit', array_merge($this->data, $return_data))->render();
        } else {
            return redirect()->route('bill');
        }
    }
    
    public function delete(Request $request){
        $bill           =  Bill::find($request->id);
        $bill->chr_delete = 1;
        $bill->save();
        return redirect()->route('bill');
    }
    
    public function updateClose(Request $request){
        $bill           =  Bill::find($request->id);
        $bill->is_close = $request->val;
        $bill->save();
        return redirect()->route('bill');
    }
    
    public function update(Request $request){
        $bill           =  Bill::find($request->id);
        $bill->customer_id = $request->customer_id;
        $bill->estimate_date = date('Y-m-d', strtotime($request->estimate_date)); 
        $bill->serial_id = $request->serial_id;
        $bill->save();
        return redirect()->route('bill');
    }
    
    public function store(Request $request){
        $customer_bill_count = Bill::where('customer_id','=',$request->customer_id)->count();
        $bill =  new Bill();
        $bill->customer_id = $request->customer_id;
        $bill->customer_bill_id = $customer_bill_count + 1;
        $bill->estimate_date = date('Y-m-d', strtotime($request->estimate_date)); 
        $bill->serial_id = $request->serial_id;
        $bill->save();
        return redirect()->route('bill');
    }
    
    public static function addCustomer(Request $request){
        $customer_name = $request->customer_name;
        if($customer_name){
            $check_customers = Customer::where('name','=',$customer_name)->first();
            if(empty($check_customers)){
                $customer = new Customer();
                $customer->name = $customer_name;
                $customer->mobile = $request->mobile;
                $customer->save();
                $return_data['flag'] = 1;
                $return_data['msg'] = 'Customer added successfully.';
                
                $customers =  Customer::select('name','id')->where('chr_delete','=',0)->get();
                $return_data['count'] =  $customers->count();
                $return_data['customer'] =  $customers;
                
            } else {
                $return_data['flag'] = 0;
                $return_data['msg'] = 'Customer name already exist.';
            }
        } else {
            $return_data['flag'] = 0;
            $return_data['msg'] = 'Please enter customer name.';
        }
        return json_encode($return_data);
    }
    
    public function orderDetail(Request $request){
        $id = $request->id;
         $return_data = array();
         
        if(!empty($id)) {
          $billdata = Bill::select('bills.*','customers.name','sizewithprices.serial_name','sizewithprices.cloth_details as serial_kapad')
                    ->leftjoin('customers', 'bills.customer_id', '=', 'customers.id')
                    ->leftjoin('sizewithprices', 'bills.serial_id', '=', 'sizewithprices.id')
                    ->where('bills.id','=',$id)->first();
          if(!empty($billdata)){ 
          $return_data['bills'] = $billdata;
          $return_data['payment_details'] = json_decode($billdata->payment_details);
          
          $customer = Customer::select('id','name','mobile')->where('chr_delete','=',0);
          if($billdata->customer_id){
              $customer->where('id','=',$billdata->customer_id);
          }
          $return_data['customers'] = $customer->get();
          $sizewithprices = Sizewithprice::select('id','serial_name')->where('chr_delete','=',0);
          $return_data['serial_detail'] = array();
          if($billdata->serial_id > 0){
              $return_data['serial_detail'] = OrderController::getAvgDetails($billdata->serial_id);
              $sizewithprices->where('id','=',$billdata->serial_id);
          }
          $return_data['sizewithprices'] = $sizewithprices->get();
//          echo '<pre>'; print_r($return_data['serial_detail']); die;
          $return_data['cloth_master'] = ClothMaster::select('id','name')->where('chr_delete','=',0)->get();
          
          
          $order_data = Order::select('orders.*','sizewithprices.serial_name')
                    ->leftjoin('sizewithprices', 'orders.serial_id', '=', 'sizewithprices.id')
                    ->where('orders.chr_delete','=',0)->where('orders.bill_id','=',$id);
           $return_data['order_data'] = $order_data->get(); 
       
           $bill_data = Bill::select('bills.*','customers.name')->leftjoin('customers', 'bills.customer_id', '=', 'customers.id');
           $bill_data->where('bills.chr_delete','=',0)->where('bills.is_close','=',0)->where('bills.customer_bill_id','>',$billdata->customer_bill_id)->where('bills.customer_id','=',$billdata->customer_id)->where('bills.serial_id','=',$billdata->serial_id);
        $result = $bill_data->groupBy('bills.id')->orderBy('bills.customer_bill_id','ASC')->paginate(5);
//        echo $billdata->id; die;
        $return_data['next_bills'] = $result;
         $return_data['closed'] = 0;
         $return_data['assign_kapad'] = AssignToCustomer::select('*','cloth_masters.name')->leftjoin('cloth_masters', 'cloth_masters.id', '=', 'assign_to_customers.cloth_id')->where('assign_to_customers.customer_id','=',$billdata->customer_id)->where('assign_to_customers.bill_id','=',$billdata->id)->where('assign_to_customers.chr_delete','=',0)->orderBy('assign_to_customers.assign_date','desc')->get();
            
         
         $return_data['remaining_data'] = OrderController::validMaxQtyBillWise($billdata->id);
         
             return View('order/index', array_merge($this->data, $return_data))->render();
          } else {
              return redirect()->route('bill');
          }
        } else {
            return redirect()->route('bill');
        }
    }
    
    public function assignCloth(Request $request){
        
        $AssignToCustomer = new AssignToCustomer();
        $AssignToCustomer->customer_id = $request->customer_id;
        $AssignToCustomer->bill_id = $request->bill_id;
        $AssignToCustomer->cloth_id = $request->cloth_id;
        $AssignToCustomer->cloth_meter = $request->cloth_meter;
        $AssignToCustomer->assign_date = date('Y-m-d', strtotime($request->assign_date));
        $AssignToCustomer->save();
        $bill_id = $request->bill_id;
        if($bill_id){
            return redirect()->route('order.detail',array('id' => $bill_id));
        } else if($request->customer_id){
            return redirect()->route('customer');
        }  else {
            return redirect()->route('bill');
        }
    }
    
    public static function getKapadArray(){
        return $kapad_array = ClothMaster::pluck('name','id');
        
    }
    
    public static function getSizeWithPrice(Request $request){
      $serial_id = $request->serial_id; 
      if($serial_id){
            $check_sizewithprice =  $sizewithprices = Sizewithprice::select('id','serial_name','cloth_details')->where('chr_delete','=',0)->where('id','=',$serial_id)->first();
      }
      
        if(!empty($check_sizewithprice)){
            if(isset($check_sizewithprice->cloth_details) && $check_sizewithprice->cloth_details){
                $kapad_array = BillController::getKapadArray();
                $result = json_decode($check_sizewithprice->cloth_details);
                $return_data['flag'] = 1;
                $count =  count($result);
                
                $html = '';
//                echo '<pre>'; print_r($kapad_array);
//                echo '<pre>'; print_r($result);
//                die;
                if($count > 0){
           $html .= '<div class="form-group col-sm-6"><label class="font-normal"  style="color: #68b7bb;">Size</label></div>
            <div class="form-group col-sm-4"><label class="font-normal" style="color: #68b7bb;">Price</label></div>
            <div class="form-group col-sm-2"><label class="font-normal" style="color: #68b7bb;">Qty</label></div>
            <div class="clearfix"></div>';
             $valid_count = 0;
             foreach($result as $key => $data){
                 $i = $key + 1;
                 $size = '';
                 $price = '';
                 $other_price = '';
                 $other_price_value = '';
                 if(isset($data->size)){
                    $size = $data->size;   
                 }
                 if(isset($data->price)){
                    $price = $data->price;   
                    if(isset($data->other_price)){
                         $x = $price - $data->other_price;
                        $other_price = ' <small style="font-size: 12px;">  ('.$x.' + '.$data->other_price.')</small>';  
                        $other_price_value = $data->other_price;
                     }
                 }
                 $cloth_detail = '';
                 $avg_count = count($data->avg->kapad);
                 
                 for($i = 0; $i < $avg_count; $i++){
                     if($i == 0){
                         $cloth_detail .= ' <small style="font-size: 12px;">(';
                     }
                     if(isset($data->avg->kapad[$i]) && isset($data->avg->use_kapad[$i]) && isset($kapad_array[$data->avg->kapad[$i]])){
                        $cloth_detail .= $kapad_array[$data->avg->kapad[$i]].': '.$data->avg->use_kapad[$i];
                     }
                     if($i == ($avg_count-1)){
                         $cloth_detail .= ')</small>';
                     } else {
                         $cloth_detail .= ', ';
                     }
                 }
                
                  if($size){    
                      $valid_count++;
             $html .= '<div class="form-group col-sm-6"><label>'.$size.$cloth_detail.'</label><input type="hidden" class="form-control p-input" id="order_size_'.$valid_count.'" name="order_size[]" value="'.$size.'"></div>
            <div class="form-group col-sm-4"><input type="text" class="form-control p-input price_validate" id="order_price_'.$valid_count.'" name="order_price[]" value="'.$price.'" style="display:inline; width:70%; "><label>'.$other_price.'</label><input type="hidden" name="order_other_price[]" id="order_other_price_'.$valid_count.'" value="'.$other_price_value.'" /></div><div class="form-group col-sm-2"><input type="text" class="form-control p-input price_validate" id="order_qty_'.$valid_count.'" name="order_qty[]" value=""></div>
             <div class="clearfix"></div>';
             
                    }
             }
             $html .= '<input type="hidden" name="count_size_with_price" id="count_size_with_price" value="'.$valid_count.'" />';
             $html .= '<script>$(".price_validate").keypress(function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
        if(     ($(this).val().indexOf('.') != -1) &&   ($(this).val().substring($(this).val().indexOf('.'),$(this).val().indexOf('.').length).length>2 )         ){
            event.preventDefault();
        }
    });</script>';
                }
            } else {
                $html = '<div class="form-group">Size not available for selected serial number.</div>';
            }
        } else {
            $html  = '<div class="form-group">Please select valid serial number.</div>';
        }
        return $html;
    }
    public static function orderStore(Request $request){
        $bill_id = $request->bill_id;
        $customer_id = $request->customer_id;
        $serial_id = $request->serial_id;
        $order_date = date('Y-m-d', strtotime($request->order_date));
        $size = $request->order_size;
        $price = $request->order_price;
        $other_price = $request->order_other_price;
        $qty = $request->order_qty;
        
        $count = count($size);
        if($bill_id && $customer_id && $serial_id){
            for($i = 0; $i < $count; $i++){
                $order = new Order();
                $order->bill_id = $bill_id;
                $order->customer_id = $customer_id;
                $order->serial_id = $serial_id;
                $order->order_date = $order_date;

                if(isset($size[$i])){
                    $order->size = $size[$i];
                }
                if(isset($price[$i])){
                    $order->price = $price[$i];
                    if(isset($other_price[$i])){
                        $order->other_price = $other_price[$i];
                    }
                }
                if(isset($qty[$i])){
                    $order->qty = $qty[$i];
                    
                    $order->save();
                }
            }
        }
        
        if($bill_id){
            return redirect()->route('order.detail',array('id' => $bill_id));
        } else {
            return redirect()->route('bill');
        }
    }
    
    public static function paymentPrice(Request $request){
        $bill_id = $request->bill_id;
        $price = $request->price;
        $estimate_date = $request->estimate_date;
        
        if($bill_id && $price && $estimate_date){
             $bill           =  Bill::find($bill_id);
             if(!empty($bill) && empty($bill->payment_details)){
                $data['price'] = $price;
                $data['estimate_date'] = date('Y-m-d', strtotime($estimate_date));
                $array[] = $data;
                $bill->payment_details = json_encode($array);
                $bill->save();
             } else if(!empty($bill)) {
                $data['price'] = $price;
                $data['estimate_date'] = date('Y-m-d', strtotime($estimate_date));
                $exist_data = (array) json_decode($bill->payment_details);
                $array[] = $data;
                $data_merge = array_merge($exist_data,$array);
                $bill->payment_details = json_encode($data_merge);
                $bill->save();
             }
        }
        if($bill_id){
            return redirect()->route('order.detail',array('id' => $bill_id));
        } else {
            return redirect()->route('bill');
        }
    }
    
     public function orderDelete(Request $request){
        $order           =  Order::find($request->id);
        $order->chr_delete = 1;
        $order->save();
        return redirect()->route('order.detail',array('id' => $request->bill_id));
    }
     public function autoSearchData(Request $request){
            $search_type = $request->search_type; 
            $search_value = $request->search_value;
            if(isset($search_type) && $search_type == '1'){
               return redirect()->route('bill')->with('search_value', $search_value);
            } else if(isset($search_type) && $search_type == '2'){
                return redirect()->route('customer')->with('search_value', $search_value);
            } else if(isset($search_type) && $search_type == '3'){
                return redirect()->route('user')->with('search_value', $search_value);
            } else if(isset($search_type) && $search_type == '4'){
                return redirect()->route('sizewithprice')->with('search_value', $search_value);
            } else if(isset($search_type) && $search_type == '5'){
                return redirect()->route('bill.close')->with('search_value', $search_value);
            } else if(isset($search_type) && $search_type == '6'){
                return redirect()->route('order')->with('search_value', $search_value);
            } else if(isset($search_type) && $search_type == '7'){
                return redirect()->route('storage')->with('search_value', $search_value);
            } else {
                return redirect()->route('bill');
            }
    }
}

?>