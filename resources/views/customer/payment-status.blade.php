<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Status Pembayaran - {{ $payment->order_id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Status Pembayaran</h4>
                    </div>
                    <div class="card-body text-center">
                        @if($payment->status == 'success')
                            <div class="mb-4">
                                <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                            </div>
                            <h4 class="mb-3">Pembayaran Berhasil!</h4>
                            <p class="mb-4">Terima kasih, pembayaran Anda telah kami terima.</p>
                        @elseif($payment->status == 'pending')
                            <div class="mb-4">
                                <i class="bi bi-hourglass-split text-warning" style="font-size: 5rem;"></i>
                            </div>
                            <h4 class="mb-3">Pembayaran Tertunda</h4>
                            <p class="mb-4">Pembayaran Anda sedang diproses. Silakan cek email Anda untuk petunjuk lebih lanjut.</p>
                        @else
                            <div class="mb-4">
                                <i class="bi bi-x-circle-fill text-danger" style="font-size: 5rem;"></i>
                            </div>
                            <h4 class="mb-3">Pembayaran Gagal</h4>
                            <p class="mb-4">Maaf, terjadi kesalahan dalam proses pembayaran Anda.</p>
                        @endif

                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Detail Transaksi</h5>
                                <table class="table table-bordered mt-3">
                                    <tr>
                                        <th>Order ID</th>
                                        <td>{{ $payment->order_id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jumlah</th>
                                        <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            @if($payment->status == 'success')
                                                <span class="badge bg-success">Berhasil</span>
                                            @elseif($payment->status == 'pending')
                                                <span class="badge bg-warning">Tertunda</span>
                                            @elseif($payment->status == 'expired')
                                                <span class="badge bg-secondary">Kadaluarsa</span>
                                            @else
                                                <span class="badge bg-danger">Gagal</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if($payment->payment_date)
                                    <tr>
                                        <th>Tanggal Pembayaran</th>
                                        <td>{{ $payment->payment_date->format('d M Y H:i') }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th>Jatuh Tempo</th>
                                        <td>{{ $payment->due_date->format('d M Y') }}</td>
                                    </tr>
                                    @if($payment->payment_method)
                                    <tr>
                                        <th>Metode Pembayaran</th>
                                        <td>{{ strtoupper($payment->payment_method) }}</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <a href="{{ url('/customer') }}" class="btn btn-primary">Kembali ke Dashboard</a>
                            
                            @if($payment->status != 'success')
                                <a href="{{ url('/payment/create') }}" class="btn btn-outline-secondary">Coba Bayar Lagi</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>