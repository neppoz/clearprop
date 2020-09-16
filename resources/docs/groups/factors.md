# Factors


## Get ALL factors

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://dev.clearprop.test/api/v1/factors"
);

let headers = {
    "Authorization": "Bearer 6akgZhd84V3fDace561bEPv",
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
    'http://dev.clearprop.test/api/v1/factors',
    [
        'headers' => [
            'Authorization' => 'Bearer 6akgZhd84V3fDace561bEPv',
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
            "id": 1,
            "name": "Premium",
            "description": null,
            "created_at": "2020-09-16T15:58:18.000000Z",
            "updated_at": "2020-09-16T15:58:18.000000Z",
            "deleted_at": null
        },
        {
            "id": 2,
            "name": "Standard",
            "description": null,
            "created_at": "2020-09-16T15:58:18.000000Z",
            "updated_at": "2020-09-16T15:58:18.000000Z",
            "deleted_at": null
        }
    ]
}
```

### Request
<small class="badge badge-green">GET</small>
 **`api/v1/factors`**



## Create factors

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://dev.clearprop.test/api/v1/factors"
);

let headers = {
    "Authorization": "Bearer a6gZV3DkPd6Eb8h4v1f5eac",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "provident"
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
    'http://dev.clearprop.test/api/v1/factors',
    [
        'headers' => [
            'Authorization' => 'Bearer a6gZV3DkPd6Eb8h4v1f5eac',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'provident',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### Request
<small class="badge badge-black">POST</small>
 **`api/v1/factors`**

<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<code><b>name</b></code>&nbsp; <small>string</small>     <br>
    



## Get factor by ID

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://dev.clearprop.test/api/v1/factors/1"
);

let headers = {
    "Authorization": "Bearer dhV8Zcgvak3EDfeb64651aP",
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
    'http://dev.clearprop.test/api/v1/factors/1',
    [
        'headers' => [
            'Authorization' => 'Bearer dhV8Zcgvak3EDfeb64651aP',
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
        "id": 1,
        "name": "Premium",
        "description": null,
        "created_at": "2020-09-16T15:58:18.000000Z",
        "updated_at": "2020-09-16T15:58:18.000000Z",
        "deleted_at": null
    }
}
```

### Request
<small class="badge badge-green">GET</small>
 **`api/v1/factors/{factor}`**



## Update factors

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://dev.clearprop.test/api/v1/factors/1"
);

let headers = {
    "Authorization": "Bearer fakgv3aVb51Zd6e4PcEDh68",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "quas"
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
    'http://dev.clearprop.test/api/v1/factors/1',
    [
        'headers' => [
            'Authorization' => 'Bearer fakgv3aVb51Zd6e4PcEDh68',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'quas',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### Request
<small class="badge badge-darkblue">PUT</small>
 **`api/v1/factors/{factor}`**

<small class="badge badge-purple">PATCH</small>
 **`api/v1/factors/{factor}`**

<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<code><b>name</b></code>&nbsp; <small>string</small>     <br>
    



## Delete factor by ID

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://dev.clearprop.test/api/v1/factors/1"
);

let headers = {
    "Authorization": "Bearer 6Zc61ha3a5Pfd4vk8EeDVbg",
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
    'http://dev.clearprop.test/api/v1/factors/1',
    [
        'headers' => [
            'Authorization' => 'Bearer 6Zc61ha3a5Pfd4vk8EeDVbg',
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
 **`api/v1/factors/{factor}`**




