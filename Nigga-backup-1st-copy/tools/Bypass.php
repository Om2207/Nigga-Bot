<?php
if (preg_match('/^(\/url|\.url|!url)/', $text)) {
    $SQL = "SELECT * FROM `users` WHERE `teleid`=".$userId;
    $CONSULTA = mysqli_query($con,$SQL);
    $f = mysqli_num_rows($CONSULTA);

    if($f > 0) {
        // User is registered
    } else {
        // User is not registered
        reply_tox($chatId,$message_id,$keyboard,"You are not registered. Register first with <code>/register</code> to use me.");
        exit; // Stop further execution
    }

    $url = substr($message, 5);

function getHttpStatus($url) {
    $headers = get_headers($url, 1);
    if ($headers !== false && isset($headers[0])) {
        return substr($headers[0], 9, 3);
    }
    return "Unknown";
}

// Function to check for captchas
function checkCaptcha($html) {
    $patterns = array(
        '/class=["\']g-recaptcha["\']/i', // reCAPTCHA v2
        '/class=["\']h-captcha["\']/i', // hCaptcha
        '/class=["\']grecaptcha-badge["\']/i', // reCAPTCHA badge
        '/id=["\']BDC_VCID_Container["\']/i', // BotDetect CAPTCHA
        '/class=["\']cf-captcha-container["\']/i', // Cloudflare CAPTCHA
        '/data-ray=["\']/i', // Cloudflare ray ID
        '/class=["\']rc-anchor["\']/i' // reCAPTCHA v3
    );

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $html)) {
            return "Yes";
        }
    }

    return "No";
}

// Function to check for payment gateways
function checkPaymentGateways($html) {
    $gateways = array(
        'Stripe' => 'Stripe',
        'Braintree' => 'Braintree',
        'Square' => 'Square',
        'PayPal' => 'PayPal',
        'Adyen' => 'Adyen',
        'SecurePay' => 'SecurePay',
        'WorldPay' => 'WorldPay',
        'AmazonPay' => 'AmazonPay',
        'ANZ eGate' => 'ANZ eGate',
        '2Checkout' => '2Checkout',
        'Sage Pay' => 'Sage Pay',
        // Add more payment gateways as needed
    );

    $foundGateways = array();
    foreach ($gateways as $key => $gateway) {
        if (stripos($html, $gateway) !== false) {
            $foundGateways[] = $key;
        }
    }

    // Add Braintree specific pattern
    if (preg_match('/class=["\']braintree["\']/i', $html)) {
        $foundGateways[] = 'Braintree';
    }

    if (!empty($foundGateways)) {
        return implode(", ", $foundGateways);
    }
    return "None";
}

// Function to check for donate option
function checkDonateOption($html) {
    if (
        strpos($html, 'donate') !== false ||
        strpos($html, 'Donate') !== false ||
        strpos($html, 'donation') !== false ||
        strpos($html, 'Donation') !== false ||
        strpos($html, 'support') !== false ||
        strpos($html, 'Support') !== false
    ) {
        return "Yes";
    }
    return "No";
}

// Function to check for order system
function checkOrderSystem($html) {
    if (
        strpos($html, 'checkout') !== false ||
        strpos($html, 'order') !== false ||
        strpos($html, 'Order') !== false
    ) {
        return "Yes";
    }
    return "No";
}

// Fetch the HTML content of the webpage
$html = file_get_contents($url);

// Check for Cloudflare challenge page
if (strpos($html, 'Attention Required! | Cloudflare') !== false) {
    echo "This site is protected by Cloudflare.";
    // Additional logic to handle Cloudflare's challenge page if needed
} else {
    // Check for captchas
    $captcha = checkCaptcha($html);

    // Check for payment gateways
    $gateways = checkPaymentGateways($html);

    // Check for donate option
    $donateOption = checkDonateOption($html);

    // Check for order system
    $orderSystem = checkOrderSystem($html);

    // Get HTTP status code
    $httpStatus = getHttpStatus($url);

    // Output the results
    /*
    echo "Captcha: " . $captcha . "<br>";
    echo "Gateways: " . $gateways . "<br>";
    echo "Donate Option: " . $donateOption . "<br>";
    echo "Order System: " . $orderSystem . "<br>";
    echo "HTTP Status Code: " . $httpStatus;
    */
}
if ($html === false) {
    // Error handling if the content retrieval fails
    echo "Failed to retrieve content.";
} else {
    $dom = new DOMDocument();
    @$dom->loadHTML($html); // Suppress errors for invalid HTML
    $links = $dom->getElementsByTagName('a');

    $donatePageUrl = '';

    // Iterate through all <a> tags to find the donate page link
    foreach ($links as $link) {
        if (strpos($link->getAttribute('href'), 'donate') !== false) {
            // If the href contains 'donate', consider it as the donate page link
            $donatePageUrl = $link->getAttribute('href');
            break;
        }
    }

    if (!empty($donatePageUrl)) {
    //    echo "The donation page link is: $donatePageUrl";
    } else {
    //    echo "Donation page link not found.";
    }
}
if(!empty($donatePageUrl))
{
    // Construct response
$respo = urlencode("
    <b>
°°°°°°°°[SITE CHECKER]°°°°°°°°°°
<b>[★] SITE 🔥: $url </b>
<b>[★] CAPTCHA 🔥: $captcha </b>
<b>[★] GATEWAY 🔥: $gateways </b>
<b>[★] Donate Option: $donateOption </b>
<b>[★] Donate link: $donatePageUrl </b>
<b>[★] Order System: $orderSystem </b>
<b>[★] HTTP Status Code: $httpStatus </b>
<b>[★] CHECKED BY: @$username [$role] </b>
<b>[★] BOT BY: $owner </b>
°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    </b>");
    }else{
    $respo = urlencode("
    <b>
°°°°°°°°[SITE CHECKER]°°°°°°°°°°
<b>[★] SITE 🔥: $url </b>
<b>[★] CAPTCHA 🔥: $captcha </b>
<b>[★] GATEWAY 🔥: $gateways </b>
<b>[★] Donate Option: No </b>
<b>[★] Order System: $orderSystem </b>
<b>[★] HTTP Status Code: $httpStatus </b>
<b>[★] CHECKED BY: @$username [$role] </b>
<b>[★] BOT BY: $owner </b>
°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    </b>");
    }

    sendMessage($chatId,$respo,$message_id);
}
?>
