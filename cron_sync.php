<?php
//echo "asda";
try
		{
			$client = new \SoapClient("https://soap.e-boekhouden.nl/soap.asmx?WSDL");
			$date = new \DateTime(date("Y-m-d"));
			$startDate = $date->format('Y-m-d') . 'T' . $date->format('H:i:s');
			$stop_date =$date->modify('+1 day');
			$endDate = $stop_date->format('Y-m-d') . 'T' . $stop_date->format('H:i:s');
			$params = array(
							"Username" => "lefgozer",
							"SecurityCode1" => "e5908e507df3f151e6cf5662aa11134f",
							"SecurityCode2" => "51022EEC-1C44-49AE-AF3E-32656B9089F5"
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
							"SecurityCode2" => "51022EEC-1C44-49AE-AF3E-32656B9089F5",
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
			//print_r($getResponse);
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
		$servername = "localhost";
		$username = "root";
		$password = "password";
		$db = "lcrm";
		
		// Create connection
		$conn = new mysqli($servername, $username, $password, $db);
		
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
						
		//print_r($getResponse->GetFacturenResult->Facturen->cFactuurList);						
		foreach($getResponse->GetFacturenResult->Facturen->cFactuurList as $eachResponse){
			//print_r($eachResponse);
			echo $eachResponse->Factuurnummer;
			
			
			//continue;
			//echo $eachResponse->Factuurnummer;
			$sql = "SELECT * FROM invoices where invoice_number ='".$eachResponse->Factuurnummer."'";
			$result = $conn->query($sql);
			echo "@@@@@@@";
			if ($result->num_rows < 1) {
				echo "dffdf";
						##########################################Invoice Insert ############################################
						$insertInvoice = "INSERT INTO `invoices`
						(`id`, `order_id`, `customer_id`, `sales_person_id`, `sales_team_id`, `invoice_number`, `invoice_date`, `due_date`, `payment_term`, `status`, `total`, `tax_amount`, `grand_total`, `unpaid_amount`, `discount`, `final_price`, `user_id`, `created_at`, `updated_at`, `deleted_at`) 
						VALUES (NULL, '0', '4', '5', '1', '".$eachResponse->Factuurnummer."', '".date("Y-m-d")."','".date("Y-m-d")."', '', 'Open Invoice', '".$eachResponse->TotaalExclBTW."', '".$eachResponse->TotaalBTW."', '".$eachResponse->TotaalInclBTW."', '".$eachResponse->TotaalInclBTW."', '0.00', '".$eachResponse->TotaalInclBTW."', '1', '".date("Y-m-d h:i:s")."', '".date("Y-m-d h:i:s")."', NULL)";#okay
						
						if ($conn->query($insertInvoice) === TRUE) {
							$last_id = $conn->insert_id;
							echo $eachProduct->Omschrijving;
							print_r($eachResponse->Regels->cFactuurRegel);
							foreach($eachResponse->Regels->cFactuurRegel as $eachProduct){
								echo "==".$eachProduct->Aantal."==";
								############## Product Save ###############################
								echo $createProduct = "INSERT INTO `products` (`id`, `product_name`, `product_image`, `category_id`, `product_type`, `status`, `quantity_on_hand`, `quantity_available`, `sale_price`, `description`, `description_for_quotations`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, '".$eachProduct->Omschrijving."', '', 0, 'Stockable Product', '', ".$eachProduct->Aantal.", '".$eachProduct->Aantal."', '".$eachProduct->PrijsPerEenheid."', '', '', '1', '".date("Y-m-d h:i:s")."', '".date("Y-m-d h:i:s")."', NULL)";
								$conn->query($createProduct);
								############## Product Save For Invoice ###############################
								$subTotal = $eachProduct->PrijsPerEenheid*$eachProduct->Aantal;
								//echo "New record created successfully. Last inserted ID is: " . $last_id."<br/>";
								$insertProducts = "INSERT INTO `invoices_products` (`id`, `invoice_id`, `product_id`, `product_name`, `description`, `quantity`, `price`, `sub_total`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, '".$last_id."', '".$conn->insert_id."', '".$eachProduct->Omschrijving."', NULL, '".$eachProduct->Aantal."', '".$eachProduct->PrijsPerEenheid."', '".$subTotal."', '".date("Y-m-d h:i:s")."', '".date("Y-m-d h:i:s")."', NULL)";
								if ($conn->query($insertProducts) === TRUE) {
									echo "==".$conn->insert_id."<br/>";
								}
							}
						} 
			} 
			
			
			
			}
?> 