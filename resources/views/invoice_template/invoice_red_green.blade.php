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
            color: #555555;
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
            min-width: 460px;
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
            margin-top: 15px;
            margin-bottom: 45px;
        }

        header figure {
            float: left;
            margin-right: 10px;
            width: 65px;
            height: 70px;
            background-color: #66BDA9;
            text-align: center;
        }

        header figure img {
            margin-top: 10px;
        }

        header .company-info {
            float: right;
            color: #66BDA9;
            line-height: 14px;
        }

        header .company-info .address, header .company-info .phone, header .company-info .email {
            position: relative;
        }

        header .company-info .address img, header .company-info .phone img {
            margin-top: 2px;
        }

        header .company-info .email img {
            margin-top: 3px;
        }

        header .company-info .title {
            color: #66BDA9;
            font-weight: 400;
            font-size: 1.33333333333333em;
        }

        header .company-info .icon {
            position: absolute;
            left: -15px;
            top: 1px;
            width: 10px;
            height: 10px;
            background-color: #66BDA9;
            text-align: center;
            line-height: 0;
        }

        section .details {
            min-width: 440px;
            margin-bottom: 40px;
            padding: 5px 10px;
            background-color: #CC5A6A;
            color: #ffffff;
            line-height: 20px;
        }

        section .details .client {
            width: 50%;
        }

        section .details .client .name {
            font-size: 1.16666666666667em;
            font-weight: 600;
        }

        section .details .data {
            width: 50%;
            font-weight: 600;
            text-align: right;
        }

        section .details .title {
            margin-bottom: 5px;
            font-size: 1.33333333333333em;
            text-transform: uppercase;
        }

        section table {
            width: 100%;
            margin-bottom: 20px;
            table-layout: fixed;
            border-collapse: collapse;
            border-spacing: 0;
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
            padding: 7px 10px;
            background: #66BDA9;
            border-right: 5px solid #FFFFFF;
            color: white;
            text-align: center;
            font-weight: 400;
            text-transform: uppercase;
        }

        section table thead th:last-child {
            border-right: none;
        }

        section table tbody tr:first-child td {
            border-top: 10px solid #ffffff;
        }

        section table tbody td {
            padding: 10px 10px;
            text-align: center;
            border-right: 3px solid #66BDA9;
        }

        section table tbody td:last-child {
            border-right: none;
        }

        section table tbody td.desc {
            text-align: left;
        }

        section table tbody td.total {
            color: #66BDA9;
            font-weight: 600;
            text-align: right;
        }

        section table tbody h3 {
            margin-bottom: 5px;
            color: #66BDA9;
            font-weight: 600;
        }

        section table.grand-total {
            margin-bottom: 50px;
        }

        section table.grand-total tbody tr td {
            padding: 0px 10px 12px;
            border: none;
            background-color: #B2DDD4;
            color: #555555;
            font-weight: 300;
            text-align: right;
        }

        section table.grand-total tbody tr:first-child td {
            padding-top: 12px;
        }

        section table.grand-total tbody tr:last-child td {
            background-color: transparent;
        }

        section table.grand-total tbody .grand-total {
            padding: 0;
        }

        section table.grand-total tbody .grand-total div {
            float: right;
            padding: 11px 10px;
            background-color: #66BDA9;
            color: #ffffff;
            font-weight: 600;
        }

        section table.grand-total tbody .grand-total div span {
            display: inline-block;
            margin-right: 20px;
            width: 80px;
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
                <p>{{trans('invoice.invoice_to')}}</p>
                <p class="name">{{ is_null($invoice->customer)?"":$invoice->customer->full_name }}</p>
                <p>{{is_null($invoice->customer)?"":$invoice->customer->address}}</p>
                {{is_null($invoice->customer)?"":$invoice->customer->email}}
            </div>
            <div class="data right">
                <div class="title">{{trans('invoice.invoice_no')}} {{$invoice->invoice_number}}</div>
                <div class="date">
                    {{trans('invoice.invoice_date')}}: {{ $invoice->invoice_date}}<br>
                    {{trans('invoice.due_date')}}: {{ $invoice->due_date}}
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
            @foreach ($invoice->products as $key => $qo_product)
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
                    <td class="total">{{ (Settings::get('currency_position')=='left')?
                        Settings::get('currency').$invoice->total:
                        $invoice->total.' '.Settings::get('currency') }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td class="desc"></td>
                    <td class="qty"></td>
                    <td class="unit">{{trans('invoice.taxes')}}:</td>
                    <td class="total">{{ (Settings::get('currency_position')=='left')?
                        Settings::get('currency').$invoice->tax_amount:
                        $invoice->tax_amount.' '.Settings::get('currency') }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td class="desc"></td>
                    <td class="qty"></td>
                    <td class="unit">{{trans('invoice.total')}}:</td>
                    <td class="total">{{(Settings::get('currency_position')=='left')?
                        Settings::get('currency').$invoice->grand_total:
                        $invoice->grand_total.' '.Settings::get('currency') }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td class="desc"></td>
                    <td class="qty"></td>
                    <td class="unit">{{trans('invoice.discount').' '.$invoice->discount}}%:</td>
                    <td class="total">{{$invoice->total*($invoice->discount/100)}}</td>
                </tr>
                <tr>
                    <td class="grand-total" colspan="5">
                        <div>
                            <span>{{trans('invoice.final_price')}}:</span>
                            {{ (Settings::get('currency_position')=='left')?
                        Settings::get('currency').$invoice->unpaid_amount:
                        $invoice->unpaid_amount.' '.Settings::get('currency') }}</div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
</body>

</html>
