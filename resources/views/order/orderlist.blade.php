@extends('app')

@section('content')
<h3 class="text-primary mb-4">{{$title}}</h3>
                        <div class="row mb-2">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-block">
                                    <div class="table-responsive" style="margin-top: 15px;">
                                        <table class="table center-aligned-table ">
                                            <thead>
                                                <tr class="text-primary">
                                                    <th>Bill id</th>
                                                    <th>Customer Name</th>
                                                    <th>Design Number</th>
                                                    <th>Size</th>
                                                    <th>Qty</th>
                                                    <th>Price</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($order_data) && !empty($order_data) && count($order_data) > 0)
                                                @foreach($order_data as $data)
                                                <tr class="">
                                                    <td>{{$data->bill_number}}</td>
                                                    <td>{{$data->name}}</td>
                                                    <td>{{$data->serial_name}}</td>
                                                    <td>{{$data->size}}</td>
<!--                                                    <td>{{str_replace(".00","", $data->use_kapad * $data->qty)}}  ({{str_replace(".00","", $data->use_kapad)}} * {{str_replace(".00","", $data->qty)}})</td>-->

                                                    <td>{{$data->qty}}</td>
                                                    <td>{{str_replace(".00","", $data->price)}} @if(!empty($data->other_price) && $data->other_price > 0)({{str_replace(".00","", $data->price - $data->other_price)}} + {{str_replace(".00","", $data->other_price)}})@endif</td>
                                                    <td>@if($data->order_date){{date("M j, Y h:i A",strtotime($data->order_date))}}@endif </td>
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
                        </div>
@endsection