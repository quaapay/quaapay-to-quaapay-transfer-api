import requests
import json

"""
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
"""

# Setting up post fields data
gmail = "yourgmail@gmail.com"  # Your account gmail
password = "yourpassword"  # Your account password
receiver = "receivergmail"  # Receiver Gmail
amount = "0"  # Amount to send out
wallet_ids = "yourproductkey"  # Your account product key

# Transfer API endpoint
url = 'https://api.quaapay.ng/v1/transfer/'

# Header setup
header = {
    "Authorization": "youraccesskey",  # Your authorization key (product key)
    "Content-Type": "application/json"
}

# Postfields setup for quaapay transfers
"""
  "type" => "inapp-transfer" - Carry out transactions from one quaapay account to another 
  "type" => "bank-transfer" - Carry out transactions from one quaapay account to a local bank account
"""
postfields = {
    "type": "inapp-transfer",
    "gmail": gmail,
    "password": password,
    "amount": amount,
    "id": wallet_ids,
    "receiver": receiver,
    "message": "here is money for my sisters weeding and preparations take good care of everything. Thank you"
}

# Execute the POST request using requests library
response = requests.post(url, headers=header, data=json.dumps(postfields))

# Decode response
decoded_response = response.json()

# Error handling
if decoded_response["status"] == "error":
    print("An error occurred")
elif decoded_response["status"] == "success":
    print("Transaction successful")
elif decoded_response["status"] == "reversed":
    print("Transaction reversed")
else:
    print("Transaction failed")
