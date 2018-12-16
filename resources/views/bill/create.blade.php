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
                        <label>Customer</label> 
                        &nbsp;&nbsp;
                       <i class="fa fa-plus-circle add_customer" style="cursor: pointer; float: right; color: dodgerblue;"> Add Customer</i>
                        <select id="customer_id" name="customer_id" class="form-control m-b-sm">
                                    <option value="">Select Customer</option>
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
<!--                    <div class="form-group">
                        <label>Bill Prefix</label> 
                        <select id="bill_prefix" name="bill_prefix" class="form-control m-b-sm">
                                     <option value="A">A</option>
                                     <option selected="selected" value="B">B</option>
                                     <option value="C">C</option>
                                     <option value="D">D</option>
                                     <option value="E">E</option>
                                     <option value="F">F</option>
                                     <option value="G">G</option>
                                     <option value="H">H</option>
                                     <option value="I">I</option>
                                     <option value="J">J</option>
                                     <option value="K">K</option>
                                     <option value="L">L</option>
                                     <option value="M">M</option>
                                     <option value="N">N</option>
                                     <option value="O">O</option>
                                     <option value="P">P</option>
                                     <option value="Q">Q</option>
                                     <option value="R">R</option>
                                     <option value="S">S</option>
                                     <option value="T">T</option>
                                     <option value="U">U</option>
                                     <option value="V">V</option>
                                     <option value="W">W</option>
                                     <option value="X">X</option>
                                     <option value="Y">Y</option>
                                     <option value="Z">Z</option>
                                      
                        </select>
                    </div>-->
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
          <h4 class="modal-title">Add Customer</h4>
        </div>
            <div class="modal-body">
                <form method="post" id="add-ondemand-app-type">
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    <div class="modal-body input-text-field-line">
                        <div class="form-group col-sm-6">
                            <label class="font-normal">Customer Name</label>
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