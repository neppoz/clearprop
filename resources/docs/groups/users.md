# Users


## Get ALL users

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://dev.clearprop.test/api/v1/users"
);

let headers = {
    "Authorization": "Bearer E4a68ePZ16vV3kdhgcf5abD",
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
    'http://dev.clearprop.test/api/v1/users',
    [
        'headers' => [
            'Authorization' => 'Bearer E4a68ePZ16vV3kdhgcf5abD',
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
            "name": "Super Admin",
            "email": "support@clearprop.aero",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": null,
            "license": null,
            "lang": "EN",
            "taxno": null,
            "phone_1": null,
            "phone_2": null,
            "address": null,
            "city": null,
            "params": null,
            "created_at": "2020-09-16T15:58:13.000000Z",
            "updated_at": "2020-09-16T15:58:13.000000Z",
            "deleted_at": null,
            "factor_id": null,
            "factor": null,
            "roles": [
                {
                    "id": 1,
                    "title": "Admin",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 1,
                        "role_id": 1
                    }
                }
            ]
        },
        {
            "id": 2,
            "name": "Demo Admin",
            "email": "demo.admin@clearprop.aero",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.10.2010",
            "license": "19723",
            "lang": "EN",
            "taxno": null,
            "phone_1": null,
            "phone_2": null,
            "address": null,
            "city": null,
            "params": null,
            "created_at": "2020-09-16T15:58:19.000000Z",
            "updated_at": "2020-09-16T15:58:19.000000Z",
            "deleted_at": null,
            "factor_id": null,
            "factor": null,
            "roles": [
                {
                    "id": 1,
                    "title": "Admin",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 2,
                        "role_id": 1
                    }
                }
            ]
        },
        {
            "id": 3,
            "name": "Demo Instructor",
            "email": "demo.instructor@clearprop.aero",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 1,
            "medical_due": "20.10.2010",
            "license": "5098",
            "lang": "EN",
            "taxno": null,
            "phone_1": null,
            "phone_2": null,
            "address": null,
            "city": null,
            "params": null,
            "created_at": "2020-09-16T15:58:19.000000Z",
            "updated_at": "2020-09-16T15:58:19.000000Z",
            "deleted_at": null,
            "factor_id": null,
            "factor": null,
            "roles": [
                {
                    "id": 3,
                    "title": "Manager",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 3,
                        "role_id": 3
                    }
                }
            ]
        },
        {
            "id": 4,
            "name": "Demo User",
            "email": "demo.user@clearprop.aero",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.10.2010",
            "license": "40733",
            "lang": "IT",
            "taxno": null,
            "phone_1": null,
            "phone_2": null,
            "address": null,
            "city": null,
            "params": null,
            "created_at": "2020-09-16T15:58:19.000000Z",
            "updated_at": "2020-09-16T15:58:19.000000Z",
            "deleted_at": null,
            "factor_id": null,
            "factor": null,
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 4,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 5,
            "name": "Cleros Giordano",
            "email": "wvitali@piras.it",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.02.2012",
            "license": "11677",
            "lang": "IT",
            "taxno": "EZUJSY87L63Q734Q",
            "phone_1": "384 366 120",
            "phone_2": "+16 83 6899663",
            "address": "Incrocio Coppola 70 Piano 8\nPalumbo salentino, 78243 Ravenna (BR)",
            "city": "Settimo Luigi",
            "params": null,
            "created_at": "2020-09-16T15:58:19.000000Z",
            "updated_at": "2020-09-16T15:58:19.000000Z",
            "deleted_at": null,
            "factor_id": 1,
            "factor": {
                "id": 1,
                "name": "Premium",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 5,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 6,
            "name": "Dott. Flaviana Grasso",
            "email": "jbellini@donati.it",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.12.2011",
            "license": "33983",
            "lang": "IT",
            "taxno": "HSRVTJ34G29D803F",
            "phone_1": "+75 1684 8243354",
            "phone_2": "319 328 724",
            "address": "Rotonda Grassi 233 Appartamento 23\nSan Guido nell'emilia, 93201 Carbonia-Iglesias (BI)",
            "city": "Lombardi umbro",
            "params": null,
            "created_at": "2020-09-16T15:58:19.000000Z",
            "updated_at": "2020-09-16T15:58:19.000000Z",
            "deleted_at": null,
            "factor_id": 2,
            "factor": {
                "id": 2,
                "name": "Standard",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 6,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 7,
            "name": "Diana Ferrara",
            "email": "elda.colombo@yahoo.com",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.06.2026",
            "license": "6485",
            "lang": "IT",
            "taxno": "NPBEIS38D78U690U",
            "phone_1": "+52 69 0680552",
            "phone_2": "+39 303 261 096",
            "address": "Rotonda Galli 80 Piano 8\nQuarto Helga, 05909 Como (NU)",
            "city": "Martinelli veneto",
            "params": null,
            "created_at": "2020-09-16T15:58:19.000000Z",
            "updated_at": "2020-09-16T15:58:19.000000Z",
            "deleted_at": null,
            "factor_id": 2,
            "factor": {
                "id": 2,
                "name": "Standard",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 7,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 8,
            "name": "Giacobbe Gallo",
            "email": "hmarini@rinaldi.com",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.08.2008",
            "license": "23965",
            "lang": "IT",
            "taxno": "RCFPGQ98P56C444I",
            "phone_1": "+59 0928 69176917",
            "phone_2": "+39 081 192 591",
            "address": "Borgo Sartori 41\nGreco del friuli, 22389 Teramo (LC)",
            "city": "Yago del friuli",
            "params": null,
            "created_at": "2020-09-16T15:58:19.000000Z",
            "updated_at": "2020-09-16T15:58:19.000000Z",
            "deleted_at": null,
            "factor_id": 2,
            "factor": {
                "id": 2,
                "name": "Standard",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 8,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 9,
            "name": "Ivonne Greco",
            "email": "dsorrentino@yahoo.com",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.03.2012",
            "license": "5447",
            "lang": "IT",
            "taxno": "UPOSMQ21U30S562P",
            "phone_1": "057 435 5787",
            "phone_2": "012 394 0084",
            "address": "Contrada Karim 6 Piano 2\nSettimo Olimpia salentino, 81749 Catanzaro (VT)",
            "city": "Quarto Laura",
            "params": null,
            "created_at": "2020-09-16T15:58:19.000000Z",
            "updated_at": "2020-09-16T15:58:19.000000Z",
            "deleted_at": null,
            "factor_id": 1,
            "factor": {
                "id": 1,
                "name": "Premium",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 9,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 10,
            "name": "Dr. Jelena Conte",
            "email": "opellegrini@bellini.com",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.12.2029",
            "license": "24473",
            "lang": "IT",
            "taxno": "BYXIUR77V32I924G",
            "phone_1": "384 494 538",
            "phone_2": "081 212 8892",
            "address": "Incrocio De Angelis 464\nSesto Manfredi salentino, 04042 Pesaro e Urbino (AO)",
            "city": "Quarto Rita lido",
            "params": null,
            "created_at": "2020-09-16T15:58:19.000000Z",
            "updated_at": "2020-09-16T15:58:19.000000Z",
            "deleted_at": null,
            "factor_id": 2,
            "factor": {
                "id": 2,
                "name": "Standard",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 10,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 11,
            "name": "Sig. Santo Conte",
            "email": "negri.artemide@hotmail.com",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.05.2007",
            "license": "17549",
            "lang": "IT",
            "taxno": "FZHVXG49Y13N629K",
            "phone_1": "+87 646 33058766",
            "phone_2": "+82 2725 22397455",
            "address": "Via Colombo 914\nBasile laziale, 81115 Siracusa (OT)",
            "city": "San Michele",
            "params": null,
            "created_at": "2020-09-16T15:58:19.000000Z",
            "updated_at": "2020-09-16T15:58:19.000000Z",
            "deleted_at": null,
            "factor_id": 2,
            "factor": {
                "id": 2,
                "name": "Standard",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 11,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 12,
            "name": "Sig.ra Doriana Morelli",
            "email": "egisto95@hotmail.com",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.12.2003",
            "license": "36760",
            "lang": "IT",
            "taxno": "CINKOJ89L02O446Q",
            "phone_1": "+71 933 65 24 9576",
            "phone_2": "007 031 5834",
            "address": "Borgo Basile 2 Appartamento 81\nOrlando calabro, 83232 Caltanissetta (PN)",
            "city": "Gatti salentino",
            "params": null,
            "created_at": "2020-09-16T15:58:19.000000Z",
            "updated_at": "2020-09-16T15:58:19.000000Z",
            "deleted_at": null,
            "factor_id": 2,
            "factor": {
                "id": 2,
                "name": "Standard",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 12,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 13,
            "name": "Sig.ra Maika Sanna",
            "email": "irene73@valentini.org",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.10.2028",
            "license": "36450",
            "lang": "IT",
            "taxno": "KDCHDC56O85Y258K",
            "phone_1": "366 675 706",
            "phone_2": "+38 80 0586964",
            "address": "Borgo Erminio 3 Appartamento 56\nSettimo Graziano veneto, 07878 Piacenza (RE)",
            "city": "Sarita salentino",
            "params": null,
            "created_at": "2020-09-16T15:58:19.000000Z",
            "updated_at": "2020-09-16T15:58:19.000000Z",
            "deleted_at": null,
            "factor_id": 2,
            "factor": {
                "id": 2,
                "name": "Standard",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 13,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 14,
            "name": "Rebecca Gatti",
            "email": "fmilani@sorrentino.com",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.04.2010",
            "license": "46567",
            "lang": "IT",
            "taxno": "TJXEGD12K99G640T",
            "phone_1": "+58 1332 8514162",
            "phone_2": "+01 7502 1471919",
            "address": "Rotonda Esposito 423 Piano 1\nSelvaggia calabro, 46974 Parma (IM)",
            "city": "Settimo Rocco laziale",
            "params": null,
            "created_at": "2020-09-16T15:58:19.000000Z",
            "updated_at": "2020-09-16T15:58:19.000000Z",
            "deleted_at": null,
            "factor_id": 1,
            "factor": {
                "id": 1,
                "name": "Premium",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 14,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 15,
            "name": "Ing. Xavier Morelli",
            "email": "manfredi.greco@libero.it",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.04.2006",
            "license": "26505",
            "lang": "IT",
            "taxno": "JYYHWS26G95N632G",
            "phone_1": "+30 33 4929169",
            "phone_2": "+06 65 17295227",
            "address": "Rotonda Conte 49 Piano 5\nSettimo Lazzaro, 23759 Benevento (PV)",
            "city": "Gastone ligure",
            "params": null,
            "created_at": "2020-09-16T15:58:19.000000Z",
            "updated_at": "2020-09-16T15:58:19.000000Z",
            "deleted_at": null,
            "factor_id": 2,
            "factor": {
                "id": 2,
                "name": "Standard",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 15,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 16,
            "name": "Claudia Ruggiero",
            "email": "eufemia.martino@basile.it",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.02.2001",
            "license": "40532",
            "lang": "IT",
            "taxno": "GLTCTB79Z46V538P",
            "phone_1": "+30 373 72970996",
            "phone_2": "+56 764 84120067",
            "address": "Incrocio Montanari 415\nBianchi laziale, 86238 Trento (BS)",
            "city": "San Ursula",
            "params": null,
            "created_at": "2020-09-16T15:58:19.000000Z",
            "updated_at": "2020-09-16T15:58:19.000000Z",
            "deleted_at": null,
            "factor_id": 1,
            "factor": {
                "id": 1,
                "name": "Premium",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 16,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 17,
            "name": "Ing. Maika Sala",
            "email": "joannes.ferretti@rossetti.com",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.09.2020",
            "license": "18117",
            "lang": "IT",
            "taxno": "RGYKVQ74U38P736Z",
            "phone_1": "+35 57 6641338",
            "phone_2": "352 590 921",
            "address": "Incrocio Artes 6 Appartamento 90\nMilani laziale, 45051 Foggia (ME)",
            "city": "Sesto Nabil umbro",
            "params": null,
            "created_at": "2020-09-16T15:58:19.000000Z",
            "updated_at": "2020-09-16T15:58:19.000000Z",
            "deleted_at": null,
            "factor_id": 1,
            "factor": {
                "id": 1,
                "name": "Premium",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 17,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 18,
            "name": "Ing. Selvaggia Guerra",
            "email": "nunzia.longo@romano.org",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.03.2013",
            "license": "41256",
            "lang": "IT",
            "taxno": "ABXKXF59K01O099P",
            "phone_1": "+12 511 48 63 8498",
            "phone_2": "+67 60 68928811",
            "address": "Piazza Tazio 4\nArtemide sardo, 52534 Udine (BT)",
            "city": "Sesto Edilio sardo",
            "params": null,
            "created_at": "2020-09-16T15:58:20.000000Z",
            "updated_at": "2020-09-16T15:58:20.000000Z",
            "deleted_at": null,
            "factor_id": 2,
            "factor": {
                "id": 2,
                "name": "Standard",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 18,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 19,
            "name": "Alan Negri",
            "email": "qbattaglia@libero.it",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.09.2001",
            "license": "34006",
            "lang": "IT",
            "taxno": "BDUUKK98N40L248X",
            "phone_1": "+68 1017 7833869",
            "phone_2": "+81 9173 97203663",
            "address": "Strada Rita 61\nNeri terme, 00611 Aosta (CH)",
            "city": "Lucia salentino",
            "params": null,
            "created_at": "2020-09-16T15:58:20.000000Z",
            "updated_at": "2020-09-16T15:58:20.000000Z",
            "deleted_at": null,
            "factor_id": 2,
            "factor": {
                "id": 2,
                "name": "Standard",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 19,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 20,
            "name": "Gelsomina Testa",
            "email": "smazza@hotmail.com",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.04.2022",
            "license": "18480",
            "lang": "IT",
            "taxno": "HCIZAS61X79P703T",
            "phone_1": "+44 743 6065791",
            "phone_2": "+39 082 880 823",
            "address": "Strada Clodovea 33 Piano 0\nQuarto Nabil, 19830 Grosseto (SP)",
            "city": "Borgo Deborah",
            "params": null,
            "created_at": "2020-09-16T15:58:20.000000Z",
            "updated_at": "2020-09-16T15:58:20.000000Z",
            "deleted_at": null,
            "factor_id": 2,
            "factor": {
                "id": 2,
                "name": "Standard",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 20,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 21,
            "name": "Fatima Mancini",
            "email": "dante07@gmail.com",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.06.2030",
            "license": "12581",
            "lang": "IT",
            "taxno": "LAJIGQ50U04B423S",
            "phone_1": "+39 333 738 584",
            "phone_2": "+39 330 461 377",
            "address": "Borgo Milani 65 Appartamento 31\nSettimo Leonardo, 17850 Bolzano (BG)",
            "city": "Sesto Morgana umbro",
            "params": null,
            "created_at": "2020-09-16T15:58:20.000000Z",
            "updated_at": "2020-09-16T15:58:20.000000Z",
            "deleted_at": null,
            "factor_id": 1,
            "factor": {
                "id": 1,
                "name": "Premium",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 21,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 22,
            "name": "Ing. Celeste Palmieri",
            "email": "tmilani@neri.net",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.09.2010",
            "license": "19913",
            "lang": "IT",
            "taxno": "GDPKFO11Q75B887H",
            "phone_1": "+39 325 806 500",
            "phone_2": "+55 882 04184198",
            "address": "Incrocio Sala 700 Appartamento 83\nBorgo Tolomeo, 18534 Pavia (SO)",
            "city": "Conti salentino",
            "params": null,
            "created_at": "2020-09-16T15:58:20.000000Z",
            "updated_at": "2020-09-16T15:58:20.000000Z",
            "deleted_at": null,
            "factor_id": 1,
            "factor": {
                "id": 1,
                "name": "Premium",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 22,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 23,
            "name": "Dr. Marieva Carbone",
            "email": "donatella.vitali@email.it",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.02.2011",
            "license": "24955",
            "lang": "IT",
            "taxno": "IHOYHL55C22K877O",
            "phone_1": "+93 28 3090150",
            "phone_2": "+89 2205 9860633",
            "address": "Rotonda Mauro 22 Piano 8\nBorgo Marina lido, 43867 Lucca (FM)",
            "city": "Giovanna calabro",
            "params": null,
            "created_at": "2020-09-16T15:58:20.000000Z",
            "updated_at": "2020-09-16T15:58:20.000000Z",
            "deleted_at": null,
            "factor_id": 1,
            "factor": {
                "id": 1,
                "name": "Premium",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 23,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 24,
            "name": "Oretta Leone",
            "email": "jarno.martini@yahoo.com",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.05.2025",
            "license": "38651",
            "lang": "IT",
            "taxno": "UOQGHP44R50Y108R",
            "phone_1": "+20 10 12797037",
            "phone_2": "+45 82 95146786",
            "address": "Piazza Montanari 300\nSettimo Anselmo salentino, 73425 Genova (VR)",
            "city": "Settimo Mariagiulia umbro",
            "params": null,
            "created_at": "2020-09-16T15:58:20.000000Z",
            "updated_at": "2020-09-16T15:58:20.000000Z",
            "deleted_at": null,
            "factor_id": 2,
            "factor": {
                "id": 2,
                "name": "Standard",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 24,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 25,
            "name": "Eusebio Lombardi",
            "email": "marino.lucrezia@libero.it",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.09.2006",
            "license": "27822",
            "lang": "IT",
            "taxno": "NRYJZW99M98G843C",
            "phone_1": "+67 0216 74572523",
            "phone_2": "+53 04 40728583",
            "address": "Strada Costa 7 Piano 7\nGiacinta laziale, 50532 Ascoli Piceno (TN)",
            "city": "Kai calabro",
            "params": null,
            "created_at": "2020-09-16T15:58:20.000000Z",
            "updated_at": "2020-09-16T15:58:20.000000Z",
            "deleted_at": null,
            "factor_id": 1,
            "factor": {
                "id": 1,
                "name": "Premium",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 25,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 26,
            "name": "Sig. Serse Pellegrino",
            "email": "ibianco@milani.it",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.05.2017",
            "license": "34100",
            "lang": "IT",
            "taxno": "QYLBFD29D54V301L",
            "phone_1": "062 131 7873",
            "phone_2": "+12 281 41 87 3301",
            "address": "Rotonda Lombardo 07\nSesto Marina ligure, 60117 Sondrio (PC)",
            "city": "Primo a mare",
            "params": null,
            "created_at": "2020-09-16T15:58:20.000000Z",
            "updated_at": "2020-09-16T15:58:20.000000Z",
            "deleted_at": null,
            "factor_id": 1,
            "factor": {
                "id": 1,
                "name": "Premium",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 26,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 27,
            "name": "Arduino Colombo",
            "email": "ettore.ferri@caputo.com",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.05.2025",
            "license": "44339",
            "lang": "IT",
            "taxno": "NMDKYM70M78B774O",
            "phone_1": "+55 1929 03570190",
            "phone_2": "+39 350 348 386",
            "address": "Borgo Caputo 13 Appartamento 68\nVitali terme, 51637 La Spezia (AV)",
            "city": "Quarto Lucrezia",
            "params": null,
            "created_at": "2020-09-16T15:58:20.000000Z",
            "updated_at": "2020-09-16T15:58:20.000000Z",
            "deleted_at": null,
            "factor_id": 1,
            "factor": {
                "id": 1,
                "name": "Premium",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 27,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 28,
            "name": "Piccarda Esposito",
            "email": "nayade23@riva.it",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.09.2020",
            "license": "46344",
            "lang": "IT",
            "taxno": "KNFVHW62F79X627D",
            "phone_1": "+39 310 244 382",
            "phone_2": "332 441 039",
            "address": "Contrada Negri 36\nAnastasio umbro, 90915 Crotone (SI)",
            "city": "San Vienna",
            "params": null,
            "created_at": "2020-09-16T15:58:20.000000Z",
            "updated_at": "2020-09-16T15:58:20.000000Z",
            "deleted_at": null,
            "factor_id": 2,
            "factor": {
                "id": 2,
                "name": "Standard",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 28,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 29,
            "name": "Ariel Milani",
            "email": "ferrara.rosita@morelli.it",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.01.2004",
            "license": "32660",
            "lang": "IT",
            "taxno": "PFURWU25J32M623T",
            "phone_1": "+39 000 586 121",
            "phone_2": "340 935 330",
            "address": "Rotonda Piras 511\nSesto Zelida, 51366 Avellino (AV)",
            "city": "Eusebio laziale",
            "params": null,
            "created_at": "2020-09-16T15:58:20.000000Z",
            "updated_at": "2020-09-16T15:58:20.000000Z",
            "deleted_at": null,
            "factor_id": 1,
            "factor": {
                "id": 1,
                "name": "Premium",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 29,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 30,
            "name": "Vitalba Guerra",
            "email": "noel11@yahoo.it",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.11.2030",
            "license": "11399",
            "lang": "IT",
            "taxno": "AUWWZF95G71S718F",
            "phone_1": "+21 9507 59711002",
            "phone_2": "077 420 4261",
            "address": "Piazza Lombardo 590\nMonti salentino, 46592 Parma (VS)",
            "city": "Baldassarre a mare",
            "params": null,
            "created_at": "2020-09-16T15:58:20.000000Z",
            "updated_at": "2020-09-16T15:58:20.000000Z",
            "deleted_at": null,
            "factor_id": 2,
            "factor": {
                "id": 2,
                "name": "Standard",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 30,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 31,
            "name": "Diamante Amato",
            "email": "fcosta@giordano.com",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.06.2014",
            "license": "45261",
            "lang": "IT",
            "taxno": "SZJBTJ66V22Q821H",
            "phone_1": "+46 5450 4831522",
            "phone_2": "+39 037 402 727",
            "address": "Incrocio Mariani 32\nSan Joannes laziale, 02090 Palermo (AR)",
            "city": "Sesto Enrica",
            "params": null,
            "created_at": "2020-09-16T15:58:20.000000Z",
            "updated_at": "2020-09-16T15:58:20.000000Z",
            "deleted_at": null,
            "factor_id": 1,
            "factor": {
                "id": 1,
                "name": "Premium",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 31,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 32,
            "name": "Ninfa Romano",
            "email": "cvalentini@gmail.com",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.11.2007",
            "license": "9170",
            "lang": "IT",
            "taxno": "RKOFIW72Y43Y517D",
            "phone_1": "+94 9844 3406842",
            "phone_2": "+08 0766 02469579",
            "address": "Rotonda Ludovico 18 Piano 7\nSan Gilda, 55046 Palermo (AP)",
            "city": "Settimo Mietta ligure",
            "params": null,
            "created_at": "2020-09-16T15:58:20.000000Z",
            "updated_at": "2020-09-16T15:58:20.000000Z",
            "deleted_at": null,
            "factor_id": 1,
            "factor": {
                "id": 1,
                "name": "Premium",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 32,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 33,
            "name": "Michael Montanari",
            "email": "doriana30@milani.it",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.02.2011",
            "license": "24238",
            "lang": "IT",
            "taxno": "YDGRBP64F78C602L",
            "phone_1": "+82 769 41 66 0456",
            "phone_2": "+90 031 25070397",
            "address": "Via Serra 982\nSan Jole nell'emilia, 82160 Reggio Emilia (LI)",
            "city": "Settimo Giuliano a mare",
            "params": null,
            "created_at": "2020-09-16T15:58:20.000000Z",
            "updated_at": "2020-09-16T15:58:20.000000Z",
            "deleted_at": null,
            "factor_id": 2,
            "factor": {
                "id": 2,
                "name": "Standard",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 33,
                        "role_id": 2
                    }
                }
            ]
        },
        {
            "id": 34,
            "name": "Sig. Giacobbe Fiore",
            "email": "valentini.terzo@palumbo.org",
            "email_verified_at": null,
            "privacy_confirmed_at": null,
            "instructor": 0,
            "medical_due": "20.12.2012",
            "license": "26984",
            "lang": "IT",
            "taxno": "HNUNLF60C57R971S",
            "phone_1": "+25 15 0363491",
            "phone_2": "+63 925 5060189",
            "address": "Via Gianantonio 880\nPellegrino ligure, 32144 Frosinone (EN)",
            "city": "Borgo Timoteo",
            "params": null,
            "created_at": "2020-09-16T15:58:20.000000Z",
            "updated_at": "2020-09-16T15:58:20.000000Z",
            "deleted_at": null,
            "factor_id": 1,
            "factor": {
                "id": 1,
                "name": "Premium",
                "description": null,
                "created_at": "2020-09-16T15:58:18.000000Z",
                "updated_at": "2020-09-16T15:58:18.000000Z",
                "deleted_at": null
            },
            "roles": [
                {
                    "id": 2,
                    "title": "Member",
                    "created_at": "2020-09-16T15:58:13.000000Z",
                    "updated_at": "2020-09-16T15:58:13.000000Z",
                    "deleted_at": null,
                    "pivot": {
                        "user_id": 34,
                        "role_id": 2
                    }
                }
            ]
        }
    ]
}
```

### Request
<small class="badge badge-green">GET</small>
 **`api/v1/users`**



## Create users

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://dev.clearprop.test/api/v1/users"
);

let headers = {
    "Authorization": "Bearer vb36a4VEh5ckdPZ1ae86gDf",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "eius",
    "email": "et",
    "password": "ut",
    "factor_id": 4,
    "medical_due": "16.09.2020",
    "roles": [
        19
    ],
    "lang": "neque"
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
    'http://dev.clearprop.test/api/v1/users',
    [
        'headers' => [
            'Authorization' => 'Bearer vb36a4VEh5ckdPZ1ae86gDf',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'eius',
            'email' => 'et',
            'password' => 'ut',
            'factor_id' => 4,
            'medical_due' => '16.09.2020',
            'roles' => [
                19,
            ],
            'lang' => 'neque',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
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

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://dev.clearprop.test/api/v1/users/1"
);

let headers = {
    "Authorization": "Bearer PV6dbe43vf1ackghDZ85a6E",
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
    'http://dev.clearprop.test/api/v1/users/1',
    [
        'headers' => [
            'Authorization' => 'Bearer PV6dbe43vf1ackghDZ85a6E',
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
        "name": "Super Admin",
        "email": "support@clearprop.aero",
        "email_verified_at": null,
        "privacy_confirmed_at": null,
        "instructor": 0,
        "medical_due": null,
        "license": null,
        "lang": "EN",
        "taxno": null,
        "phone_1": null,
        "phone_2": null,
        "address": null,
        "city": null,
        "params": null,
        "created_at": "2020-09-16T15:58:13.000000Z",
        "updated_at": "2020-09-16T15:58:13.000000Z",
        "deleted_at": null,
        "factor_id": null,
        "factor": null,
        "roles": [
            {
                "id": 1,
                "title": "Admin",
                "created_at": "2020-09-16T15:58:13.000000Z",
                "updated_at": "2020-09-16T15:58:13.000000Z",
                "deleted_at": null,
                "pivot": {
                    "user_id": 1,
                    "role_id": 1
                }
            }
        ]
    }
}
```

### Request
<small class="badge badge-green">GET</small>
 **`api/v1/users/{user}`**



## Update users

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://dev.clearprop.test/api/v1/users/1"
);

let headers = {
    "Authorization": "Bearer 34ka8cbZE15ehVg6PvadDf6",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "hic",
    "email": "maxime",
    "factor_id": 8,
    "medical_due": "16.09.2020",
    "roles": [
        7
    ],
    "lang": "in"
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
    'http://dev.clearprop.test/api/v1/users/1',
    [
        'headers' => [
            'Authorization' => 'Bearer 34ka8cbZE15ehVg6PvadDf6',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'hic',
            'email' => 'maxime',
            'factor_id' => 8,
            'medical_due' => '16.09.2020',
            'roles' => [
                7,
            ],
            'lang' => 'in',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
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

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://dev.clearprop.test/api/v1/users/1"
);

let headers = {
    "Authorization": "Bearer 6h8aP1keacvEbZdfg465DV3",
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
    'http://dev.clearprop.test/api/v1/users/1',
    [
        'headers' => [
            'Authorization' => 'Bearer 6h8aP1keacvEbZdfg465DV3',
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
 **`api/v1/users/{user}`**




