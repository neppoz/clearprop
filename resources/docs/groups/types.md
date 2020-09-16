# Types


## Get ALL types

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://dev.clearprop.test/api/v1/types"
);

let headers = {
    "Authorization": "Bearer 1cEP3Va5k6h4Zf8Ddb6eavg",
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://dev.clearprop.test/api/v1/types',
    [
        'headers' => [
            'Authorization' => 'Bearer 1cEP3Va5k6h4Zf8Ddb6eavg',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (200):

```json
{
    "data": [
        {
            "name": "Volo locale",
            "instructor": 0,
            "active": 1
        },
        {
            "name": "Volo trasferta",
            "instructor": 0,
            "active": 1
        },
        {
            "name": "Volo per il club",
            "instructor": 0,
            "active": 1
        },
        {
            "name": "Manutenzione",
            "instructor": 0,
            "active": 1
        },
        {
            "name": "Volo locale con istruttore",
            "instructor": 1,
            "active": 1
        },
        {
            "name": "Volo trasferta con istruttore",
            "instructor": 1,
            "active": 1
        }
    ]
}
```

### Request
<small class="badge badge-green">GET</small>
 **`api/v1/types`**



## Create types

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://dev.clearprop.test/api/v1/types"
);

let headers = {
    "Authorization": "Bearer edc1fk63DvV6E4bZ8Paa5hg",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "consequatur",
    "instructor": "ullam",
    "active": "perspiciatis"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://dev.clearprop.test/api/v1/types',
    [
        'headers' => [
            'Authorization' => 'Bearer edc1fk63DvV6E4bZ8Paa5hg',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'consequatur',
            'instructor' => 'ullam',
            'active' => 'perspiciatis',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### Request
<small class="badge badge-black">POST</small>
 **`api/v1/types`**

<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<code><b>name</b></code>&nbsp; <small>string</small>     <br>
    

<code><b>instructor</b></code>&nbsp; <small>string</small>     <br>
    

<code><b>active</b></code>&nbsp; <small>string</small>     <br>
    



## Get type by ID

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://dev.clearprop.test/api/v1/types/1"
);

let headers = {
    "Authorization": "Bearer P1ga6ZDe3E8f56vabdVh4kc",
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://dev.clearprop.test/api/v1/types/1',
    [
        'headers' => [
            'Authorization' => 'Bearer P1ga6ZDe3E8f56vabdVh4kc',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (200):

```json
{
    "data": {
        "name": "Volo locale",
        "instructor": 0,
        "active": 1
    }
}
```

### Request
<small class="badge badge-green">GET</small>
 **`api/v1/types/{type}`**



## Update types

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://dev.clearprop.test/api/v1/types/1"
);

let headers = {
    "Authorization": "Bearer 8Vv6bDE5ckdP4613faZhgea",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "minima",
    "instructor": "asperiores",
    "active": "aut"
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'http://dev.clearprop.test/api/v1/types/1',
    [
        'headers' => [
            'Authorization' => 'Bearer 8Vv6bDE5ckdP4613faZhgea',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'minima',
            'instructor' => 'asperiores',
            'active' => 'aut',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
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

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://dev.clearprop.test/api/v1/types/1"
);

let headers = {
    "Authorization": "Bearer a63Zvech5fEd6D4gaVkP81b",
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

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'http://dev.clearprop.test/api/v1/types/1',
    [
        'headers' => [
            'Authorization' => 'Bearer a63Zvech5fEd6D4gaVkP81b',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### Request
<small class="badge badge-red">DELETE</small>
 **`api/v1/types/{type}`**




