@extends('app')

@section('content')
<div class="row mb-2">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-block">
                <h5 class="card-title mb-4">Add Average</h5>
                <form class="forms-sample" id="size_with_price" name="size_with_price" method="POST" enctype="multipart/form-data" action="{{ route('sizewithprice.store')}}"
                      autocomplete="off">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="addDetails" id="addDetails" value="1">
                    <div class="form-group">
                        <label>Serial Name</label>
                        <input type="text" class="form-control p-input" id="serial_name" name="serial_name" value="">
                    </div>
                    <div class="form-group">
                        <i class="fa fa-plus-circle add_sizewithprice" style="cursor: pointer; float: left; margin: 35px 0px 10px 15px; color: dodgerblue; font-size: 14px;"> Add Size</i>
                    </div>

                    <div class="row col-sm-12" >
                        <div class="col-2">
                            <label>Size (X, XL, XXL)</label>
                        </div>
                        <div class="col-10"></div>
                    </div> 
                        
                    <div class="sizewithprice_append row col-sm-12" >
                            <div class="div_row_1 row col-sm-12">
                                <input type="hidden" name="total_avg_1" id="total_avg_1" value="0" />
                                <div class="col-2 mb-xl-3" style="margin-left: 15px;">
                                    <input type="text" class="form-control p-input" id="size_1" name="size[]" value="" placeholder="size">
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control p-input price_validate" id="price_1" name="price[]" value="" placeholder="total price">
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control p-input price_validate" id="other_price_1" name="other_price[]" value="" placeholder="other price">
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control p-input" id="other_desc_1" name="other_desc[]" value="" placeholder="like: kach,button,work">
                                </div>
                                <div class="col-1" >
                                    <i class="fa fa-plus-circle add_average replace_data_id_1" style="font-size:24px; cursor: pointer;" data-id="1"></i>
                                </div>
                                <div class="clearfix" ></div>
                                <div class="sub_row_1 row col-sm-12"></div>
                            </div>
                    </div>

                    <div class="form-group"></div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a class="btn btn-primary" href='{{route('sizewithprice')}}'>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Hidden HTML-->

<div class="row col-sm-12 sizewithprice_html hidden">
                            <div class="div_row_xxxx row col-sm-12">
                                <input type="hidden" name="total_avg_xxxx" id="total_avg_xxxx" value="0" />
                                <div class="col-2 mb-xl-3" style="margin-left: 15px;">
                                    <input type="text" class="form-control p-input" id="size_xxxx" name="size_yyyy[]" value="" placeholder="size">
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control p-input price_validate" id="price_xxxx" name="price_yyyy[]" value="" placeholder="price">
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control p-input price_validate" id="other_price_xxxx" name="other_price_yyyy[]" value="" placeholder="other price">
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control p-input" id="other_desc_xxxx" name="other_desc_yyyy[]" value="" placeholder="like: kach,button,work">
                                </div>
                                <div class="col-1" >
                                    <i class="fa fa-plus-circle add_average replace_data_id_xxxx" style="font-size:24px; cursor: pointer;" data-id="xxxx"></i>
                                </div>
                                <div class="clearfix" ></div>
                                <div class="sub_row_xxxx row col-sm-12"></div>
                            </div>
                        </div>

<div class="average_hidden_html hidden">
                        <div class="row col-sm-12"  >
                            <div class="col-1"></div>
                            <div class="col-2 mb-xl-3" style="margin-left: 15px;">
                                <select id="kapad_id_xxxx_yyyy" name="kapad_id_xxxx[]" class="form-control m-b-sm">
                                    <option value="">Select</option>
                                        @if(!empty($kapad_master))
                                        @foreach($kapad_master as $kapad)
                                            <option value="{{$kapad->id}}">{{$kapad->name}}</option>
                                        @endforeach
                                        @endif
                                </select>
                            </div>
                            <div class="col-2">
                                <input type="text" class="form-control p-input price_validate" placeholder="use kapad" id="use_kapad_xxxx_yyyy" name="use_kapad_xxxx[]" value="">
                            </div>
                        </div>
</div>

@endsection