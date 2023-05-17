const API = 'ZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6VXhNaUo5LmV5SnVZVzFsSWpvaWFXNXBkR2xoYkNJc0ltTnNZWE56SWpvaVRXVnlZMmhoYm5RaUxDSndjbTltYVd4bFgzQnJJam8yT1RRMU5UQjkuNldrWmJGdUwzVUQwcEpMei1fZ09CZ21NZ3BycV9mcDR2a1pldG9ZTV9KUnlONGpwcDZTcG1YYld5ZVhDZGkwelpFN2xUVzBJZEg1UFNDbmxyLXAwenc='

async function first() {
    let data = {
        "api_key" : API
    }

    let request = await fetch('https://accept.paymob.com/api/auth/tokens' , {
        method : 'post',
        headers : {'Content-Type' : 'application/json'} , 
        body : JSON.stringify(data)
    })

    let response = await request.json()

    let token = response.token

    second(token)
}



async function second(token) {
    let data = {
        "auth_token":  token,
        "delivery_needed": "false",
        "amount_cents": "100",
        "currency": "EGP",
        "items": [],
        }

    let request = await fetch(' https://accept.paymob.com/api/ecommerce/orders', {
        method : 'post',
        headers : {'Content-Type' : 'application/json'},
        body : JSON.stringify(data)
    })

    let response = await request.json()
    let id = response.id

    third(token, id)
}



async function third(token, id) {
    let data = {
        "auth_token": token,
        "amount_cents": "100", 
        "expiration": 3600, 
        "order_id": id,
        "billing_data": {
        "apartment": "803", 
        "email": "claudette09@exa.com", 
        "floor": "42", 
        "first_name": "Clifford", 
        "street": "Ethan Land", 
        "building": "8028", 
        "phone_number": "+86(8)9135210487", 
        "shipping_method": "PKG", 
        "postal_code": "01898", 
        "city": "Jaskolskiburgh", 
        "country": "CR", 
        "last_name": "Nicolas", 
        "state": "Utah"
        }, 
        "currency": "EGP", 
        "integration_id": 3790939
        }

    let request = await fetch('https://accept.paymob.com/api/acceptance/payment_keys', {
        method : 'post',
        headers : {'Content-Type' : 'application/json'},
        body : JSON.stringify(data)
    })

    let response = await request.json()

    console.log(response.token)
}

first()
