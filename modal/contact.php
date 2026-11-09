<?php

require '../php/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Ambil data dari AJAX (TETAP pakai nama lama biar cocok dengan JS template)
$name        = $_POST['ajax_name'];
$email_from  = $_POST['ajax_email'];
$email_to    = 'dennasagita06@gmail.com';
$message     = $_POST['ajax_message'];
$phone       = $_POST['ajax_tel'];

// Validasi email
$email_from = filter_var($email_from, FILTER_SANITIZE_EMAIL);
$email_to   = filter_var($email_to, FILTER_SANITIZE_EMAIL);

if (filter_var($email_from, FILTER_VALIDATE_EMAIL)) {

    $mail = new PHPMailer(true);

    try {
        // SMTP Gmail
         //Server settings
        $mail->SMTPDebug = false;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                      //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'dennasagita06@gmail.com';                      //SMTP username
        $mail->Password   = 'wnlgwdozlbbtllzd';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;             //Enable implicit TLS encryption
        $mail->Port       = 587; 

        // Pengirim & tujuan
        $mail->setFrom('dennasagita06@gmail.com', 'Contact Website Portofolio');
        $mail->addAddress($email_to);

        // Konten
        $mail->isHTML(true);
        $mail->Subject = "Message from contact Portofolio";
		 // Gunakan nl2br untuk mengonversi newline menjadi <br>
        $name_with_html = nl2br(htmlspecialchars($name));
        $email_from_with_html = nl2br(htmlspecialchars($email_from));
        $phone_with_html = nl2br(htmlspecialchars($phone));
        $message_with_html = nl2br(htmlspecialchars($message));
        $mail->Body = "
           <div style='padding: 20px; font-family: Arial, sans-serif; background-color: #f9f9f9; border-radius: 8px; max-width: 600px; margin: auto;'>
				<h3 style='color: #333; font-size: 24px;'>Pesan Baru</h3>
				
				<p style='font-size: 16px; color: #333;'>
					<b>Nama:</b> <span style='color: #555;'>$name_with_html</span>
				</p>
				
				<p style='font-size: 16px; color: #333;'>
					<b>Email:</b> <span style='color: #555;'>$email_from_with_html</span>
				</p>
				
				<p style='font-size: 16px; color: #333;'>
					<b>Phone:</b> <span style='color: #555;'>$phone_with_html</span>
				</p>
				
				<p style='font-size: 16px; color: #333;'>
					<b>Pesan:</b><br><span style='color: #555;'>$message_with_html</span>
				</p>
				
				<hr style='border: 1px solid #ddd; margin-top: 20px;'>
				
				<p style='font-size: 14px; color: #888;'>
					Terima kasih atas pesan Anda. Kami akan segera menghubungi Anda.
				</p>
			</div>
        ";

        $mail->send();

        // PENTING: ini untuk trigger success modal
        echo "success";

    } catch (Exception $e) {
        echo "<span class='contact_error'>Mailer Error: {$mail->ErrorInfo}</span>";
    }

} else {
    echo "<span class='contact_error'>* Invalid email *</span>";
}