<?php
  session_start();
  require('oauth.php');
  require('outlook.php');
  
  $loggedIn = !is_null($_SESSION['access_token']);
  $redirectUri = 'http://localhost/cal/authorize.php';
?>
<html>
  <head>
    <title>PHP Calendar API Tutorial</title>
    
    <!-- Include events calendar css file -->
    <link rel="stylesheet" href="events/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="events/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="events/assets/css/calendar.css">
    <link rel="stylesheet" href="events/assets/css/calendar_full.css">
    <link rel="stylesheet" href="events/assets/css/calendar_compact.css">
    
    <!-- Include config file -->
    <script src="events/config/config.js"></script>
    
    <!-- Include events calendar language file -->
    <script src="events/assets/languages/en.js"></script>
    
    <!-- Include events calendar js file -->
    <script src="events/assets/js/jquery.min.js"></script>
    <script src="events/assets/js/calendar.js"></script>
  </head>
  <body>
  <!--<div class="tiva-events-calendar full" data-source="php"></div>-->
    <?php 
      if (!$loggedIn) {
    ?>
      <!-- User not logged in, prompt for login -->
      <p>Please <a href="<?php echo oAuthService::getLoginUrl($redirectUri)?>">sign in</a> with your Office 365 or Outlook.com account.</p>
    <?php
      }
      else {
        $events = OutlookService::getEvents($_SESSION['access_token'], $_SESSION['user_email']);
    ?>
      <!-- User is logged in, do something here -->
      <h2>Your events</h2>
      
      <table>
        <tr>
	      <th>Id</th>
          <th>Subject</th>
          <th>Body</th>
          <th>Start</th>
          <th>End</th>
        </tr>
        <?php foreach($events['value'] as $event) { ?>
          <tr>
          	<td><?php echo $event['Id'] ?></td>
            <td><?php echo $event['Subject'] ?></td>
            <td><?php echo $event['Body']['Content'] ?></td>
            <td><?php echo $event['Start']['DateTime'] ?></td>
            <td><?php echo $event['End']['DateTime'] ?></td>
          </tr>
        <?php } ?>
      </table>
    <?php    
      }
    ?>
  </body>
</html>