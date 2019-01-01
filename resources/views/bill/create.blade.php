@extends('app')

@section('content')
<div class="row mb-2">
    <div class="col-lg-12">
            
        <div class="card">
            <div class="card-block">
                <h5 class="card-title mb-4">Add Chitthi</h5>
                <form class="forms-sample" id="bill" name="bill" method="POST" enctype="multipart/form-data" action="{{ route('bill.store')}}"  autocomplete="off">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label>Karigar</label> 
                        &nbsp;&nbsp;
                       <i class="fa fa-plus-circle add_customer" style="cursor: pointer; float: right; color: dodgerblue;"> Add Karigar</i>
                        <select id="customer_id" name="customer_id" class="form-control m-b-sm">
                                    <option value="">Select Karigar</option>
                                      @if(!empty($customers))
                                      @foreach($customers as $customer)
                                      <option value="{{$customer->id}}">{{$customer->name}}</option>
                                      @endforeach
                                      @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Estimate Date</label>                        
                        <div class="input-group date" data-provide="datepicker">
                            <input type="text" class="form-control p-input" id="estimate_date" name="estimate_date"  value="">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bill Book</label> 
                        <select id="bill_prefix" name="bill_prefix" class="form-control m-b-sm">
                                     <option value="B1">B1</option>
                                     <option value="B2">B2</option>
                                     <option value="B3">B3</option>
                                     <option value="B4">B4</option>
                                     <option value="B5">B5</option>
                                     <option value="B6">B6</option>
                                     <option value="B7">B7</option>
                                     <option value="B8">B8</option>
                                     <option value="B9">B9</option>
                                     <option value="B10">B10</option>
                                     <option value="B11">B11</option>
                                     <option value="B12">B12</option>
                                     <option value="B13">B13</option>
                                     <option value="B14">B14</option>
                                     <option value="B15">B15</option>
                                     <option value="C1">C1</option>
                                     <option value="C2">C2</option>
                                     <option value="C3">C3</option>
                                     <option value="C4">C4</option>
                                     <option value="C5">C5</option>
                                     <option value="C6">C6</option>
                                     <option value="C7">C7</option>
                                     <option value="C8">C8</option>
                                     <option value="C9">C9</option>
                                     <option value="C10">C10</option>
                                     <option value="C11">C11</option>
                                     <option value="C12">C12</option>
                                     <option value="C13">C13</option>
                                     <option value="C14">C14</option>
                                     <option value="C15">C15</option>
                                     <option value="D1">D1</option>
                                     <option value="D2">D2</option>
                                     <option value="D3">D3</option>
                                     <option value="D4">D4</option>
                                     <option value="D5">D5</option>
                                     <option value="D6">D6</option>
                                     <option value="D7">D7</option>
                                     <option value="D8">D8</option>
                                     <option value="D9">D9</option>
                                     <option value="D10">D10</option>
                                     <option value="D11">D11</option>
                                     <option value="D12">D12</option>
                                     <option value="D13">D13</option>
                                     <option value="D14">D14</option>
                                     <option value="D15">D15</option>
                                      
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Serial Name</label> 
                        <select id="serial_id" name="serial_id" class="form-control m-b-sm">
                                    <option value="0">Select Serial Name</option>
                                      @if(!empty($sizewithprices))
                                      @foreach($sizewithprices as $avg)
                                      <option value="{{$avg->id}}">{{$avg->serial_name}}</option>
                                      @endforeach
                                      @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Predefine Order Detail</label> 
                        <textarea class="form-control p-input" style="height: 80px;" id="predefined_order_detail" name="predefined_order_detail"></textarea>
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
  <div class="modal fade  " id="add_customer" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="false" ><div class="modal-backdrop fade "></div>
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="overflow: inherit;">
             <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Karigar</h4>
        </div>
            <div class="modal-body">
                <form method="post" id="add-ondemand-app-type">
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    <div class="modal-body input-text-field-line">
                        <div class="form-group col-sm-6">
                            <label class="font-normal">Karigar Name</label>
                            <input type="text" class="form-control p-input" id="customer_name" name="customer_name" placeholder="name" value="">
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="font-normal">Mobile</label>
                            <input type="text" class="form-control p-input" id="customer_mobile" name="customer_mobile" placeholder="mobile" value="">
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer add-btn-app-type" style="text-align: center;"> 
                <button type="button" class="btn btn-primary btn-lg pull-right insert-customer">Add</button>
                <!--add-provider-btn-->
            </div>
        </div>
    </div>
</div>
@endsection