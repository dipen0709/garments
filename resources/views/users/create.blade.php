@extends('app')

@section('content')
<div class="row mb-2">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-block">
                <h5 class="card-title mb-4">{{trans('users.adduser')}}</h5>
                <form class="forms-sample" id="profile" name="profile" method="POST" enctype="multipart/form-data" action="{{ route('user.store')}}"
                      autocomplete="off">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" id="user_id" value="">
                    <div class="form-group">
                        <label>{{trans('users.firstname')}}</label>
                        <input type="text" class="form-control p-input" id="name" name="name" placeholder="{{trans('users.firstname')}}" value="">
                    </div>
                    
                    <div class="form-group">
                        <label>{{trans('users.email')}}</label>
                        <input type="email" class="form-control p-input" id="email" name="email" placeholder="{{trans('users.email')}}" value="" >
                    </div>

                    <div class="form-group">
                        <label>{{trans('users.password')}}</label>
                        <input type="password" class="form-control p-input" id="password" name="password" placeholder="{{trans('users.password')}}">
                        <small class="form-text text-muted text-success"><span class="fa fa-info mt-1"></span>&nbsp; {{trans('users.passwordnote')}}</small>
                    </div>
                    <div class="form-group">
                        <label>{{trans('users.confirmpassword')}}</label>
                        <input type="password" class="form-control p-input" id="confirmpassword" name="confirmpassword" placeholder="{{trans('users.confirmpassword')}}">
                        <small id="emailHelp" class="form-text text-muted text-success"><span class="fa fa-info mt-1"></span>&nbsp; {{trans('users.confirmpasswordnote')}}</small>
                    </div>
                    <div class="form-group">
                        <label>{{trans('users.mobile')}}</label>
                        <input type="text" maxlength="10" class="form-control p-input" id="mobile" name="mobile" placeholder="{{trans('users.mobile')}}" value="">
                    </div>
                    <div class="form-group">
                        <label>{{trans('users.profilepic')}}</label>
                        <input type="file" class="form-control-file " id="profilepic" name="profilepic" aria-describedby="fileHelp">
                        <small id="fileHelp" class="form-text text-muted">{{trans('users.5MB')}}</small>
                    </div>
 <div class="form-group">
       <label>User Login</label>
    <div class="form-check"><label class="form-check-label">
        <input type="radio" class="form-check-input" name="chr_delete" id="chr_delete_0" checked='checked' value="0" checked=""> Activate</label>
    </div>
    <div class="form-check"><label class="form-check-label">
        <input type="radio" class="form-check-input" name="chr_delete" id="chr_delete_1" value="1"> Deactivate</label>
    </div>
 </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a class="btn btn-primary" href='{{route('user')}}'>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection