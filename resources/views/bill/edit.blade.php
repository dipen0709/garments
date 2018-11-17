@extends('app')

@section('content')
<h3 class="text-primary mb-4">Edit Chitthi</h3>
<div class="row mb-2">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-block">
                <h5 class="card-title mb-4">Chitthi No. -  {{$bills->customer_bill_id}} </h5>
                <form class="forms-sample" id="bill" name="bill" method="POST" enctype="multipart/form-data" action="{{ route('bill.update')}}"
                      autocomplete="off">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="{{ $bills->id }}">
                    <div class="form-group">
                        <label>Customer</label> 
                        <!---->
                       <!--<i class="fa fa-plus-circle add_customer" style="cursor: pointer; float: right;"></i>-->
                        <select id="customer_id" name="customer_id" class="form-control m-b-sm" >
                                    <option value="">Select Customer</option>
                                      @if(!empty($customers))
                                      @foreach($customers as $customer)
                                       <?php  $selected = "";  ?>
                                      @if($bills->customer_id == $customer->id)
                                       <?php $selected = "selected"; ?>
                                      @endif
                                      <option <?php echo $selected ?> value="{{$customer->id}}">{{$customer->name}}</option>
                                      @endforeach
                                      @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Estimate Date</label>                        
                        <div class="input-group date" data-provide="datepicker">
                            <input type="text" class="form-control p-input" id="estimate_date" name="estimate_date"  value="{{date('m/d/Y', strtotime($bills->estimate_date))}}">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Serial Name</label> 
                        <select id="serial_id" name="serial_id" class="form-control m-b-sm">
                                    <option value="0">Select Serial Name</option>
                                      @if(!empty($sizewithprices))
                                      @foreach($sizewithprices as $avg)
                                      <option @if($bills->serial_id == $avg->id) {{'selected="selected"'}} @endif value="{{$avg->id}}">{{$avg->serial_name}}</option>
                                      @endforeach
                                      @endif
                        </select>
                    </div>
                   
                    <div class="col-12 mt-xl-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a class="btn btn-primary" href='{{route('bill')}}'>Cancel</a>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection