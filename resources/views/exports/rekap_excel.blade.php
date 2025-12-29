<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Omset</th>
            <th>Profit</th>
            <th>Owner</th>
            <th>Penjaga</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $row)
            <tr>
                <td>{{ $row->tanggal }}</td>
                <td>{{ $row->omset }}</td>
                <td>{{ $row->profit }}</td>
                <td>{{ $row->owner_profit }}</td>
                <td>{{ $row->penjaga_profit }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
