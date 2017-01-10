# Central API v0.1

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
    'campaign': 'inauguration',
    'source': 'sms'
]
```

##### RESPONSE

```json
{
  "status": "success",
  "data": {
    "contact": {
      "name": "DeRay",
      "email": "deray@deray.com",
      "phone": "123-456-7890",
      "campaign": "inauguration",
      "source": "sms"
    }
  }
}
```
