# Central API v0.3

### Resources

Type                              | Resource                                                                    | Description
----------------------------------|-----------------------------------------------------------------------------|------------
[Contact](#contact)       | [POST /api/contacts](#contact)                                        | Create contact

### General API Guidelines

**Encoding**

All data sent to and from the API should be encoded as UTF-8.

## CONTACT

Create a new contact.

##### REQUEST

```
POST /api/contacts

[
    'name': 'DeRay',
    'email': 'deray@deray.com',
    'phone': '123-456-7890',
    'zip': '02345',
    'campaign': 'inauguration',
    'topics': [
      'Big Data',
      'Something Else'
    ],
    'source': 'sms'
]
```

##### RESPONSE

```json
{
  "status": "success",
  "data": {
    "contact": {
      "id": 42,
      "name": "DeRay",
      "email": "deray@deray.com",
      "phone": "123-456-7890",
      "zip": "02345",
      "campaign": "inauguration",
      "source": "sms",
      "topics": [
        "Big Data",
        "Something Else"
      ],
      "created_at": "2017-01-10T05:43:19+0000",
      "updated_at": "2017-01-10T05:43:19+0000"
    }
  }
}
```
