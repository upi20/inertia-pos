<html moznomarginboxes mozdisallowselectionprint>

<head>
    <title>
        Nota Pembelian
    </title>
    <style type="text/css">
        html {
            font-family: "Verdana";
        }

        .content {
            width: 80mm;
            font-size: 10px;
            padding: 20px;
        }

        .content .title {
            text-align: center;
        }

        .content .head-desc {
            margin-top: 10px;
            display: table;
            width: 100%;
        }

        .content .head-desc>div {
            display: table-cell;
        }

        .content .head-desc .user {
            text-align: right;
        }

        .content .nota {
            text-align: center;
            margin-top: 5px;
            margin-bottom: 5px;
        }

        .content .separate {
            margin-top: 10px;
            margin-bottom: 15px;
            border-top: 1px dashed #000;
        }

        .content .transaction-table {
            width: 100%;
            font-size: 10px;
        }

        .content .transaction-table .name {
            /*//width: 185px;*/
        }

        .content .transaction-table .qty {
            /*//text-align: center;*/
            /*width: 65px;*/
        }

        .content .transaction-table .sell-price {
            /*//text-align: right;*/
            width: 65px;
            text-align: right;
        }

        .content .transaction-table .final-price {
            text-align: right;
        }

        .content .transaction-table tr td {
            vertical-align: top;
        }

        .content .transaction-table .price-tr td {
            padding-top: 7px;
            padding-bottom: 7px;
        }

        .content .transaction-table .discount-tr td {
            padding-top: 7px;
            padding-bottom: 7px;
        }

        .content .transaction-table .separate-line {
            height: 1px;
            border-top: 1px dashed #000;
        }

        .content .thanks {
            margin-top: 25px;
            text-align: center;
        }

        .content .azost {
            margin-top: 5px;
            text-align: center;
            font-size: 10px;
        }

        @media print {
            @page {
                width: 80mm;
                margin: 0mm;
            }
        }
    </style>
    <script>
        window.print();
        window.onafterprint = function() {
            setTimeout(function() {
                window.close();
            }, 1000);
        }
    </script>
</head>

<body>
    <div class="content">
        <div class="title" style="padding-bottom: 13px">
            <div style="text-align: center;text-transform: uppercase;font-size: 15px">
                SantriKoding
            </div>
            <div style="text-align: center">
                Alamat: Desa Gedangalas, Kec. Gajah, Kab. Demak
            </div>
            <div style="text-align: center">
                Telp: 0857-9087-9087
            </div>
        </div>

        <div class="separate-line" style="border-top: 1px dashed #000;height: 1px;margin-bottom: 5px"></div>
        <table class="transaction-table" cellspacing="0" cellpadding="0">
            <tr>
                <td>TANGGAL</td>
                <td>:</td>
                <td>{{ $transaction->created_at }}</td>
            </tr>
            <tr>
                <td>FAKTUR</td>
                <td>:</td>
                <td>{{ $transaction->invoice }}</td>
            </tr>
            <tr>
                <td>KASIR</td>
                <td>:</td>
                <td>{{ $transaction->cashier->name ?? '' }}</td>
            </tr>
            <tr>
                <td>PEMBELI</td>
                <td>:</td>
                <td>{{ $transaction->customer->name ?? 'Umum' }}</td>
            </tr>
        </table>

        <div class="transaction">
            <table class="transaction-table" cellspacing="0" cellpadding="0">
                <tr class="price-tr">
                    <td colspan="3">
                        <div class="separate-line" style="border-top: 1px dashed #000;"></div>
                    </td>
                    <td colspan="3">
                        <div class="separate-line" style="border-top: 1px dashed #000;"></div>
                    </td>
                    <td colspan="3">
                        <div class="separate-line" style="border-top: 1px dashed #000;"></div>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left">PRODUK</td>
                    <td style="text-align: center">QTY</td>
                    <td style="text-align: right" colspan="5">HARGA</td>
                </tr>
                <tr class="price-tr">
                    <td colspan="3">
                        <div class="separate-line" style="border-top: 1px dashed #000;"></div>
                    </td>
                    <td colspan="3">
                        <div class="separate-line" style="border-top: 1px dashed #000;"></div>
                    </td>
                    <td colspan="3">
                        <div class="separate-line" style="border-top: 1px dashed #000;"></div>
                    </td>
                </tr>
                @foreach ($transaction->details()->get() as $item)
                <tr>
                    <td class='name'>{{ $item->product->title }}</td>
                    <td class='qty' style='text-align: center'>{{ $item->qty }}</td>
                    <td class='final-price' style='text-align: right' colspan="5">{{ formatPrice($item->price) }}</td>
                </tr>
                @endforeach
                <tr class="price-tr">
                    <td colspan="3">
                        <div class="separate-line"></div>
                    </td>
                    <td colspan="3">
                        <div class="separate-line"></div>
                    </td>
                    <td colspan="3">
                        <div class="separate-line"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="final-price">
                        SUB TOTAL
                    </td>
                    <td colspan="3" class="final-price">
                        :
                    </td>
                    <td class="final-price">
                        {{ formatPrice($transaction->grand_total) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="final-price">
                        DISKON
                    </td>
                    <td colspan="3" class="final-price">
                        :
                    </td>
                    <td class="final-price">
                        {{ formatPrice($transaction->discount) }}
                    </td>
                </tr>

                <tr class="discount-tr">
                    <td colspan="3">
                        <div class="separate-line"></div>
                    </td>
                    <td colspan="3">
                        <div class="separate-line"></div>
                    </td>
                    <td colspan="3">
                        <div class="separate-line"></div>
                    </td>
                </tr>

                <tr>
                    <td colspan="3" class="final-price">
                        TUNAI
                    </td>
                    <td colspan="3" class="final-price">
                        :
                    </td>
                    <td class="final-price">
                        {{ formatPrice($transaction->cash) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="final-price">
                        KEMBALI
                    </td>
                    <td colspan="3" class="final-price">
                        :
                    </td>
                    <td class="final-price">
                        {{ formatPrice($transaction->change) }}
                    </td>
                </tr>
            </table>
        </div>
        <div class="thanks">
            =====================================
        </div>
        <div class="azost" style="margin-top: 5px">
            TERIMA KASIH<br>
            ATAS KUNJUNGAN ANDA
        </div>
    </div>
</body>

</html>