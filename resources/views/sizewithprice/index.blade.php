@extends('app')

@section('content')
<h3 class="text-primary mb-4">Average<a href="{{ route('sizewithprice.create') }}" class="btn-primary btn" style="float: right;">Add Average</a></h3>
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-block">
                                    <div class="card-title mb-4">Welcome to the size with prices dashboard. All records are listed below.
</div>
                                    <div class="table-responsive">
                                        <table class="table center-aligned-table ">
                                            <thead>
                                                <tr class="text-primary">
                                                    <th>Serial Name</th>                       
                                                    <th>{{trans('users.createdat')}}</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($sizenprices) && !empty($sizenprices) && count($sizenprices) > 0)
                                                @foreach($sizenprices as $data)
                                                <tr class="">
                                                    <td>{{$data->serial_name}}</td>                   
                                                    <td>{{date("M j, Y h:i A",strtotime($data->created_at. ' ' . trans('users.timezone')))}} 
                                                    <td><a href="{{ route('sizewithprice.edit',array('id'=>$data->id)) }}" rel="tooltip" title="" class="btn btn-default btn-xs" data-original-title="Edit"><i class="fa fa-pencil"></i></a></td>
                                                    <td><a href="{{ route('sizewithprice.delete',array('id'=>$data->id)) }}" onclick="return deleteconfirm('Are you sure you want to delete this? \n ');" rel="tooltip" title="" class="btn btn-default btn-xs " data-original-title="Delete"><i class="fa fa-times text-danger text"></i></a></td> 
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
                                    {{ $sizenprices->links() }}
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