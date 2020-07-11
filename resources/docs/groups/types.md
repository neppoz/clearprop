# Types


## Get ALL types




> Example request:

```bash
curl -X GET \
    -G "http://clearprop.test/api/v1/types" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://clearprop.test/api/v1/types"
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
 **`api/v1/types`**



## Create types




> Example request:

```bash
curl -X POST \
    "http://clearprop.test/api/v1/types" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"odio","instructor":"eius","active":"ducimus"}'

```

```javascript
const url = new URL(
    "http://clearprop.test/api/v1/types"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "odio",
    "instructor": "eius",
    "active": "ducimus"
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
 **`api/v1/types`**

<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<code><b>name</b></code>&nbsp; <small>string</small>     <br>
    

<code><b>instructor</b></code>&nbsp; <small>string</small>     <br>
    

<code><b>active</b></code>&nbsp; <small>string</small>     <br>
    



## Get type by ID




> Example request:

```bash
curl -X GET \
    -G "http://clearprop.test/api/v1/types/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://clearprop.test/api/v1/types/1"
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
 **`api/v1/types/{type}`**



## Update types




> Example request:

```bash
curl -X PUT \
    "http://clearprop.test/api/v1/types/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"velit","instructor":"quos","active":"labore"}'

```

```javascript
const url = new URL(
    "http://clearprop.test/api/v1/types/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "velit",
    "instructor": "quos",
    "active": "labore"
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
 **`api/v1/types/{type}`**

<small class="badge badge-purple">PATCH</small>
 **`api/v1/types/{type}`**

<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<code><b>name</b></code>&nbsp; <small>string</small>     <br>
    

<code><b>instructor</b></code>&nbsp; <small>string</small>     <br>
    

<code><b>active</b></code>&nbsp; <small>string</small>     <br>
    



## Delete type by ID




> Example request:

```bash
curl -X DELETE \
    "http://clearprop.test/api/v1/types/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://clearprop.test/api/v1/types/1"
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
 **`api/v1/types/{type}`**




