@extends('app')

@section('content')
<h3 class="text-primary mb-4">Karigars<a href="{{ route('customer.create') }}" class="btn-primary btn" style="float: right;">Add Karigar</a></h3>
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-block">
                                    <div class="card-title mb-4">Welcome to the Karigars dashboard. All Karigars are listed below.
</div>
                                    <div class="table-responsive">
                                        <table class="table center-aligned-table ">
                                            <thead>
                                                <tr class="text-primary">
                                                    <th>Karigar Name</th>
                                                    <th>{{trans('users.mobile')}}</th>
                                                    <th>{{trans('users.createdat')}}</th>
                                                    <th>Assign Kapad</th>
                                                    <th>Click to Go</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($customers) && !empty($customers) && count($customers) > 0)
                                                @foreach($customers as $data)
                                                <tr style="@if($data->chr_delete == 1){{"background-color: antiquewhite;"}} @endif">
                                                    <td>{{$data->name}}</td>
                                                    <td>{{$data->mobile}}</td>
                                                    <td>{{date("M j, Y h:i A",strtotime($data->created_at. ' ' . trans('users.timezone')))}}</td>
                                                    <td><button type="button" class="btn btn-outline-success assign_kapad" data-bill="{{$data->id}}" data-name="{{$data->name}}" data-id="{{$data->id}}">Assign Kapad</button></td>
                                                    <td><a type="button" class="btn btn-success btn-sm" href="{{ route('bill').'?customer='.$data->id }}" style="-webkit-appearance:none;">Go to Chitthi</a></td>
                                                    <td><a href="{{ route('customer.edit',array('id'=>$data->id)) }}" rel="tooltip" title="" class="btn btn-default btn-xs" data-original-title="Edit"><i class="fa fa-pencil"></i></a></td>
                                                    <td>
                                                        @if($data->chr_delete == 1)
                                                        {{'Deleted'}}
                                                        @else
                                                        <a href="{{ route('customer.delete',array('id'=>$data->id)) }}" onclick="return deleteconfirm('Are you sure you want to delete this? \n ');" rel="tooltip" title="" class="btn btn-default btn-xs " data-original-title="Delete"><i class="fa fa-times text-danger text"></i></a>
                                                        @endif
                                                    </td> 
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
                                    {{ $customers->links() }}
                                </div>
                            </div>
                        </div>
                    </div>

 <div class="modal fade  " id="assign_kapad" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="false" ><div class="modal-backdrop fade "></div>
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content"
                                                 style="overflow: inherit;">
                                                 <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h4 class="modal-title">Assign Kapad - <label class="cus_name"></label></h4>
                                            </div>
                                                <form  id="assign-kapad" name="assign-kapad" method="POST" enctype="multipart/form-data" action="{{ route('assigncloth.store')}}" autocomplete="off"> 
                                                <div class="modal-body">
                                                   
                                                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" name="customer_id" id="customer_id" value="">
                                                        <input type="hidden" name="bill_id" id="bill_id" value="0">
                                                        
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
                                                            <input type="text" class="form-control p-input" id="cloth_meter" name="cloth_meter" placeholder="" value="">
                                                        </div>
                                                            <div class="form-group col-sm-4">
                                                            <label>Date</label> 
                                                            <div class="input-group date" data-provide="datepicker">
                                                                <input type="text" class="form-control p-input" id="assign_date" name="assign_date" value="">
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