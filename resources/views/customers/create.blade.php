@extends('app')

@section('content')
<div class="row mb-2">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-block">
                <h5 class="card-title mb-4">{{trans('users.addcustomer')}}</h5>
                <form class="forms-sample" id="customer" name="customer" method="POST" enctype="multipart/form-data" action="{{ route('customer.store')}}"
                      autocomplete="off">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label>{{trans('users.firstname')}}</label>
                        <input type="text" class="form-control p-input" id="name" name="name" placeholder="{{trans('users.firstname')}}" value="">
                    </div>
                    
                    <div class="form-group">
                        <label>{{trans('users.mobile')}}</label>
                        <input type="text" maxlength="10" class="form-control p-input" id="mobile" name="mobile" placeholder="{{trans('users.mobile')}}" value="">
                    </div>
                    <div class="form-group">
                    <label>Customer Activate / Deactivate</label>
                    <div class="form-check"><label class="form-check-label">
                        <input type="radio" class="form-check-input" name="chr_delete" id="chr_delete_0" checked='checked' value="0" checked=""> Activate</label>
                    </div>
                    <div class="form-check"><label class="form-check-label">
                        <input type="radio" class="form-check-input" name="chr_delete" id="chr_delete_1" value="1"> Deactivate</label>
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