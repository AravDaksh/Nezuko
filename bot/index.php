<?php

include __DIR__ . '/../hosting.php';

$botToken = '7611362260:AAEmp1VMosGD2BcU7Ar7_DMLnUG0gWKH0q4';
$botUrl = "$hosting/bot/index.php";

$input = json_decode(file_get_contents('php://input'), true);

// DEBUG: log raw and parsed input (temporary)
file_put_contents(__DIR__ . '/debug.log', date('Y-m-d H:i:s') . " RAW INPUT: " . file_get_contents('php://input') . "\n", FILE_APPEND);
file_put_contents(__DIR__ . '/debug.log', date('Y-m-d H:i:s') . " PARSED INPUT: " . var_export($input, true) . "\n", FILE_APPEND);

include('proxys.php');
require_once('functions.php');

$f_data = json_decode(file_get_contents(__DIR__ . '/data.json'), true);
if (!is_array($f_data)) {
    $f_data = ['premiuns' => [], 'groups' => [], 'antispam' => []];
}
// ensure keys exist
$f_data['premiuns'] = $f_data['premiuns'] ?? [];
$f_data['groups'] = $f_data['groups'] ?? [];
$f_data['antispam'] = $f_data['antispam'] ?? [];


if(isset($input['message'])){
	$user = $input['message']['from'];
	$chat = $input['message']['chat'];
	$msg = $input['message'];
}

$userlink = "<a href='tg://user?id=".$user['id'].">".$user['first_name']."</a>";

$admins = [
	'5032657924',
	'1205717709',
	'5435611792',
	'1649834075',
	'1297999372'
];
$isAdmin = in_array($user['id'], $admins);

$sellers = [
'5435611792',
'5362176219',
'6076355362',
'5162213041',
'5622648117',
'5928496674',
'1649834075',
'5113072048',
'5747095773',
'5494896535',
'5750586305',
'1824148738',
'1297999372'
];
$isSeller = in_array($user['id'], $sellers);

$isPremiun = in_array($user['id'] ?? null, $f_data['premiuns']);
$isGAppd   = in_array($chat['id'] ?? null, $f_data['groups']);


include('kbinline.php');

if(in_array($msg['text'], ['/start', '!start', '.start', '/cmds', '!cmds', '.cmds'])){
	output('sendVideo', array_merge([
'chat_id' => $chat['id'],
'video' => 'https://polito283.alwaysdata.net/video/1_5111912587285496600.mp4',
'reply_to_message_id'=> $msg['message_id']
	], $kb_s));
}

include('admins.php');
include('au.php');
include('key.php');
include('claim.php');
include('tools.php');
include('sk.php');
include('rnd.php');
include('rnd1.php');
include('rndp.php');
include('email.php');
include('email1.php');
include('auto.php');
include('itachi.php');//Braintree $3 2req
include('aktz.php');//Shopify avs
include('kyusuke.php');//Shopify + Chase
include('daibutsu.php');//Shopify + adyen
include('yahiko.php');//Shopify + Moneris
include('pain.php');//Shopify Avs $4.36
include('zetsu.php');//Shopify $18.93
include('hidan.php');//Shopify + Braintree $14.14
include('tobi.php');//Shopify + Braintree
include('obito.php');//Shopify + Moneris $9.85
include('sasori.php');//Shopify + Payeezy
include('kie.php');//Shopify + Payeezy
include('pp.php');//Paypal $0.01
include('pp1.php');//Paypal $1
include('kakuzu.php');//Braintree + vbv €7.94
include('konan.php');//Stripe Auth 4req
include('deidara.php');//Shopify auth

// Always return 200 JSON to Telegram
http_response_code(200);
header('Content-Type: application/json');
echo json_encode(['ok' => true]);


function output($method, $data){
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://api.telegram.org/bot'.$GLOBALS['botToken'].'/'.$method,
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => array_merge(['parse_mode' => 'HTML'], $data),
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_TIMEOUT => 10,
    ]);
    $result = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    // Log result and any error for debugging
    file_put_contents(__DIR__ . '/debug.log',
        date('Y-m-d H:i:s') . " OUT " . $method .
        " DATA: " . json_encode($data) .
        "\nRESULT: " . ($result ?? 'NULL') .
        "\nCURLERR: " . ($err ?: 'NONE') . "\n\n",
        FILE_APPEND
    );

    return json_decode($result, true);
}

