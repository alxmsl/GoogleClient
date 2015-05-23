GoogleClient
===

Google services API library. 
Supported APIs:

* [OAuth2 authorization API](/README.md#oauth2)
* [Google Cloud Messaging API](/README.md#gcm)
* Android Publisher API: in-app products, products purchases and subscriptions purchases

Installation
---

For install library you need to modify your composer configuration file

```
    "alxmsl/googleclient": "v1.*"
```

And just run installation command

```
    $ composer.phar install
```

## <a name="oauth2"></a> OAuth2 authorization

To authorize client you need to create [WebServerApplication](/source/OAuth2/WebServerApplication.php) instance with 
 needed scopes using client identifier, client secret and redirect uri from you console
  
```
    $Client = new WebServerApplication();
    $Client->setClientId(<client id>)
        ->setClientSecret(<client secret>)
        ->setRedirectUri(<redirect uri>);
```

...make authentication url

```
    $Client->createAuthUrl([
            'https://www.googleapis.com/auth/androidpublisher',
        ]
        , ''
        , WebServerApplication::RESPONSE_TYPE_CODE
        , WebServerApplication::ACCESS_TYPE_OFFLINE
        , WebServerApplication::APPROVAL_PROMPT_FORCE);
```

...compete authorization in browser and give authorization code. With this code you could get access token
 
```
    $Token = $Client->authorizeByCode(<code>);
    print((string) $Token);
```

You could see examples [webclient.uri.php](/examples/webclient.uri.php) about uri creation, and 
 [webclient.authorize.php](/examples/webclient.authorize.php) about code authentication. Already you could use completed 
 5script [authorize.php](/bin/authorize.php)
 
```
$ php bin/authorize.php
Using: /usr/local/bin/php bin/authorize.php [-h|--help] [-o|--code] -c|--client -r|--redirect -s|--scopes -e|--secret
-h, --help  - show help
-o, --code  - authorization code
-c, --client  - client id
-r, --redirect  - redirect uri
-s, --scopes  - grant scopes
-e, --secret  - client secret

$ php bin/authorize.php --client='my-client@id' --secret='clientsecret' --redirect='http://example.com/oauth2callback' 
    --scopes='https://www.googleapis.com/auth/androidpublisher'
https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=my-client@id
&redirect_uri=http%3A%2F%2Fexample.com%2Foauth2callback&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fandroidpublisher
&access_type=offline&approval_prompt=force

$ php bin/authorize.php --client='my-client@id' --secret='clientsecret' --code='authorization/code'
    access token:  ya.AccES5_T0keN
    expires in:    3558
    id token:      id.T0kEn
    refresh token: refrE5H_T0KEN
    token type:    Bearer

```

Of course, I created scripts for token refreshing

```
$ php bin/refresh.php
Using: /usr/local/bin/php bin/refresh.php [-h|--help] -c|--client -e|--secret -t|--token
-h, --help  - show help
-c, --client  - client id
-e, --secret  - client secret
-t, --token  - refresh token
```

...and token revoking
 
```
$ php bin/revoke.php --help
Using: /usr/local/bin/php bin/revoke.php [-h|--help] -t|--token
-h, --help  - show help
-t, --token  - revoked token
```

## <a name="gcm"></a> Google Cloud Messaging



## <a name="oauth2"></a> OAuth2 authorization

License
-------
Copyright © 2014-2015 Alexey Maslov <alexey.y.maslov@gmail.com>
This work is free. You can redistribute it and/or modify it under the
terms of the Do What The Fuck You Want To Public License, Version 2,
as published by Sam Hocevar. See the COPYING file for more details.
