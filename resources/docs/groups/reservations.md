# Reservations


## Get ALL reservations




> Example request:

```bash
curl -X GET \
    -G "http://clearprop.test/api/v1/bookings" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://clearprop.test/api/v1/bookings"
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
 **`api/v1/bookings`**



## Create reservations




> Example request:

```bash
curl -X POST \
    "http://clearprop.test/api/v1/bookings" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"user_id":12,"plane_id":20,"reservation_start":"11.07.2020 10:48","reservation_stop":"11.07.2020 10:48"}'

```

```javascript
const url = new URL(
    "http://clearprop.test/api/v1/bookings"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "user_id": 12,
    "plane_id": 20,
    "reservation_start": "11.07.2020 10:48",
    "reservation_stop": "11.07.2020 10:48"
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
 **`api/v1/bookings`**

<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<code><b>user_id</b></code>&nbsp; <small>integer</small>     <br>
    

<code><b>plane_id</b></code>&nbsp; <small>integer</small>     <br>
    

<code><b>reservation_start</b></code>&nbsp; <small>string</small>     <br>
    The value must be a valid date in the format d.m.Y H:i.

<code><b>reservation_stop</b></code>&nbsp; <small>string</small>     <br>
    The value must be a valid date in the format d.m.Y H:i.



## Get reservation by ID




> Example request:

```bash
curl -X GET \
    -G "http://clearprop.test/api/v1/bookings/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://clearprop.test/api/v1/bookings/1"
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
 **`api/v1/bookings/{booking}`**



## Update reservations




> Example request:

```bash
curl -X PUT \
    "http://clearprop.test/api/v1/bookings/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"user_id":17,"plane_id":3,"reservation_start":"11.07.2020 10:48","reservation_stop":"11.07.2020 10:48"}'

```

```javascript
const url = new URL(
    "http://clearprop.test/api/v1/bookings/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "user_id": 17,
    "plane_id": 3,
    "reservation_start": "11.07.2020 10:48",
    "reservation_stop": "11.07.2020 10:48"
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
 **`api/v1/bookings/{booking}`**

<small class="badge badge-purple">PATCH</small>
 **`api/v1/bookings/{booking}`**

<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<code><b>user_id</b></code>&nbsp; <small>integer</small>     <br>
    

<code><b>plane_id</b></code>&nbsp; <small>integer</small>     <br>
    

<code><b>reservation_start</b></code>&nbsp; <small>string</small>     <br>
    The value must be a valid date in the format d.m.Y H:i.

<code><b>reservation_stop</b></code>&nbsp; <small>string</small>     <br>
    The value must be a valid date in the format d.m.Y H:i.



## Delete reservation by ID




> Example request:

```bash
curl -X DELETE \
    "http://clearprop.test/api/v1/bookings/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://clearprop.test/api/v1/bookings/1"
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
 **`api/v1/bookings/{booking}`**




