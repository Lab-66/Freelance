<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\UserController;
use App\Models\Invoice;
use App\Http\Requests;
use Illuminate\Support\Facades\URL;
use \Input as Input;
use DB;
use App\Models\Slider;

class SupportController extends UserController
{
	public function index(){
		$records = DB::table('s_ticket')->get();
		return View('user.supportticket.index',array('title' => 'support ticket'))->with('records',$records);
	}	
	
	public function create(){
		return View('user.supportticket.create',array('title' => 'Support Ticket Create'));	
	}
	public function insertData(){
		//print_r($_REQUEST);
		$api_key = "nVqte1MEfe8JJ8DE3n3f";
		$password = "admin@321";
		$yourdomain = "bac789";
		
		$ticket_data = json_encode(array(
		  "description" => $_REQUEST['description'],
		  "subject" => $_REQUEST['subject'],
		  "email" => $_REQUEST['email'],
		  "priority" => intval($_REQUEST['priority']),
		  "status" => intval($_REQUEST['status'])
		  //"cc_emails" => array("ram@freshdesk.com", "diana@freshdesk.com")
		));
		$url = "https://$yourdomain.freshdesk.com/api/v2/tickets";
		
		$ch = curl_init($url);
		
		$header[] = "Content-type: application/json";
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$server_output = curl_exec($ch);
		$info = curl_getinfo($ch);
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$headers = substr($server_output, 0, $header_size);
		$response = substr($server_output, $header_size);
		$jsonResponse = json_decode($response, true);
		$getID = $jsonResponse['id'];
		
		DB::table('s_ticket')->insert([
								['ticket_subject' => $_REQUEST['subject'], 'ticket_description' => $_REQUEST['description'],
								  'email' => $_REQUEST['email'], 'priority' => $_REQUEST['priority'], 'status' => $_REQUEST['status'],
								  'freshdesk_id' => $getID],
							]);
							
		if($info['http_code'] == 201) {
		  echo "Ticket created successfully, the response is given below \n";
		  echo "Response Headers are \n";
		  echo $headers."\n";
		  echo "Response Body \n";
		  echo "$response \n";
		} else {
		  if($info['http_code'] == 404) {
			echo "Error, Please check the end point \n";
		  } else {
			echo "Error, HTTP Status Code : " . $info['http_code'] . "\n";
			echo "Headers are ".$headers;
			echo "Response are ".$response;
			//header("Location: http://93.158.221.197/files/public/support_ticket");
			//die();
		  }
		}
		
		curl_close($ch);	
		header("Location: http://93.158.221.197/files/public/support_ticket");
			die();
	}
	
	public function showData($ticket_id){
		$records = DB::table('s_ticket')->where('ticket_id','=',$ticket_id)->get();
		return View('user.supportticket.edit',array('title' => 'Support Ticket Edit'))->with('records',$records);	
	}
	
	public function updateData(){
		$api_key = "nVqte1MEfe8JJ8DE3n3f";
		$password = "admin@321";
		$yourdomain = "bac789";
		
		/*$custom_fields = array(
		  "department" => "Production"
		);*/
		
		$ticket_data = json_encode(array(
		  "priority" => intval($_REQUEST['priority']),
		  "status" => intval($_REQUEST['status']),
		  "description" => "Need support for the issue"
		  //"custom_fields" => $custom_fields
		));
		
		// Id of the ticket to be updated
		$ticket_id = $_REQUEST['freshdesk_id'];
		
		$url = "https://$yourdomain.freshdesk.com/api/v2/tickets/$ticket_id";
		
		$ch = curl_init($url);
		
		$header[] = "Content-type: application/json";
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$server_output = curl_exec($ch);
		$info = curl_getinfo($ch);
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$headers = substr($server_output, 0, $header_size);
		$response = substr($server_output, $header_size);
		
		
		if($info['http_code'] == 200) {
		  echo "Ticket updated successfully, the response is given below \n";
		  echo "Response Headers are \n";
		  echo $headers."\n";
		  echo "Response Body \n";
		  echo "$response \n";
		} else {
		  if($info['http_code'] == 404) {
			echo "Error, Please check the end point \n";
		  } else {
			echo "Error, HTTP Status Code : " . $info['http_code'] . "\n";
			echo "Headers are ".$headers;
			echo "Response are ".$response;
		  }
		}
		
		curl_close($ch);

		DB::table('s_ticket')
            ->where('ticket_id', $_REQUEST['ticket_id'])
            ->update(['ticket_subject' => $_REQUEST['subject'], 'ticket_description' => $_REQUEST['description'],
								  'email' => $_REQUEST['email'], 'priority' => $_REQUEST['priority'], 'status' => $_REQUEST['status']]);
								  header("Location: http://93.158.221.197/files/public/support_ticket");
			die();
	}
	
	public function deleteData($ticket_id){
		$fticket_no = DB::table('s_ticket')->where('ticket_id','=',$ticket_id)->get();
		$api_key = "nVqte1MEfe8JJ8DE3n3f";
		$password = "admin@321";
		$yourdomain = "bac789";
		$sticket_id = $ticket_id;
		/*$custom_fields = array(
		  "department" => "Production"
		);*/
		
		/*$ticket_data = json_encode(array(
		  "priority" => intval($_REQUEST['priority']),
		  "status" => intval($_REQUEST['status']),
		  "description" => "Need support for the issue"
		  //"custom_fields" => $custom_fields
		));*/
		
		// Id of the ticket to be updated
		$ticket_id = $fticket_no[0]->freshdesk_id;;
		
		$url = "https://$yourdomain.freshdesk.com/api/v2/tickets/$ticket_id";
		//header("Location: $url");
		//die;
		$ch = curl_init($url);
		
		$header[] = "Content-type: application/json";
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
		//curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$server_output = curl_exec($ch);
		$info = curl_getinfo($ch);
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$headers = substr($server_output, 0, $header_size);
		$response = substr($server_output, $header_size);
		
		
		if($info['http_code'] == 200) {
		  echo "Ticket updated successfully, the response is given below \n";
		  echo "Response Headers are \n";
		  echo $headers."\n";
		  echo "Response Body \n";
		  echo "$response \n";
		} else {
		  if($info['http_code'] == 404) {
			echo "Error, Please check the end point \n";
		  } else {
			echo "Error, HTTP Status Code : " . $info['http_code'] . "\n";
			echo "Headers are ".$headers;
			echo "Response are ".$response;
			
			
		  }
		}
		
		curl_close($ch);
			//$data = DB::table('s_ticket')->where('ticket_id','=',$ticket_id)->get();
			$del = DB::table('s_ticket')->where('ticket_id','=',$sticket_id)->delete();
			//echo $ticket_id;
			//print_r($data);
			header("Location: http://93.158.221.197/files/public/support_ticket");
			die();
	
	}
}
