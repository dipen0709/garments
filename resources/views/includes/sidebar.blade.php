<nav class="bg-white sidebar sidebar-fixed sidebar-offcanvas" id="sidebar">
<!--                <div class="user-info">
                <?php 
                    $user = Auth::user();
                    $id = '';
                    $profilepic = '';
                    $name = '';
                    $mobile = '';
                    if(!empty($user->profilepic) && $user->profilepic != 'null'){
                        $profilepic = $uploadpath.$user->profilepic;
                    }
                    if(!empty($user->id)){
                        $id = $user->id;
                    }
                    if(!empty($user->name)){
                        $name = $user->name.' '.$user->last_name;
                    }
                    if(!empty($user->mobile)){
                        $mobile = $user->mobile;
                    }
                ?>
                    <img src="{{ $profilepic }}" alt="" title="{{ $name }}">
                    <p class="name">{{ $name }}</p>
                    <p class="designation">{{ $mobile }}</p>
                    <span class="online"></span>
                </div>-->
                    <ul class="nav">
                        <li class="nav-item @if(isset($route_group) && $route_group == 'home'){{'active'}}@endif">
                            <a class="nav-link" href="{{ route('home') }}">
                                <!-- <i class="fa fa-dashboard"></i> -->
                                <img src="{{ asset('images/icons/1.png') }}" alt="">
                                <span class="menu-title">Dashboard</span>
                            </a>
                        </li>
                        
                         <li class="nav-item @if(isset($route_group) && $route_group == 'customer'){{'active'}}@endif">
                            <a class="nav-link" href="{{ route('customer') }}">
                                <img src="{{ asset('images/icons/2.png') }}" alt="">
                                <span class="menu-title">Karigars</span>
                            </a>
                        </li>
                         <li class="nav-item @if(isset($route_group) && $route_group == 'bill'){{'active'}}@endif">
                            <a class="nav-link" href="{{ route('bill') }}">
                                <img src="{{ asset('images/icons/3.png') }}" alt="">
                                <span class="menu-title">Chitthi (Bills)</span>
                            </a>
                        </li>
                        <li class="nav-item @if(isset($route_group) && $route_group == 'billclose'){{'active'}}@endif">
                            <a class="nav-link" href="{{ route('bill.close') }}">
                                <img src="{{ asset('images/icons/4.png') }}" alt="">
                                <span class="menu-title">Closed Chitthi</span>
                            </a>
                        </li>
                         <li class="nav-item  @if(isset($route_group) && $route_group == 'sizewithprice'){{'active'}}@endif">
                            <a class="nav-link" href="{{ route('sizewithprice') }}">
                                <img src="{{ asset('images/icons/5.png') }}" alt="">
                                <span class="menu-title">Average</span>
                            </a>
                        </li>
                        
                        
                        <li class="nav-item @if(isset($route_group) && $route_group == 'order'){{'active'}}@endif">
                            <a class="nav-link" href="{{ route('order') }}">
                                <img src="{{ asset('images/icons/7.png') }}" alt="">
                                <span class="menu-title">Jama (Orders)</span>
                            </a>
                        </li>
                         
                         <li class="nav-item @if(isset($route_group) && $route_group == 'storage'){{'active'}}@endif">
                            <a class="nav-link" href="{{ route('storage') }}">
                                <img src="{{ asset('images/icons/9.png') }}" alt="">
                                <span class="menu-title">Storages (Godown)</span>
                            </a>
                        </li>
                        <li class="nav-item @if(isset($route_group) && $route_group == 'report'){{'active'}}@endif">
                            <a class="nav-link" href="{{ route('report') }}">
                                <img src="{{ asset('images/icons/6.png') }}" alt="">
                                <span class="menu-title">Reports</span>
                            </a>
                        </li>
                        <li class="nav-item @if(isset($route_group) && $route_group == 'profile'){{'active'}}@endif">
                            <a class="nav-link" data-toggle="collapse" href="#setting" aria-expanded="false" aria-controls="setting">
                                <img src="{{ asset('images/icons/10.png') }}" alt="">
                                <span class="menu-title">Settings &nbsp;</span><i class="fa fa-sort-down"></i>
                            </a>
                             <div class="collapse @if(isset($route_group) && ($route_group == 'profile' || $route_group == 'user')){{'in'}}@endif" id="setting">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item @if(isset($route_group) && $route_group == 'user'){{'active'}}@endif">
                                        <a class="nav-link" href="{{ route('user') }}">
                                            <span class="menu-title">Users</span>
                                        </a>
                                    </li>
                                    <li class="nav-item @if(isset($route_group) && $route_group == 'profile'){{'active'}}@endif">
                                        <a class="nav-link" href="{{ route('user.edit',array('id'=>$id)) }}">
                                      Profile
                                    </a>
                                    </li>
                                    
                                    <li class="nav-item">
                                        <a class="visible-xs nav-link user-logout" href="{{ url('/logout') }}"  ui-sref="access.signin">Logout
                                            </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </nav>