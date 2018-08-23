<!DOCTYPE html>
<html>
<head>
    <title>LCRM invoice</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="content-type" content="text-html; charset=utf-8">
    <style type="text/css">
        html, body, div, span, applet, object, iframe,
        h1, h2, h3, h4, h5, h6, p, blockquote, pre,
        a, abbr, acronym, address, big, cite, code,
        del, dfn, em, img, ins, kbd, q, s, samp,
        small, strike, strong, sub, sup, tt, var,
        b, u, i, center,
        dl, dt, dd, ol, ul, li,
        fieldset, form, label, legend,
        table, caption, tbody, tfoot, thead, tr, th, td,
        article, aside, canvas, details, embed,
        figure, figcaption, footer, header, hgroup,
        menu, nav, output, ruby, section, summary,
        time, mark, audio, video {
            margin: 0;
            padding: 0;
            border: 0;
            font: inherit;
            font-size: 100%;
            vertical-align: baseline;
        }

        html {
            line-height: 1;
        }

        ol, ul {
            list-style: none;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        caption, th, td {
            text-align: left;
            font-weight: normal;
            vertical-align: middle;
        }

        q, blockquote {
            quotes: none;
        }

        q:before, q:after, blockquote:before, blockquote:after {
            content: "";
            content: none;
        }

        a img {
            border: none;
        }

        article, aside, details, figcaption, figure, footer, header, hgroup, main, menu, nav, section, summary {
            display: block;
        }

        body {
            font-family: 'Source Sans Pro', sans-serif;
            font-weight: 300;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        body a {
            text-decoration: none;
            color: inherit;
        }

        body a:hover {
            color: inherit;
            opacity: 0.7;
        }

        body .container {
            min-width: 500px;
            margin: 0 auto;
            padding: 0 20px;
        }

        body .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        body .left {
            float: left;
        }

        body .right {
            float: right;
        }

        body .helper {
            display: inline-block;
            height: 100%;
            vertical-align: middle;
        }

        body .no-break {
            page-break-inside: avoid;
        }

        header {
            margin-top: 20px;
            margin-bottom: 50px;
        }

        header figure {
            float: left;
            width: 60px;
            height: 60px;
            margin-right: 10px;
            background-color: #8BC34A;
            border-radius: 50%;
            text-align: center;
        }

        header figure img {
            margin-top: 13px;
        }

        header .company-address {
            float: left;
            max-width: 150px;
            line-height: 1.7em;
        }

        header .company-address .title {
            color: #8BC34A;
            font-weight: 400;
            font-size: 1.5em;
            text-transform: uppercase;
        }

        header .company-contact {
            float: right;
            height: 60px;
            padding: 0 10px;
            background-color: #8BC34A;
            color: white;
        }

        header .company-contact span {
            display: inline-block;
            vertical-align: middle;
        }

        header .company-contact .circle {
            width: 20px;
            height: 20px;
            background-color: white;
            border-radius: 50%;
            text-align: center;
        }

        header .company-contact .circle img {
            vertical-align: middle;
        }

        header .company-contact .phone {
            height: 100%;
            margin-right: 20px;
        }

        header .company-contact .email {
            height: 100%;
            min-width: 100px;
            text-align: right;
        }

        section .details {
            margin-bottom: 55px;
        }

        section .details .client {
            width: 50%;
            line-height: 20px;
        }

        section .details .client .name {
            color: #8BC34A;
        }

        section .details .data {
            width: 50%;
            text-align: right;
        }

        section .details .title {
            margin-bottom: 15px;
            color: #8BC34A;
            font-size: 3em;
            font-weight: 400;
            text-transform: uppercase;
        }

        section table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            font-size: 0.9166em;
        }

        section table .qty, section table .unit, section table .total {
            width: 15%;
        }

        section table .desc {
            width: 55%;
        }

        section table thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
        }

        section table thead th {
            padding: 5px 10px;
            background: #8BC34A;
            border-bottom: 5px solid #FFFFFF;
            border-right: 4px solid #FFFFFF;
            text-align: right;
            color: white;
            font-weight: 400;
            text-transform: uppercase;
        }

        section table thead th:last-child {
            border-right: none;
        }

        section table thead .desc {
            text-align: left;
        }

        section table thead .qty {
            text-align: center;
        }

        section table tbody td {
            padding: 10px;
            background: #E8F3DB;
            color: #777777;
            text-align: right;
            border-bottom: 5px solid #FFFFFF;
            border-right: 4px solid #E8F3DB;
        }

        section table tbody td:last-child {
            border-right: none;
        }

        section table tbody h3 {
            margin-bottom: 5px;
            color: #8BC34A;
            font-weight: 600;
        }

        section table tbody .desc {
            text-align: left;
        }

        section table tbody .qty {
            text-align: center;
        }

        section table.grand-total {
            margin-bottom: 45px;
        }

        section table.grand-total td {
            padding: 5px 10px;
            border: none;
            color: #777777;
            text-align: right;
        }

        section table.grand-total .desc {
            background-color: transparent;
        }

        section table.grand-total tr:last-child td {
            font-weight: 600;
            color: #8BC34A;
            font-size: 1.18181818181818em;
        }
    </style>
</head>

<body>
<header class="clearfix">
    <div class="container">
        <figure>
            <img class="logo" src="{{ url('uploads/site/'.((Settings::get('pdf_logo')!='')?Settings::get('pdf_logo'):Settings::get('site_logo'))) }}" alt="">
        </figure>
        <div class="company-info">
            <h2 class="title">{{Settings::get('site_name')}}</h2>
            <span>{{Settings::get('address1')}}</span>
            <span>{{Settings::get('address2')}}</span><br>
            {{Settings::get('phone')}} | {{Settings::get('fax')}}<br>
            {{Settings::get('site_email')}}
        </div>
    </div>
</header>

<section>
    <div class="container">
        <div class="details clearfix">
            <div class="client left">
                <p>{{trans('sales_order.salesorder_to')}}</p>
                <p class="name">{{ is_null($saleorder->customer)?"":$saleorder->customer->full_name }}</p>
                <p>{{is_null($saleorder->customer)?"":$saleorder->customer->address}}</p>
                {{is_null($saleorder->customer)?"":$saleorder->customer->email}}
            </div>
            <div class="data right">
                <div class="title">{{trans('sales_order.sales_order_no')}} {{$saleorder->sale_number}}</div>
                <div class="date">
                    {{trans('invoice.invoice_date')}}: {{ $saleorder->invoice_date}}<br>
                    {{trans('invoice.due_date')}}: {{ $saleorder->due_date}}
                </div>
            </div>
        </div>

        <table border="0" cellspacing="0" cellpadding="0">
            <thead>
            <tr>
                <th class="desc">{{trans('invoice.product')}}</th>
                <th class="qty">{{trans('invoice.quantity')}}</th>
                <th class="unit">{{trans('invoice.unit_price')}}</th>
                <th class="total">{{trans('invoice.subtotal')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($saleorder->products as $key => $qo_product)
                <tr>
                    <td class="desc">{{$qo_product->product_name}}</td>
                    <td class="qty">{{ $qo_product->quantity}}</td>
                    <td class="unit">{{ $qo_product->price}}</td>
                    <td class="total">{{ $qo_product->sub_total }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="no-break">
            <table class="grand-total">
                <tbody>
                <tr>
                    <td class="no"></td>
                    <td class="desc"></td>
                    <td class="qty"></td>
                    <td class="unit">{{trans('invoice.untaxed_amount')}}:</td>
                    <td class="total">{{  (Settings::get('currency_position')=='left')?
                        Settings::get('currency').$invoice->total:
                        $invoice->total.' '.Settings::get('currency') }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td class="desc"></td>
                    <td class="qty"></td>
                    <td class="unit">{{trans('invoice.taxes')}}:</td>
                    <td class="total">{{  (Settings::get('currency_position')=='left')?
                        Settings::get('currency').$invoice->tax_amount:
                        $invoice->tax_amount.' '.Settings::get('currency') }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td class="desc"></td>
                    <td class="qty"></td>
                    <td class="unit">{{trans('invoice.total')}}:</td>
                    <td class="total">{{  (Settings::get('currency_position')=='left')?
                        Settings::get('currency').$invoice->grand_total:
                        $invoice->grand_total.' '.Settings::get('currency') }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td class="desc"></td>
                    <td class="qty"></td>
                    <td class="unit">{{trans('invoice.discount').' '.$saleorder->discount}}%:</td>
                    <td class="total">{{$saleorder->total*($saleorder->discount/100)}}</td>
                </tr>
                <tr>
                    <td class="grand-total" colspan="5">
                        <div>
                            <span>{{trans('invoice.final_price')}}:</span>
                            {{  (Settings::get('currency_position')=='left')?
                        Settings::get('currency').$invoice->final_price:
                        $invoice->final_price.' '.Settings::get('currency') }}</div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

</body>

</html>
