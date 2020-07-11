# Activities


## Get ALL activities




> Example request:

```bash
curl -X GET \
    -G "http://clearprop.test/api/v1/activities" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://clearprop.test/api/v1/activities"
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
 **`api/v1/activities`**



## Create activities




> Example request:

```bash
curl -X POST \
    "http://clearprop.test/api/v1/activities" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"user_id":16,"type_id":1,"split_cost":{},"plane_id":11,"event":"11.07.2020","counter_start":"sed","counter_stop":"aut","event_start":"10:48","event_stop":"10:48"}'

```

```javascript
const url = new URL(
    "http://clearprop.test/api/v1/activities"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "user_id": 16,
    "type_id": 1,
    "split_cost": {},
    "plane_id": 11,
    "event": "11.07.2020",
    "counter_start": "sed",
    "counter_stop": "aut",
    "event_start": "10:48",
    "event_stop": "10:48"
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
 **`api/v1/activities`**

<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<code><b>user_id</b></code>&nbsp; <small>integer</small>     <br>
    

<code><b>type_id</b></code>&nbsp; <small>integer</small>     <br>
    

<code><b>split_cost</b></code>&nbsp; <small>string</small>         <i>optional</i>    <br>
    

<code><b>plane_id</b></code>&nbsp; <small>integer</small>     <br>
    

<code><b>event</b></code>&nbsp; <small>string</small>     <br>
    The value must be a valid date in the format d.m.Y.

<code><b>counter_start</b></code>&nbsp; <small>string</small>     <br>
    

<code><b>counter_stop</b></code>&nbsp; <small>string</small>     <br>
    

<code><b>event_start</b></code>&nbsp; <small>string</small>         <i>optional</i>    <br>
    The value must be a valid date in the format H:i.

<code><b>event_stop</b></code>&nbsp; <small>string</small>         <i>optional</i>    <br>
    The value must be a valid date in the format H:i.



## Get activities by ID




> Example request:

```bash
curl -X GET \
    -G "http://clearprop.test/api/v1/activities/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://clearprop.test/api/v1/activities/1"
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
 **`api/v1/activities/{activity}`**



## Update activities




> Example request:

```bash
curl -X PUT \
    "http://clearprop.test/api/v1/activities/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"plane_id":9,"event":"11.07.2020","counter_start":"voluptatem","counter_stop":"hic","event_start":"10:48","event_stop":"10:48"}'

```

```javascript
const url = new URL(
    "http://clearprop.test/api/v1/activities/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "plane_id": 9,
    "event": "11.07.2020",
    "counter_start": "voluptatem",
    "counter_stop": "hic",
    "event_start": "10:48",
    "event_stop": "10:48"
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
 **`api/v1/activities/{activity}`**

<small class="badge badge-purple">PATCH</small>
 **`api/v1/activities/{activity}`**

<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<code><b>plane_id</b></code>&nbsp; <small>integer</small>     <br>
    

<code><b>event</b></code>&nbsp; <small>string</small>     <br>
    The value must be a valid date in the format d.m.Y.

<code><b>counter_start</b></code>&nbsp; <small>string</small>     <br>
    

<code><b>counter_stop</b></code>&nbsp; <small>string</small>     <br>
    

<code><b>event_start</b></code>&nbsp; <small>string</small>         <i>optional</i>    <br>
    The value must be a valid date in the format H:i.

<code><b>event_stop</b></code>&nbsp; <small>string</small>         <i>optional</i>    <br>
    The value must be a valid date in the format H:i.



## Delete activities by ID




> Example request:

```bash
curl -X DELETE \
    "http://clearprop.test/api/v1/activities/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://clearprop.test/api/v1/activities/1"
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
 **`api/v1/activities/{activity}`**




