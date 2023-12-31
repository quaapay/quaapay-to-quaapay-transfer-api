import 'dart:convert';
import 'package:http/http.dart' as http;


/*
  dependencies:
    http: ^0.14.0
*/


void main() async {
  // Setting up post fields data
  String gmail = "yourgmail@gmail.com"; // Your account gmail
  String password = "yourpassword"; // Your account password
  String receiver = "receivergmail"; // Receiver Gmail
  String amount = "0"; // Amount to send out
  String walletIds = "yourproductkey"; // Your account product key

  // Transfer API endpoint
  String url = 'https://api.quaapay.ng/v1/transfer/';

  // Header setup
  Map<String, String> header = {
    "Authorization": "youraccesskey", // Your authorization key (product key)
    "Content-Type": "application/json"
  };

  // Postfields setup for quaapay transfers
  /*
    "type" => "inapp-transfer" - Carry out transactions from one quaapay account to another 
    "type" => "bank-transfer" - Carry out transactions from one quaapay account to a local bank account
  */
  Map<String, dynamic> postfields = {
    "type": "inapp-transfer",
    "gmail": gmail,
    "password": password,
    "amount": amount,
    "id": walletIds,
    "receiver": receiver,
    "message": "here is money for my sisters wedding and preparations take good care of everything. Thank you"
  };

  // Make the POST request
  var response = await http.post(
    Uri.parse(url),
    headers: header,
    body: jsonEncode(postfields),
  );

  // Decode response
  var decodedResponse = jsonDecode(response.body);

  // Error handling
  if (decodedResponse["status"] == "error") {
    print("An error occurred");
  } else if (decodedResponse["status"] == "success") {
    print("Transaction successful");
  } else if (decodedResponse["status"] == "reversed") {
    print("Transaction reversed");
  } else {
    print("Transaction failed");
  }
}
