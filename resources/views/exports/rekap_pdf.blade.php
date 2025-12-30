<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Bulanan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
            margin-bottom: 5px;
        }
        .info {
            text-align: center;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px;
            font-size: 11px;
        }
        th {
            background: #f2f2f2;
        }
        .summary td {
            border: none;
            padding: 4px;
        }
    </style>
</head>
<body>

<h2>Rekap Bulanan</h2>

<div class="info">
    Bulan {{ $bulan }} Tahun {{ $tahun }}
</div>

<table class="summary" width="100%" style="margin-bottom:15px">
    <tr>
        <td>Total Omset</td>
        <td>: {{ rupiahShort($summary['omset']) }}</td>
        <td>Total Profit</td>
        <td>: {{ rupiahShort($summary['profit']) }}</td>
    </tr>
    <tr>
        <td>Bagian Owner</td>
        <td>: {{ rupiahShort($summary['owner']) }}</td>
        <td>Bagian Penjaga</td>
        <td>: {{ rupiahShort($summary['penjaga']) }}</td>
    </tr>
</table>

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
            <td>{{ number_format($row->omset,0,',','.') }}</td>
            <td>{{ number_format($row->bagian_owner + $row->bagian_penjaga,0,',','.') }}</td>
            <td>{{ number_format($row->bagian_owner,0,',','.') }}</td>
            <td>{{ number_format($row->bagian_penjaga,0,',','.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
