<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

$to = 'contato@athaisefranca.com.br';
$successUrl = '/obrigado/planilha-cmv-margem';
$errorUrl = '/materiais/planilha-cmv-margem?erro=envio';

function clean_text($value, $maxLength = 300) {
    $value = trim($value);
    $value = strip_tags($value);
    $value = str_replace(array("\r", "\n"), ' ', $value);
    $value = preg_replace('/\s+/', ' ', $value);
    return substr($value, 0, $maxLength);
}

function redirect_to($url) {
    header('Location: ' . $url, true, 303);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo 'Endpoint ativo. Este arquivo deve receber dados via POST pelo formulario.';
    exit;
}

$honeypot = clean_text(isset($_POST['website']) ? $_POST['website'] : '');
if ($honeypot !== '') {
    redirect_to($successUrl);
}

$name = clean_text(isset($_POST['name']) ? $_POST['name'] : '', 120);
$email = filter_var(isset($_POST['email']) ? $_POST['email'] : '', FILTER_SANITIZE_EMAIL);
$whatsapp = clean_text(isset($_POST['whatsapp']) ? $_POST['whatsapp'] : '', 60);
$businessName = clean_text(isset($_POST['businessName']) ? $_POST['businessName'] : '', 160);
$businessSegment = clean_text(isset($_POST['businessSegment']) ? $_POST['businessSegment'] : '', 80);
$consent = clean_text(isset($_POST['consent']) ? $_POST['consent'] : '', 40);

$leadMagnet = clean_text(isset($_POST['leadMagnet']) ? $_POST['leadMagnet'] : '', 80);
$origin = clean_text(isset($_POST['origin']) ? $_POST['origin'] : '', 80);
$sourceArticle = clean_text(isset($_POST['sourceArticle']) ? $_POST['sourceArticle'] : '', 80);
$cta = clean_text(isset($_POST['cta']) ? $_POST['cta'] : '', 80);

$allowedSegments = array(
    'Restaurante',
    'Pizzaria',
    'Hamburgueria',
    'Cafeteria',
    'Confeitaria',
    'Bar',
    'Delivery',
    'Dark kitchen',
    'Outro'
);

if (
    $name === '' ||
    !$email ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    $businessName === '' ||
    !in_array($businessSegment, $allowedSegments) ||
    $consent !== 'accepted' ||
    $leadMagnet !== 'planilha-cmv-margem'
) {
    redirect_to('/materiais/planilha-cmv-margem?erro=validacao');
}

$dateTime = date('d/m/Y H:i:s');

$consentText = 'O usuario aceitou receber o material solicitado e comunicacoes da Thaise Franca por e-mail e, caso tenha informado WhatsApp, tambem por mensagem. O usuario foi informado de que pode cancelar o recebimento ou solicitar remocao dos dados pelo e-mail contato@athaisefranca.com.br.';

$subject = 'Novo lead - Planilha de CMV e Margem';

$body = "Novo lead capturado pelo Blog Food Service.\n\n";
$body .= "Nome:\n" . $name . "\n\n";
$body .= "E-mail:\n" . $email . "\n\n";
$body .= "WhatsApp:\n" . ($whatsapp !== '' ? $whatsapp : 'Nao informado') . "\n\n";
$body .= "Nome do negocio:\n" . $businessName . "\n\n";
$body .= "Segmento:\n" . $businessSegment . "\n\n";
$body .= "Material solicitado:\nPlanilha de CMV e Margem\n\n";
$body .= "Origem:\n" . ($origin !== '' ? $origin : 'blog') . "\n\n";
$body .= "Artigo de origem:\n" . ($sourceArticle !== '' ? $sourceArticle : 'cmv-restaurante') . "\n\n";
$body .= "CTA:\n" . ($cta !== '' ? $cta : 'cta-cmv-artigo-01') . "\n\n";
$body .= "Consentimento:\n" . $consentText . "\n\n";
$body .= "Data/hora:\n" . $dateTime . "\n";

$headers = array();
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-Type: text/plain; charset=UTF-8';
$headers[] = 'From: Blog Food Service <contato@athaisefranca.com.br>';
$headers[] = 'Reply-To: ' . $email;

$sent = mail($to, $subject, $body, implode("\r\n", $headers));

if (!$sent) {
    redirect_to('/materiais/planilha-cmv-margem?erro=envio');
}

redirect_to($successUrl);