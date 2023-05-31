@extends('layouts.app')

@section('content')
    <section id="data-list-view" class="data-list-view-header">

        <!-- DataTable starts -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="thead">
                    <tr>
                        <th>Id</th>
                        <th>title</th>
                        <th>Body</th>
                        <th>Order</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($notifications as $notification)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="product-name">{{ data_get($notification,'data.title') }}</td>
                            <td class="product-price">{{ data_get($notification,'data.body') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', ['order' => data_get($notification,'data.order_id')]) }}">
                                    <span class="action-show">{{data_get($notification,'data.order_id')}}</span>
                                </a>
                            </td>
                          


                        </tr>
                    @endforeach


                </tbody>

            </table>
            <div class="d-flex align-items-center justify-content-center">
                {!! $notifications->onEachSide(1)->links('pagination::bootstrap-4') !!}
            </div>
        </div>
        <!-- DataTable ends -->
    </section>
@endsection
