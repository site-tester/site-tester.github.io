<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Expiration Date or Condition</th>
            <th>Image</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($entry->donationItems as $item)
            <tr>
                <td>{{ $item->item_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->expiration_date ?? ($item->condition ?? 'N/A') }}</td>
                <td>
                    @if ($item->image_path)
                        <img src="/storage/{{$item->image_path}}" alt="Item Image"
                            height="100">
                    @else
                        No Image Available
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
