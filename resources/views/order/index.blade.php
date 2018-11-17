@extends('app')

@section('content')

<div class="modal fade" id="payment_details" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="false" ><div class="modal-backdrop fade "></div>
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content"
                                                 style="overflow: inherit;">
                                                 <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h4 class="modal-title">Payment Details</h4>
                                            </div>
                                               <div class="modal-body">
                                                        <div class="modal-body input-text-field-line">
                                                            <div class="form-group col-sm-6">
                                                                <label style="color:#1991eb;">Payment</label> 
                                                            </div>
                                                            <div class="form-group col-sm-6">
                                                                <label style="color:#1991eb;">Date</label>                        
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <?php $already_paid = 0; ?>
                                                            @if(isset($payment_details) && count($payment_details) > 0)
                                                            @foreach($payment_details as $payment)
                                                            <div class="form-group col-sm-6">
                                                                <label>{{$payment->price}}</label> 
                                                            </div>
                                                            <div class="form-group col-sm-6">
                                                                <label>{{date("M j, Y",strtotime($payment->estimate_date))}}</label>                        
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <?php $already_paid += $payment->price; ?>
                                                            @endforeach
                                                            @endif
                                                        </div>
                                                   
                                                </div>
                                         </div>
                                             
                                        </div>
                                    </div>


                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-block">
                                    <div class="col-lg-4">
                                    <!--<div class="card-title mb-4" style="color: #8bbf6a; font-size: 16px;">Bill Details</div>-->
                                    <div class="card-title mb-3" style="font-size: 22px;">Chitthi No: {{$bills->customer_bill_id}}</div>
                                    <div class="card-title mb-3" style="font-size: 14px;">Name: {{$bills->name}}</div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                    @if(isset($bills->serial_name) && $bills->serial_name != '')
                                    <div class="card-title mb-3" style="font-size: 22px;">Serial No:  {{$bills->serial_name}}</div>
                                    @endif    
                                    <div class="card-title mb-3" style="font-size: 14px;">Estimate Date: {{date("M j, Y",strtotime($bills->estimate_date))}}</div>                  
                                    </div>
                                    
                                    @if($bills->serial_name)
                                    @if(isset($assign_kapad) && !empty($assign_kapad) && $assign_kapad->count() > 0)
                                    <div class="col-lg-2"><button type="button" class="btn btn-success add_order" data-bill="{{$bills->id}}" style="float: right;">Add Order</button></div>
                                    @endif
                                    @else
                                    <div class="col-lg-2"><a href="{{route('bill.edit', array('id'=>$bills->id))}}" style="-webkit-appearance:none;" class="btn btn-success" >Select Serial No.</a></div>
                                    @endif
                                    <div class="table-responsive" style="margin-top: 15px;">
                                        <table class="table center-aligned-table ">
                                            <thead>
                                                <tr class="text-primary">
                                                    <th>Size</th>
                                                    <th>Piece</th>
                                                    <th>Avg</th>
                                                    <th>Total Avg</th>
                                                    <th>Price</th>
                                                    <th>Total Price</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $total_paid = 0; 
                                                $kapad_sum = 0; 
                                                $qty_sum = 0; 
                                                $key_total = array(); $size_total = array(); ?>
                                                @if(isset($order_data) && !empty($order_data) && count($order_data) > 0)
                                                @foreach($order_data as $data)
                                                <tr class="">
                                                     <?php $a = '';  $b = ''; 
                                                     if(isset($size_total[$data->size])){
                                                        $c = $size_total[$data->size];
                                                        $size_total[$data->size] = $c + $data->qty; 
                                                    } else {
                                                        $size_total[$data->size] = $data->qty;
                                                    }
                                                     ?>
                                                    <td>{{$data->size}}</td>
                                                    
                                                    @if(isset($serial_detail[$data->size]['kapad']) && isset($serial_detail['count_size']) && !empty($serial_detail[$data->size]['kapad']))
                                                    <?php  $loop_1 = $serial_detail[$data->size]['count_kapad']; ?>
                                                    <?php $start = 0; ?>
                                                    @foreach($serial_detail[$data->size]['kapad'] as $key => $x)
                                                    <?php 
                                                    $start++;
                                                    $a .= $key.': '.$x;
                                                    $b .= $key.': '.$x * $data->qty;
                                                    if($start != $loop_1){
                                                        $a .= ', ';
                                                        $b .= ', ';
                                                    }
                                                    if(isset($key_total[$key])){
                                                        $c = $key_total[$key];
                                                        $d = $x * $data->qty;
                                                        $key_total[$key] = $c + $d; 
                                                    } else {
                                                        $key_total[$key] = $x * $data->qty;
                                                    }
                                                    ?>
                                                    @endforeach
                                                    @endif
                                                    <td>{{$data->qty}}</td>
                                                    <td>{{str_replace(".00","", $a)}}</td>
                                                    <td>{{str_replace(".00","", $b)}}</td>
                                                    <td>{{str_replace(".00","", $data->price)}} @if(!empty($data->other_price) && $data->other_price > 0)({{str_replace(".00","", $data->price - $data->other_price)}} + {{str_replace(".00","", $data->other_price)}})@endif</td>
                                                    <td>{{str_replace(".00","", $data->price * $data->qty)}}</td>
                                                    <td>@if($data->order_date){{date("M j, Y",strtotime($data->order_date))}}@endif<a href="{{ route('order.delete',array('id'=>$data->id,'bill_id'=>$bills->id)) }}" onclick="return deleteconfirm('Are you sure you want to delete this? \n ');" rel="tooltip" title="" class="btn btn-default btn-xs " data-original-title="Delete"><i class="fa fa-times text-danger text"></i></a></td>
                                                      <?php 
                                                            $paid = $data->price * $data->qty;
                                                            if($paid){
                                                               $total_paid += $paid; 
                                                            } 
                                                            $kapad_sum += $data->use_kapad * $data->qty;
                                                            $qty_sum += $data->qty;
                                                        ?> 
                                                </tr>
                                                @endforeach
                                                <?php  //echo '<pre>'; print_r($key_total); die; ?>
                                                <tr><td colspan="5"></td></tr>
                                                <tr class="" style="background-color: antiquewhite">
                                                    <td colspan="3"> 
                                                        @if(!empty($size_total))               
                                                            @foreach($size_total as $h => $i)
                                                                {{$h.': '.$i}}{{','}}
                                                            @endforeach
                                                        @endif
                                                        {{'Total: '.$qty_sum}}
                                                    </td>
                                                    <td colspan="2" class="return_cloth" data-total="{{$kapad_sum}}">@if(!empty($key_total))                                             <?php $j = 1; ?>
                                                        @foreach($key_total as $k => $e)
                                                            
                                                            {{$k.': '.$e}}@if(count($key_total) != $j){{','}}
                                                            <?php $j++; ?>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    </td>
                                                    <td>@if($total_paid){{str_replace(".00","", $total_paid)}}@endif</td>
                                                    <td></td>
                                                </tr>
                                                
                                                @if($already_paid)
                                                <tr><td colspan="7"></td></tr>
                                                <tr class="" style="background-color: antiquewhite;">
                                                    <td colspan="4"></td>
                                                    <td colspan="1">Apya</td> 
                                                    <td>{{str_replace(".00","", $already_paid)}}</td>
                                                    <td></td>
                                                </tr>
                                                @endif
                                                
                                                <tr><td colspan="5"></td></tr>
                                                <tr class="" style="background-color: #dae4b0; height: 50px;">
                                                    <td colspan="4"></td>
                                                    <td colspan="1">Baki</td> 
                                                    <td class="max_payment" data-price="{{$total_paid - $already_paid}}">{{str_replace(".00","", $total_paid - $already_paid)}}</td>
                                                    <td></td>
                                                </tr>
                                                @else
                                                <tr class="">
                                                    <td>{{trans('users.norecords')}}</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    
                                    
                                    <button type="button" class="btn btn-outline-primary payment_customer">Payment to Customer</button>
                                    <button type="button" class="btn btn-outline-primary payment_details">Click to view payment details</button>
                                    
                                    <div class="form-group">&nbsp;</div>
                                    
                                    <div class="col-lg-12"><button type="button" class="btn btn-success assign_kapad" data-bill="{{$bills->customer_bill_id}}" data-bill="{{$bills->id}}" style="float: right;">Assign Kapad</button></div>
                                    <div class="table-responsive">
                                        <table class="table center-aligned-table ">
                                            <thead>
                                                <tr class="text-primary">
                                                    <th>Chitthi No.</th>
                                                    <th>Karigar</th>
                                                    <th>Kapad</th>
                                                    <th>Meter</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($assign_kapad) && !empty($assign_kapad) && $assign_kapad->count() > 0)
                                                @foreach($assign_kapad as $data)
                                                <tr>
                                                    <td>{{$bills->customer_bill_id}}</td>
                                                    <td>{{$bills->name}}</td>
                                                    <td>{{$data->name}}</td>
                                                    <td>{{str_replace(".00","", $data->cloth_meter)}}</td>
                                                    <td>{{date("M j, Y",strtotime($data->assign_date))}}</td>
                                                </tr>
                                                @endforeach
                                                <tr><td colspan="5"></td></tr>
                                                <tr class="" style="background-color: antiquewhite;">
                                                    <td colspan="2">@if(!empty($remaining_data['remaining_kapad_with_name']) && count($remaining_data['remaining_kapad_with_name']) > 0)<?php $j = 1; $rem_count = count($remaining_data['remaining_kapad_with_name']); ?>Kapad Baki:  @foreach($remaining_data['remaining_kapad_with_name'] as $k => $e){{$k.': '.$e}}@if($rem_count != $j){{','}}<?php $j++; ?>@endif
                                        @endforeach
                                    @endif</td>
                                                    <td colspan="3">@if(!empty($remaining_data['assign']) && count($remaining_data['assign']) > 0)<?php $j = 1; $rem_count = count($remaining_data['assign']); ?>Kapad Apyu:  @foreach($remaining_data['assign'] as $k => $e){{$k.': '.$e}}@if($rem_count != $j){{','}}<?php $j++; ?>@endif
                                        @endforeach
                                    @endif</td> 
                                                </tr>
                                                @else
                                                <tr class="">
                                                    <td>{{trans('users.norecords')}}</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    @if(!empty($next_bills) && count($next_bills) > 0)
                                    <div class="form-group">&nbsp;</div>
                                    <div class="table-responsive">
                                        <table class="table center-aligned-table ">
                                            <thead>
                                                <tr class="text-primary">
                                                    <th>Next Chitthi No.</th>
                                                    <th>Name</th>
                                                    <th>Estimate Date</th>
                                                    <th>{{trans('users.createdat')}}</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($next_bills) && !empty($next_bills) && count($next_bills) > 0)
                                                @foreach($next_bills as $data)
                                                <tr>
                                                    <td>{{$data->customer_bill_id}}</td>
                                                    <td>{{$data->name}}</td>
                                                    <td>{{date("M j, Y",strtotime($data->estimate_date))}}</td>
                                                    <td>{{date("M j, Y h:i A",strtotime($data->created_at))}} </td>
                                                    <td><a type="button" class="btn btn-success btn-sm" href="{{route('order.detail', array('id'=>$data->id))}}" style="-webkit-appearance:none;">Jama</a></td>
                                                    <td><a href="{{ route('bill.edit',array('id'=>$data->id)) }}" rel="tooltip" title="" class="btn btn-default btn-xs" data-original-title="Edit"><i class="fa fa-pencil"></i></a></td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr class="">
                                                    <td>{{trans('users.norecords')}}</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

<div class="modal fade  " id="add_order" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="false" ><div class="modal-backdrop fade "></div>
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content"
                                                 style="overflow: inherit;">
                                                 <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h4 class="modal-title">Add Order</h4>
                                            </div>
                                                <form  id="insert-order-form" name="insert-order-form" method="POST" enctype="multipart/form-data" action="{{ route('order.store')}}" autocomplete="off"> 
                                                <div class="modal-body">
                                                   
                                                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" name="bill_id" id="bill_id" value="{{ $bills->id }}">
                                                        <div class="modal-body input-text-field-line">
                                                            <div class="form-group col-sm-4">
                                                            <label>Customer</label> 
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
                                                            <div class="form-group col-sm-4">
                                                            <label>Serial Number</label> 
                                                            <select id="serial_id" name="serial_id" class="form-control m-b-sm get-size-price" >
                                                                        <option value="">Select Serial No.</option>
                                                                          @if(!empty($sizewithprices))
                                                                          @foreach($sizewithprices as $sizewithprice)
                                                                           <?php  $selected = "";  ?>
                                                                          <option <?php echo $selected ?> value="{{$sizewithprice->id}}">{{$sizewithprice->serial_name}}</option>
                                                                          @endforeach
                                                                          @endif
                                                            </select>
                                                        </div>
                                                            <div class="form-group col-sm-4">
                                                            <label>Order Date</label> 
                                                            <div class="input-group date" data-provide="datepicker">
                                                                <input type="text" class="form-control p-input" id="order_date" name="order_date" value="">
                                                                <div class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-th"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                            <div class="clearfix"></div>
                              
        
                              <div class="form-group"></div>                              
        <div class="sizewithdata-html">
        </div>                                        
                
                                                        </div>
                                                   
                                                </div>
                                                <div class="modal-footer add-btn-app-type" style="text-align: center;"> 
                                                    <button type="submit" class="btn btn-primary btn-lg pull-right">Add</button>
                                                    <!--add-provider-btn-->
                                                </div>
                                                    </form>
                                            </div>
                                             
                                        </div>
                                    </div>
                                    
                                    <div class="modal fade  " id="payment_customer" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="false" ><div class="modal-backdrop fade "></div>
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content"
                                                 style="overflow: inherit;">
                                                 <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h4 class="modal-title">Payment to Customer</h4>
                                            </div>
                                                <form  id="payment-customer" name="payment-customer" method="POST" enctype="multipart/form-data" action="{{ route('payment.store')}}" autocomplete="off"> 
                                                <div class="modal-body">
                                                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" name="bill_id" id="bill_id" value="{{ $bills->id }}">
                                                        <div class="modal-body input-text-field-line">
                                                        <div class="form-group col-sm-6">
                                                            <label>Price</label> 
                                                            <input type="text" class="form-control p-input price_validate" id="price" name="price"  value="">
                                                        </div>
                                                        <div class="form-group col-sm-6">
                                                            <label>Submitted Date</label>                        
                                                            <div class="input-group date" data-provide="datepicker">
                                                                <input type="text" class="form-control p-input" id="estimate_date" name="estimate_date"  value="">
                                                                <div class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-th"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                   
                                                </div>
                                                <div class="modal-footer add-btn-app-type" style="text-align: center;"> 
                                                    <button type="button" class="btn btn-primary btn-lg pull-right payment-to-customer">Add</button>
                                                    <!--add-provider-btn-->
                                                </div>
                                                    </form>
                                            </div>
                                             
                                        </div>
                                    </div>
                                    
                                    

 <div class="modal fade  " id="assign_kapad" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="false" ><div class="modal-backdrop fade "></div>
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content"
                                                 style="overflow: inherit;">
                                                 <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h4 class="modal-title">Assign Kapad to Bill no. - {{$bills->customer_bill_id}}<label class="cus_name"></label></h4>
                                            </div>
                                                <form  id="assign-kapad" name="assign-kapad" method="POST" enctype="multipart/form-data" action="{{ route('assigncloth.store')}}" autocomplete="off"> 
                                                <div class="modal-body">
                                                   
                                                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" name="bill_id" id="bill_id" value="{{$bills->id}}">
                                                        <input type="hidden" name="customer_id" id="customer_id" value="{{$bills->customer_id}}">
                                                        
                                                        <div class="modal-body input-text-field-line">
                                                            <div class="form-group col-sm-4">
                                                            <label>Cloth / Kapad</label> 
                                                            <select id="cloth_id" name="cloth_id" class="form-control m-b-sm">
                                                                        <option value="">Select Cloth / Kapad</option>
                                                                          @if(!empty($cloth_master))
                                                                          @foreach($cloth_master as $cloth)
                                                                          <option value="{{$cloth->id}}">{{$cloth->name}}</option>
                                                                          @endforeach
                                                                          @endif
                                                            </select>
                                                        </div>
                                                            <div class="form-group col-sm-4">
                                                            <label>Meter</label> 
                                                            <input type="text" class="form-control p-input price_validate" id="cloth_meter" name="cloth_meter" placeholder="" value="">
                                                        </div>
                                                            <div class="form-group col-sm-4">
                                                            <label>Date</label> 
                                                            <div class="input-group date" data-provide="datepicker">
                                                                <input type="text" class="form-control p-input" id="assign_date" name="assign_date"  value="">
                                                                <div class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-th"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                   
                                                </div>
                                                <div class="modal-footer add-btn-app-type" style="text-align: center;"> 
                                                    <button type="submit" class="btn btn-primary btn-lg pull-right">Add</button>
                                                    <!--add-provider-btn-->
                                                </div>
                                                    </form>
                                            </div>
                                             
                                        </div>
                                    </div>
<script type="text/javascript">
    function deleteconfirm(str){
    if(confirm(str)){
        return true;
    }
    return false;
}
    </script>
@endsection