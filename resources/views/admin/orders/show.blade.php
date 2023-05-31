@extends('layouts.app')
@section('content')
    <section id="basic-examples">
        <div class="row match-height">
            @foreach ($order->orderItems as $item)
                <div class="col-xl-4 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-content">
                            <img class="card-img-top img-fluid" src="{{ $item->product->image }}" alt="Card image cap">
                            <div class="card-body">
                                <h5>Product: {{$item->product->name}}</h5>
                                <p class="card-text  mb-0">{{$item->product->price}} $</p>
                                <span class="card-text">{{$item->quantity}} Q</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </section>
@endsection
