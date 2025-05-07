<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran - {{ $payment->order_id }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tambahkan script Midtrans -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Detail Pembayaran</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <p><strong>Order ID:</strong> {{ $payment->order_id }}</p>
                            <p><strong>Jumlah:</strong> Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                            <p><strong>Status:</strong> <span class="badge bg-warning">Menunggu Pembayaran</span></p>
                            <p><strong>Tanggal Jatuh Tempo Baru:</strong> {{ $payment->due_date->format('d M Y') }}</p>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" id="pay-button">Bayar Sekarang</button>
                            <a href="{{ url('/customer') }}" class="btn btn-outline-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // Trigger snap popup when pay button clicked
        document.getElementById('pay-button').onclick = function() {
            // Save snap token to variable
            var snapToken = "{{ $snapToken }}";
            
            // Trigger snap popup
            snap.pay(snapToken, {
                // Implementasi callback saat pembayaran berhasil
                onSuccess: function(result) {
                    console.log('Pembayaran berhasil:', result);
                    // Kirim data ke backend untuk verifikasi
                    sendPaymentDataToBackend(result, 'success');
                },
                // Implementasi callback saat pembayaran tertunda
                onPending: function(result) {
                    console.log('Pembayaran tertunda:', result);
                    // Kirim data ke backend untuk verifikasi
                    sendPaymentDataToBackend(result, 'pending');
                },
                // Implementasi callback saat pembayaran gagal
                onError: function(result) {
                    console.log('Pembayaran gagal:', result);
                    // Kirim data ke backend untuk verifikasi
                    sendPaymentDataToBackend(result, 'error');
                },
                // Implementasi callback saat popup ditutup
                onClose: function() {
                    console.log('Popup ditutup tanpa menyelesaikan pembayaran');
                    alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                }
            });
        };

        // Fungsi untuk mengirim data pembayaran ke backend untuk verifikasi
        function sendPaymentDataToBackend(result, status) {
            // Tampilkan loading state
            document.getElementById('pay-button').disabled = true;
            document.getElementById('pay-button').innerText = 'Memproses...';

            // Kirim data ke endpoint callback
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
                // Redirect ke halaman status setelah selesai memproses
                window.location.href = "{{ url('/payment/status') }}/" + result.order_id;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memverifikasi pembayaran. Silakan hubungi admin.');
                // Tetap redirect ke halaman status meskipun ada error
                window.location.href = "{{ url('/payment/status') }}/" + result.order_id;
            });
        }
    </script>
</body>
</html>