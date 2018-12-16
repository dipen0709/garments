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
use App\ClothMaster;
use App\AssignToCustomer;
use App\Order;
use App\Storages;


class CustomerController extends CommonController{

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
        $customer_data = Customer::select('*');
        if(isset($term) && $term != ''){
            $customer_data->where('name','like','%' .$term . '%');
        }
        $result = $customer_data->orderBy('name','ASC')->paginate(25);
        $this->data['customers'] = $result;
        $return_data['cloth_master'] = ClothMaster::select('id','name')->where('chr_delete','=',0)->get();
        $this->data['user'] = Auth::user();
        return View('customers/index', array_merge($this->data, $return_data))->with('term', $term)->render();
    }
    
    public function create(Request $request){
        $return_data = array();
        return View('customers/create', array_merge($this->data, $return_data))->render();
    }
    
    public function edit(Request $request){
        $customers = Customer::find($request->id);
        $return_data['customers'] = $customers;
        
        if(!empty($customers) && count($customers) > 0) {
            return View('customers/edit', array_merge($this->data, $return_data))->render();
        } else {
            return redirect()->route('home');
        }
    }
    
    public function delete(Request $request){
        $customer           =  Customer::find($request->id);
        $customer->chr_delete = 1;
        $customer->save();
        return redirect()->route('customer');
    }
    
     
    
    public function update(Request $request){

        $customer           =  Customer::find($request->id);
        $customer->name = $request->name;
        $customer->mobile = $request->mobile;
        $customer->chr_delete = $request->chr_delete;
        $customer->save();
        return redirect()->route('customer');
    }
    
    public function store(Request $request){

        $customer           =   new Customer();
        $customer->name = $request->name;
        $customer->mobile = $request->mobile;
        $customer->chr_delete = $request->chr_delete;
        $customer->save();
        return redirect()->route('customer');
    }
    
    public function reportData(Request $request){
        
        $return_data = array();
        $customer_data = Customer::select('*');
        $result = $customer_data->orderBy('name','ASC')->get();
        $this->data['customers'] = $result;
        $this->data['user'] = Auth::user();
        
        
        $query = AssignToCustomer::select('cloth_id',DB::raw("sum(cloth_meter) as assign_cloth"))
                ->where('chr_delete','=',0);
        $assigntocustomer = $query->groupBy('cloth_id')->orderBy('cloth_id')->get();
        $array1 = array();
        if(!empty($assigntocustomer) && $assigntocustomer->count()  > 0){
            foreach($assigntocustomer as $data){
                $array1[$data->cloth_id] = $data->assign_cloth;
            }
        }
        
        $storage = Storages::select('cloth_id',DB::raw("sum(cloth_meter) as total_cloth"))
                ->where('chr_delete','=',0)->groupBy('cloth_id')->orderBy('cloth_id')->get();
        $array2 = array();
        if(!empty($storage) && $storage->count()  > 0){
            foreach($storage as $data){
                $array2[$data->cloth_id] = $data->total_cloth;
            }
        }
        $temp = array();
        
        foreach($array2 as $key => $value){
            if(isset($array1[$key])){
                $temp[$key] = $value - $array1[$key];
            } else {
                $temp[$key] = $value;
            }
        }
        $diff = array_diff_key($array1,$array2); 
        if(!empty($diff)){
            foreach($diff as $key => $value){
                $temp[$key] = '-'.$value;
            }
        }
        $return_data['kapad_array'] = BillController::getKapadArray();
        $return_data['storage_rem']= $temp;
        return View('customers/report', array_merge($this->data, $return_data))->render();
    }
    
    
    
}

?>