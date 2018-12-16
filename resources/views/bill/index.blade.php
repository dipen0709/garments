@extends('app')

@section('content')
<h3 class="text-primary mb-4">{{$title}} @if(!empty($customer_name) && isset($customer_name->name))- {{$customer_name->name}}@endif
    @if($closed == 0)
    <a href="{{ route('bill.create') }}" class="btn-primary btn" style="float: right;">Add New Chitthi</a>
    @endif
</h3>
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table class="table center-aligned-table ">
                                            <thead>
                                                <tr class="text-primary">
                                                    <th>Chitthi No.</th>
                                                    <th>Design No.</th>
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
                                                <?php $class = ''; ?>
                                                @if($data->order_count == 0)
                                               <?php  
                                                      $alert_days = trans('users.alert_days');
                                                      $date =  date('Y-m-d', strtotime($data->estimate_date));
                                                      $today_date = date('Y-m-d');
                                                      if($today_date > $date){
                                                          $class = 'table-info';
                                                      }
                                               ?>
                                                @endif
                                                <tr class="{{$class}}" >
                                                    <td>{{$data->bill_prefix}}-{{$data->customer_bill_id}}</td>
                                                    <td>{{$data->serial_name}}</td>
                                                    <td>{{$data->name}}</td>
                                                    <td>{{date("M j, Y",strtotime($data->estimate_date))}}</td>
                                                    <td>{{date("M j, Y h:i A",strtotime($data->created_at))}} </td>
                                                    <td><a type="button" class="btn btn-success btn-sm" href="{{route('order.detail', array('id'=>$data->id))}}" style="-webkit-appearance:none;">Jama</a></td>
                                                    <?php 
                                                    $close_val = 1; 
                                                    $close_name = 'Close';
                                                    $msg = 'Are you sure you want to close this Chitthi? \n ';
                                                    if($closed == 1){
                                                        $close_val = 0; 
                                                        $close_name = 'Open';
                                                        $msg = 'Are you sure you want to open this Chitthi again? \n ';
                                                    }
                                                    ?>
                                                    <td><a type="button" class="btn btn-warning btn-sm" href="{{ route('update.close',array('id'=>$data->id , 'val' => $close_val)) }}" style="-webkit-appearance:none;" onclick="return deleteconfirm('{{$msg}}');">{{$close_name}}</a></td>                      
                                                    <td><a href="{{ route('bill.edit',array('id'=>$data->id)) }}" rel="tooltip" title="" class="btn btn-default btn-xs" data-original-title="Edit"><i class="fa fa-pencil"></i></a></td>
                                                    <td><a href="{{ route('bill.delete',array('id'=>$data->id)) }}" onclick="return deleteconfirm('Are you sure you want to delete this? \n ');" rel="tooltip" title="" class="btn btn-default btn-xs " data-original-title="Delete"><i class="fa fa-times text-danger text"></i></a></td>
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
                                    
                                   {{ $bills->links() }}
                                </div>
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