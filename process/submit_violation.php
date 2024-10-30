<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once 'db_connection.php';
require_once 'semaphore.php'; // Include Semaphore library

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = isset($_POST['studentId']) ? $_POST['studentId'] : '';
    $violationType = isset($_POST['violationType']) ? $_POST['violationType'] : '';
    $offenseCount = isset($_POST['offenseCount']) ? $_POST['offenseCount'] : '';
    $sanctionId = isset($_POST['sanction_id']) ? $_POST['sanction_id'] : '';

    $conn = getDbConnection();
    $fullName = $_SESSION['id'];
    $status = "pending";

    // Step 1: Fetch student and guardian details
    $studentSql = "SELECT first_name, middle_name, last_name, email, guardian_name, guardian_contact FROM accounts WHERE id = ?";
    if ($stmt = $conn->prepare($studentSql)) {
        $stmt->bind_param('s', $studentId);
        $stmt->execute();
        $studentResult = $stmt->get_result();
        $studentData = $studentResult->fetch_assoc();
        
        // Check if student exists
        if (!$studentData) {
            echo json_encode(['status' => 'error', 'message' => 'Student not found.']);
            exit;
        }

        $full_name = trim($studentData['first_name'] . ' ' . $studentData['middle_name'] . ' ' . $studentData['last_name']);
        $guardian_name = $studentData['guardian_name'];
        $guardian_contact = $studentData['guardian_contact'];
        $student_email = $studentData['email'];
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to fetch student details.']);
        exit;
    }

    // Step 2: Add violation record
    $sql = "INSERT INTO student_violations (student_id, violation_id, offense_count, sanction_id, status, date_of_offense)
            VALUES (?, ?, ?, ?, ?, NOW())";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('sssss', $studentId, $violationType, $offenseCount, $sanctionId, $status);

        if ($stmt->execute()) {
            // Step 3: Get violation description
            $violationSql = "SELECT description FROM violations WHERE violation_id = ?";
            if ($violationStmt = $conn->prepare($violationSql)) {
                $violationStmt->bind_param('s', $violationType);
                $violationStmt->execute();
                $violationResult = $violationStmt->get_result();
                $violationData = $violationResult->fetch_assoc();
                $violation_description = $violationData['description'] ?? 'No description available';
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to fetch violation description.']);
                exit;
            }

            // Step 4: Get sanction details
            $sanctionSql = "SELECT sanction_details FROM sanctions WHERE sanction_id = ?";
            if ($sanctionStmt = $conn->prepare($sanctionSql)) {
                $sanctionStmt->bind_param('s', $sanctionId);
                $sanctionStmt->execute();
                $sanctionResult = $sanctionStmt->get_result();
                $sanctionData = $sanctionResult->fetch_assoc();
                $sanction_details = $sanctionData['sanction_details'] ?? 'No sanction details available';
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to fetch sanction details.']);
                exit;
            }

            // Step 5: Send SMS to guardian using Semaphore
            $smsContent = "Hi $guardian_name,\n\nWe send you a text message to inform you that $full_name has committed the following violation:\n$violation_description\n\nThe sanction for these types of violation is as follows:\n$sanction_details";

            // Assuming sendSMS is a function that sends an SMS using Semaphore
            $smsStatus = sendSMS($guardian_contact, $smsContent);
            require '../vendor/autoload.php';
            //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'cictstudentviolation@gmail.com';                     //SMTP username
            $mail->Password   = 'gplkayvxtsbedpyw'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('cictstudentviolation@gmail.com', 'CICT Student Violation');
            // $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
            $mail->addAddress($student_email);              
            $mail->addReplyTo('cictstudentviolation@gmail.com', 'CICT Student Violation');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Violation Notification';
            $mail->Body    = '
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" style="font-family: sans-serif; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
	  
	  <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Email from Bulsu CICT</title>
		<style type="text/css" data-styled-components="" data-styled-components-is-local="false">
           
		  @media only screen and (min-width:30em) {
			.container {
			  width: 31rem;
			}
			.col-sm,
			.col-sm-1,
			.col-sm-10,
			.col-sm-11,
			.col-sm-12,
			.col-sm-2,
			.col-sm-3,
			.col-sm-4,
			.col-sm-5,
			.col-sm-6,
			.col-sm-7,
			.col-sm-8,
			.col-sm-9,
			.col-sm-offset-1,
			.col-sm-offset-10,
			.col-sm-offset-11,
			.col-sm-offset-12,
			.col-sm-offset-2,
			.col-sm-offset-3,
			.col-sm-offset-4,
			.col-sm-offset-5,
			.col-sm-offset-6,
			.col-sm-offset-7,
			.col-sm-offset-8,
			.col-sm-offset-9 {
			  box-sizing: border-box;
			  -webkit-box-flex: 0;
			  -webkit-flex: 0 0 auto;
			  -ms-flex: 0 0 auto;
			  -webkit-flex: 0 0 auto;
			  -ms-flex: 0 0 auto;
			  flex: 0 0 auto;
			  padding-right: .5rem;
			  padding-left: .5rem;
			}
			.col-sm {
			  -webkit-box-flex: 1;
			  -webkit-flex-grow: 1;
			  -ms-flex-positive: 1;
			  -webkit-flex-grow: 1;
			  -ms-flex-grow: 1;
			  flex-grow: 1;
			  -webkit-flex-basis: 0;
			  -ms-flex-preferred-size: 0;
			  -webkit-flex-basis: 0;
			  -ms-flex-basis: 0;
			  flex-basis: 0;
			  max-width: 100%;
			}
			.col-sm-1 {
			  -webkit-flex-basis: 8.333%;
			  -ms-flex-preferred-size: 8.333%;
			  -webkit-flex-basis: 8.333%;
			  -ms-flex-basis: 8.333%;
			  flex-basis: 8.333%;
			  max-width: 8.333%;
			}
			.col-sm-2 {
			  -webkit-flex-basis: 16.667%;
			  -ms-flex-preferred-size: 16.667%;
			  -webkit-flex-basis: 16.667%;
			  -ms-flex-basis: 16.667%;
			  flex-basis: 16.667%;
			  max-width: 16.667%;
			}
			.col-sm-3 {
			  -webkit-flex-basis: 25%;
			  -ms-flex-preferred-size: 25%;
			  -webkit-flex-basis: 25%;
			  -ms-flex-basis: 25%;
			  flex-basis: 25%;
			  max-width: 25%;
			}
			.col-sm-4 {
			  -webkit-flex-basis: 33.333%;
			  -ms-flex-preferred-size: 33.333%;
			  -webkit-flex-basis: 33.333%;
			  -ms-flex-basis: 33.333%;
			  flex-basis: 33.333%;
			  max-width: 33.333%;
			}
			.col-sm-5 {
			  -webkit-flex-basis: 41.667%;
			  -ms-flex-preferred-size: 41.667%;
			  -webkit-flex-basis: 41.667%;
			  -ms-flex-basis: 41.667%;
			  flex-basis: 41.667%;
			  max-width: 41.667%;
			}
			.col-sm-6 {
			  -webkit-flex-basis: 50%;
			  -ms-flex-preferred-size: 50%;
			  -webkit-flex-basis: 50%;
			  -ms-flex-basis: 50%;
			  flex-basis: 50%;
			  max-width: 50%;
			}
			.col-sm-7 {
			  -webkit-flex-basis: 58.333%;
			  -ms-flex-preferred-size: 58.333%;
			  -webkit-flex-basis: 58.333%;
			  -ms-flex-basis: 58.333%;
			  flex-basis: 58.333%;
			  max-width: 58.333%;
			}
			.col-sm-8 {
			  -webkit-flex-basis: 66.667%;
			  -ms-flex-preferred-size: 66.667%;
			  -webkit-flex-basis: 66.667%;
			  -ms-flex-basis: 66.667%;
			  flex-basis: 66.667%;
			  max-width: 66.667%;
			}
			.col-sm-9 {
			  -webkit-flex-basis: 75%;
			  -ms-flex-preferred-size: 75%;
			  -webkit-flex-basis: 75%;
			  -ms-flex-basis: 75%;
			  flex-basis: 75%;
			  max-width: 75%;
			}
			.col-sm-10 {
			  -webkit-flex-basis: 83.333%;
			  -ms-flex-preferred-size: 83.333%;
			  -webkit-flex-basis: 83.333%;
			  -ms-flex-basis: 83.333%;
			  flex-basis: 83.333%;
			  max-width: 83.333%;
			}
			.col-sm-11 {
			  -webkit-flex-basis: 91.667%;
			  -ms-flex-preferred-size: 91.667%;
			  -webkit-flex-basis: 91.667%;
			  -ms-flex-basis: 91.667%;
			  flex-basis: 91.667%;
			  max-width: 91.667%;
			}
			.col-sm-12 {
			  -webkit-flex-basis: 100%;
			  -ms-flex-preferred-size: 100%;
			  -webkit-flex-basis: 100%;
			  -ms-flex-basis: 100%;
			  flex-basis: 100%;
			  max-width: 100%;
			}
			.col-sm-offset-1 {
			  margin-left: 8.333%;
			}
			.col-sm-offset-2 {
			  margin-left: 16.667%;
			}
			.col-sm-offset-3 {
			  margin-left: 25%;
			}
			.col-sm-offset-4 {
			  margin-left: 33.333%;
			}
			.col-sm-offset-5 {
			  margin-left: 41.667%;
			}
			.col-sm-offset-6 {
			  margin-left: 50%;
			}
			.col-sm-offset-7 {
			  margin-left: 58.333%;
			}
			.col-sm-offset-8 {
			  margin-left: 66.667%;
			}
			.col-sm-offset-9 {
			  margin-left: 75%;
			}
			.col-sm-offset-10 {
			  margin-left: 83.333%;
			}
			.col-sm-offset-11 {
			  margin-left: 91.667%;
			}
			.start-sm {
			  -webkit-box-pack: start;
			  -webkit-justify-content: flex-start;
			  -ms-flex-pack: start;
			  -webkit-box-pack: start;
			  -webkit-justify-content: flex-start;
			  -ms-flex-pack: start;
			  justify-content: flex-start;
			  text-align: start;
			}
			.center-sm {
			  -webkit-box-pack: center;
			  -webkit-justify-content: center;
			  -ms-flex-pack: center;
			  -webkit-box-pack: center;
			  -webkit-justify-content: center;
			  -ms-flex-pack: center;
			  justify-content: center;
			  text-align: center;
			}
			.end-sm {
			  -webkit-box-pack: end;
			  -webkit-justify-content: flex-end;
			  -ms-flex-pack: end;
			  -webkit-box-pack: end;
			  -webkit-justify-content: flex-end;
			  -ms-flex-pack: end;
			  justify-content: flex-end;
			  text-align: end;
			}
			.top-sm {
			  -webkit-box-align: start;
			  -webkit-align-items: flex-start;
			  -ms-flex-align: start;
			  -webkit-align-items: flex-start;
			  -webkit-box-align: flex-start;
			  -ms-flex-align: flex-start;
			  align-items: flex-start;
			}
			.middle-sm {
			  -webkit-box-align: center;
			  -webkit-align-items: center;
			  -ms-flex-align: center;
			  -webkit-align-items: center;
			  -webkit-box-align: center;
			  -ms-flex-align: center;
			  align-items: center;
			}
			.bottom-sm {
			  -webkit-box-align: end;
			  -webkit-align-items: flex-end;
			  -ms-flex-align: end;
			  -webkit-align-items: flex-end;
			  -webkit-box-align: flex-end;
			  -ms-flex-align: flex-end;
			  align-items: flex-end;
			}
			.around-sm {
			  -webkit-justify-content: space-around;
			  -ms-flex-pack: distribute;
			  -webkit-box-pack: space-around;
			  -webkit-justify-content: space-around;
			  -ms-flex-pack: space-around;
			  justify-content: space-around;
			}
			.between-sm {
			  -webkit-box-pack: justify;
			  -webkit-justify-content: space-between;
			  -ms-flex-pack: justify;
			  -webkit-box-pack: space-between;
			  -webkit-justify-content: space-between;
			  -ms-flex-pack: space-between;
			  justify-content: space-between;
			}
			.first-sm {
			  -webkit-box-ordinal-group: 0;
			  -webkit-order: -1;
			  -ms-flex-order: -1;
			  -webkit-order: -1;
			  -ms-flex-order: -1;
			  order: -1;
			}
			.last-sm {
			  -webkit-box-ordinal-group: 2;
			  -webkit-order: 1;
			  -ms-flex-order: 1;
			  -webkit-order: 1;
			  -ms-flex-order: 1;
			  order: 1;
			}
		  }
	
		  @media only screen and (min-width:48em) {
			.container {
			  width: 49rem;
			}
			.col-md,
			.col-md-1,
			.col-md-10,
			.col-md-11,
			.col-md-12,
			.col-md-2,
			.col-md-3,
			.col-md-4,
			.col-md-5,
			.col-md-6,
			.col-md-7,
			.col-md-8,
			.col-md-9,
			.col-md-offset-1,
			.col-md-offset-10,
			.col-md-offset-11,
			.col-md-offset-12,
			.col-md-offset-2,
			.col-md-offset-3,
			.col-md-offset-4,
			.col-md-offset-5,
			.col-md-offset-6,
			.col-md-offset-7,
			.col-md-offset-8,
			.col-md-offset-9 {
			  box-sizing: border-box;
			  -webkit-box-flex: 0;
			  -webkit-flex: 0 0 auto;
			  -ms-flex: 0 0 auto;
			  -webkit-flex: 0 0 auto;
			  -ms-flex: 0 0 auto;
			  flex: 0 0 auto;
			  padding-right: .5rem;
			  padding-left: .5rem;
			}
			.col-md {
			  -webkit-box-flex: 1;
			  -webkit-flex-grow: 1;
			  -ms-flex-positive: 1;
			  -webkit-flex-grow: 1;
			  -ms-flex-grow: 1;
			  flex-grow: 1;
			  -webkit-flex-basis: 0;
			  -ms-flex-preferred-size: 0;
			  -webkit-flex-basis: 0;
			  -ms-flex-basis: 0;
			  flex-basis: 0;
			  max-width: 100%;
			}
			.col-md-1 {
			  -webkit-flex-basis: 8.333%;
			  -ms-flex-preferred-size: 8.333%;
			  -webkit-flex-basis: 8.333%;
			  -ms-flex-basis: 8.333%;
			  flex-basis: 8.333%;
			  max-width: 8.333%;
			}
			.col-md-2 {
			  -webkit-flex-basis: 16.667%;
			  -ms-flex-preferred-size: 16.667%;
			  -webkit-flex-basis: 16.667%;
			  -ms-flex-basis: 16.667%;
			  flex-basis: 16.667%;
			  max-width: 16.667%;
			}
			.col-md-3 {
			  -webkit-flex-basis: 25%;
			  -ms-flex-preferred-size: 25%;
			  -webkit-flex-basis: 25%;
			  -ms-flex-basis: 25%;
			  flex-basis: 25%;
			  max-width: 25%;
			}
			.col-md-4 {
			  -webkit-flex-basis: 33.333%;
			  -ms-flex-preferred-size: 33.333%;
			  -webkit-flex-basis: 33.333%;
			  -ms-flex-basis: 33.333%;
			  flex-basis: 33.333%;
			  max-width: 33.333%;
			}
			.col-md-5 {
			  -webkit-flex-basis: 41.667%;
			  -ms-flex-preferred-size: 41.667%;
			  -webkit-flex-basis: 41.667%;
			  -ms-flex-basis: 41.667%;
			  flex-basis: 41.667%;
			  max-width: 41.667%;
			}
			.col-md-6 {
			  -webkit-flex-basis: 50%;
			  -ms-flex-preferred-size: 50%;
			  -webkit-flex-basis: 50%;
			  -ms-flex-basis: 50%;
			  flex-basis: 50%;
			  max-width: 50%;
			}
			.col-md-7 {
			  -webkit-flex-basis: 58.333%;
			  -ms-flex-preferred-size: 58.333%;
			  -webkit-flex-basis: 58.333%;
			  -ms-flex-basis: 58.333%;
			  flex-basis: 58.333%;
			  max-width: 58.333%;
			}
			.col-md-8 {
			  -webkit-flex-basis: 66.667%;
			  -ms-flex-preferred-size: 66.667%;
			  -webkit-flex-basis: 66.667%;
			  -ms-flex-basis: 66.667%;
			  flex-basis: 66.667%;
			  max-width: 66.667%;
			}
			.col-md-9 {
			  -webkit-flex-basis: 75%;
			  -ms-flex-preferred-size: 75%;
			  -webkit-flex-basis: 75%;
			  -ms-flex-basis: 75%;
			  flex-basis: 75%;
			  max-width: 75%;
			}
			.col-md-10 {
			  -webkit-flex-basis: 83.333%;
			  -ms-flex-preferred-size: 83.333%;
			  -webkit-flex-basis: 83.333%;
			  -ms-flex-basis: 83.333%;
			  flex-basis: 83.333%;
			  max-width: 83.333%;
			}
			.col-md-11 {
			  -webkit-flex-basis: 91.667%;
			  -ms-flex-preferred-size: 91.667%;
			  -webkit-flex-basis: 91.667%;
			  -ms-flex-basis: 91.667%;
			  flex-basis: 91.667%;
			  max-width: 91.667%;
			}
			.col-md-12 {
			  -webkit-flex-basis: 100%;
			  -ms-flex-preferred-size: 100%;
			  -webkit-flex-basis: 100%;
			  -ms-flex-basis: 100%;
			  flex-basis: 100%;
			  max-width: 100%;
			}
			.col-md-offset-1 {
			  margin-left: 8.333%;
			}
			.col-md-offset-2 {
			  margin-left: 16.667%;
			}
			.col-md-offset-3 {
			  margin-left: 25%;
			}
			.col-md-offset-4 {
			  margin-left: 33.333%;
			}
			.col-md-offset-5 {
			  margin-left: 41.667%;
			}
			.col-md-offset-6 {
			  margin-left: 50%;
			}
			.col-md-offset-7 {
			  margin-left: 58.333%;
			}
			.col-md-offset-8 {
			  margin-left: 66.667%;
			}
			.col-md-offset-9 {
			  margin-left: 75%;
			}
			.col-md-offset-10 {
			  margin-left: 83.333%;
			}
			.col-md-offset-11 {
			  margin-left: 91.667%;
			}
			.start-md {
			  -webkit-box-pack: start;
			  -webkit-justify-content: flex-start;
			  -ms-flex-pack: start;
			  -webkit-box-pack: start;
			  -webkit-justify-content: flex-start;
			  -ms-flex-pack: start;
			  justify-content: flex-start;
			  text-align: start;
			}
			.center-md {
			  -webkit-box-pack: center;
			  -webkit-justify-content: center;
			  -ms-flex-pack: center;
			  -webkit-box-pack: center;
			  -webkit-justify-content: center;
			  -ms-flex-pack: center;
			  justify-content: center;
			  text-align: center;
			}
			.end-md {
			  -webkit-box-pack: end;
			  -webkit-justify-content: flex-end;
			  -ms-flex-pack: end;
			  -webkit-box-pack: end;
			  -webkit-justify-content: flex-end;
			  -ms-flex-pack: end;
			  justify-content: flex-end;
			  text-align: end;
			}
			.top-md {
			  -webkit-box-align: start;
			  -webkit-align-items: flex-start;
			  -ms-flex-align: start;
			  -webkit-align-items: flex-start;
			  -webkit-box-align: flex-start;
			  -ms-flex-align: flex-start;
			  align-items: flex-start;
			}
			.middle-md {
			  -webkit-box-align: center;
			  -webkit-align-items: center;
			  -ms-flex-align: center;
			  -webkit-align-items: center;
			  -webkit-box-align: center;
			  -ms-flex-align: center;
			  align-items: center;
			}
			.bottom-md {
			  -webkit-box-align: end;
			  -webkit-align-items: flex-end;
			  -ms-flex-align: end;
			  -webkit-align-items: flex-end;
			  -webkit-box-align: flex-end;
			  -ms-flex-align: flex-end;
			  align-items: flex-end;
			}
			.around-md {
			  -webkit-justify-content: space-around;
			  -ms-flex-pack: distribute;
			  -webkit-box-pack: space-around;
			  -webkit-justify-content: space-around;
			  -ms-flex-pack: space-around;
			  justify-content: space-around;
			}
			.between-md {
			  -webkit-box-pack: justify;
			  -webkit-justify-content: space-between;
			  -ms-flex-pack: justify;
			  -webkit-box-pack: space-between;
			  -webkit-justify-content: space-between;
			  -ms-flex-pack: space-between;
			  justify-content: space-between;
			}
			.first-md {
			  -webkit-box-ordinal-group: 0;
			  -webkit-order: -1;
			  -ms-flex-order: -1;
			  -webkit-order: -1;
			  -ms-flex-order: -1;
			  order: -1;
			}
			.last-md {
			  -webkit-box-ordinal-group: 2;
			  -webkit-order: 1;
			  -ms-flex-order: 1;
			  -webkit-order: 1;
			  -ms-flex-order: 1;
			  order: 1;
			}
		  }
	
		  @media only screen and (min-width:64em) {
			.container {
			  width: 65rem;
			}
			.col-lg,
			.col-lg-1,
			.col-lg-10,
			.col-lg-11,
			.col-lg-12,
			.col-lg-2,
			.col-lg-3,
			.col-lg-4,
			.col-lg-5,
			.col-lg-6,
			.col-lg-7,
			.col-lg-8,
			.col-lg-9,
			.col-lg-offset-1,
			.col-lg-offset-10,
			.col-lg-offset-11,
			.col-lg-offset-12,
			.col-lg-offset-2,
			.col-lg-offset-3,
			.col-lg-offset-4,
			.col-lg-offset-5,
			.col-lg-offset-6,
			.col-lg-offset-7,
			.col-lg-offset-8,
			.col-lg-offset-9 {
			  box-sizing: border-box;
			  -webkit-box-flex: 0;
			  -webkit-flex: 0 0 auto;
			  -ms-flex: 0 0 auto;
			  -webkit-flex: 0 0 auto;
			  -ms-flex: 0 0 auto;
			  flex: 0 0 auto;
			  padding-right: .5rem;
			  padding-left: .5rem;
			}
			.col-lg {
			  -webkit-box-flex: 1;
			  -webkit-flex-grow: 1;
			  -ms-flex-positive: 1;
			  -webkit-flex-grow: 1;
			  -ms-flex-grow: 1;
			  flex-grow: 1;
			  -webkit-flex-basis: 0;
			  -ms-flex-preferred-size: 0;
			  -webkit-flex-basis: 0;
			  -ms-flex-basis: 0;
			  flex-basis: 0;
			  max-width: 100%;
			}
			.col-lg-1 {
			  -webkit-flex-basis: 8.333%;
			  -ms-flex-preferred-size: 8.333%;
			  -webkit-flex-basis: 8.333%;
			  -ms-flex-basis: 8.333%;
			  flex-basis: 8.333%;
			  max-width: 8.333%;
			}
			.col-lg-2 {
			  -webkit-flex-basis: 16.667%;
			  -ms-flex-preferred-size: 16.667%;
			  -webkit-flex-basis: 16.667%;
			  -ms-flex-basis: 16.667%;
			  flex-basis: 16.667%;
			  max-width: 16.667%;
			}
			.col-lg-3 {
			  -webkit-flex-basis: 25%;
			  -ms-flex-preferred-size: 25%;
			  -webkit-flex-basis: 25%;
			  -ms-flex-basis: 25%;
			  flex-basis: 25%;
			  max-width: 25%;
			}
			.col-lg-4 {
			  -webkit-flex-basis: 33.333%;
			  -ms-flex-preferred-size: 33.333%;
			  -webkit-flex-basis: 33.333%;
			  -ms-flex-basis: 33.333%;
			  flex-basis: 33.333%;
			  max-width: 33.333%;
			}
			.col-lg-5 {
			  -webkit-flex-basis: 41.667%;
			  -ms-flex-preferred-size: 41.667%;
			  -webkit-flex-basis: 41.667%;
			  -ms-flex-basis: 41.667%;
			  flex-basis: 41.667%;
			  max-width: 41.667%;
			}
			.col-lg-6 {
			  -webkit-flex-basis: 50%;
			  -ms-flex-preferred-size: 50%;
			  -webkit-flex-basis: 50%;
			  -ms-flex-basis: 50%;
			  flex-basis: 50%;
			  max-width: 50%;
			}
			.col-lg-7 {
			  -webkit-flex-basis: 58.333%;
			  -ms-flex-preferred-size: 58.333%;
			  -webkit-flex-basis: 58.333%;
			  -ms-flex-basis: 58.333%;
			  flex-basis: 58.333%;
			  max-width: 58.333%;
			}
			.col-lg-8 {
			  -webkit-flex-basis: 66.667%;
			  -ms-flex-preferred-size: 66.667%;
			  -webkit-flex-basis: 66.667%;
			  -ms-flex-basis: 66.667%;
			  flex-basis: 66.667%;
			  max-width: 66.667%;
			}
			.col-lg-9 {
			  -webkit-flex-basis: 75%;
			  -ms-flex-preferred-size: 75%;
			  -webkit-flex-basis: 75%;
			  -ms-flex-basis: 75%;
			  flex-basis: 75%;
			  max-width: 75%;
			}
			.col-lg-10 {
			  -webkit-flex-basis: 83.333%;
			  -ms-flex-preferred-size: 83.333%;
			  -webkit-flex-basis: 83.333%;
			  -ms-flex-basis: 83.333%;
			  flex-basis: 83.333%;
			  max-width: 83.333%;
			}
			.col-lg-11 {
			  -webkit-flex-basis: 91.667%;
			  -ms-flex-preferred-size: 91.667%;
			  -webkit-flex-basis: 91.667%;
			  -ms-flex-basis: 91.667%;
			  flex-basis: 91.667%;
			  max-width: 91.667%;
			}
			.col-lg-12 {
			  -webkit-flex-basis: 100%;
			  -ms-flex-preferred-size: 100%;
			  -webkit-flex-basis: 100%;
			  -ms-flex-basis: 100%;
			  flex-basis: 100%;
			  max-width: 100%;
			}
			.col-lg-offset-1 {
			  margin-left: 8.333%;
			}
			.col-lg-offset-2 {
			  margin-left: 16.667%;
			}
			.col-lg-offset-3 {
			  margin-left: 25%;
			}
			.col-lg-offset-4 {
			  margin-left: 33.333%;
			}
			.col-lg-offset-5 {
			  margin-left: 41.667%;
			}
			.col-lg-offset-6 {
			  margin-left: 50%;
			}
			.col-lg-offset-7 {
			  margin-left: 58.333%;
			}
			.col-lg-offset-8 {
			  margin-left: 66.667%;
			}
			.col-lg-offset-9 {
			  margin-left: 75%;
			}
			.col-lg-offset-10 {
			  margin-left: 83.333%;
			}
			.col-lg-offset-11 {
			  margin-left: 91.667%;
			}
			.start-lg {
			  -webkit-box-pack: start;
			  -webkit-justify-content: flex-start;
			  -ms-flex-pack: start;
			  -webkit-box-pack: start;
			  -webkit-justify-content: flex-start;
			  -ms-flex-pack: start;
			  justify-content: flex-start;
			  text-align: start;
			}
			.center-lg {
			  -webkit-box-pack: center;
			  -webkit-justify-content: center;
			  -ms-flex-pack: center;
			  -webkit-box-pack: center;
			  -webkit-justify-content: center;
			  -ms-flex-pack: center;
			  justify-content: center;
			  text-align: center;
			}
			.end-lg {
			  -webkit-box-pack: end;
			  -webkit-justify-content: flex-end;
			  -ms-flex-pack: end;
			  -webkit-box-pack: end;
			  -webkit-justify-content: flex-end;
			  -ms-flex-pack: end;
			  justify-content: flex-end;
			  text-align: end;
			}
			.top-lg {
			  -webkit-box-align: start;
			  -webkit-align-items: flex-start;
			  -ms-flex-align: start;
			  -webkit-align-items: flex-start;
			  -webkit-box-align: flex-start;
			  -ms-flex-align: flex-start;
			  align-items: flex-start;
			}
			.middle-lg {
			  -webkit-box-align: center;
			  -webkit-align-items: center;
			  -ms-flex-align: center;
			  -webkit-align-items: center;
			  -webkit-box-align: center;
			  -ms-flex-align: center;
			  align-items: center;
			}
			.bottom-lg {
			  -webkit-box-align: end;
			  -webkit-align-items: flex-end;
			  -ms-flex-align: end;
			  -webkit-align-items: flex-end;
			  -webkit-box-align: flex-end;
			  -ms-flex-align: flex-end;
			  align-items: flex-end;
			}
			.around-lg {
			  -webkit-justify-content: space-around;
			  -ms-flex-pack: distribute;
			  -webkit-box-pack: space-around;
			  -webkit-justify-content: space-around;
			  -ms-flex-pack: space-around;
			  justify-content: space-around;
			}
			.between-lg {
			  -webkit-box-pack: justify;
			  -webkit-justify-content: space-between;
			  -ms-flex-pack: justify;
			  -webkit-box-pack: space-between;
			  -webkit-justify-content: space-between;
			  -ms-flex-pack: space-between;
			  justify-content: space-between;
			}
			.first-lg {
			  -webkit-box-ordinal-group: 0;
			  -webkit-order: -1;
			  -ms-flex-order: -1;
			  -webkit-order: -1;
			  -ms-flex-order: -1;
			  order: -1;
			}
			.last-lg {
			  -webkit-box-ordinal-group: 2;
			  -webkit-order: 1;
			  -ms-flex-order: 1;
			  -webkit-order: 1;
			  -ms-flex-order: 1;
			  order: 1;
			}
		  }
		</style>
		<style type="text/css" data-styled-components="iECmZH gilyel evpGNr byGfxM jFgvCd kktUDF jlPFGn eWjzRU jGqJlD kuqIKy ktKmOq iWVBpY hNogKD dggHpc jpHwD ipliua doYTvo eLCXzP hznfox cHZARy fhbjHj dRtAmU cULmEo hiKSiS cpoSvg kSOdgB GrYpZ dRiOjk cKjbEQ CLluW irjKNI dDRnsI YzqzA gEwPsy gLRoTZ bTVPzW eLBKpU bXYmZq jiDMyE cCPdDf kFuKSG JaVau iheQPW cDBKQv fKsNLk eRGRqS efxxAa eMaSBg fVrZls evjDXW bqVLhR gXwWwO etWFLc jhTbHC hRkhrw gEMvbe dJvZEL dBSBrt fJDlWs chprFS bxIgtu dQWvvR llGlaf cTengc idjmuw"
		data-styled-components-is-local="true">
		  @media (max-width: 30rem) {
			.cpoSvg {
			  font-size: 1rem !important;
			}
		  }
	
		  @media (max-width: 30rem) {
			.gEwPsy {
			  font-size: 1rem !important;
			}
		  }
	
		  @media (max-width: 30rem) {
			.eLBKpU {
			  font-size: 1.3090000000000002rem !important;
			}
		  }
	
		  @media (max-width: 30rem) {
			.bqVLhR {
			  font-size: 1rem !important;
			}
		  }
	
		  @media (max-width: 30rem) {
			.jFgvCd {
			  font-size: 1rem !important;
			}
		  }
	
		  @media (max-width: 30rem) {
			.eWjzRU {
			  font-size: 1.3090000000000002rem !important;
			}
		  }
	
		  @media (max-width: 30rem) {
			.cKjbEQ {
			  font-size: 1.3090000000000002rem !important;
			}
		  }
	
		  @media (max-width: 30rem) {
			.gLRoTZ {
			  font-size: 1rem !important;
			}
		  }
	
		  @media (max-width: 30rem) {
			.etWFLc {
			  font-size: 1rem !important;
			}
		  }
	
		  @media (max-width: 30rem) {
			.hNogKD {
			  font-size: 1rem !important;
			}
		  }
	
		  @media (max-width: 30rem) {
			.jpHwD {
			  font-size: 1rem !important;
			}
		  }
	
		  @media (max-width: 30rem) {
			.cULmEo {
			  font-size: 1rem !important;
			}
		  }
	
		  @media (max-width: 30rem) {
			.hiKSiS {
			  font-size: 1rem !important;
			}
		  }
	
		  @media (max-width: 30rem) {
			.bTVPzW {
			  font-size: 1rem !important;
			}
		  }
	
		  @media (max-width: 30rem) {
			.jiDMyE {
			  font-size: 1.618rem !important;
			}
		  }
	
		  @media (max-width: 30rem) {
			.cCPdDf {
			  font-size: 1.618rem !important;
			}
		  }
	
		  @media (max-width: 30rem) {
			.JaVau {
			  font-size: 1.3090000000000002rem !important;
			}
		  }
	
		  @media (max-width: 30rem) {
			.efxxAa {
			  font-size: 1rem !important;
			}
		  }
	
		  @media (max-width: 30rem) {
			.jhTbHC {
			  font-size: 1.3090000000000002rem !important;
			}
		  }
	
		  @media (max-width: 30rem) {
			.dBSBrt {
			  font-size: 1rem !important;
			}
		  }
	
		  @media (max-width: 30rem) {
			.fJDlWs {
			  font-size: 0.6180469715698392rem !important;
			}
		  }
	
		  @media (max-width: 30rem) {
			.chprFS {
			  font-size: 0.6180469715698392rem !important;
			}
		  }
	
		  @media (max-width: 30rem) {
			.bxIgtu {
			  font-size: 0.8090234857849197rem !important;
			}
		  }
	
		  @media (max-width: 30rem) {
			.dQWvvR {
			  font-size: 0.8090234857849197rem !important;
			}
		  }
	
		  @media (max-width: 30rem) {
			.cTengc {
			  font-size: 1.3090000000000002rem !important;
			}
		  }
		</style>
		<style type="text/css" data-styled-components="" data-styled-components-is-local="false">
		  @media (max-width: 30rem) {
			#component-playground .containerInner .fullWidthMobile,
			.reactWrapper .containerInner .fullWidthMobile {
			  padding-left: 0;
			  padding-right: 0;
			  overflow-x: hidden;
			}
		  }
		</style>
	  </head>
	  
	  <body style="min-width: 320px; background-color: #FFFFFF; width: 100%; margin: 0; padding: 0; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;">
		<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0" align="left"
		valign="top" style="border-collapse: collapse; border-spacing: 0;">
		  <tbody style="background-color:#FFB3B3 !important;">
			<tr>
			  <td align="center" valign="top" style="padding: 0;">
				<table width="600" align="center" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border-spacing: 0; background-color: #F3F4F5; text-align: center;"
				border="0" valign="top" bgcolor="#F3F4F5">
				  <tbody>
					<tr>
					</tr>
					<tr>
					  <td style="padding: 0;">
						<div class="sc-bdVaJa byGfxM" display="block" style="box-sizing: border-box; position: static; border-radius: 0; -webkit-transition: all 300ms cubic-bezier(0.19, 1, 0.22, 1); transition: all 300ms cubic-bezier(0.19, 1, 0.22, 1); overflow: inherit; padding: 0rem 3rem 0rem 3rem; margin: 0rem 0rem 0rem 0rem; border-top: none; border-right: none; border-bottom: none; border-left: none; display: block;"><span class="sc-bxivhb jFgvCd" color="gray1" scale="1" style="color: #052D49; font-family: America, sans-serif; -webkit-letter-spacing: inherit; -moz-letter-spacing: inherit; -ms-letter-spacing: inherit; letter-spacing: inherit; margin: 0; opacity: 1; position: relative; text-align: inherit; text-transform: inherit; text-shadow: none; -webkit-transition: all 300ms cubic-bezier(0.19, 1, 0.22, 1); transition: all 300ms cubic-bezier(0.19, 1, 0.22, 1); -webkit-user-select: inherit; -moz-user-select: inherit; -ms-user-select: inherit; user-select: inherit; font-size: 1rem; font-weight: 400; line-height: 1.5;"><div class="sc-kgoBCf kktUDF" overflow="hidden" style="border-top: none; border-bottom: none; border-left: none; border-right: none; border-radius: 0; box-shadow: 0 2px 0 0 rgba(5, 45, 73, 0.06999999999999995); background-color: #FFFFFF; overflow: hidden;"><div class="sc-bdVaJa jlPFGn" display="block" style="box-sizing: border-box; position: static; border-radius: 0; -webkit-transition: all 300ms cubic-bezier(0.19, 1, 0.22, 1); transition: all 300ms cubic-bezier(0.19, 1, 0.22, 1); overflow: inherit; padding: 2rem 2rem 2rem 2rem; margin: 0rem 0rem 0rem 0rem; border-top: none; border-right: none; border-bottom: none; border-left: none; display: block;"><div class="sc-htpNat cpoSvg" color="gray1" scale="1" style="color: #052D49; font-family: America, sans-serif; -webkit-letter-spacing: inherit; -moz-letter-spacing: inherit; -ms-letter-spacing: inherit; letter-spacing: inherit; margin: 0; opacity: 1; position: relative; text-align: left; text-transform: inherit; text-shadow: none; -webkit-transition: all 300ms cubic-bezier(0.19, 1, 0.22, 1); transition: all 300ms cubic-bezier(0.19, 1, 0.22, 1); -webkit-user-select: inherit; -moz-user-select: inherit; -ms-user-select: inherit; user-select: inherit; font-size: 1rem; font-weight: 400; line-height: 1.5;"><span class="sc-bxivhb eWjzRU" color="gray3" scale="1" size="2" style="color: #4F687A; font-family: America, sans-serif; -webkit-letter-spacing: inherit; -moz-letter-spacing: inherit; -ms-letter-spacing: inherit; letter-spacing: inherit; margin: 0; opacity: 1; position: relative; text-align: inherit; text-transform: inherit; text-shadow: none; -webkit-transition: all 300ms cubic-bezier(0.19, 1, 0.22, 1); transition: all 300ms cubic-bezier(0.19, 1, 0.22, 1); -webkit-user-select: inherit; -moz-user-select: inherit; -ms-user-select: inherit; user-select: inherit; font-size: 1.3090000000000002rem; font-weight: 400; line-height: 1.25;">
							Violation Notification</span>
	
                            <div class="sc-bdVaJa dggHpc" style="box-sizing: border-box; position: static; border-radius: 0; transition: all 300ms cubic-bezier(0.19, 1, 0.22, 1); overflow: inherit; padding: 0rem; margin: 1.5rem 0; border: none;">
                            Hi <b>' . $full_name . '</b>,<br><br>
                            This is to notify you that you had committed the following violation:<br><br>
                            <b>' . $violation_description . '</b><br><br>
                            The sanction for these types of violation is as follows:<br><br>
                            <b>' . $sanction_details . '</b>
                        </div>
						
						</div>
						</div>
						</span>
						</div>
					  </td>
					</tr>
					<tr>
					  <td style="padding: 0;">
						<div class="sc-bdVaJa gilyel" display="block" style="box-sizing: border-box; position: static; border-radius: 0; -webkit-transition: all 300ms cubic-bezier(0.19, 1, 0.22, 1); transition: all 300ms cubic-bezier(0.19, 1, 0.22, 1); overflow: inherit; padding: 3rem 3rem 3rem 3rem; margin: 0rem 0rem 0rem 0rem; border-top: none; border-right: none; border-bottom: none; border-left: none; display: block;"><span class="sc-bxivhb jFgvCd" color="gray1" scale="1" style="color: #052D49; font-family: America, sans-serif; -webkit-letter-spacing: inherit; -moz-letter-spacing: inherit; -ms-letter-spacing: inherit; letter-spacing: inherit; margin: 0; opacity: 1; position: relative; text-align: inherit; text-transform: inherit; text-shadow: none; -webkit-transition: all 300ms cubic-bezier(0.19, 1, 0.22, 1); transition: all 300ms cubic-bezier(0.19, 1, 0.22, 1); -webkit-user-select: inherit; -moz-user-select: inherit; -ms-user-select: inherit; user-select: inherit; font-size: 1rem; font-weight: 400; line-height: 1.5;"><div class="sc-bdVaJa cHZARy" display="block" style="box-sizing: border-box; position: static; border-radius: 0; -webkit-transition: all 300ms cubic-bezier(0.19, 1, 0.22, 1); transition: all 300ms cubic-bezier(0.19, 1, 0.22, 1); overflow: inherit; padding: 0rem 0rem 3rem 0rem; margin: 0rem 0rem 0rem 0rem; border-top: none; border-right: none; border-bottom: none; border-left: none; display: block;">
							Have any questions? Please email us <b> cictstudentviolation@gmail.com</b> 
																   
						</span>
						</div>
					  </td>
					</tr>
				  </tbody>
				</table>
			  </td>
			</tr>
		  </tbody>
		</table>
	
	  </body>
	
	</html>';
            $mail->AltBody = 'You have a violation!';

            $mail->send();
     
        } catch (Exception $e) {
            echo json_encode(['error_msg' => $mail->ErrorInfo ,'error_count' => 1]);
        }

            // Log the action
            $logSql = "INSERT INTO logs (action_performed, performed_by, logged_date) VALUES (?, ?, ?)";
            if ($logStmt = $conn->prepare($logSql)) {
                $actionPerformed = "Added a violation for student ID: $studentId";
                $loggedDate = date('Y-m-d H:i:s'); // Capture current date and time
                $logStmt->bind_param('sss', $actionPerformed, $fullName, $loggedDate);
                $logStmt->execute();
                $logStmt->close();
            }

            echo json_encode(['status' => 'success', 'message' => 'Violation recorded and SMS sent.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to record violation.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database query failed.']);
    }

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
