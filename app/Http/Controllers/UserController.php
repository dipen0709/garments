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


class UserController extends CommonController{

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
        $user_data = User::select('*');
        if(isset($term) && $term != ''){
            $user_data->where('name','like','%' .$term . '%');
        }
        $result = $user_data->orderBy('name','ASC')->paginate(100);
        $this->data['users'] = $result;
        $this->data['user'] = Auth::user();
        return View('users/index', array_merge($this->data, $return_data))->with('term', $term)->render();
    }
    
    public function create(Request $request){
         $return_data = array();
        $this->data['user'] = Auth::user();
        return View('users/create', array_merge($this->data, $return_data))->render();
    }
    
    public function edit(Request $request){
        $users = User::find($request->id);
        $return_data['users'] = $users;
        
        if(!empty($users) && count($users) > 0) {
            return View('users/edit', array_merge($this->data, $return_data))->render();
        } else {
            return redirect()->route('home');
        }
    }
    
    public function delete(Request $request){
        $user           =  User::find($request->id);
        $user->chr_delete = 1;
        $user->save();
        return redirect()->route('user');
    }
    
     
    
    public function update(Request $request){

        $user           =  User::find($request->id);
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->chr_delete = $request->chr_delete;
        if($request->password){
        $user->password = bcrypt($request->password);
        } 
        if($request->hasFile('profilepic')){
  
            $image = $request->File('profilepic');
            $filename  = time() . '.' . $image->getClientOriginalExtension();

            $path = public_path('upload/' . $filename);
 
                Image::make($image->getRealPath())->resize(200, 200)->save($path);
                $user->profilepic = $filename;
           }
            $user->save();
        return redirect()->route('user');
    }
    
    public function store(Request $request){

        $user           =   new User();
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->chr_delete = $request->chr_delete;
        $user->password = bcrypt($request->password);
        if($request->hasFile('profilepic'))
            {
  
            $image = $request->File('profilepic');
            $filename  = time() . '.' . $image->getClientOriginalExtension();

            $path = public_path('upload/' . $filename);
 
                Image::make($image->getRealPath())->resize(200, 200)->save($path);
                $user->profilepic = $filename;
           }
        $user->save();
        return redirect()->route('user');
    }
    
    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
    
}

?>