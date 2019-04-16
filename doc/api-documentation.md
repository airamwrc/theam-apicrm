# API documentation
In order to make a clearer documentation, we will assume we are working under the next domain

    http://apicrm.theam/

## Get client and secret id
The first step to use the API is request a client id and secret id

    URL: /createClient
    Type: POST
    Headers: 
        Content-Type: application/json
        Accept: application/json
    Body: 
      {
        "redirect-uri":"http://apicrm.theam/", 
        "grant-type":"password"
      }
    Response:
	  {
		“client_id":  "1_3f5n57nsnmio4skgcoo0s004g888k8k8k0skkc4wcw84o4cskc",
		"secret_id":  "uy1cl1hktg08wo04scgcs4800gk4cwocoggcccgoockg840ko"
	  }

## Get the access token
We need to request the access token

    URL: /oauth/v2/token
    Type: POST
    Headers: 
        Content-Type: application/json
        Accept: application/json
    Body: 
      {
          "client_id": "1_3f5n57nsnmio4skgcoo0s004g888k8k8k0skkc4wcw84o4cskc",
          "client_secret": "uy1cl1hktg08wo04scgcs4800gk4cwocoggcccgoockg840ko",
          "grant_type": "password",
          "username": "test_user",
          "password": "123456"
      }
    Response:
	  {
          "access_token": "YmY0ZTMyODEyYmQ5YTE4ZDYyZWU4YWZlODNjZjk3NzJmZDg3NzU4NTFlYmUyZDZlOTAyOTA1ODYwNmIzNWM0Yg",
          "expires_in": 86400,
          "token_type": "bearer",
          "scope": null,
          "refresh_token": "ZTk3OWI3OTE5MTgyZDc4NGEzYjJmYzkwNjE4ZjhiMzk0MjQ3ZjQzYTAyN2FjMjA1ODQ4MmQ0ZjdlY2Y5OTUzYg"
      }

Use the access token for the new requests. The token must be included in the Authorization header preceded by the <i>Bearer</i> word.

## Renew the access token

    URL: /oauth/v2/token
        Type: POST
        Headers: 
            Content-Type: application/x-www-form-urlencoded
            Accept: application/json
        Body: 
          {
              "client_id": "4_12fhz2snfxiosgkc8go4840cwo8oswkc4wg4kcok0ocgkwo0s4",
              "client_secret": "3df2ljlca1ic0cswkk8444k8s848w080kowc8gogskgssw4480",
              "grant_type": "refresh_token",
              "refresh_token": "YmMxZGYyNDBkMDg3ODViNDZkMmQ3YTQ5NGUzYWM1OTI2Y2NjYzhlNTVhYThmY2MxMDg2Zjg4YmRkMmRlNzQzMw"
          }
        Response:
    	  {
              "access_token": "ZDVlZmQ0ZjVjOWI1ZmQ4MGI1ZGFjZjkyN2ZkODFiNjQzYmU3OTI1ZmI4MGMwMmQwYTQyODAzMDcxNGFmNjM0ZA",
              "expires_in": 86400,
              "token_type": "bearer",
              "scope": null,
              "refresh_token": "OTJiNThmYWRiYjc3Yzk0MjhjOTY5MzBlNjQxODY3N2U4NWI0NTJmYTkwZTUxYWM3YmQ3ZTU0YjI4MjhjMmVmMg"
          }

## Get customers
    URL: api/v1/customer
    Type: GET
    Headers: 
        Content-Type: application/json
        Accept: application/json
        Authorization: Bearer MGVlZmY1MDQyY2FjN2FjNmE1YzczZTYwNTk0NmUzNmJmZDhiODgzYmZjODc4YzE2NTc4MzMwMjQ1N2MyMjIzNw
    Body: 
      
    Response:
	  [
          {
              "id": 17,
              "name": "Test4 Update Name",
              "surname": "Test Surname",
              "identificationNumber": "B78387872",
              "address": "c/ Custom Street, 8",
              "businessName": "My bussiness name",
              "tradeName": "My trade name",
              "contactName": "John Doe",
              "phone": "555 12 32 23",
              "phone2": "928 000 111",
              "notes": "Custom notes",
              "creator": {
                  "id": 1,
                  "username": "test_user",
                  "email": "test@user.com",
                  "name": "Test name",
                  "surname": "Test surname",
                  "created": "2019-04-01 21:10:05",
                  "updated": "2019-04-01 21:16:25"
              },
              "lastEditor": {
                  "id": 1,
                  "username": "test_user",
                  "email": "test@user.com",
                  "name": "Test name",
                  "surname": "Test surname",
                  "created": "2019-04-01 21:10:05",
                  "updated": "2019-04-01 21:16:25"
              },
              "created": "2019-04-12 11:07:53",
              "updated": "2019-04-12 12:15:17",
              "photoUrl": "http://apicrm.theam/api/v1/customer/photo/17"
          }
      ]
    
## Create customer
    URL: api/v1/customer
    Type: POST
    Headers: 
        Content-Type: application/json
        Accept: application/json
        Authorization: Bearer MGVlZmY1MDQyY2FjN2FjNmE1YzczZTYwNTk0NmUzNmJmZDhiODgzYmZjODc4YzE2NTc4MzMwMjQ1N2MyMjIzNw
    Body:
        {
            "name": "Test4 Update Name",
            "surname": "Test Surname",
            "identificationNumber": "B78387872",
            "address": "c/ Custom Street, 8",
            "businessName": "My bussiness name",
            "tradeName": "My trade name",
            "contactName": "John Doe",
            "phone": "555 12 32 23",
            "phone2": "928 000 111",
            "notes": "Custom notes"
        }
    Response:
        {
            "success": true,
            "customerId": 21
        }
    
## Upload photo customer
    URL: api/v1/customer/photo/21
    Type: POST
    Headers: 
        Content-Type: multipart/form-data
        Authorization: Bearer MGVlZmY1MDQyY2FjN2FjNmE1YzczZTYwNTk0NmUzNmJmZDhiODgzYmZjODc4YzE2NTc4MzMwMjQ1N2MyMjIzNw
    Body:
        The body will send a form with a field with name customer[imageFile] and its value is the image file to be uploaded.
    Response:
        {
            "success": true
        }
    
## Update customer
    URL: api/v1/customer/17
    Type: PUT
    Headers: 
        Content-Type: application/json
        Accept: application/json
        Authorization: Bearer MGVlZmY1MDQyY2FjN2FjNmE1YzczZTYwNTk0NmUzNmJmZDhiODgzYmZjODc4YzE2NTc4MzMwMjQ1N2MyMjIzNw
    Body:
        {
            "name": "Test4 Update Name",
            "surname": "Test Surname",
            "identificationNumber": "B78387872",
            "address": "c/ Custom Street, 8",
            "businessName": "My bussiness name",
            "tradeName": "My trade name",
            "contactName": "John Doe",
            "phone": "555 12 32 23",
            "phone2": "928 000 111",
            "notes": "Custom notes"
        }
    Response:
        {
            "success": true
        }
        
  > **Note:** Partial updates are allowed sending only the fields to be updated.

## Get customer photo
    URL: api/v1/customer/photo/17
    Type: GET
    Headers: 
        Authorization: Bearer MGVlZmY1MDQyY2FjN2FjNmE1YzczZTYwNTk0NmUzNmJmZDhiODgzYmZjODc4YzE2NTc4MzMwMjQ1N2MyMjIzNw
    Body:
        
    Response:
        An image file will be returned or 
        {
            "success": false,
            "errors": "No photo found"
        }
        
## Delete customer
    URL: api/v1/customer/7
    Type: DELETE
    Headers: 
        Content-Type: application/json
        Accept: application/json
        Authorization: Bearer MGVlZmY1MDQyY2FjN2FjNmE1YzczZTYwNTk0NmUzNmJmZDhiODgzYmZjODc4YzE2NTc4MzMwMjQ1N2MyMjIzNw
    Body:
        
    Response:
        {
            "success": true
        }

## Response for invalid customer
All request for an invalid customer will receive as response
    
    {
        "success": false,
        "errors": "Customer not found"
    }
    
## Response when errors handling the request
When a request can not be handled properly

    {
        "success": false,
        "errors": "Information about the errors"
    }

