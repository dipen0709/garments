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
                                                    <th>Design Name</th>                       
                                                    <th>{{trans('users.createdat')}}</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($sizenprices) && !empty($sizenprices) && $sizenprices->count() > 0)
                                                @foreach($sizenprices as $data)
                                                <tr class="">
                                                    <td>{{$data->serial_name}}</td>                   
                                                    <td>{{date("M j, Y h:i A",strtotime($data->created_at. ' ' . trans('users.timezone')))}} 
                                                    <td><a href="{{ route('sizewithprice.edit',array('id'=>$data->id)) }}" rel="tooltip" title="" class="btn btn-default btn-xs" data-original-title="Edit"><i class="fa fa-pencil"></i></a></td>
                                                    <td><a href="{{ route('sizewithprice.delete',array('id'=>$data->id)) }}" onclick="return deleteconfirm('Are you sure you want to delete this? \n ');" rel="tooltip" title="" class="btn btn-default btn-xs " data-original-title="Delete"><i class="fa fa-times text-danger text"></i></a></td> 
                                               
                                                <td><button data-id="{{$data->id}}" type="button" class="btn btn-success btn-sm copy-average" style="-webkit-appearance:none;">Copy</button></td>
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

    <div class="modal fade  " id="copy-average" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="false" >
        <div class="modal-backdrop fade "></div>
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="overflow: inherit;">
             <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Copy Average</h4>
        </div>
            <div class="modal-body">
                <form method="post" id="copy-average" autocomplete="off" onsubmit="return false;">
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    <div class="modal-body input-text-field-line">
                        <div class="form-group">
                            <label class="font-normal">Design Number</label>
                            <input type="text" class="form-control p-input" id="design_name" name="design_name" placeholder="design name" value="" autocomplete="off">
                            <input type="hidden" name="design_id" id="design_id" value="" />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer add-btn-app-type" style="text-align: center;"> 
                <button type="button" class="btn btn-primary btn-lg pull-right insert-copy-design">Add</button>
                <!--add-provider-btn-->
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