# BEA Disable XMLRPC

Current version: `1.0.1`

A must-use WordPress plugin that turns off XML-RPC. No settings, no admin page: drop it in, and the XML-RPC surface is gone.

## What it does

* Disables the XML-RPC API through the `xmlrpc_enabled` filter, so every authenticated XML-RPC method (`wp.*`, `blogger.*`, `metaWeblog.*`, `mt.*`) answers "XML-RPC services are disabled on this site".
* Removes the `X-Pingback` HTTP header from front-end responses.
* Removes the Really Simple Discovery (RSD) `<link>` from `wp_head`, so clients stop advertising the `xmlrpc.php` endpoint.

## What it does not do

`xmlrpc.php` still exists and still answers requests. Methods that do not require a login, such as `pingback.ping` and `system.listMethods`, keep working, and the file still receives whatever traffic a bot sends to it. To block the endpoint for good, add a rule at the web server level (see [Blocking `xmlrpc.php` at the server level](#blocking-xmlrpcphp-at-the-server-level)).

If you need XML-RPC for a specific client (Jetpack, the WordPress mobile apps, a remote publishing tool), do not install this plugin.

## Requirements

* WordPress 3.5+ (`xmlrpc_enabled` filter)
* PHP 5.6+ (any version WordPress itself supports)

## Installation

The plugin is a single PHP file meant to run as a must-use plugin. Installed through Composer it lands in its own folder, so a MU loader such as [BeAPI/wp-mu-loader](https://github.com/BeAPI/wp-mu-loader) or [Bedrock's autoloader](https://roots.io/bedrock/) is needed to load it.

### Composer

* Add the repository source if it is not already available through your package mirror: `{ "type": "git", "url": "https://github.com/BeAPI/bea-disable-xmlrpc" }`.
* Require the package: `composer require bea/disable-xmlrpc`.
* The package type is `wordpress-muplugin`, so [composer/installers](https://github.com/composer/installers) (1.x or 2.x) places it in your `mu-plugins` directory.

### Manual

* Copy `bea-disable-xmlrpc.php` into your `wp-content/mu-plugins/` directory.
* Nothing more: must-use plugins are active as soon as the file is in place.

## Blocking `xmlrpc.php` at the server level

The plugin cannot alter your web server configuration. For a complete lockdown, deny access to `xmlrpc.php` before WordPress is even loaded. This stops brute-force and pingback amplification traffic at the door and saves a PHP bootstrap on every hit.

### Apache (`.htaccess`)

Add this block to the `.htaccess` at the web root, above the `# BEGIN WordPress` block:

```apache
# START Disable xmlrpc
<IfModule mod_alias.c>
  RedirectMatch 403 /xmlrpc.php
</IfModule>
# END Disable xmlrpc
```

If `mod_alias` is not available, the same result with a `<Files>` directive:

```apache
<Files xmlrpc.php>
  Require all denied
</Files>
```

### Nginx

```nginx
location = /xmlrpc.php {
  deny all;
  return 403;
}
```

Keep the plugin installed alongside the server rule: it removes the `X-Pingback` header and the RSD link, which the server rule does not touch.

## Changelog

See [CHANGELOG.md](CHANGELOG.md).

## License

GPL-2.0. See [LICENSE](LICENSE).

## Who?

Created by [Be API](https://beapi.fr), the French WordPress leader.
