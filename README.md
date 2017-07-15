# osu-stats
Template website for searching the osu!api for users.

A few things:
* It was made to be *functional*, not pretty.
* Change the osu_token before attempting to use.

### How to change osu_token:
The token is located in includes/php/settings.php. If you do not have a key, you can get one for free [here](https://osu.ppy.sh/p/api).
If you do not change it, it WILL NOT function.

Error you'll get if you don't change it: (ignore the xamp stuff)
```php
Warning: file_get_contents(https://osu.ppy.sh/api/get_user?k=change-this&u=DUPLICATION): failed to open stream: HTTP request failed! HTTP/1.1 401 Unauthorized in C:\xampp\htdocs\Landon\index.php on line 22
Warning: array_key_exists() expects parameter 2 to be array, null given in C:\xampp\htdocs\Landon\index.php on line 25
```

Never publicize your key, as it's like giving out your password.

If you find any issues/errors, please post them under the `Issues` tab above.

Thank you! SirGregg
