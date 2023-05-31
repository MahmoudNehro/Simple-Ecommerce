<table class="table" id="orders-table-body">
    <thead>
        <tr>
            <th>Id</th>
            <th>User</th>
            <th>Total Price</th>
            <th>Total Quantity</th>
            <th>ACTIONs</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td class="product-name">{{ $order->user?->name }}</td>
                <td class="product-price">{{ $order->total_price }}</td>
                <td>
                    {{ $order->total_quantity }}
                </td>
                <td class="product-action">
                    <span class="action-show"><i data-feather="eye"></i></span>
                </td>


            </tr>
        @endforeach


    </tbody>
</table>
