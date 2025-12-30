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
                <td>{{ $row->bagian_owner + $row->bagian_penjaga }}</td>
                <td>{{ $row->bagian_owner }}</td>
                <td>{{ $row->bagian_penjaga }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
