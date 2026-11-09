<?php

require './vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['kirim'])) {

    $nama  = $_POST['nama'];
    $email = $_POST['email'];
    $telp  = $_POST['telp'];
    $pesan = $_POST['pesan'];

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = false;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                      //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'dennasagita06@gmail.com';                      //SMTP username
        $mail->Password   = 'wnlgwdozlbbtllzd';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;             //Enable implicit TLS encryption
        $mail->Port       = 587;     

        // Pengirim & penerima
        $mail->setFrom('dennasagita06@gmail.com', 'Contact Form');
        $mail->addAddress('dennasagita06@gmail.com'); // email tujuan

        // Konten email
        $mail->isHTML(true);
        $mail->Subject = 'Pesan dari Website';

        $mail->Body = "
            <h3>Pesan Baru</h3>
            <p><b>Nama:</b> $nama</p>
            <p><b>Email:</b> $email</p>
            <p><b>Telepon:</b> $telp</p>
            <p><b>Pesan:</b><br>$pesan</p>
        ";

        $mail->send();

        echo "success";

    } catch (Exception $e) {
        echo "Error: {$mail->ErrorInfo}";
    }
}