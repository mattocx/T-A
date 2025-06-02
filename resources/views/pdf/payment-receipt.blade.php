<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            font-size: 14px;
            margin: 0;
            padding: 0;
        }
        .invoice-box {
            max-width: 600px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        }
        .title {
            text-align: center;
            font-size: 22px;
            margin-bottom: 20px;
        }
        .logo {
            width: 100px;
            margin: 0 auto 10px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 8px 0;
        }
        .info-table .label {
            width: 150px;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
        .status-success {
            color: green;
            font-weight: bold;
        }
        .status-failed {
            color: red;
            font-weight: bold;
        }
        .status-pending {
            color: orange;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <img class="logo" src="{{ public_path('images/logo.png') }}" alt="Logo">
        <div class="title">Struk Pembayaran Paket Internet</div>

        <table class="info-table">
            <tr>
                <td class="label">Order ID:</td>
                <td>{{ $payment->order_id }}</td>
            </tr>
            <tr>
                <td class="label">Transaction ID:</td>
                <td>{{ $payment->transaction_id }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Pembayaran:</td>
                <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y, H:i') }}</td>
            </tr>
            <tr>
                <td class="label">Jatuh Tempo:</td>
                <td>{{ \Carbon\Carbon::parse($payment->due_date)->format('d M Y') }}</td>
            </tr>
            <tr>
                <td class="label">Metode Pembayaran:</td>
                <td>{{ ucfirst($payment->payment_method) }}</td>
            </tr>
            <tr>
                <td class="label">Status:</td>
                <td>
                    @php
                        $status = $payment->status;
                        $statusClass = match($status) {
                            'success' => 'status-success',
                            'failed' => 'status-failed',
                            'pending' => 'status-pending',
                            default => ''
                        };
                    @endphp
                    <span class="{{ $statusClass }}">{{ ucfirst($status) }}</span>
                </td>
            </tr>
            <tr>
                <td class="label">Jumlah:</td>
                <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="footer">
            Terima kasih telah melakukan pembayaran. <br>
            Jika ada pertanyaan, hubungi tim admin.
        </div>
    </div>
</body>
</html>
