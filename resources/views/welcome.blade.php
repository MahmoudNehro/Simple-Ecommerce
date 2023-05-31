@extends('layouts.app')


@section('content')
<section id="dashboard-analytics">

    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card bg-analytics text-white">
                <div class="card-content">
                    <div class="card-body text-center">
                        <img src="{{ asset('assets/images/decore-left.png') }}" class="img-left" alt="card-img-left">
                        <img src="{{ asset('assets/images/decore-right.png') }}" class="img-right" alt="card-img-right">
                        <div class="avatar avatar-xl bg-primary shadow mt-0">
                            <div class="avatar-content">
                                <i data-feather="award"></i>
                            </div>
                        </div>
                        <div class="text-center">
                            <h1 class="mb-2 text-dark">Welcome, {{auth()->user()->name}} !</h1>
                         
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
</section>
@endsection
