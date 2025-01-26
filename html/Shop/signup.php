<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './phpMailer/src/PHPMailer.php';
require './phpMailer/src/Exception.php';
require './phpMailer/src/SMTP.php';
if($_SERVER['REQUEST_METHOD']=='POST'){

    require_once 'config.php';
    connect::setConnection();
    $pdo = connect::getConnection();
    $email = $_POST['email'];
      // Check unique email
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM USERS WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $emailExists = $stmt->fetchColumn();
    
        if ($emailExists) {
            echo "<script>alert('Email is already exists!')</script>";
        }else {
            //Check password
       if($_POST['password']!=$_POST['confirm_password']){
        echo"<script>alert('The passwords do not match!')</script>";
        }else{
            // fill the users table in database
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $phone = $_POST['phone_number'];
        $password = $_POST['password'];
        $sql = "INSERT INTO USERS VALUES(null,:fname,:lname,:email,:password,:phone)";
        $stmt = $pdo->prepare($sql);
        $result= $stmt->execute([
            ':fname'=>$fname,
            ':lname'=>$lname,
            ':email'=>$email,
            ':password'=>$password,
            ':phone'=>$phone
        ]);
        if($result){
            ?>
            		<script>
				alert("تمت الاضافه بنجاح");
			
			</script>
            <?php
            // Send Email message for users
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host='smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'basilhb20@gmail.com';
            $mail->Password='ddgbjdsavlpevlmw';
            $mail->SMTPSecure= 'ssl';
            $mail->Port = '465';
            $mail->SetFrom('basilhb20@gmail.com');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $subject = "Visit Syria";
            $message = "Thank you for registration in our website";
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->send();
            } 
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign UP</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css"></link>
</head>
<body>
<div class="container jumbotron">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<h2 class="text-center">Create Account</h2>
			<form action="" method="post" enctype="multipart/form-data">
				<div class="form-group">
				<input type="text" class="form-control" name="fname" placeholder="Fisrt Name" >
				</div>
				<div class="form-group">
				<input type="text" class="form-control" name="lname" placeholder="Last Name" required>
				</div>
				<div class="form-group">
				<input type="text" class="form-control" name="email" placeholder="Email" required>
				</div>
				<div class="form-group">
				<input type="number" class="form-control" name="phone_number" placeholder="Phone Number" required>
				</div>
				<div class="form-group">
				<input type="password" class="form-control" name="password" placeholder="Password" required>
				</div>
                <div class="form-group">
				<input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required>
				</div>
				<button type="submit" name="submit" class="btn btn-info btn-lg">Create</button>
			</form>
		</div>
	</div>
</div>
</body>
</html>
