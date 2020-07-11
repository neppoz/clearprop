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
    -d '{"name":"qui","email":"omnis","password":"omnis","factor_id":6,"medical_due":"11.07.2020","roles":[20],"lang":"laborum"}'

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
    "name": "qui",
    "email": "omnis",
    "password": "omnis",
    "factor_id": 6,
    "medical_due": "11.07.2020",
    "roles": [
        20
    ],
    "lang": "laborum"
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
    -d '{"name":"commodi","email":"doloribus","factor_id":4,"medical_due":"11.07.2020","roles":[13],"lang":"rerum"}'

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
    "name": "commodi",
    "email": "doloribus",
    "factor_id": 4,
    "medical_due": "11.07.2020",
    "roles": [
        13
    ],
    "lang": "rerum"
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




