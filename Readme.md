## [CStrike-Regnick](https://github.com/vimishor/CStrike-Regnick): Servers Live module

[Servers Live](https://github.com/vimishor/Servers-Live.regnick-module) is a module for [CStrike-Regnick](https://github.com/vimishor/CStrike-Regnick), which provides additional information for each server registred in application, like: _current map_, _online players_ and _server lattency_ .


## Requirements

* [CStrike-Regnick](https://github.com/vimishor/CStrike-Regnick) installed (_obvious_).
* PHP 5.3+


## Installation

* From the archive, upload each directory to his correspondent on the server:
    * `[archive]/upload/app/modules/servers` to `[regnick_install]/app/modules/servers`
    * `[archive]/upload/pub/storage/servers_live` to `[regnick_install]/pub/storage/servers_live`
* Access `http://example.com/regnick/servers/`.
* Done.

## FAQ

1. Live data is cached ?
Yes, data fetched from servers, it is cached for 5 mins.

2. How can I change the default cache time ?
Edit `app/modules/servers/config/servers.php` and change value for `$config['cache_time']`.

3. Can i use this module as a frontpage (_aka index_) ?
Yes, you can. Edit `app/config/routes` and change value for `$route['default_controller']`:
    ```$route['default_controller']        = "servers/show";```

4. How can I prevent the frontpage to change on default one, after each [CStrike-Regnick](https://github.com/vimishor/CStrike-Regnick) update ?
Copy `app/config/routes.php` to `app/config/production/routes.php` and any changes you made to that file will be preserved accross updates.

## LICENSE

[GNU General Public License v2](http://opensource.org/licenses/gpl-2.0.php)