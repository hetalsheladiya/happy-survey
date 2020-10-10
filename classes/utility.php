<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Utility {
	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
    function sendEmail($email, $name, $subject, $body, $replyTo) {

        require_once 'PHPMailer/src/Exception.php';
        require_once 'PHPMailer/src/PHPMailer.php';
        require_once 'PHPMailer/src/SMTP.php';
        
        $from = $email;    
        // $to = "hi@logileap.com";    
        // $to = "testkmsof@gmail.com";
        $to = "hpysrvy@gmail.com"; 
        //$sendToGmail = "bhautik@kmsof.com";
        $sender_name = $name;
        $password = 'no@1234';

        // $replyTo = $email;
        $replyToName = $sender_name;
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            // $mail->Host = 'squareroot.us';                         // Specify main and backup SMTP servers
            $mail->Host = 'md-in-11.webhostbox.net';  
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = "norply@logileap.net";                              // SMTP username
            $mail->Password = $password;                          // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom($from, $sender_name);
            $mail->addAddress($to);         // Add a recipient
            $mail->addCC("test@kmsof.com");         // Add a recipient
            $mail->addCC("testkmsof@gmail.com");         // Add a recipient
            $mail->addCC("hi@logileap.com");         // Add a recipient
            $mail->addAddress($to);         // Add a recipient
            //$mail->addAddress($sendToGmail);                    // Name is optional
            $mail->addReplyTo($replyTo, $sender_name);           

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    } 
	function sendEmain($email, $subject, $body, $replyTo) {

		require_once 'PHPMailer/src/Exception.php';
		require_once 'PHPMailer/src/PHPMailer.php';
		require_once 'PHPMailer/src/SMTP.php';

		$from = 'norply@logileap.net';
		$sendToInfo = $email;
        //$sendToGmail = "bhautik@kmsof.com";
		$sender_name = "Happy Survey";
		$password = 'no@1234';

		$replyTo = $replyTo;
		$replyToName = $sender_name;
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();  
            $mail->Host = 'md-in-11.webhostbox.net';                                    // Set mailer to use SMTP
            // $mail->Host = 'squareroot.us';                         // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $from;                              // SMTP username
            $mail->Password = $password;                          // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom($from, $sender_name);
            $mail->addAddress($sendToInfo);         // Add a recipient
            //$mail->addAddress($sendToGmail);                    // Name is optional
            $mail->addReplyTo($replyTo, $sender_name);

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
        	return $e->getMessage();
        }
    }

    function sendEmailforQrcode($email, $subject, $body, $replyTo, $path, $file, $pdfName, $pdfPath) {

    	require_once 'PHPMailer/src/Exception.php';
    	require_once 'PHPMailer/src/PHPMailer.php';
    	require_once 'PHPMailer/src/SMTP.php';        

    	$from = 'norply@logileap.net';
    	$sendToInfo = $email;

    	$sender_name = "Happy Survey";
    	$password = 'no@1234';

    	$replyTo = $replyTo;
    	$replyToName = $sender_name;
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
        	$mail->IsSMTP();
        	$mail->CharSet = 'UTF-8';
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->Host     = "md-in-11.webhostbox.net";               // Set mailer to use SMTP
            // $mail->Host     = "mail.kmsof.com";               // Set mailer to use SMTP
            // $mail->Host = 'squareroot.us';                         // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $from;                              // SMTP username
            $mail->Password = $password;                          // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to

            //Recipients
            
            $mail->setFrom($from, $sender_name);
            $mail->addAddress($sendToInfo);         // Add a recipient
            //$mail->addAddress($sendToGmail);                    // Name is optional
            $mail->addReplyTo($replyTo, $sender_name);
            $mail->addAttachment($path, $file);
             if ($pdfPath != NULL && $pdfName != NULL) {
                 $mail->addAttachment($pdfPath, $pdfName);
             }
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
        	return $e->getMessage();
        }
    }

    function sendEmailforSurvey($email, $subject, $body, $replyTo){
        require_once 'PHPMailer/src/Exception.php';
        require_once 'PHPMailer/src/PHPMailer.php';
        require_once 'PHPMailer/src/SMTP.php';        

        $from = 'norply@logileap.net';
        $sendToInfo = $email;

        $sender_name = "Happy Survey";
        $password = 'no@1234';

        $replyTo = $replyTo;
        $replyToName = $sender_name;
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->IsSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->Host     = "md-in-11.webhostbox.net";               // Set mailer to use SMTP
            // $mail->Host     = "mail.kmsof.com";               // Set mailer to use SMTP
            // $mail->Host = 'squareroot.us';                         // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $from;                              // SMTP username
            $mail->Password = $password;                          // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to

            //Recipients
            
            $mail->setFrom($from, $sender_name);
            $mail->addAddress($sendToInfo);         // Add a recipient
            //$mail->addAddress($sendToGmail);                    // Name is optional
            $mail->addReplyTo($replyTo, $sender_name);
            // $mail->addAttachment($path, $file);
            //  if ($pdfPath != NULL && $pdfName != NULL) {
            //      $mail->addAttachment($pdfPath, $pdfName);
            //  }
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    function uploadImage($targetDirectory, $newFileName, $fieldName = "image") {
    	$message = "";
        $target_dir = $targetDirectory;//"uploads/";
        $target_file = $target_dir . $newFileName;//basename($_FILES["{$fieldName}"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file . basename($_FILES["{$fieldName}"]["name"]), PATHINFO_EXTENSION));
        
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
        	$check = getimagesize($_FILES["{$fieldName}"]["tmp_name"]);
        	if($check === false) {
        		return  "File is not an image.";
        	}
        }
        // Check if file already exists
        if (file_exists($target_file)) {
        	unlink($target_file);
        }
        // Check file size
        if ($_FILES["{$fieldName}"]["size"] > 10000000) {
        	return "Sorry, your file is too large.";
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        	return "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }
        // Check if $uploadOk is set to 0 by an error
        if (move_uploaded_file($_FILES["{$fieldName}"]["tmp_name"], $target_file)) {
        	return true;
        } else {
        	return "Sorry, there was an error uploading your file.";
        }
    }

    function fn_resize($image_resource_id, $width, $height) {         
        $widthRatio = 300/ $width;
        $heightRatio = 300/ $height;

        if($widthRatio > $heightRatio) {
          $newWidth =  $width * $heightRatio;
          $newHeight = $height * $heightRatio;
        } 
        else {
          $newWidth =  $width * $widthRatio;
          $newHeight = $height * $widthRatio;
        }

        $target_layer = imagecreatetruecolor($newWidth,$newHeight);
        $transparent = imagecolorallocatealpha($target_layer, 0, 0, 0, 127);
        imagefill($target_layer, 0, 0, $transparent);
        imagesavealpha($target_layer, true);
        imagecopyresampled($target_layer, $image_resource_id, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        return $target_layer;
    }
    
}

?>
