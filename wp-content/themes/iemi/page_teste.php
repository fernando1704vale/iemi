<?php/* Template Name: Teste de email */ ?>


<?php get_header(); ?>


teste de email
<?php 

/*$message = "
Novo usuário cadastrado.
Nome: teste
Email: teste
Telefone: teste
";
$headers = 'From: Site IEMI <faleconosco@iemi.com.br>' . "\r\n";
$allOK = wp_mail('karzin@gmail.com', 'teste de email', $message, $headers);*/

$email_usuario='karzin@gmail.com';
$email_remetente = "faleconosco@iemi.com.br";
$headers = "MIME-Version: 1.1\n";
$headers .= "Content-type: text/plain; charset=iso-8859-1\n";
$headers .= "From: $email_remetente\n"; // remetente
$headers .= "Return-Path: $email_remetente\n"; // return-path
$headers .= "Reply-To: $email_usuario\n"; // Endereço (devidamente validado) que o seu usuário informou no contato
$allOK = mail($email_usuario, "Assunto", "Mensagem", $headers, "-f$email_remetente");

_log('!!!!!!!!!!!!!!!! MAIL_OK: '.$allOK);

echo('!!!!!!!!!!!!!!!! MAIL_OK: '.$allOK);



?>

<?php get_footer(); ?>