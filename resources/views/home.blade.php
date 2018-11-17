@extends('app')

@section('content')

                    <h3 class="text-primary mb-4">{{$title}}
                        <button type="button" class="btn-primary btn add_cloth" style="float: right; margin-right: 10px;">Add Kapad Type</button>
                    </h3>
                    
<div class="modal fade  " id="add_cloth" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="false" ><div class="modal-backdrop fade "></div>
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="overflow: inherit;">
             <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Kapad Type</h4>
        </div>
            <div class="modal-body">
                <form method="post" id="add-ondemand-app-type">
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    <div class="modal-body input-text-field-line">
                        <div class="form-group">
                            <label class="font-normal">Kapad Type</label>
                            <input type="text" class="form-control p-input" id="cloth_name" name="cloth_name" placeholder="name" value="">
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer add-btn-app-type" style="text-align: center;"> 
                <button type="button" class="btn btn-primary btn-lg pull-right insert-cloth">Add</button>
                <!--add-provider-btn-->
            </div>
        </div>
    </div>
</div>
  
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <div class="card">
                                <div class="card-block">
                                    <h5 class="card-title mb-4">Due Date Bills</h5>
                                    <table class="table center-aligned-table ">
                                            <thead>
                                                <tr class="text-primary">
                                                    <th>Bill No.</th>
                                                    <th>Name</th>
                                                    <th>Estimate Date</th>
                                                    <th>{{trans('users.createdat')}}</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($bills) && !empty($bills) && count($bills) > 0)
                                                @foreach($bills as $data)
                                                <tr>
                                                    <td>{{$data->customer_bill_id}}</td>
                                                    <td>{{$data->name}}</td>
                                                    <td>{{date("M j, Y",strtotime($data->estimate_date))}}</td>
                                                    <td>{{date("M j, Y h:i A",strtotime($data->created_at))}} </td>
                                                    <td><a href="{{ route('bill.edit',array('id'=>$data->id)) }}" rel="tooltip" title="" class="btn btn-default btn-xs" data-original-title="Edit"><i class="fa fa-pencil"></i></a></td>
                                                    <td><a href="{{ route('bill.delete',array('id'=>$data->id)) }}" onclick="return deleteconfirm('Are you sure you want to delete this? \n ');" rel="tooltip" title="" class="btn btn-default btn-xs " data-original-title="Delete"><i class="fa fa-times text-danger text"></i></a></td> 
                                                    <td><a type="button" class="btn btn-success btn-sm" href="{{route('order.detail', array('id'=>$data->id))}}" style="-webkit-appearance:none;">Order</a></td>
                                                    <?php 
                                                    $close_val = 1; 
                                                    $close_name = 'Close';
                                                    $msg = 'Are you sure you want to close this bill? \n ';
                                                    ?>
                                                    <td><a type="button" class="btn btn-warning btn-sm" href="{{ route('update.close',array('id'=>$data->id , 'val' => $close_val)) }}" style="-webkit-appearance:none;" onclick="return deleteconfirm('{{$msg}}');">{{$close_name}}</a></td>                      
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
                            </div>
                        </div>
                    </div>
@endsection