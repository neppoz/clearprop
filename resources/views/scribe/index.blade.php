<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>API Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=PT+Sans&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset("vendor/scribe/css/style.css") }}" media="screen" />
        <link rel="stylesheet" href="{{ asset("vendor/scribe/css/print.css") }}" media="print" />
        <script src="{{ asset("vendor/scribe/js/all.js") }}"></script>

        <link rel="stylesheet" href="{{ asset("vendor/scribe/css/highlight-darcula.css") }}" media="" />
        <script src="{{ asset("vendor/scribe/js/highlight.pack.js") }}"></script>
    <script>hljs.initHighlightingOnLoad();</script>

</head>

<body class="" data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">
<a href="#" id="nav-button">
      <span>
        NAV
            <img src="{{ asset("vendor/scribe/images/navbar.png") }}" alt="-image" class=""/>
      </span>
</a>
<div class="tocify-wrapper">
                <div class="lang-selector">
                            <a href="#" data-language-name="bash">bash</a>
                            <a href="#" data-language-name="javascript">javascript</a>
                    </div>
        <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>
    <ul class="search-results"></ul>

    <ul id="toc">
    </ul>

            <ul class="toc-footer" id="toc-footer">
                            <li><a href="{{ route("scribe.json") }}">View Postman Collection</a></li>
                            <li><a href='http://github.com/knuckleswtf/scribe'>Documentation powered by Scribe ✍</a></li>
                    </ul>
            <ul class="toc-footer" id="last-updated">
            <li>Last updated: July 11 2020</li>
        </ul>
</div>
<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1>Introduction</h1>
<p>Welcome to our ClearProp API documentation!</p>
<aside>As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile), and you can switch the programming language of the examples with the tabs in the top right (or from the nav menu at the top left on mobile).</aside><h1>Authenticating requests</h1>
<p>This API is not authenticated.</p><h1>Activities</h1>
<h2>Get ALL activities</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://clearprop.test/api/v1/activities" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (401):</p>
</blockquote>
<pre><code class="language-json">{
    "message": "Unauthenticated."
}</code></pre>
<h3>Request</h3>
<p><small class="badge badge-green">GET</small>
<strong><code>api/v1/activities</code></strong></p>
<h2>Create activities</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://clearprop.test/api/v1/activities" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"user_id":16,"type_id":1,"split_cost":{},"plane_id":11,"event":"11.07.2020","counter_start":"sed","counter_stop":"aut","event_start":"10:48","event_stop":"10:48"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>Request</h3>
<p><small class="badge badge-black">POST</small>
<strong><code>api/v1/activities</code></strong></p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p><code><b>user_id</b></code>&nbsp; <small>integer</small>     <br></p>
<p><code><b>type_id</b></code>&nbsp; <small>integer</small>     <br></p>
<p><code><b>split_cost</b></code>&nbsp; <small>string</small>         <i>optional</i>    <br></p>
<p><code><b>plane_id</b></code>&nbsp; <small>integer</small>     <br></p>
<p><code><b>event</b></code>&nbsp; <small>string</small>     <br>
The value must be a valid date in the format d.m.Y.</p>
<p><code><b>counter_start</b></code>&nbsp; <small>string</small>     <br></p>
<p><code><b>counter_stop</b></code>&nbsp; <small>string</small>     <br></p>
<p><code><b>event_start</b></code>&nbsp; <small>string</small>         <i>optional</i>    <br>
The value must be a valid date in the format H:i.</p>
<p><code><b>event_stop</b></code>&nbsp; <small>string</small>         <i>optional</i>    <br>
The value must be a valid date in the format H:i.</p>
<h2>Get activities by ID</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://clearprop.test/api/v1/activities/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (401):</p>
</blockquote>
<pre><code class="language-json">{
    "message": "Unauthenticated."
}</code></pre>
<h3>Request</h3>
<p><small class="badge badge-green">GET</small>
<strong><code>api/v1/activities/{activity}</code></strong></p>
<h2>Update activities</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X PUT \
    "http://clearprop.test/api/v1/activities/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"plane_id":9,"event":"11.07.2020","counter_start":"voluptatem","counter_stop":"hic","event_start":"10:48","event_stop":"10:48"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>Request</h3>
<p><small class="badge badge-darkblue">PUT</small>
<strong><code>api/v1/activities/{activity}</code></strong></p>
<p><small class="badge badge-purple">PATCH</small>
<strong><code>api/v1/activities/{activity}</code></strong></p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p><code><b>plane_id</b></code>&nbsp; <small>integer</small>     <br></p>
<p><code><b>event</b></code>&nbsp; <small>string</small>     <br>
The value must be a valid date in the format d.m.Y.</p>
<p><code><b>counter_start</b></code>&nbsp; <small>string</small>     <br></p>
<p><code><b>counter_stop</b></code>&nbsp; <small>string</small>     <br></p>
<p><code><b>event_start</b></code>&nbsp; <small>string</small>         <i>optional</i>    <br>
The value must be a valid date in the format H:i.</p>
<p><code><b>event_stop</b></code>&nbsp; <small>string</small>         <i>optional</i>    <br>
The value must be a valid date in the format H:i.</p>
<h2>Delete activities by ID</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X DELETE \
    "http://clearprop.test/api/v1/activities/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>Request</h3>
<p><small class="badge badge-red">DELETE</small>
<strong><code>api/v1/activities/{activity}</code></strong></p><h1>Factors</h1>
<h2>Get ALL factors</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://clearprop.test/api/v1/factors" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://clearprop.test/api/v1/factors"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (401):</p>
</blockquote>
<pre><code class="language-json">{
    "message": "Unauthenticated."
}</code></pre>
<h3>Request</h3>
<p><small class="badge badge-green">GET</small>
<strong><code>api/v1/factors</code></strong></p>
<h2>Create factors</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://clearprop.test/api/v1/factors" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"ea"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://clearprop.test/api/v1/factors"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "ea"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>Request</h3>
<p><small class="badge badge-black">POST</small>
<strong><code>api/v1/factors</code></strong></p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p><code><b>name</b></code>&nbsp; <small>string</small>     <br></p>
<h2>Get factor by ID</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://clearprop.test/api/v1/factors/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://clearprop.test/api/v1/factors/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (401):</p>
</blockquote>
<pre><code class="language-json">{
    "message": "Unauthenticated."
}</code></pre>
<h3>Request</h3>
<p><small class="badge badge-green">GET</small>
<strong><code>api/v1/factors/{factor}</code></strong></p>
<h2>Delete factor by ID</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X DELETE \
    "http://clearprop.test/api/v1/factors/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://clearprop.test/api/v1/factors/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>Request</h3>
<p><small class="badge badge-red">DELETE</small>
<strong><code>api/v1/factors/{factor}</code></strong></p><h1>Planes</h1>
<h2>Get ALL planes</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://clearprop.test/api/v1/planes" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (401):</p>
</blockquote>
<pre><code class="language-json">{
    "message": "Unauthenticated."
}</code></pre>
<h3>Request</h3>
<p><small class="badge badge-green">GET</small>
<strong><code>api/v1/planes</code></strong></p>
<h2>Create planes</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://clearprop.test/api/v1/planes" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"callsign":"ipsum","vendor":"in","counter_type":"a"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://clearprop.test/api/v1/planes"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "callsign": "ipsum",
    "vendor": "in",
    "counter_type": "a"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>Request</h3>
<p><small class="badge badge-black">POST</small>
<strong><code>api/v1/planes</code></strong></p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p><code><b>callsign</b></code>&nbsp; <small>string</small>     <br></p>
<p><code><b>vendor</b></code>&nbsp; <small>string</small>     <br></p>
<p><code><b>counter_type</b></code>&nbsp; <small>string</small>     <br></p>
<h2>Get plane by ID</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://clearprop.test/api/v1/planes/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (401):</p>
</blockquote>
<pre><code class="language-json">{
    "message": "Unauthenticated."
}</code></pre>
<h3>Request</h3>
<p><small class="badge badge-green">GET</small>
<strong><code>api/v1/planes/{plane}</code></strong></p>
<h2>Update plane</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X PUT \
    "http://clearprop.test/api/v1/planes/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"callsign":"sed","vendor":"sunt","counter_type":"autem"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://clearprop.test/api/v1/planes/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "callsign": "sed",
    "vendor": "sunt",
    "counter_type": "autem"
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>Request</h3>
<p><small class="badge badge-darkblue">PUT</small>
<strong><code>api/v1/planes/{plane}</code></strong></p>
<p><small class="badge badge-purple">PATCH</small>
<strong><code>api/v1/planes/{plane}</code></strong></p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p><code><b>callsign</b></code>&nbsp; <small>string</small>     <br></p>
<p><code><b>vendor</b></code>&nbsp; <small>string</small>     <br></p>
<p><code><b>counter_type</b></code>&nbsp; <small>string</small>     <br></p>
<h2>Delete plane by ID</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X DELETE \
    "http://clearprop.test/api/v1/planes/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>Request</h3>
<p><small class="badge badge-red">DELETE</small>
<strong><code>api/v1/planes/{plane}</code></strong></p><h1>Reservations</h1>
<h2>Get ALL reservations</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://clearprop.test/api/v1/bookings" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (401):</p>
</blockquote>
<pre><code class="language-json">{
    "message": "Unauthenticated."
}</code></pre>
<h3>Request</h3>
<p><small class="badge badge-green">GET</small>
<strong><code>api/v1/bookings</code></strong></p>
<h2>Create reservations</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://clearprop.test/api/v1/bookings" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"user_id":12,"plane_id":20,"reservation_start":"11.07.2020 10:48","reservation_stop":"11.07.2020 10:48"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>Request</h3>
<p><small class="badge badge-black">POST</small>
<strong><code>api/v1/bookings</code></strong></p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p><code><b>user_id</b></code>&nbsp; <small>integer</small>     <br></p>
<p><code><b>plane_id</b></code>&nbsp; <small>integer</small>     <br></p>
<p><code><b>reservation_start</b></code>&nbsp; <small>string</small>     <br>
The value must be a valid date in the format d.m.Y H:i.</p>
<p><code><b>reservation_stop</b></code>&nbsp; <small>string</small>     <br>
The value must be a valid date in the format d.m.Y H:i.</p>
<h2>Get reservation by ID</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://clearprop.test/api/v1/bookings/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (401):</p>
</blockquote>
<pre><code class="language-json">{
    "message": "Unauthenticated."
}</code></pre>
<h3>Request</h3>
<p><small class="badge badge-green">GET</small>
<strong><code>api/v1/bookings/{booking}</code></strong></p>
<h2>Update reservations</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X PUT \
    "http://clearprop.test/api/v1/bookings/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"user_id":17,"plane_id":3,"reservation_start":"11.07.2020 10:48","reservation_stop":"11.07.2020 10:48"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>Request</h3>
<p><small class="badge badge-darkblue">PUT</small>
<strong><code>api/v1/bookings/{booking}</code></strong></p>
<p><small class="badge badge-purple">PATCH</small>
<strong><code>api/v1/bookings/{booking}</code></strong></p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p><code><b>user_id</b></code>&nbsp; <small>integer</small>     <br></p>
<p><code><b>plane_id</b></code>&nbsp; <small>integer</small>     <br></p>
<p><code><b>reservation_start</b></code>&nbsp; <small>string</small>     <br>
The value must be a valid date in the format d.m.Y H:i.</p>
<p><code><b>reservation_stop</b></code>&nbsp; <small>string</small>     <br>
The value must be a valid date in the format d.m.Y H:i.</p>
<h2>Delete reservation by ID</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X DELETE \
    "http://clearprop.test/api/v1/bookings/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>Request</h3>
<p><small class="badge badge-red">DELETE</small>
<strong><code>api/v1/bookings/{booking}</code></strong></p><h1>Types</h1>
<h2>Get ALL types</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://clearprop.test/api/v1/types" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (401):</p>
</blockquote>
<pre><code class="language-json">{
    "message": "Unauthenticated."
}</code></pre>
<h3>Request</h3>
<p><small class="badge badge-green">GET</small>
<strong><code>api/v1/types</code></strong></p>
<h2>Create types</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://clearprop.test/api/v1/types" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"odio","instructor":"eius","active":"ducimus"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>Request</h3>
<p><small class="badge badge-black">POST</small>
<strong><code>api/v1/types</code></strong></p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p><code><b>name</b></code>&nbsp; <small>string</small>     <br></p>
<p><code><b>instructor</b></code>&nbsp; <small>string</small>     <br></p>
<p><code><b>active</b></code>&nbsp; <small>string</small>     <br></p>
<h2>Get type by ID</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://clearprop.test/api/v1/types/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (401):</p>
</blockquote>
<pre><code class="language-json">{
    "message": "Unauthenticated."
}</code></pre>
<h3>Request</h3>
<p><small class="badge badge-green">GET</small>
<strong><code>api/v1/types/{type}</code></strong></p>
<h2>Update types</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X PUT \
    "http://clearprop.test/api/v1/types/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"velit","instructor":"quos","active":"labore"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>Request</h3>
<p><small class="badge badge-darkblue">PUT</small>
<strong><code>api/v1/types/{type}</code></strong></p>
<p><small class="badge badge-purple">PATCH</small>
<strong><code>api/v1/types/{type}</code></strong></p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p><code><b>name</b></code>&nbsp; <small>string</small>     <br></p>
<p><code><b>instructor</b></code>&nbsp; <small>string</small>     <br></p>
<p><code><b>active</b></code>&nbsp; <small>string</small>     <br></p>
<h2>Delete type by ID</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X DELETE \
    "http://clearprop.test/api/v1/types/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>Request</h3>
<p><small class="badge badge-red">DELETE</small>
<strong><code>api/v1/types/{type}</code></strong></p><h1>Users</h1>
<h2>Get ALL users</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://clearprop.test/api/v1/users" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (401):</p>
</blockquote>
<pre><code class="language-json">{
    "message": "Unauthenticated."
}</code></pre>
<h3>Request</h3>
<p><small class="badge badge-green">GET</small>
<strong><code>api/v1/users</code></strong></p>
<h2>Create users</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://clearprop.test/api/v1/users" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"qui","email":"omnis","password":"omnis","factor_id":6,"medical_due":"11.07.2020","roles":[20],"lang":"laborum"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>Request</h3>
<p><small class="badge badge-black">POST</small>
<strong><code>api/v1/users</code></strong></p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p><code><b>name</b></code>&nbsp; <small>string</small>     <br></p>
<p><code><b>email</b></code>&nbsp; <small>string</small>     <br></p>
<p><code><b>password</b></code>&nbsp; <small>string</small>     <br></p>
<p><code><b>factor_id</b></code>&nbsp; <small>integer</small>     <br></p>
<p><code><b>medical_due</b></code>&nbsp; <small>string</small>         <i>optional</i>    <br>
The value must be a valid date in the format d.m.Y.</p>
<p><code><b>roles</b></code>&nbsp; <small>array</small>     <br></p>
<p><code><b>lang</b></code>&nbsp; <small>string</small>     <br></p>
<p><code><b>roles.*</b></code>&nbsp; <small>integer</small>         <i>optional</i>    <br></p>
<h2>Get users by ID</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://clearprop.test/api/v1/users/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (401):</p>
</blockquote>
<pre><code class="language-json">{
    "message": "Unauthenticated."
}</code></pre>
<h3>Request</h3>
<p><small class="badge badge-green">GET</small>
<strong><code>api/v1/users/{user}</code></strong></p>
<h2>Update users</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X PUT \
    "http://clearprop.test/api/v1/users/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"commodi","email":"doloribus","factor_id":4,"medical_due":"11.07.2020","roles":[13],"lang":"rerum"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>Request</h3>
<p><small class="badge badge-darkblue">PUT</small>
<strong><code>api/v1/users/{user}</code></strong></p>
<p><small class="badge badge-purple">PATCH</small>
<strong><code>api/v1/users/{user}</code></strong></p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p><code><b>name</b></code>&nbsp; <small>string</small>     <br></p>
<p><code><b>email</b></code>&nbsp; <small>string</small>     <br></p>
<p><code><b>factor_id</b></code>&nbsp; <small>integer</small>     <br></p>
<p><code><b>medical_due</b></code>&nbsp; <small>string</small>         <i>optional</i>    <br>
The value must be a valid date in the format d.m.Y.</p>
<p><code><b>roles</b></code>&nbsp; <small>array</small>     <br></p>
<p><code><b>lang</b></code>&nbsp; <small>string</small>     <br></p>
<p><code><b>roles.*</b></code>&nbsp; <small>integer</small>         <i>optional</i>    <br></p>
<h2>Delete user by ID</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X DELETE \
    "http://clearprop.test/api/v1/users/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>Request</h3>
<p><small class="badge badge-red">DELETE</small>
<strong><code>api/v1/users/{user}</code></strong></p>
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                    <a href="#" data-language-name="bash">bash</a>
                                    <a href="#" data-language-name="javascript">javascript</a>
                            </div>
            </div>
</div>
<script>
    $(function () {
        var languages = ["bash","javascript"];
        setupLanguages(languages);
    });
</script>
</body>
</html>