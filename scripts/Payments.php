<?php
//general configuration for payments
$paypalConfig = [
    'email' => 'topChoiceAuctions@gmail.com',
    'return_url' => 'http://example.com/payment-successful.html',
    'cancel_url' => 'http://example.com/payment-cancelled.html',
    'notify_url' => 'http://example.com/payments.php'
];

//leaving this as a test item for the time being
$paypalUrl = $enableSandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
$itemName = 'Test Item';
$itemAmount = 5.00;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("DBConnection.php");


public class Payments extends DBConnection{
    public function __construct(){
        $enableSandbox = true;
    }

}


/**
if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])) {

$data = [];
foreach ($_POST as $key => $value) {
$data[$key] = stripslashes($value);
}
//selecting our Paypal account
$data['business'] = $paypalConfig['email'];
// Selecting the PayPal return addresses.
$data['return'] = stripslashes($paypalConfig['return_url']);
$data['cancel_return'] = stripslashes($paypalConfig['cancel_url']);
$data['notify_url'] = stripslashes($paypalConfig['notify_url']);

$data['item_name'] = $itemName;
$data['amount'] = $itemAmount;
$data['currency_code'] = 'EUR';

$queryString = http_build_query($data);
// Redirect to paypal IPN
header('location:' . $paypalUrl . '?' . $queryString);
exit();
} else {

// Creating a connection to the database.
$db = new mysqli($dbConfig['host'], $dbConfig['username'], $dbConfig['password'], $dbConfig['name']);

$data = [
'item_name' => $_POST['item_name'],
'item_number' => $_POST['item_number'],
'payment_status' => $_POST['payment_status'],
'payment_amount' => $_POST['mc_gross'],
'payment_currency' => $_POST['mc_currency'],
'txn_id' => $_POST['txn_id'],
'receiver_email' => $_POST['receiver_email'],
'payer_email' => $_POST['payer_email'],
'custom' => $_POST['custom'],
];

if (verifyTransaction($_POST) && checkTxnid($data['txn_id'])) {
if (addPayment($data) !== false) {
// Payment successfully added.
}
}
}


<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="3EGWGBXYZZSUL">
<table>
<tr><td><input type="hidden" name="on0" value="Colours">Colours</td></tr><tr><td><select name="os0">
<option value="Space Grey">Space Grey €650.00 EUR</option>
<option value="Rose Gold">Rose Gold €675.00 EUR</option>
<option value="Black">Black €650.00 EUR</option>
<option value="White">White €625.00 EUR</option>
</select> </td></tr>
</table>
<input type="hidden" name="currency_code" value="EUR">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

 */