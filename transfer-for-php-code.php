<?php 
/* 
    AML REGULATORY SYSTEM
    ---------------------
    To safeguard against money laundering activities within our application, we've implemented 
    Anti-Money Laundering (AML) Regulations that rigorously monitor and control all transactions.

    Key Features:
        
    1. Account Balance Limits: These limits restrict the maximum amount that can be deposited 
       into your account at once. If the set limit is exceeded, your account will be investigated 
       and reported to the appropriate authorities. We reserve the right to suspend or deactivate 
       your account.

    2. Daily Transaction Limits: Each account is assigned a daily transaction cap. This measure 
       helps prevent misuse of our app for illicit financial activities.

    3. Expiry Date Monitoring: This feature tracks the expiry of daily transaction limits, ensuring 
       compliance with the assigned time frame.
*/
  

# Setting up post fields data
$gmail = "yourgmail@gmail.com"; // Your account gmail
$pass = "yourpassword"; // Your account password
$receiver = "receivergmail"; // Receiver Gmail
$amount = "0"; // Amount to send out
$walletIds = "yourproductkey"; // Your account product key

# Transfer API endpoint
$url = 'https://api.quaapay.ng/v1/transfer/';

# Header setup
$header = [
    "Authorization: youraccesskey", // Your authorization key (product key)
    "Content-Type: application/json"
];

# Postfields setup for quaapay transfers
/*
  "type" => "inapp-transfer" - Carry out transactions from one quaapay account to another 
  "type" => "bank-transfer" - Carry out transactions from one quaapay account to a local bank account
*/
$postfields = [
    "type" => "inapp-transfer",
    "gmail" => $gmail,
    "password" => $pass,
    "amount" => $amount,
    "id" => $walletIds,
    "receiver" => $receiver,
    "message" => "here is money for my sisters weeding and preparations take good care of everything. Thank you"
];

# Initialize cURL session
$ch = curl_init();

# Set cURL options for POST request
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postfields));

# Execute cURL session and fetch response
$response = curl_exec($ch);
$decodedResponse = json_decode($response, true);

# Error handling
if ($decodedResponse["status"] == "error"){
  echo "An error occurred";
} else if($decodedResponse["status"] == "success"){
   echo "Transaction successful";
} else if($decodedResponse["status"] == "reversed"){
  echo "Transaction reversed";
} else {
  echo "Transaction failed";
}

# Close cURL session
curl_close($ch);
?>

<!-- Explanation of response statuses -->

<!--
    Transaction success messages:

    {
        "status" => "success",
        "currency" => "USD",
        "trackingid" => "4737x..",
        "date" => "30 Jan.."
    }

    Note: 
    The trackingId helps us easily track payments. The receiver and sender share the same tracking ID in their transaction history, facilitating tracking for payment failures.
-->

<!--
    Transaction Reversed messages:

    {
        "status" => "reversed",
        "currency" => "USD",
        "trackingid" => "4737x.."
    }

    Note: 
    This usually occurs due to issues during transactions, often from our servers, leading to a quick reversal of customer funds.
-->

<!--
    Return error messages from the server:

    {
        ... // Other error messages and explanations go here

      1. {"status" => "error", "message" => "invalid request"}: This indicates that the API request URI is either invalid or the request itself isn't a POST request.
      
      2. {"status" => "error", "message" => "invalid authorization key"}: This signifies that the authorization key, which acts as your product key, either doesn't exist or is incorrect.
      
      3. {"status" => "error", "message" => "connection failed"}: This mostly happens due to poor internet connections. It ensures safe money transfer and protects against potential glitches arising from network issues.
      
      4. {"status" => "error", "message" => "server timeout"}: The set time for each request is automatically 30 seconds (maximum 1 minute). Whenever your request's loading time exceeds this limit, the request is canceled, and this error message is returned.
      
      5. {"status" => "error", "message" => "invalid postfield data"}: This means the data required to fulfill your request is incomplete.
      
      6. {"status" => "error", "message" => "invalid amount"}: This often occurs when the provided amount contains non-accepted characters, such as alphabets. This error message could also be a result of embedded SQL injections or incorrect input.
      
      7. {"status" => "error", "message" => "invalid wallet ID"}: Similar to the issue with an invalid amount.
      
      8. {"status" => "error", "message" => "invalid Gmail address"}: This indicates that the Gmail address provided for your account is incorrect, either missing '@gmail.com' or containing SQL injection characters that are prohibited by our server to safeguard users' money.
      
      9. {"status" => "error", "message" => "internal error"}: Rarely seen, this error is reported when an issue originates directly from our server.
      
      10. {"status" => "error", "message" => "invalid user"}: This occurs only when the user's Gmail and password combination is incorrect. It automatically checks both credentials, and if either is incorrect, it logs the message 'invalid user.'
      
      11. {"status" => "error", "message" => "invalid payout methods"}: This happens when the specified $type doesn't match the provided transfer methods, which are inapp-transfer and bank-transfer.
      
      12. {"status" => "error", "message" => "invalid receiver"}: This means the receiver's Gmail address doesn't exist on our server.
      
      13. {"status" => "error", "message" => "message too long"}: Messages accompanying transactions should be shorter than 87 characters. This message indicates that the provided message exceeds the allowed length.
      
      14. {"status" => "error", "message" => "invalid receiver Gmail"}: This indicates that the receiver's Gmail address violates our Gmail rules, either by missing '@gmail.com' or containing unwanted characters.
      
      15. {"status" => "error", "message" => "transaction terminated"}: This rarely happens and is mostly due to our server detecting suspicious activity or an inability to verify critical details of the sender or receiver, resulting in an immediate error return.
      
      16. {"status" => "error", "message" => "currency mismatch"}: This occurs when attempting to send one currency to a Quaapay user who doesn't use the same currency. It's advisable to transact in the same currency, such as NGN to NGN or USD to USD.
      
      17. {"status" => "error", "message" => "amount higher than limit"}: This occurs when the amount you're trying to send exceeds the daily limit set for your account.
      
      18. {"status" => "error", "message" => "daily limit reached"}: This mostly occurs when you've sent funds and reached your daily limit until the next day when you can send again.

    }
-->

