@extends('app')

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-block">
            <div class="col-lg-6" style="font-size: 22px; font-weight: 500;">Storage Kapad <small style="font-size: 12px;">(Godown ma baki)</small></div>
            <div class="col-lg-6">
            <div class="col-lg-10">
                <div class="card-title mb-4">
                    <select name="customer_id" id="customer_id" class="form-control m-b-sm"> 
                        <option value="">All Karigar</option>
                        @if(!empty($customers) && $customers->count() > 0)
                        @foreach($customers as $customer)
                        <option value="{{$customer->id}}">{{$customer->name}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <button type="button" class="btn btn-success get-report">Submit</button>
            
            </div>
        </div>
    </div>
</div>

<div class="col-lg-6">
    <div class="card">
        <div class="card-block">
            <div class="col-lg-12">
                @if(!empty($storage_rem) && count($storage_rem) > 0)
                    @foreach($storage_rem as $key => $value)
                        <div class="card-title mb-3" >{{$kapad_array[$key]}}: &nbsp;&nbsp;{{str_replace(".00","", $value)}} </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
<div class="col-lg-6 report_html"></div>
@endsection