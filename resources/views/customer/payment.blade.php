<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran - {{ $payment->order_id }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Tambahkan Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Script Midtrans -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto py-10 px-4">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="bg-pink-600 px-6 py-4">
                    <h4 class="text-white text-lg font-semibold mb-0">Detail Pembayaran</h4>
                </div>
                <div class="px-6 py-4">
                    <div class="mb-4 space-y-2">
                        <p><strong>Order ID:</strong> {{ $payment->order_id }}</p>
                        <p><strong>Jumlah:</strong> Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                        <p><strong>Status:</strong> <span class="inline-block bg-yellow-400 text-white text-sm px-2 py-1 rounded">Menunggu Pembayaran</span></p>
                        <p><strong>Tanggal Jatuh Tempo Baru:</strong> {{ $payment->due_date->format('d M Y') }}</p>
                    </div>

                    <div class="flex flex-col gap-3">
                        <button class="w-full text-white py-2 px-4 rounded bg-pink-600 hover:bg-pink-700 transition duration-200" id="pay-button">
                            Bayar Sekarang
                        </button>
                        <a href="{{ url('/customer') }}" class="w-full text-center py-2 px-4 rounded border border-gray-400 text-gray-700 hover:bg-gray-100 transition duration-200">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // Trigger snap popup when pay button clicked
        document.getElementById('pay-button').onclick = function() {
            var snapToken = "{{ $snapToken }}";

            snap.pay(snapToken, {
                onSuccess: function(result) {
                    console.log('Pembayaran berhasil:', result);
                    sendPaymentDataToBackend(result, 'success');
                },
                onPending: function(result) {
                    console.log('Pembayaran tertunda:', result);
                    sendPaymentDataToBackend(result, 'pending');
                },
                onError: function(result) {
                    console.log('Pembayaran gagal:', result);
                    sendPaymentDataToBackend(result, 'error');
                },
                onClose: function() {
                    console.log('Popup ditutup tanpa menyelesaikan pembayaran');
                    alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                }
            });
        };

        function sendPaymentDataToBackend(result, status) {
            document.getElementById('pay-button').disabled = true;
            document.getElementById('pay-button').innerText = 'Memproses...';

            fetch('{{ route("payment.callback") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    order_id: result.order_id,
                    transaction_id: result.transaction_id,
                    transaction_status: result.transaction_status,
                    payment_type: result.payment_type,
                    gross_amount: result.gross_amount,
                    status_code: result.status_code,
                    signature_key: result.signature_key,
                    client_status: status
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Respons dari server:', data);
                if (data.status === 'success') {
                    console.log('Verifikasi pembayaran berhasil');
                } else {
                    console.error('Verifikasi pembayaran gagal');
                }
                window.location.href = "{{ url('/payment/status') }}/" + result.order_id;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memverifikasi pembayaran. Silakan hubungi admin.');
                window.location.href = "{{ url('/payment/status') }}/" + result.order_id;
            });
        }
    </script>
</body>
</html>
