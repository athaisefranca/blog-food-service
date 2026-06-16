<?php
declare(strict_types=1);

$to = 'contato@athaisefranca.com.br';
$successUrl = '/obrigado/planilha-cmv-margem';
$errorUrl = '/materiais/planilha-cmv-margem?erro=envio';

function clean_text(string $value, int $maxLength = 300): string {
    $value = trim($value);
    $value = strip_tags($value);
    $value = str_replace(["\r", "\n"], ' ', $value);
    $value = preg_replace('/\s+/', ' ', $value);
    return substr($value, 0, $maxLength);
}

function redirect_to(string $url): void {
    header('Location: ' . $url, true, 303);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect_to($errorUrl);
}

$honeypot = clean_text($_POST['website'] ?? '');
if ($honeypot !== '') {
    redirect_to($successUrl);
}

$startedAt = isset($_POST['startedAt']) ? (int) $_POST['startedAt'] : 0;
if ($startedAt > 0) {
    $elapsedSeconds = time() - (int) floor($startedAt / 1000);
    if ($elapsedSeconds >= 0 && $elapsedSeconds < 3) {
        redirect_to($successUrl);
    }
}

$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$rateFile = sys_get_temp_dir() . '/lead_cmv_' . hash('sha256', $ip) . '.txt';

if (file_exists($rateFile) && (time() - filemtime($rateFile)) < 60) {
    redirect_to('/materiais/planilha-cmv-margem?erro=limite');
}

$name = clean_text($_POST['name'] ?? '', 120);
$email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
$whatsapp = clean_text($_POST['whatsapp'] ?? '', 60);
$businessName = clean_text($_POST['businessName'] ?? '', 160);
$businessSegment = clean_text($_POST['businessSegment'] ?? '', 80);
$consent = clean_text($_POST['consent'] ?? '', 40);

$leadMagnet = clean_text($_POST['leadMagnet'] ?? '', 80);
$origin = clean_text($_POST['origin'] ?? '', 80);
$sourceArticle = clean_text($_POST['sourceArticle'] ?? '', 80);
$cta = clean_text($_POST['cta'] ?? '', 80);

$allowedSegments = [
    'Restaurante',
    'Pizzaria',
    'Hamburgueria',
    'Cafeteria',
    'Confeitaria',
    'Bar',
    'Delivery',
    'Dark kitchen',
    'Outro',
];

if (
    $name === '' ||
    !$email ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    $businessName === '' ||
    !in_array($businessSegment, $allowedSegments, true) ||
    $consent !== 'accepted'
) {
    redirect_to('/materiais/planilha-cmv-margem?erro=validacao');
}

if ($leadMagnet !== 'planilha-cmv-margem') {
    redirect_to($errorUrl);
}

$dateTime = date('d/m/Y H:i:s');

$consentText = 'O usuário aceitou receber o material solicitado e comunicações da Thaise França por e-mail e, caso tenha informado WhatsApp, também por mensagem. O usuário foi informado de que pode cancelar o recebimento ou solicitar remoção dos dados pelo e-mail contato@athaisefranca.com.br.';

$subject = 'Novo lead — Planilha de CMV e Margem';
$encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';

$body = "Novo lead capturado pelo Blog Food Service.\n\n";
$body .= "Nome:\n{$name}\n\n";
$body .= "E-mail:\n{$email}\n\n";
$body .= "WhatsApp:\n" . ($whatsapp !== '' ? $whatsapp : 'Não informado') . "\n\n";
$body .= "Nome do negócio:\n{$businessName}\n\n";
$body .= "Segmento:\n{$businessSegment}\n\n";
$body .= "Material solicitado:\nPlanilha de CMV e Margem\n\n";
$body .= "Origem:\n" . ($origin !== '' ? $origin : 'blog') . "\n\n";
$body .= "Artigo de origem:\n" . ($sourceArticle !== '' ? $sourceArticle : 'cmv-restaurante') . "\n\n";
$body .= "CTA:\n" . ($cta !== '' ? $cta : 'cta-cmv-artigo-01') . "\n\n";
$body .= "Consentimento:\n{$consentText}\n\n";
$body .= "Data/hora:\n{$dateTime}\n\n";
$body .= "IP de envio:\n{$ip}\n";

$headers = [];
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-Type: text/plain; charset=UTF-8';
$headers[] = 'From: Blog Food Service <contato@athaisefranca.com.br>';
$headers[] = 'Reply-To: ' . $email;
$headers[] = 'X-Mailer: PHP/' . phpversion();

@mail($to, $encodedSubject, $body, implode("\r\n", $headers));

@file_put_contents($rateFile, (string) time());

redirect_to($successUrl);