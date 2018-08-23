<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="content-type" content="text-html; charset=utf-8">
    <title>LCRM invoice</title>
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
            font-family: sans-serif;
            font-weight: 300;
            font-size: 12px;
            margin: 0;
            padding: 0;
            color: #777777;
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
            padding: 0 30px;
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
            height: 100%;
        }

        header {
            height: 90px;
            margin-top: 20px;
            margin-bottom: 40px;
            padding: 0px 5px 0;
        }

        header figure {
            float: left;
            width: 40px;
            margin-right: 10px;
        }

        header figure img {
            height: 40px;
        }

        header .company-info {
            color: #BDB9B9;
        }

        header .company-info .title {
            margin-bottom: 5px;
            color: #2A8EAC;
            font-weight: 600;
            font-size: 2em;
        }

        header .company-info .line {
            display: inline-block;
            height: 9px;
            margin: 0 4px;
            border-left: 1px solid #2A8EAC;
        }

        section .details {
            min-width: 800px;
            margin-bottom: 40px;
            padding: 10px 35px;
            background-color: #2A8EAC;
            color: #ffffff;
        }

        section .details .client {
            width: 800px;
            line-height: 16px;
        }

        section .details .client .name {
            font-weight: 600;
        }

        section .details .data {
            width: 800px;
            text-align: right;
        }

        section .details .title {
            margin-bottom: 15px;
            font-size: 3em;
            font-weight: 400;
            text-transform: uppercase;
        }

        section .table-wrapper {
            position: relative;
            overflow: hidden;
        }

        section .table-wrapper:before {
            content: "";
            display: block;
            position: absolute;
            top: 33px;
            left: 30px;
            width: 90%;
            height: 100%;
            border-top: 2px solid #BDB9B9;
            border-left: 2px solid #BDB9B9;
            z-index: -1;
        }

        section .no-break {
            page-break-inside: avoid;
        }

        section table {
            width: 100%;
            margin-bottom: -20px;
            table-layout: fixed;
            border-collapse: separate;
            border-spacing: 5px 20px;
        }

        section table .no {
            width: 50px;
        }

        section table .desc {
            width: 55%;
        }

        section table .qty, section table .unit, section table .total {
            width: 15%;
        }

        section table tbody.head {
            vertical-align: middle;
            border-color: inherit;
        }

        section table tbody.head th {
            text-align: center;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
        }

        section table tbody.head th div {
            display: inline-block;
            padding: 7px 0;
            width: 100%;
            background: #BDB9B9;
        }

        section table tbody.head th.desc div {
            width: 115px;
            margin-left: -110px;
        }

        section table tbody.body td {
            padding: 10px 5px;
            background: #F3F3F3;
            text-align: center;
        }

        section table tbody.body h3 {
            margin-bottom: 5px;
            color: #2A8EAC;
            font-weight: 600;
        }

        section table tbody.body .no {
            padding: 0px;
            background-color: #2A8EAC;
            color: #ffffff;
            font-size: 1.66666666666667em;
            font-weight: 600;
            line-height: 50px;
        }

        section table tbody.body .desc {
            padding-top: 0;
            padding-bottom: 0;
            background-color: transparent;
            color: #777787;
            text-align: left;
        }

        section table tbody.body .total {
            color: #2A8EAC;
            font-weight: 600;
        }

        section table tbody.body tr.total td {
            padding: 5px 10px;
            background-color: transparent;
            border: none;
            color: #777777;
            text-align: right;
        }

        section table tbody.body tr.total .empty {
            background: white;
        }

        section table tbody.body tr.total .total {
            font-size: 1.18181818181818em;
            font-weight: 600;
            color: #2A8EAC;
        }

        section table.grand-total {
            margin-top: 40px;
            margin-bottom: 0;
            border-collapse: collapse;
            border-spacing: 0px 0px;
            margin-bottom: 40px;
        }

        section table.grand-total tbody td {
            padding: 0 10px 10px;
            background-color: #2A8EAC;
            color: #ffffff;
            font-weight: 400;
            text-align: right;
        }

        section table.grand-total tbody td.no, section table.grand-total tbody td.desc, section table.grand-total tbody td.qty {
            background-color: transparent;
        }

        section table.grand-total tbody td.total, section table.grand-total tbody td.grand-total {
            border-right: 5px solid #ffffff;
        }

        section table.grand-total tbody td.grand-total {
            padding: 0;
            font-size: 1.16666666666667em;
            font-weight: 600;
            background-color: transparent;
        }

        section table.grand-total tbody td.grand-total div {
            float: right;
            padding: 10px 5px;
            background-color: #21BCEA;
        }

        section table.grand-total tbody td.grand-total div span {
            margin-right: 5px;
        }

        section table.grand-total tbody tr:first-child td {
            padding-top: 10px;
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
    <div class="details clearfix">
        <div class="client left">
            <p>{{trans('sales_order.salesorder_to')}}</p>
            <p class="name">{{ is_null($saleorder->customer)?"":$saleorder->customer->full_name }}</p>
            <p> {{is_null($saleorder->customer)?"":$saleorder->customer->address}}</p>
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
    <div class="container">
        <div class="table-wrapper">
            <table>
                <tbody class="head">
                <tr>
                    <th class="no">&nbsp;</th>
                    <th class="desc">
                        <div>{{trans('invoice.product')}}</div>
                    </th>
                    <th class="qty">
                        <div>{{trans('invoice.quantity')}}</div>
                    </th>
                    <th class="unit">
                        <div>{{trans('invoice.unit_price')}}</div>
                    </th>
                    <th class="total">
                        <div>{{trans('invoice.subtotal')}}</div>
                    </th>
                </tr>
                </tbody>
                <tbody class="body">
                @foreach ($saleorder->products as $key => $qo_product)
                    <tr>
                        <td class="no">{{($key+1)}}</td>
                        <td class="desc">{{$qo_product->product_name}}</td>
                        <td class="qty">{{ $qo_product->quantity}}</td>
                        <td class="unit">{{ $qo_product->price}}</td>
                        <td class="total">{{ $qo_product->sub_total }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
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