@extends('app')

@section('content')
<h3 class="text-primary mb-4">Edit Chitthi</h3>
<div class="row mb-2">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-block">
                <h5 class="card-title mb-4">Chitthi No:  {{$bills->bill_prefix}}-{{$bills->customer_bill_id}} </h5>
                <form class="forms-sample" id="bill" name="bill" method="POST" enctype="multipart/form-data" action="{{ route('bill.update')}}"
                      autocomplete="off">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="{{ $bills->id }}">
                    <div class="form-group">
                        <label>Karigar</label> 
                        <!---->
                       <!--<i class="fa fa-plus-circle add_customer" style="cursor: pointer; float: right;"></i>-->
                        <select id="customer_id" name="customer_id" class="form-control m-b-sm" >
                            <option value="">Select Karigar</option>
                            @if(!empty($customers))
                            @foreach($customers as $customer)
                            <?php $selected = ""; ?>
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
                        <label>Bill Book</label> 
                        <select id="bill_prefix" name="bill_prefix" class="form-control m-b-sm" disabled="">
                            <option @if($bills->bill_prefix == 'B1') {{'selected="selected"'}} @endif value="B1">B1</option>
                            <option @if($bills->bill_prefix == 'B2') {{'selected="selected"'}} @endif value="B2">B2</option>
                            <option @if($bills->bill_prefix == 'B3') {{'selected="selected"'}} @endif value="B3">B3</option>
                            <option @if($bills->bill_prefix == 'B4') {{'selected="selected"'}} @endif value="B4">B4</option>
                            <option @if($bills->bill_prefix == 'B5') {{'selected="selected"'}} @endif value="B5">B5</option>
                            <option @if($bills->bill_prefix == 'B6') {{'selected="selected"'}} @endif value="B6">B6</option>
                            <option @if($bills->bill_prefix == 'B7') {{'selected="selected"'}} @endif value="B7">B7</option>
                            <option @if($bills->bill_prefix == 'B8') {{'selected="selected"'}} @endif value="B8">B8</option>
                            <option @if($bills->bill_prefix == 'B9') {{'selected="selected"'}} @endif value="B9">B9</option>
                            <option @if($bills->bill_prefix == 'B10') {{'selected="selected"'}} @endif value="B10">B10</option>
                            <option @if($bills->bill_prefix == 'B11') {{'selected="selected"'}} @endif value="B11">B11</option>
                            <option @if($bills->bill_prefix == 'B12') {{'selected="selected"'}} @endif value="B12">B12</option>
                            <option @if($bills->bill_prefix == 'B13') {{'selected="selected"'}} @endif value="B13">B13</option>
                            <option @if($bills->bill_prefix == 'B14') {{'selected="selected"'}} @endif value="B14">B14</option>
                            <option @if($bills->bill_prefix == 'B15') {{'selected="selected"'}} @endif value="B15">B15</option>            
                            <option @if($bills->bill_prefix == 'C1') {{'selected="selected"'}} @endif value="C1">C1</option>
                            <option @if($bills->bill_prefix == 'C2') {{'selected="selected"'}} @endif value="C2">C2</option>
                            <option @if($bills->bill_prefix == 'C3') {{'selected="selected"'}} @endif value="C3">C3</option>
                            <option @if($bills->bill_prefix == 'C4') {{'selected="selected"'}} @endif value="C4">C4</option>
                            <option @if($bills->bill_prefix == 'C5') {{'selected="selected"'}} @endif value="C5">C5</option>
                            <option @if($bills->bill_prefix == 'C6') {{'selected="selected"'}} @endif value="C6">C6</option>
                            <option @if($bills->bill_prefix == 'C7') {{'selected="selected"'}} @endif value="C7">C7</option>
                            <option @if($bills->bill_prefix == 'C8') {{'selected="selected"'}} @endif value="C8">C8</option>
                            <option @if($bills->bill_prefix == 'C9') {{'selected="selected"'}} @endif value="C9">C9</option>
                            <option @if($bills->bill_prefix == 'C10') {{'selected="selected"'}} @endif value="C10">C10</option>
                            <option @if($bills->bill_prefix == 'C11') {{'selected="selected"'}} @endif value="C11">C11</option>
                            <option @if($bills->bill_prefix == 'C12') {{'selected="selected"'}} @endif value="C12">C12</option>
                            <option @if($bills->bill_prefix == 'C13') {{'selected="selected"'}} @endif value="C13">C13</option>
                            <option @if($bills->bill_prefix == 'C14') {{'selected="selected"'}} @endif value="C14">C14</option>
                            <option @if($bills->bill_prefix == 'C15') {{'selected="selected"'}} @endif value="C15">C15</option>
                            <option @if($bills->bill_prefix == 'D1') {{'selected="selected"'}} @endif value="D1">D1</option>
                            <option @if($bills->bill_prefix == 'D2') {{'selected="selected"'}} @endif value="D2">D2</option>
                            <option @if($bills->bill_prefix == 'D3') {{'selected="selected"'}} @endif value="D3">D3</option>
                            <option @if($bills->bill_prefix == 'D4') {{'selected="selected"'}} @endif value="D4">D4</option>
                            <option @if($bills->bill_prefix == 'D5') {{'selected="selected"'}} @endif value="D5">D5</option>
                            <option @if($bills->bill_prefix == 'D6') {{'selected="selected"'}} @endif value="D6">D6</option>
                            <option @if($bills->bill_prefix == 'D7') {{'selected="selected"'}} @endif value="D7">D7</option>
                            <option @if($bills->bill_prefix == 'D8') {{'selected="selected"'}} @endif value="D8">D8</option>
                            <option @if($bills->bill_prefix == 'D9') {{'selected="selected"'}} @endif value="D9">D9</option>
                            <option @if($bills->bill_prefix == 'D10') {{'selected="selected"'}} @endif value="D10">D10</option>
                            <option @if($bills->bill_prefix == 'D11') {{'selected="selected"'}} @endif value="D11">D11</option>
                            <option @if($bills->bill_prefix == 'D12') {{'selected="selected"'}} @endif value="D12">D12</option>
                            <option @if($bills->bill_prefix == 'D13') {{'selected="selected"'}} @endif value="D13">D13</option>
                            <option @if($bills->bill_prefix == 'D14') {{'selected="selected"'}} @endif value="D14">D14</option>
                            <option @if($bills->bill_prefix == 'D15') {{'selected="selected"'}} @endif value="D15">D15</option>


                        </select>
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
                    <div class="form-group">
                        <label>Predefine Order Detail</label> 
                        <textarea class="form-control p-input" style="height: 80px;" id="predefined_order_detail" name="predefined_order_detail">{{$bills->predefined_order_detail}}</textarea>
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