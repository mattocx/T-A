<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>NIK</th>
            <th>Alamat</th>
            <th>No HP</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($customers as $customer)
            <tr>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->nik }}</td>
                <td>{{ $customer->address }}</td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->status === 'active' ? 'Aktif' : 'Nonaktif' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
