# Changelog

## 1.0.1 - 16 Oct 2026
* Add README with installation steps and the server-level `.htaccess` / Nginx rules to block `xmlrpc.php` (#1)
* Add this changelog
* Normalize the `composer/installers` constraint to `^1.0 || ^2.0` and bump the plugin header so Composer picks the version that accepts installers 2.x (#2)

## 0.1.1 - 02 Aug 2022
* Accept `composer/installers` 2.x

## 1.0.0 - 29 Mar 2017
* Composer package `bea/disable-xmlrpc`, type `wordpress-muplugin`

## 0.1 - 27 Nov 2015
* Initial release: disable XML-RPC, remove the `X-Pingback` header and the RSD link
