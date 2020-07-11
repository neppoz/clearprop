# Users


## Get ALL users




> Example request:

```bash
curl -X GET \
    -G "http://clearprop.test/api/v1/users" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://clearprop.test/api/v1/users"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### Request
<small class="badge badge-green">GET</small>
 **`api/v1/users`**



## Create users




> Example request:

```bash
curl -X POST \
    "http://clearprop.test/api/v1/users" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"veritatis","email":"quis","password":"natus","factor_id":5,"medical_due":"11.07.2020","roles":[14],"lang":"doloremque"}'

```

```javascript
const url = new URL(
    "http://clearprop.test/api/v1/users"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "veritatis",
    "email": "quis",
    "password": "natus",
    "factor_id": 5,
    "medical_due": "11.07.2020",
    "roles": [
        14
    ],
    "lang": "doloremque"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### Request
<small class="badge badge-black">POST</small>
 **`api/v1/users`**

<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<code><b>name</b></code>&nbsp; <small>string</small>     <br>
    

<code><b>email</b></code>&nbsp; <small>string</small>     <br>
    

<code><b>password</b></code>&nbsp; <small>string</small>     <br>
    

<code><b>factor_id</b></code>&nbsp; <small>integer</small>     <br>
    

<code><b>medical_due</b></code>&nbsp; <small>string</small>         <i>optional</i>    <br>
    The value must be a valid date in the format d.m.Y.

<code><b>roles</b></code>&nbsp; <small>array</small>     <br>
    

<code><b>lang</b></code>&nbsp; <small>string</small>     <br>
    

<code><b>roles.*</b></code>&nbsp; <small>integer</small>         <i>optional</i>    <br>
    



## Get users by ID




> Example request:

```bash
curl -X GET \
    -G "http://clearprop.test/api/v1/users/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://clearprop.test/api/v1/users/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### Request
<small class="badge badge-green">GET</small>
 **`api/v1/users/{user}`**



## Update users




> Example request:

```bash
curl -X PUT \
    "http://clearprop.test/api/v1/users/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"ipsa","email":"consequatur","factor_id":10,"medical_due":"11.07.2020","roles":[19],"lang":"quasi"}'

```

```javascript
const url = new URL(
    "http://clearprop.test/api/v1/users/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "ipsa",
    "email": "consequatur",
    "factor_id": 10,
    "medical_due": "11.07.2020",
    "roles": [
        19
    ],
    "lang": "quasi"
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### Request
<small class="badge badge-darkblue">PUT</small>
 **`api/v1/users/{user}`**

<small class="badge badge-purple">PATCH</small>
 **`api/v1/users/{user}`**

<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<code><b>name</b></code>&nbsp; <small>string</small>     <br>
    

<code><b>email</b></code>&nbsp; <small>string</small>     <br>
    

<code><b>factor_id</b></code>&nbsp; <small>integer</small>     <br>
    

<code><b>medical_due</b></code>&nbsp; <small>string</small>         <i>optional</i>    <br>
    The value must be a valid date in the format d.m.Y.

<code><b>roles</b></code>&nbsp; <small>array</small>     <br>
    

<code><b>lang</b></code>&nbsp; <small>string</small>     <br>
    

<code><b>roles.*</b></code>&nbsp; <small>integer</small>         <i>optional</i>    <br>
    



## Delete user by ID




> Example request:

```bash
curl -X DELETE \
    "http://clearprop.test/api/v1/users/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://clearprop.test/api/v1/users/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### Request
<small class="badge badge-red">DELETE</small>
 **`api/v1/users/{user}`**




