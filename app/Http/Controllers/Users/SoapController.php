<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\UserController;
use App\Models\Invoice;
use App\Http\Requests;
use Illuminate\Support\Facades\URL;
use \Input as Input;
use DB;
use App\Models\Slider;

class SoapController extends UserController
{
	
  	public $Username = "lefgozer";
 	public $SecurityCode1 = "e5908e507df3f151e6cf5662aa11134f";
  	public $SecurityCode2 = "51022EEC-1C44-49AE-AF3E-32656B9089F5";
	
	public function soapSetting(){
		return View('user.soap.index',array('title' => 'Soapkoppeling'));////
	}
	public function styleCSS(){
		echo "<style>
            thead td {background-color: #4FC1E9; color:#fff;}
			tr:nth-child(odd) {background-color: #ccc;}
            </style>";	
	}
	public function syncData(){
		echo "dfsf";
		$msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
//mail("webtest.am@gmail.com","My subject",$msg);die;
		try
		{
			$client = new \SoapClient("https://soap.e-boekhouden.nl/soap.asmx?WSDL");
			$date = new \DateTime("2017-04-13");
			$startDate = $date->format('Y-m-d') . 'T' . $date->format('H:i:s');
			$edate = new \DateTime("2017-04-14");
			echo $endDate = $edate->format('Y-m-d') . 'T' . $edate->format('H:i:s');
			// sessie openen en sessionid ophalen
			$params = array(
							"Username" => $this->Username,
							"SecurityCode1" => $this->SecurityCode1,
							"SecurityCode2" => $this->SecurityCode2
							);
			$response = $client->__soapCall("OpenSession", array($params));
			if(!empty($response->OpenSessionResult->ErrorMsg->LastErrorCode)){
			$this->checkforerror($response, "OpenSessionResult");}
			$SessionID = $response->OpenSessionResult->SessionID;
			echo "SessionID: " . $SessionID;
			echo "<hr>";
			//date_default_timezone_set('UTC');
			// get the date
			//$startDate = date("Y-m-d") . 'T' . date("H:i:s");
			$getParams = array(
							"SecurityCode2" => $this->SecurityCode2,
							"SessionID" => $SessionID,
							"cFilter" => array(
										"Factuurnummer" => "",
										"Relatiecode" => "",
										"DatumVan" => $startDate,
										"DatumTm" => $endDate								
										)
			);
			//print_r($getParams);
			$getResponse = $client->__soapCall("GetFacturen", array($getParams));
			//$this->checkforerror($getResponse, "GetFacturenResult");
			
			// sessie sluiten
			$params = array(
			"SessionID" => $SessionID
			);
			$response = $client->__soapCall("CloseSession", array($params));
		}
		
		catch(SoapFault $soapFault)
		{
			echo '<strong>Er is een fout opgetreden:</strong><br>';
			echo $soapFault;
		}
		//print_r($getResponse);
		//echo date("Y-m-d h:i:s");die;
		foreach($getResponse->GetFacturenResult->Facturen->cFactuurList as $eachResponse){
			//echo $eachResponse->Factuurnummer."===========";
			//print_r($eachResponse->Factuurnummer);
			$insertInvoice = DB::table('invoices')->insertGetId(array(
										'customer_id' => 4, 'sales_person_id' => 3, 'sales_team_id' => 1, 'invoice_number' => $eachResponse->Factuurnummer, 	'invoice_date' => date("Y-m-d"), 'status' => 'Open Invoice', 'total' =>$eachResponse->TotaalExclBTW, 'tax_amount' => $eachResponse->TotaalExclBTW, 'tax_amount' => $eachResponse->TotaalBTW, 'grand_total' => $eachResponse->TotaalInclBTW, 'unpaid_amount' => $eachResponse->TotaalInclBTW,'final_price' => $eachResponse->TotaalInclBTW, 'user_id' => 1, 'created_at' => date("Y-m-d h:i:s"), 'updated_at' => date("Y-m-d h:i:s"))
									);
			
			foreach($eachResponse->Regels->cFactuurRegel as $eachProduct){
				$subTotal = $eachProduct->PrijsPerEenheid*$eachProduct->Aantal;
				$insertInvoiceProduct = DB::table('invoices_products')->insert([
										['invoice_id' => $insertInvoice, 'product_id' => trim($eachProduct->Code,'"'), 'product_name' => $eachProduct->Omschrijving, 'quantity' => $eachProduct->Aantal,'price' => $eachProduct->PrijsPerEenheid, 'sub_total' => $subTotal, 'created_at' => date("Y-m-d h:i:s"), 'updated_at' => date("Y-m-d h:i:s")]
									]);
			}
			//print_r($eachResponse->Regels->cFactuurRegel->Aantal);
			
			
			//print_r($inser);
			//print_r($eachResponse->Regels->cFactuurRegel);
			/*DB::table('invoices')->insert([
										['invoice_id' => $inser, 'product_id' => $eachResponse->Regels->cFactuurRegel->Code, 'product_name' => $eachResponse->Regels->cFactuurRegel->Omschrijving, 'quantity' => $eachResponse->Regels->cFactuurRegel->Aantal, 	'price' => $eachResponse->Regels->cFactuurRegel->PrijsPerEenheid, 'sub_total' => $eachResponse->Regels->cFactuurRegel->Aantal, 'created_at' => date("Y-m-d h:i:s"), 'updated_at' => date("Y-m-d h:i:s")]
									]);*/
									
		}
		//echo $getResponse->
		die;
	}
	public function soapFactuur(){
			$this->styleCSS();
			$arr = DB::table("invoices")->get();
			$invoiceDatas = DB::table("soap_boekhouden")
							->where("soap_method","=","all_invoice_datas")
							->get();
			if(!empty($invoiceDatas)){				
				$soapVal = unserialize($invoiceDatas[0]->soap_value);
				$ckhInvoiceID = array();
				foreach($soapVal as $eachVal){
					$ckhInvoiceID[] = $eachVal['lcrmInvoiceID'];
				}						
			}
			?>
            <strong>LCRM INVOICES</strong>
            <table width="100%">
            <thead>
            	<td align="center">Invoice ID</td>
                <td align="center">Invoice Date</td>
                <td align="center">Action</td>
            </thead>
            <?php foreach($arr as $eachInvoice){ ?>
				<tr>
                    <td align="center"><?php echo $eachInvoice->id;?></td>
                    <td align="center"><?php echo $eachInvoice->invoice_date;?></td>
                    <td align="center">
                    <?php if (!empty($invoiceDatas) && in_array($eachInvoice->id, $ckhInvoiceID)) {
								echo "Updated";
							} else { ?>
                    <a href="http://93.158.221.197/files/public/update_invoice/<?php echo $eachInvoice->id; ?>">Insert Into Soapkoppeling</a>
                    <?php } ?>
                    </td>
                </tr>
			<?php }	?>
            </table>
            <?php

	}
	
	public function updateFactuur($invoice_id){
		$invoiceDatas = DB::table("invoices")
						->join("invoices_products","invoices.id","=","invoices_products.invoice_id")
						->where("invoices.id","=",$invoice_id)
						->get();
		//print_r($invoiceDatas);
		$date = new \DateTime($invoiceDatas[0]->invoice_date);
		$startDate = $date->format('Y-m-d') . 'T' . $date->format('H:i:s');
		$invoiceProducts = array();
		$i = 0;
		foreach($invoiceDatas as $eachData){
			$invoiceProducts[$i] = array();
			$invoiceProducts[$i]["Aantal"] = $eachData->quantity;
			$invoiceProducts[$i]["Eenheid"] = "stuk";
			$invoiceProducts[$i]["Code"] = '"'.$eachData->product_id.'"';
			$invoiceProducts[$i]["Omschrijving"] = '"'.$eachData->product_name.'"';
			$invoiceProducts[$i]["PrijsPerEenheid"] = $eachData->price;
			$invoiceProducts[$i]["BTWCode"] = "LAAG_VERK";
			$invoiceProducts[$i]["TegenrekeningCode"] = "0130";
			$invoiceProducts[$i]["KostenplaatsID"] = 0;
			$i++;
		}
		
		try
		{
			$client = new \SoapClient("https://soap.e-boekhouden.nl/soap.asmx?WSDL");
			
			// sessie openen en sessionid ophalen
			$params = array(
							"Username" => $this->Username,
							"SecurityCode1" => $this->SecurityCode1,
							"SecurityCode2" => $this->SecurityCode2
							);
			$response = $client->__soapCall("OpenSession", array($params));
			if(!empty($response->OpenSessionResult->ErrorMsg->LastErrorCode)){
			$this->checkforerror($response, "OpenSessionResult");}
			$SessionID = $response->OpenSessionResult->SessionID;
			echo "SessionID: " . $SessionID;
			echo "<hr>";
			//date_default_timezone_set('UTC');
			// get the date
			//$startDate = date("Y-m-d") . 'T' . date("H:i:s");
			$addParams = array(
							"SecurityCode2" => $this->SecurityCode2,
							"SessionID" => $SessionID,
							"oFact" => array(
										"Factuurnummer" => "lcrm_".$invoice_id,
										"Relatiecode" => "R001",
										"Datum" => $startDate,
										"Betalingstermijn" => 20,
										"Factuursjabloon" => "Voorbeeld 1",
										"PerEmailVerzenden" => 0,
										"AutomatischeIncasso" => 0,
										"IncassoMachtigingDatumOndertekening" => $startDate,
										"IncassoMachtigingFirst" => 0,
										"IncassoRekeningNummer" => "sds",
										"InBoekhoudingPlaatsen" => 0,
										"Regels" => array(
													  "cFactuurRegel" => $invoiceProducts		
															
														  )
										
										)
			);
			$addResponse = $client->__soapCall("AddFactuur", array($addParams));
			if(!empty($response->AddFactuurResult->ErrorMsg->LastErrorCode)){
				$this->checkforerror($addResponse, "AddFactuurResult");
			}else{
				$invoiceDatas = DB::table("soap_boekhouden")
							->where("soap_method","=","all_invoice_datas")
							->get();
				
				if(empty($invoiceDatas)){
					$invoiceDatas = array();
					$invoiceDatas[$invoice_id] = array();
					$invoiceDatas[$invoice_id]["lcrmInvoiceID"] = $invoice_id;
					$invoiceDatas[$invoice_id]["soapInvoiceID"] = $addResponse->AddFactuurResult->Factuurnummer;
					$sid = serialize($invoiceDatas);
					DB::table('soap_boekhouden')->insert(['soap_method' => 'all_invoice_datas', 'soap_value' => $sid]);
				} else {
					$getSaveData = unserialize($invoiceDatas[0]->soap_value);
					$newData = array();
					$newData[$invoice_id] = array();
					$newData[$invoice_id]['lcrmInvoiceID'] = $invoice_id;
					$newData[$invoice_id]['soapInvoiceID'] = $addResponse->AddFactuurResult->Factuurnummer;
					$finalData = serialize(array_merge($getSaveData, $newData));
					print_r($finalData);
					DB::table('soap_boekhouden')->where('soap_method', 'all_invoice_datas')->update(['soap_value' => $finalData]);
				}
				echo "AddFactuur added successfully";
				header("Location: http://93.158.221.197/files/public/soap/factuur");
				die();
			}
			
			
			// sessie sluiten
			$params = array(
			"SessionID" => $SessionID
			);
			$response = $client->__soapCall("CloseSession", array($params));
		}
		
		catch(SoapFault $soapFault)
		{
			echo '<strong>Er is een fout opgetreden:</strong><br>';
			echo $soapFault;
		}
	}
	public function checkforerror($rawresponse, $sub) {
		$LastErrorCode = $rawresponse->$sub->ErrorMsg->LastErrorCode;
		$LastErrorDescription = $rawresponse->$sub->ErrorMsg->LastErrorDescription;
		if($LastErrorCode <> '') {
			echo '<strong>Er is een fo
			ut opgetreden:</strong><br>';
			echo $LastErrorCode . ': ' . $LastErrorDescription;
			exit();
		}
	}
	
	public function soapRelatie(){
		$this->styleCSS();
		$users = DB::table('customers')
            ->join('users', 'customers.user_id', '=', 'users.id')
            ->get();
		$relatieDatas = DB::table("soap_boekhouden")
							->where("soap_method","=","all_relatie_datas")
							->get();
			if(!empty($relatieDatas)){				
				$soapVal = unserialize($relatieDatas[0]->soap_value);
				$ckhRelatieID = array();
				foreach($soapVal as $eachVal){
					$ckhRelatieID[] = $eachVal['lcrmRelatieID'];
				}
			}
		?>
        
		<strong>LCRM Client</strong>
            <table width="100%">
            <thead>
            	<td align="center">Customer ID</td>
                <td align="center">Customer Name</td>
                <td align="center">Action</td>
            </thead>
             <?php foreach($users as $eachCustomer){ ?>
				<tr>
                    <td align="center"><?php echo $eachCustomer->user_id;?></td>
                    <td align="center"><?php echo $eachCustomer->first_name." ".$eachCustomer->last_name;?></td>
                    <td align="center">
                    <?php if (!empty($relatieDatas) && in_array($eachCustomer->id, $ckhRelatieID)) {
								echo "Updated";
							} else { ?>
                    <a href="http://93.158.221.197/files/public/update_relatie/<?php echo $eachCustomer->id; ?>">Insert Into Soapkoppeling</a>
                    <?php } ?>
                    </td>
                </tr>
			<?php }	?>
            </table>
		<?php
	}
	
	public function updateRelatie($relatie_id){
		$users = DB::table('customers')
            ->join('users', 'customers.user_id', '=', 'users.id')
            ->get();
		$getCompany = DB::table('companies')
						->where('main_contact_person','=',$relatie_id)
						->get();
		$date = new \DateTime($users[0]->created_at);
		$startDate = $date->format('Y-m-d') . 'T' . $date->format('H:i:s');
		try
			{
				$client = new \SoapClient("https://soap.e-boekhouden.nl/soap.asmx?WSDL");
				// sessie openen en sessionid ophalen
				$params = array(
								"Username" => $this->Username,
								"SecurityCode1" => $this->SecurityCode1,
								"SecurityCode2" => $this->SecurityCode2
								);
				$response = $client->__soapCall("OpenSession", array($params));
				if(!empty($response->OpenSessionResult->ErrorMsg->LastErrorCode)){
				checkforerror($response, "OpenSessionResult");}
				$SessionID = $response->OpenSessionResult->SessionID;
				echo "SessionID: " . $SessionID;
				echo "<hr>";
				// opvragen alle grootboekrekeningen van de categorie balans
				// set the default timezone to use. Available since PHP 5.1
				/*############################## Add Relatie ############################################*/
				$params = array(
								"SecurityCode2" => $this->SecurityCode2,
								"SessionID" => $SessionID,
								"oRel" => array(
											"ID" => 0,
											"Code" => "lcrm_".$users[0]->id,
											"Bedrijf" => $getCompany[0]->name,
											"AddDatum" => $startDate ,
											"Adres" => $users[0]->address,
											"Telefoon" => $users[0]->phone_number,
											"GSM" => $users[0]->mobile,
											"FAX" => $users[0]->fax,
											"Email" => $users[0]->email,
											"Site" => $users[0]->website,
											"Gb_ID" => "",
											"GeenEmail" => "",
											"NieuwsbriefgroepenCount" => ""
											)
				);
				$addresponse = $client->__soapCall("AddRelatie", array($params));
				if(!empty($response->AddRelatie->ErrorMsg->LastErrorCode)){
					$this->checkforerror($addresponse, "AddRelatieResult");
				}else{
				$relatieDatas = DB::table("soap_boekhouden")
							->where("soap_method","=","all_relatie_datas")
							->get();
				
				if(empty($relatieDatas)){
					$relatieDatas = array();
					$relatieDatas[$relatie_id] = array();
					$relatieDatas[$relatie_id]["lcrmRelatieID"] = $relatie_id;
					$relatieDatas[$relatie_id]["soapRelatieID"] = $addresponse->AddRelatieResult->Rel_ID;
					$sid = serialize($relatieDatas);
					DB::table('soap_boekhouden')->insert(['soap_method' => 'all_relatie_datas', 'soap_value' => $sid]);
				} else {
					$getSaveData = unserialize($relatieDatas[0]->soap_value);
					$newData = array();
					$newData[$relatie_id] = array();
					$newData[$relatie_id]['lcrmRelatieID'] = $relatie_id;
					$newData[$relatie_id]['soapRelatieID'] = $addresponse->AddRelatieResult->Rel_ID;
					$finalData = serialize(array_merge($getSaveData, $newData));
					print_r($finalData);
					DB::table('soap_boekhouden')->where('soap_method', 'all_relatie_datas')->update(['soap_value' => $finalData]);
				}
				echo "Relatie added successfully";
				header("Location: http://93.158.221.197/files/public/soap/relatie");
				die();
			}
				// sessie sluiten
				$params = array(
				"SessionID" => $SessionID
				);
				$response = $client->__soapCall("CloseSession", array($params));
			}
			catch(SoapFault $soapFault)
			{
				echo '<strong>Er is een fout opgetreden:</strong><br>';
				echo $soapFault;
			}
	}
}
