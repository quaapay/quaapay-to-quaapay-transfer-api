// Setting up post fields data
const gmail = "yourgmail@gmail.com"; // Your account gmail
const password = "yourpassword"; // Your account password
const receiver = "receivergmail"; // Receiver Gmail
const amount = "0"; // Amount to send out
const walletIds = "yourproductkey"; // Your account product key

// Transfer API endpoint
const url = 'https://api.quaapay.ng/v1/transfer/';

// Header setup
const header = {
  "Authorization": "youraccesskey", // Your authorization key (product key)
  "Content-Type": "application/json"
};

// Postfields setup for quaapay transfers
/*
  "type" => "inapp-transfer" - Carry out transactions from one quaapay account to another 
  "type" => "bank-transfer" - Carry out transactions from one quaapay account to a local bank account
*/
const postfields = {
  "type": "inapp-transfer",
  "gmail": gmail,
  "password": password,
  "amount": amount,
  "id": walletIds,
  "receiver": receiver,
  "message": "here is money for my sisters wedding and preparations take good care of everything. Thank you"
};

// Make the POST request using fetch
fetch(url, {
  method: 'POST',
  headers: header,
  body: JSON.stringify(postfields)
})
.then(response => response.json())
.then(data => {
  // Error handling
  if (data.status === "error") {
    console.log("An error occurred");
  } else if (data.status === "success") {
    console.log("Transaction successful");
  } else if (data.status === "reversed") {
    console.log("Transaction reversed");
  } else {
    console.log("Transaction failed");
  }
})
.catch(error => {
  console.error('Error:', error);
});
