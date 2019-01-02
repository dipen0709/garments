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
use App\Sizewithprice;
use App\ClothMaster;


class SizeWithPriceController extends CommonController{

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
        $Sizewithprice_data = Sizewithprice::where('chr_delete','=',0);
        if(isset($term) && $term != ''){
            $Sizewithprice_data->where('serial_name','like','%' .$term . '%');
        }
        $result = $Sizewithprice_data->orderBy('serial_name','ASC')->paginate(100);
        $this->data['sizenprices'] = $result;
        $this->data['user'] = Auth::user();
        $this->data['kapad_array'] = BillController::getKapadArray();
        return View('sizewithprice/index', array_merge($this->data, $return_data))->with('term', $term)->render();
    }
    
    public function create(Request $request){
        $return_data = array();
        $this->data['kapad_master'] = ClothMaster::select('id','name')->where('chr_delete','=',0)->get();
        return View('sizewithprice/create', array_merge($this->data, $return_data))->render();
    }
    
    public function edit(Request $request){
        $sizewithprice = Sizewithprice::find($request->id);     
        $return_data['sizewithprice'] = $sizewithprice;
        $this->data['kapad_master'] = ClothMaster::select('id','name')->where('chr_delete','=',0)->get();
        $return_data['cloth_details'] = array();
        if(!empty($sizewithprice)) {
            if(isset($sizewithprice['cloth_details']) && $sizewithprice['cloth_details'] != ''){
                $return_data['cloth_details'] = json_decode($sizewithprice['cloth_details']);
            }
            return View('sizewithprice/edit', array_merge($this->data, $return_data))->render();
        } else {
            return redirect()->route('home');
        }
    }
    
    public function delete(Request $request){
        $sizenprice           =  Sizewithprice::find($request->id);
        $sizenprice->chr_delete = 1;
        $sizenprice->save();
        return redirect()->route('sizewithprice');
    }
    
     
    
    public function update(Request $request){
        $sizenprice =  Sizewithprice::find($request->id);
        $sizenprice->serial_name = $request->serial_name;
        $j = $request->addDetails;
        $size = $request->size;
        $price = $request->price;
        $other_price = $request->other_price;
        $other_desc = $request->other_desc;
//        echo '<pre>'; print_r($size);
//        echo '<pre>'; print_r($price);
        $data = array();
        for($a= 0; $a < $j; $a++){
            if(isset($size[$a]) && isset($price[$a])){
                $data[$a]['size'] = $size[$a];
                $data[$a]['price'] = $price[$a];
                $data[$a]['other_price'] = $other_price[$a];
                $data[$a]['other_desc'] = $other_desc[$a];
                $key = $a + 1; 
                $avg_key = 'total_avg_'.$key;
                $total_avg =  $request->$avg_key; 
                if($total_avg > 0){
                        $kapad_key = 'kapad_id_'.$key;
                        $kapad_use_key = 'use_kapad_'.$key;
                        $kapad = $request->$kapad_key;
                        $use_kapad = $request->$kapad_use_key;
                        if(!empty($kapad) && !empty($use_kapad)){
//                            echo $a;
//                            echo '<pre>'; print_r($kapad);
                            $loop = count($kapad);
                            $temp = array();
                            $use_temp = array();
                            $x = 0;
                            for($i = 0; $i < $loop; $i++){
                                if(!empty($kapad[$i]) && !empty($use_kapad[$i])) {
                                    $temp[$x] = $kapad[$i];
                                    $use_temp[$x] = $use_kapad[$i];
                                    $x++;
                                }
                            }
                            if(!empty($temp) && !empty($use_temp)){
                                $data[$a]['avg']['kapad'] =  $temp;
                                $data[$a]['avg']['use_kapad'] =  $use_temp;
                            } else {
                                unset($data[$a]);
                            }
                        } else {
                            unset($data[$a]);
                        }
                } else {
                            unset($data[$a]);
                }
            }
        }
//        echo '<pre>'; print_r($data); die;
        if(!empty($data)){
            $sizenprice->cloth_details = json_encode($data);
        } else {
            $sizenprice->cloth_details = '';
        }
        $sizenprice->save();
        return redirect()->route('sizewithprice');
    }
    
    public function store(Request $request){

        $sizenprice = new Sizewithprice();
        $sizenprice->serial_name = $request->serial_name;
        $j = $request->addDetails;
        $size = $request->size;
        $price = $request->price;
        $other_price = $request->other_price;
        $other_desc = $request->other_desc;
        $data = array();
        for($a= 0; $a < $j; $a++){
            if(isset($size[$a]) && isset($price[$a])){
                $data[$a]['size'] = $size[$a];
                $data[$a]['price'] = $price[$a];
                $data[$a]['other_price'] = $other_price[$a];
                $data[$a]['other_desc'] = $other_desc[$a];
                $key = $a + 1; 
                $avg_key = 'total_avg_'.$key;
                $total_avg =  $request->$avg_key; 
                if($total_avg > 0){
                        $kapad_key = 'kapad_id_'.$key;
                        $kapad_use_key = 'use_kapad_'.$key;
                        $kapad = $request->$kapad_key;
                        $use_kapad = $request->$kapad_use_key;
                        if(!empty($kapad) && !empty($use_kapad)){
                            $loop = count($kapad);
                            $temp = array();
                            $use_temp = array();
                            $x = 0;
                            for($i = 0; $i < $loop; $i++){
                                if(!empty($kapad[$i]) && !empty($use_kapad[$i])) {
                                    $temp[$x] = $kapad[$i];
                                    $use_temp[$x] = $use_kapad[$i];
                                    $x++;
                                }
                            }
                            if(!empty($temp) && !empty($use_temp)){
                                $data[$a]['avg']['kapad'] =  $temp;
                                $data[$a]['avg']['use_kapad'] =  $use_temp;
                            } else {
                                unset($data[$a]);
                            }
                        } else {
                            unset($data[$a]);
                        }
                } else {
                            unset($data[$a]);
                }
            }
        }
        if(!empty($data)){
            $sizenprice->cloth_details = json_encode($data);
        } 
        $sizenprice->save();
        return redirect()->route('sizewithprice');
 
    }
     
    public static function copyDesign(Request $request){
        $design_name = $request->design_name;
        $design_id = $request->design_id;
       
        if($design_id && $design_name){
            $check_avg = Sizewithprice::where('serial_name','=',$design_name)->first();
            if(empty($check_avg)){
                $copy_avg = Sizewithprice::where('id','=',$design_id)->first();
                if(!empty($copy_avg)){
                    $average = new Sizewithprice();
                    $average->cloth_details = $copy_avg->cloth_details;
                    $average->serial_name = $design_name;
                    $average->save();
                    $return_data['flag'] = 1;
                    $return_data['msg'] = 'Design name added successfully.';
                } else {
                    $return_data['flag'] = 0;
                    $return_data['msg'] = 'Something going wrong. Please refresh and try again.';
                }
            } else {
                $return_data['flag'] = 0;
                $return_data['msg'] = 'Design name already exist.';
            }
        } else {
            $return_data['flag'] = 0;
            $return_data['msg'] = 'Please enter design name.';
        }
        return json_encode($return_data);
    }
    
}

?>