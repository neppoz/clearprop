# Planes


## Get ALL planes




> Example request:

```bash
curl -X GET \
    -G "http://clearprop.test/api/v1/planes" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://clearprop.test/api/v1/planes"
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
 **`api/v1/planes`**



## Create planes




> Example request:

```bash
curl -X POST \
    "http://clearprop.test/api/v1/planes" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"callsign":"autem","vendor":"sit","counter_type":"sed"}'

```

```javascript
const url = new URL(
    "http://clearprop.test/api/v1/planes"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "callsign": "autem",
    "vendor": "sit",
    "counter_type": "sed"
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
 **`api/v1/planes`**

<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<code><b>callsign</b></code>&nbsp; <small>string</small>     <br>
    

<code><b>vendor</b></code>&nbsp; <small>string</small>     <br>
    

<code><b>counter_type</b></code>&nbsp; <small>string</small>     <br>
    



## Get plane by ID




> Example request:

```bash
curl -X GET \
    -G "http://clearprop.test/api/v1/planes/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://clearprop.test/api/v1/planes/1"
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
 **`api/v1/planes/{plane}`**



## Update plane




> Example request:

```bash
curl -X PUT \
    "http://clearprop.test/api/v1/planes/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"callsign":"iste","vendor":"dolore","counter_type":"repellat"}'

```

```javascript
const url = new URL(
    "http://clearprop.test/api/v1/planes/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "callsign": "iste",
    "vendor": "dolore",
    "counter_type": "repellat"
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
 **`api/v1/planes/{plane}`**

<small class="badge badge-purple">PATCH</small>
 **`api/v1/planes/{plane}`**

<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<code><b>callsign</b></code>&nbsp; <small>string</small>     <br>
    

<code><b>vendor</b></code>&nbsp; <small>string</small>     <br>
    

<code><b>counter_type</b></code>&nbsp; <small>string</small>     <br>
    



## Delete plane by ID




> Example request:

```bash
curl -X DELETE \
    "http://clearprop.test/api/v1/planes/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://clearprop.test/api/v1/planes/1"
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
 **`api/v1/planes/{plane}`**




