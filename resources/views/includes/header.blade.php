 <nav class="navbar bg-primary-gradient col-lg-12 col-12 p-0 fixed-top navbar-inverse d-flex flex-row">
            <div class="bg-white text-center navbar-brand-wrapper">
                <a class="navbar-brand brand-logo" href="{{route('home')}}"><img src="{{ asset('images/logo_star_black.png') }}" /></a>
                <a class="navbar-brand brand-logo-mini" href="{{route('home')}}"><img src="{{ asset('images/logo_star_mini.jpg') }}" alt=""></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center">
                <button class="navbar-toggler navbar-toggler hidden-md-down align-self-center mr-3" type="button" data-toggle="minimize">
                  <span class="navbar-toggler-icon"></span>
                </button>
                @if(isset($search_type) && $search_type > 0)
                <form class="form-inline mt-2 mt-md-0 hidden-md-down" id="autosearch-form" name="autosearch-form" method="POST"  action="{{ route('autosearch.data')}}" autocomplete="off" >
                    <input class="form-control mr-sm-2 search" type="text" placeholder="Search" id="search_value" name="search_value" value="@if(isset($term)){{$term}}@endif">
                    <input type="hidden" id="search_type" name="search_type" value="{{$search_type}}"/>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="card-block">
                        <button type="submit" class="btn btn-secondary" style="color: blue;">Search</button>
                    </div>
                </form>
                @endif
                <ul class="navbar-nav ml-lg-auto d-flex align-items-center flex-row">
                    <?php 
                    $user = Auth::user();
                    $id = '';
                    $profilepic = '';
                    $name = '';
                    if(!empty($user->profilepic) && $user->profilepic != 'null'){
                        $profilepic = $uploadpath.$user->profilepic;
                    }
                    if(!empty($user->id)){
                        $id = $user->id;
                    }
                    if(!empty($user->name)){
                        $name = $user->name.' '.$user->last_name;
                    }
                ?>
                    <li class="nav-item">
                        <a class="nav-link profile-pic" href="{{ route('user.edit',array('id'=>$id)) }}"><img class="rounded-circle" src="{{ $profilepic }}" title="{{ $name }}" alt=""></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-th"></i></a>
                    </li>
                </ul>
                <a type="button" class="btn btn-secondary" style="-webkit-appearance:none; color: blue;" href="{{route('logout')}}">Logout</a>
                <button class="navbar-toggler navbar-toggler-right hidden-lg-up align-self-center" type="button" data-toggle="offcanvas">
                  <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>