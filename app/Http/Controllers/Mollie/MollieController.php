<?php

namespace App\Http\Controllers\Mollie;

use App\Http\Controllers\UserController;
use App\Repositories\ContractRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\MeetingRepository;
use App\Repositories\OpportunityRepository;
use App\Repositories\PriceListRepository;
use App\Repositories\PriceListVersionRepository;
use App\Repositories\QuotationRepository;
use Efriandika\LaravelSettings\Facades\Settings;
use Sentinel;
use App\Http\Requests;
use Illuminate\Support\Facades\URL;
use DB;
use App\Models\Setting;

class MollieController extends UserController
{
	public function getPayment(){
		$getInvoice = DB::table('invoices')->select('grand_total')
										   ->where('id', '=', $_REQUEST['invoice_id'])
										   ->get();
		$fetchData = DB::table('settings')
                            ->select('setting_value')
                            ->where('setting_key', '=', 'mollie_setup')
                            ->get();
		$allData = unserialize($fetchData[0]->setting_value);
		//require "Mollie/API/Autoloader.php";								   
		$mollie = \Mollie::api();
    	$mollie->setApiKey($allData['api_key']);
		$payment = $mollie->payments()->create([
        "amount"      => $getInvoice[0]->grand_total,
        "description" => "invoice ID ".$_REQUEST['invoice_id'],
        "redirectUrl" => $allData['redirectUrl'],
	    ]);

	    $payment = $mollie->payments()->get($payment->id);
	    //print_r($payment);
	    /*if ($payment->isPaid())
	    {
	        echo "Payment received.";
	    } else
	    {
	    	echo "Payment not received.";
	    }*/
	    if($payment->links->paymentUrl){
	    	//echo $payment->links->paymentUrl;
	    	header('Location: '.$payment->links->paymentUrl);
			die();
	    }
	}

	public function sendInvoice(){
		$invice_id = $_REQUEST['invice_id'];
		$getInvoice = DB::table('invoice_receive_payments')->select('*')
										   ->where('invoice_id', '=', $invice_id)
										   ->get();
		$user = DB::table('invoices')
            ->leftJoin('users', 'invoices.customer_id', '=', 'users.id')
            ->where('invoices.id','=',$invice_id)
            ->get();
		$msg = '
		<html>
		<head>
		<title>HTML email</title>
		</head>
		<body>
		<p class="test">
                            Hello '.$user[0]->first_name.' '.$user[0]->last_name.',
                            </p>
                            <p>Here is your order confirmation from LCRM: </p>
                            <p style="margin-left: 30px;">
                                  <strong>REFERENCES</strong><br>
                                  Order number: <strong>'.$getInvoice[0]->payment_number.'</strong><br>
                                  Order total: <strong>'.$getInvoice[0]->payment_received.'</strong><br>
                                  Order date: '.$getInvoice[0]->payment_date.'<br/><br/><br/><br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <a href="http://93.158.221.197/files/public/mollie/webhook?invoice_id='.$invice_id.'" style="moz-box-shadow: inset 0px 1px 0px 0px #9fb4f2;
    -webkit-box-shadow: inset 0px 1px 0px 0px #9fb4f2;
    box-shadow: inset 0px 1px 0px 0px #9fb4f2;
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0.05, #7892c2), color-stop(1, #476e9e));
    background: -moz-linear-gradient(top, #7892c2 5%, #476e9e 100%);
    background: -webkit-linear-gradient(top, #7892c2 5%, #476e9e 100%);
    background: -o-linear-gradient(top, #7892c2 5%, #476e9e 100%);
    background: -ms-linear-gradient(top, #7892c2 5%, #476e9e 100%);
    background: linear-gradient(to bottom, #7892c2 5%, #476e9e 100%);
    
    background-color: #7892c2;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    border-radius: 3px;
    border: 1px solid #4e6096;
    display: inline-block;
    cursor: pointer;
    color: #ffffff;
    font-family: Arial;
    font-size: 17px;
    font-weight: bold;
    padding: 10px 20px;
    text-decoration: none;
    text-shadow: 0px 1px 0px #283966;">Pay Now</a>
                                <br>
                            </p>
                            </body></html>
                       ';
        $headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		//mail("$user[0]->email","Invoice From Alpha",$msg,$headers);
        //echo "The email was successfully sent.";      
		if(mail($user[0]->email,"Invoice From Alpha",$msg,$headers)){
        	echo "<script type='text/javascript'>alert('The email was successfully sent.');</script>";
        	header("Location: http://93.158.221.197/files/public/invoices_payment_log");
            die();
	    } else {
	        echo "The email was NOT sent.";
	    }
	}
	public function requirement(){
		$fetchData = DB::table('settings')
							->select('setting_value')
							->where('setting_key', '=', 'mollie_setup')
							->get();
		$allData = unserialize($fetchData[0]->setting_value);
		$checkTestModeFalse = 0;
		$checkTestModeTrue = 0;
		if($allData['mollie_testmode'] == 'false'){ $checkTestModeFalse = 'checked="checked"';}
		if($allData['mollie_testmode'] == 'true'){ $checkTestModeTrue = 'checked="checked"';}
		$re_html = '<link type="text/css" rel="Stylesheet" href="http://93.158.221.197/files/public/css/secure.css" />
		<div class="mollie-payment">
					<form action="'. URL::to('mollie_requirements').'" method="post">
					<div class="form-group required">
						<label class="control-label" for="mollie_testmode">Mollie testmode</label><br>
						<div class="controls">
                                <div class="form-inline">
                                    <div class="radio">
                                        <div class="iradio_minimal-blue" style="position: relative;">
                                        	<input type="radio" name="mollie_testmode" value="true" '.$checkTestModeTrue.'> True
                                        </div>
                                    </div>
                                    <div class="radio">
                                        <div class="iradio_minimal-blue" style="position: relative;">
                                        	<input type="radio" name="mollie_testmode" value="false" '.$checkTestModeFalse.'> False
                                        </div>
                                    </div>
                                </div>
                        </div>
                        </div><div class="form-group required">
                        <label class="control-label" for="api_key">Mollie Api Key</label>
						<div class="controls">
							<input class="form-control" type="text" name="api_key" value="'.$allData['api_key'].'">
						</div>
  						</div>
  						<div class="form-group required">
  							<label class="control-label" for="redirectUrl">Redirect Url</label>
  							<div class="controls">
  								<input class="form-control" type="text" name="redirectUrl" value="'.$allData['redirectUrl'].'">
  							</div>
  						</div>  						 						
  						<input type="hidden" value="'.csrf_token().'" name="_token">
  						<input class="btn btn btn-primary" type="submit" name="submit" value="Save">
					</form>
					</div>';
		echo $re_html;
	}
	public function getrequirement(){
		$s_data = serialize($_REQUEST);
		$query = DB::table('settings')
							->select(DB::raw('count(*) as setting_key'))
							->where('setting_key', '=', 'mollie_setup')
							->get();
		if($query[0]->setting_key == 1){
			DB::table('settings')
			            ->where('setting_key', 'mollie_setup')
			            ->update(['setting_value' =>  $s_data]);
		}
		else{
			DB::table('settings')->insert([
		    			['setting_key' => 'mollie_setup', 'setting_value' => $s_data]
			]);
		}
		header("Location: ".URL::to('mollie_requirements'));
		die();
	}
	/*public function payByEmail(){
		echo "sdjsd";
		//print_r($_REQUEST);
		$getInvoice = DB::table('invoice_receive_payments')->select('*')
										   ->where('id', '=', $_REQUEST['invoice_id'])
										   ->get();
		print_r($getInvoice);
		die();

		/*$msg = '     	<p class="test">
                            Hello,
                            ,</p>
                            <p>Here is your order confirmation from Demo Company: </p>
                            <p style="border-left: 1px solid #8e0000; margin-left: 30px;">
                                  <strong>REFERENCES</strong><br>
                                  Order number:
                                <strong>1</strong><br>
                                  Order total: <strong>200</strong><br>
                                  Order date: 01/01/1970 00:00
                                <br>
                            </p>
                       ';

		// use wordwrap() if lines are longer than 70 characters
		$msg = wordwrap($msg,70);

		// send email
		//mail("promith@andromind.com","My subject",$msg);
		 if(mail("promith@andromind.com","My subject",$msg)){
        echo "The email was successfully sent.";
	    } else {
	        echo "The email was NOT sent.";
	    }
	}*/
}
