<ul class="list-disc pl-5 text-sm text-gray-700">
    @forelse ($customerIds as $id)
        <li>{{ $id }}</li>
    @empty
        <li>Tidak ada pelanggan jatuh tempo hari ini.</li>
    @endforelse
</ul>
