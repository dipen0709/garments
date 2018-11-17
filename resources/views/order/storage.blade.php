@extends('app')

@section('content')

                    <h3 class="text-primary mb-4">{{$title}}
                        <button type="button" class="btn-primary btn assign_kapad" style="float: right; margin-right: 10px;">Add Storage</button>
                    </h3>
       <div class="modal fade  " id="assign_kapad" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="false" ><div class="modal-backdrop fade "></div>
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content"
                                                 style="overflow: inherit;">
                                                 <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h4 class="modal-title">Add Kapad Storage<label class="cus_name"></label></h4>
                                            </div>
                                                <form  id="storage-kapad" name="storage-kapad" method="POST" enctype="multipart/form-data" action="{{ route('storage.store')}}" autocomplete="off"> 
                                                <div class="modal-body">
                                                   
                                                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
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
  
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <div class="card">
                                <div class="card-block">
                                    <h5 class="card-title mb-4">Kapad Storage</h5>
                                    <table class="table center-aligned-table ">
                                            <thead>
                                                <tr class="text-primary">
                                                    <th>Kapad Name</th>
                                                    <th>Meter</th>
                                                    <th>Date</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($storage) && !empty($storage) && count($storage) > 0)
                                                @foreach($storage as $data)
                                                <tr>
                                                    <td>{{$data->name}}</td>
                                                    <td>{{str_replace(".00","", $data->cloth_meter)}}</td>
                                                    <td>{{date("M j, Y",strtotime($data->assign_date))}}</td>
                                                    <td><a href="{{ route('storage.delete',array('id'=>$data->id)) }}" onclick="return deleteconfirm('Are you sure you want to delete this? \n ');" rel="tooltip" title="" class="btn btn-default btn-xs " data-original-title="Delete"><i class="fa fa-times text-danger text"></i></a></td> 
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