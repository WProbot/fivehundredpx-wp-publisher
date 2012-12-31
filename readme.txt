=== 500px WP Publisher ===
Contributors: danosipov
Tags: 500px, photography, import, photo, profile
Requires at least: 3.0.1
Tested up to: 3.5
Stable tag: 1.0
License: MIT

Import shots from 500px profile as Wordpress posts.

== Description ==

This plugin takes the new shots from 500px profile, and posts them into the blog.
If more than one photo has been posted between runs, the post contains the highest ranked photo first, followed by smaller thumbnails of additional photographs.
Post template is kept in file `post_template.php` in plugin directory. Modify it if you would like to change the post content.

== Installation ==

NOTE: this plugin requires that your php installation support curl. 
See http://us3.php.net/manual/en/book.curl.php for more info

To properly configure the plugin, please follow these steps:

1. Upload `fivehundredpx-wp-publisher` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Give `fivehundredpx-wp-publisher/cron.php` execute permissions, by running the following:
`chmod +x /wp-content/plugins/fivehundredpx-wp-publisher/cron.php`
4. Add a cron job on your server to call the plugin, for example:
00 12 * * * php /var/www/wp-content/plugins/fivehundredpx-wp-publisher/cron.php
See http://linuxconfig.org/linux-cron-guide for more information about cron.
5. In the Wordpress Settings, select '500px Publisher', and fill in all fields.

== Changelog ==

= 1.0 =
* Initial release

== Upgrade Notice ==
