<?php

Route::group(array('middleware' => 'sentinel'), function () {
//customer routes
    Route::group(array('middleware' => ['customer', 'xss_protection'], 'prefix' => 'customers', 'namespace' => 'Customer'), function () {

        Route::get('/', 'DashboardController@index');

        Route::get('mailbox', 'MailboxController@index');
        Route::get('mailbox/all', 'MailboxController@getData');
        Route::get('mailbox/{id}/get', 'MailboxController@getMail');
        Route::post('mailbox/{id}/reply', 'MailboxController@postReply');
        Route::get('mailbox/data', 'MailboxController@getAllData');
        Route::get('mailbox/received', 'MailboxController@getReceived');
        Route::post('mailbox/send', 'MailboxController@sendEmail');
        Route::get('mailbox/sent', 'MailboxController@getSent');
        Route::post('mailbox/mark-as-read', 'MailboxController@postMarkAsRead');
        Route::post('mailbox/delete', 'MailboxController@postDelete');

        Route::get('contract/data', 'ContractController@data');
        Route::resource('contract', 'ContractController');

        Route::group(['prefix' => 'quotation'], function () {
            Route::get('data', 'QuotationController@data');
            Route::get('{quotation}/show', 'QuotationController@show');
            Route::get('{quotation}/ajax_create_pdf', 'QuotationController@ajaxCreatePdf');
            Route::get('{quotation}/print_quot', 'QuotationController@printQuot');
        });
        Route::resource('quotation', 'QuotationController');

        Route::group(['prefix' => 'invoice'], function () {
            Route::get('data', 'InvoiceController@data');
            Route::get('{invoice}/show', 'InvoiceController@show');
            Route::get('{invoice}/ajax_create_pdf', 'InvoiceController@ajaxCreatePdf');
            Route::get('{invoice}/print_quot', 'InvoiceController@printQuot');
        });
        Route::resource('invoice', 'InvoiceController');

        Route::group(['prefix' => 'sales_order'], function () {
            Route::get('data', 'SalesorderController@data');
            Route::get('{saleorder}/show', 'SalesorderController@show');
            Route::get('{saleorder}/ajax_create_pdf', 'SalesorderController@ajaxCreatePdf');
            Route::get('{saleorder}/print_quot', 'SalesorderController@printQuot');
        });
        Route::resource('sales_order', 'SalesorderController');

        Route::group(['prefix' => 'payment'], function () {
            Route::get('{invoice}/pay', 'PaymentController@pay');
            Route::post('{invoice}/paypal', 'PaymentController@paypal');
            Route::get('{invoice}/paypal_success', 'PaymentController@paypalSuccess');
            Route::get('{invoice}/paypal_cancel', function () {
                return Redirect::to('/');
            });
            Route::post('{invoice}/stripe', 'PaymentController@stripe');
            Route::get('success', 'PaymentController@success');
            Route::get('cancel', 'PaymentController@cancel');
        });
    });
});