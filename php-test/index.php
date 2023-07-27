<?php
include('./config/connect.php');
$errors = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (empty($_POST['fullName'])) {
    $errors['fullName'] = 'Full Name is required.';
  }
  if (empty($_POST['phoneNumber'])) {
    $errors['phoneNumber'] = 'Phone Number is required.';
  }
  if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Email is required or invalid.';
  }

  if (empty($_POST['subject'])) {
    $errors['subject'] = 'Subject is required.';
  }
  if (empty($_POST['message'])) {
    $errors['message'] = 'Message is required.';
  }

  if (empty($errors)) {
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $port = $_SERVER['REMOTE_PORT'];
    $ipVersion = filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ? 'IPv6' : 'IPv4';
    $fullIpAddress = $ipAddress . ':' . $port . ' (' . $ipVersion . ')';

    $fullName = mysqli_real_escape_string($conn, $_POST['fullName']);
    $phoneNumber = mysqli_real_escape_string($conn, $_POST['phoneNumber']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $ipAddress = $fullIpAddress;
    $timestamp = date('Y-m-d H:i:s');
    $sql = "INSERT INTO contact_form (full_name, phone_number, email, subject, message, ip_address, timestamp) VALUES ('$fullName', '$phoneNumber', '$email', '$subject', '$message', '$ipAddress', '$timestamp')";

    if (mysqli_query($conn, $sql)) {

      $to = 'test@techsolvitservice.com';
      $subject = 'New Form Submission';
      $message = "A new form submission has been received.\n\nFull Name: $fullName\nPhone Number: $phoneNumber\nEmail: $email\nSubject: $subject\nMessage: $message\nIP Address: $ipAddress\nTimestamp: $timestamp";
      $headers = "From: noreply@example.com\r\n";
      mail($to, $subject, $message, $headers);
      header('Location: success.php');

      // exit();
    } else {
      echo 'Error: ' . mysqli_error($conn);
    }
    mysqli_close($conn);
  }
}

?>


<!DOCTYPE html>
<html>

<head>
  <title>Contact Form</title>
<style>
body {
  background: #F2F3EB;
}

input, textarea {
  color: #5A5A5A;
  font: inherit;
  margin: 0;
}

input {
  line-height: normal;
}

textarea {
  overflow: auto;
}

.container {
  border: solid 2px #474544;
  max-width: 768px;
  margin: 60px auto;
  position: relative;
}

form {
  padding: 70px;
}

h1 {
  color: #474544;
  font-size: 32px;
  font-weight: 700;
  letter-spacing: 7px;
  text-align: center;
  text-transform: uppercase;
}

.underline {
  border-bottom: solid 2px #474544;
  margin: -0.512em auto;
  width: 80px;
}

input[type='text'], [type='number'], [type='email'], textarea {
	background: none;
  border: none;
	border-bottom: solid 2px #474544;
	color: #474544;
	font-size: 1.000em;
  font-weight: 400;
  letter-spacing: 1px;
	margin: 0em 0 1.875em 0;
	padding: 0 0 0.875em 0;
	width: 100%;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	-ms-box-sizing: border-box;
	-o-box-sizing: border-box;
	box-sizing: border-box;
	-webkit-transition: all 0.3s;
	-moz-transition: all 0.3s;
	-ms-transition: all 0.3s;
	-o-transition: all 0.3s;
	transition: all 0.3s;
}

input[type='text']:focus, [type='number']:focus, [type='email']:focus, textarea:focus {
	outline: none;
	padding: 0 0 0.875em 0;
}

textarea {
	line-height: 150%;
	height: 150px;
	resize: none;
  width: 100%;
}

.error {
  color: red;
}
</style>
</head>

<body>

  <div style="justify-content: center; " class="container">
    <h1>Contact Form</h1>
    <div class="underline">
  </div>
    <form method="POST" action="">
      
      <input type="text" id="fullName" name="fullName" placeholder="Full Name">
      <?php if (isset($errors['fullName'])) { ?>
        <span class="error"><?php echo $errors['fullName']; ?></span>
      <?php } ?>
      
      
      <input type="number" id="phoneNumber" name="phoneNumber" placeholder="Phone Number">
      <?php if (isset($errors['phoneNumber'])) { ?>
        <span class="error"><?php echo $errors['phoneNumber']; ?></span>
      <?php } ?>
      
      
      <input type="email" id="email" name="email" placeholder="Email">
      <?php if (isset($errors['email'])) { ?>
        <span class="error"><?php echo $errors['email']; ?></span>
      <?php } ?>
      
     
      <input type="text" id="subject" name="subject" placeholder="Subject">
      <?php if (isset($errors['subject'])) { ?>
        <span class="error"><?php echo $errors['subject']; ?></span>
      <?php } ?>
      
      
      <textarea id="message" name="message" placeholder="Message" ></textarea>
      <?php if (isset($errors['message'])) { ?>
        <span class="error"><?php echo $errors['message']; ?></span>
      <?php } ?>
      
      <input type="submit" value="Submit">
    </form>
  </div>
</body>

</html>
