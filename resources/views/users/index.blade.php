@extends('app')

@section('content')
<h3 class="text-primary mb-4">{{trans('users.usertitle')}}<a href="{{ route('user.create') }}" class="btn-primary btn" style="float: right;">{{trans('users.adduser')}}</a></h3>
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-block">
                                    <div class="card-title mb-4">{{trans('users.usernote')}}</div>
                                    <div class="table-responsive">
                                        <table class="table center-aligned-table ">
                                            <thead>
                                                <tr class="text-primary">
                                                    <th>{{trans('users.firstname')}}</th>
                                                    <th>{{trans('users.mobile')}}</th>
                                                    <th>{{trans('users.email')}}</th>
                                                    <th>{{trans('users.createdat')}}</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($users) && !empty($users) && $users->count() > 0)
                                                @foreach($users as $data)
                                                
                                                
                                                <tr style="@if($data->chr_delete == 1){{"background-color: antiquewhite;"}} @endif">
                                                    <td>{{$data->name}}</td>
                                                    <td>{{$data->mobile}}</td>
                                                    <td>{{$data->email}}</td>
                                                    <td>{{date("M j, Y h:i A",strtotime($data->created_at. ' ' . trans('users.timezone')))}} 
                                                    <td><a href="{{ route('user.edit',array('id'=>$data->id)) }}" rel="tooltip" title="" class="btn btn-default btn-xs" data-original-title="Edit"><i class="fa fa-pencil"></i></a></td>
                                                    <td>
                                                        @if($data->chr_delete == 1)
                                                        {{'Deleted'}}
                                                        @else
                                                        <a href="{{ route('user.delete',array('id'=>$data->id)) }}" onclick="return deleteconfirm('Are you sure you want to delete this? \n ');" rel="tooltip" title="" class="btn btn-default btn-xs " data-original-title="Delete"><i class="fa fa-times text-danger text"></i></a>
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
                                     {{ $users->links() }}
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