@extends('layouts.app')

@section('content')
    <section id="data-list-view" class="data-list-view-header">

        <!-- DataTable starts -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="thead">
                    <tr>
                        <th>Id</th>
                        <th>User</th>
                        <th>Total Price</th>
                        <th>Total Quantity</th>
                        <th>Date</th>
                        <th>ACTIONs</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration}}</td>
                            <td class="product-name">{{ $order->user?->name }}</td>
                            <td class="product-price">{{ $order->total_price }}</td>
                            <td>
                                {{ $order->total_quantity }}
                            </td>
                            <td>
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="product-action">
                                <a href="{{ route('admin.orders.show', ['order' => $order->id]) }}">
                                    <span class="action-show"><i data-feather="eye"></i></span>
                                </a>
                            </td>


                        </tr>
                    @endforeach


                </tbody>

            </table>
            <div class="d-flex align-items-center justify-content-center">
                {!! $orders->onEachSide(1)->links('pagination::bootstrap-4') !!}
            </div>
        </div>
        <!-- DataTable ends -->
    </section>
@endsection
