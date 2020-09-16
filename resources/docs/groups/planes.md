# Planes


## Get ALL planes

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://dev.clearprop.test/api/v1/planes"
);

let headers = {
    "Authorization": "Bearer egdPV3Ehb56acf6vDa18k4Z",
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
    'http://dev.clearprop.test/api/v1/planes',
    [
        'headers' => [
            'Authorization' => 'Bearer egdPV3Ehb56acf6vDa18k4Z',
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
            "callsign": "I-C001",
            "vendor": "ICP",
            "model": "Savannah S",
            "active": 1
        },
        {
            "callsign": "I-A918",
            "vendor": "Tecnam",
            "model": "P92 Eaglet",
            "active": 1
        }
    ]
}
```

### Request
<small class="badge badge-green">GET</small>
 **`api/v1/planes`**



## Create planes

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://dev.clearprop.test/api/v1/planes"
);

let headers = {
    "Authorization": "Bearer f3hE4vgke8Z6aD6aPcV5b1d",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "callsign": "dolor",
    "vendor": "perferendis",
    "counter_type": "quisquam"
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
    'http://dev.clearprop.test/api/v1/planes',
    [
        'headers' => [
            'Authorization' => 'Bearer f3hE4vgke8Z6aD6aPcV5b1d',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
        'json' => [
            'callsign' => 'dolor',
            'vendor' => 'perferendis',
            'counter_type' => 'quisquam',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### Request
<small class="badge badge-black">POST</small>
 **`api/v1/planes`**

<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<code><b>callsign</b></code>&nbsp; <small>string</small>     <br>
    

<code><b>vendor</b></code>&nbsp; <small>string</small>     <br>
    

<code><b>counter_type</b></code>&nbsp; <small>string</small>     <br>
    



## Get plane by ID

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://dev.clearprop.test/api/v1/planes/1"
);

let headers = {
    "Authorization": "Bearer 5k36ZahveDP8aE1Vc6fbg4d",
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
    'http://dev.clearprop.test/api/v1/planes/1',
    [
        'headers' => [
            'Authorization' => 'Bearer 5k36ZahveDP8aE1Vc6fbg4d',
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
        "callsign": "I-C001",
        "vendor": "ICP",
        "model": "Savannah S",
        "active": 1
    }
}
```

### Request
<small class="badge badge-green">GET</small>
 **`api/v1/planes/{plane}`**



## Update plane

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://dev.clearprop.test/api/v1/planes/1"
);

let headers = {
    "Authorization": "Bearer k6va5hcEPeaf13Z86DVdbg4",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "callsign": "enim",
    "vendor": "tempore",
    "counter_type": "ut"
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
    'http://dev.clearprop.test/api/v1/planes/1',
    [
        'headers' => [
            'Authorization' => 'Bearer k6va5hcEPeaf13Z86DVdbg4',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
        'json' => [
            'callsign' => 'enim',
            'vendor' => 'tempore',
            'counter_type' => 'ut',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
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

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://dev.clearprop.test/api/v1/planes/1"
);

let headers = {
    "Authorization": "Bearer Z5DkbadEe8h36416afVcgvP",
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
    'http://dev.clearprop.test/api/v1/planes/1',
    [
        'headers' => [
            'Authorization' => 'Bearer Z5DkbadEe8h36416afVcgvP',
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
 **`api/v1/planes/{plane}`**




