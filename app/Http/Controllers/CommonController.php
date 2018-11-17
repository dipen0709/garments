<?php

namespace App\Http\Controllers;

use Auth;
use Route;
use App\Timezone;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Cookie;
use Symfony\Component\HttpFoundation\Request as SRequest;
use Illuminate\Support\Facades\Log;
use App\Helpers\Thumbnail;//use Avamr\Libraries\MessageLib;
use Carbon\Carbon;
use App\SideMenu;
use App\User;


class CommonController extends Controller {

     protected $data                   = array();
     protected $iconpath               = array();
     protected $sidemenu               = array();
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
       $route = Route::current()->action;
       $search_type = '';
       $route_group = '';
       if(isset($route['searchtype'])){
          $search_type = $route['searchtype'];
       }
       if(isset($route['routegroup'])){
          $route_group = $route['routegroup'];
       }
       $this->data['search_type'] = $search_type;
       $this->data['route_group'] = $route_group;
       $this->iconpath = URL::to('/icons/').'/';
       $this->data['uploadpath'] = URL::to('/upload/').'/';
       
//       $route_name =  Route::currentRouteName();
//       if($route_name == 'bill'){
//           $this->data['search_type'] = '1';
//       } else if($route_name == 'customer'){
//           $this->data['search_type'] = '2';
//       } else if($route_name == 'user'){
//           $this->data['search_type'] = '3';
//       } else if($route_name == 'sizewithprice'){
//           $this->data['search_type'] = '4';
//       } else if($route_name == 'bill.close'){
//           $this->data['search_type'] = '5';
//       } else {
//           $this->data['search_type'] = '';
//       }
    }
}
