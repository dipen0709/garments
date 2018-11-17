@extends('app')

@section('content')
<h3 class="text-primary mb-4">{{trans('users.editcustomer')}}</h3>
<div class="row mb-2">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-block">
                <h5 class="card-title mb-4">{{trans('users.useredit')}} - {{$customers->name}} {{$customers->last_name}}</h5>
                <form class="forms-sample" id="customer" name="customer" method="POST" enctype="multipart/form-data" action="{{ route('customer.update')}}"
                      autocomplete="off">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="{{ $customers->id }}">
                    <div class="form-group">
                        <label>{{trans('users.firstname')}}</label>
                        <input type="text" class="form-control p-input" id="name" name="name" placeholder="{{trans('users.firstname')}}" value="{{$customers->name}}">
                    </div>
                    
                   
<div class="form-group">
                        <label>{{trans('users.mobile')}}</label>
                        <input type="text" maxlength="10" class="form-control p-input" id="mobile" name="mobile" placeholder="{{trans('users.mobile')}}" value="{{$customers->mobile}}">
                    </div>
                    <div class="form-group">
                        <label>Customer Activate / Deactivate</label>
                     <div class="form-check"><label class="form-check-label">
                         <input type="radio" class="form-check-input" name="chr_delete" id="chr_delete_0" value="0" @if(isset($customers->chr_delete) && $customers->chr_delete == 0) {{ "checked=''" }} @endif > Activate</label>
                     </div>
                     <div class="form-check"><label class="form-check-label">
                         <input type="radio" class="form-check-input" name="chr_delete" id="chr_delete_1" value="1" @if(isset($customers->chr_delete) && $customers->chr_delete == 1) {{ "checked=''" }} @endif> Deactivate</label>
                     </div>
                  </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a class="btn btn-primary" href='{{route('customer')}}'>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection