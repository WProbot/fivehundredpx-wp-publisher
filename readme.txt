=== 500px WP Publisher ===
Contributors: danosipov
Tags: 500px, photography, import, photo, profile
Requires at least: 3.0.1
Tested up to: 3.5
Stable tag: 1.1
License: MIT

Import shots from 500px profile as Wordpress posts.

== Description ==

This plugin takes the new shots from 500px profile, and posts them into the blog.
If more than one photo has been posted between runs, the post contains the highest ranked photo first, followed by smaller thumbnails of additional photographs.
Post template is kept in file `post_template.php` in plugin directory. Modify it if you would like to change the post content.
Also, the plugin is available on github for anyone who's interested: https://github.com/danosipov/fivehundredpx-wp-publisher

== Installation ==

NOTE: this plugin requires that your php installation support curl. 
See http://us3.php.net/manual/en/book.curl.php for more info

To properly configure the plugin, please follow these steps:

1. Upload `fivehundredpx-wp-publisher` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. In the Wordpress Settings, select '500px Publisher', and fill in all fields.

== Changelog ==

= 1.1 =
* Remove cron, use WP scheduled events

= 1.0 =
* Initial release

== Upgrade Notice ==
