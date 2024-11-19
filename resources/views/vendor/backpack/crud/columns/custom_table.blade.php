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
                        {{-- <img src="/storage/{{$item->image_path}}" alt="Item Image" height="100"> --}}
                        {{-- <img src="/storage/app/public/{{$item->image_path}}" alt="Item Image" height="100"> --}}
                        <a href="/storage/app/public/{{$item->image_path}}" data-fancybox="gallery"
                            data-caption="{{ $item->item_name }}">
                            <img src="/storage/app/public/{{$item->image_path}}" height="100" />
                        </a>
                    @else
                        No Image Available
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
