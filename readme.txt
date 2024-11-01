=== SQUARE Custom Sidebars ===
Contributors: daniellapides
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=UPPPPY6G8U9R2
Tags: sidebar, sidebar management, custom sidebar, custom sidebars, sidebars, square sidebars, widgets, widgetized, square
Requires at least: 3.8
Tested up to: 3.9
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

SQUARE Sidebars is a sidebar management plugin for WordPress that allows the users to create and manage custom sidebars.

== Description ==

**SQUARE Sidebars** is a sidebar management plugin for WordPress that allows the users to create and manage custom sidebars directly from the WordPress administration. It aims at giving the users the magic wand to create, manage and replace sidebars.
The SQUARE Sidebars plugin is made to boost WordPress websites by allowing the users to display different contents and calls to action on each pages of their willing.

Thus, plenty of display options are available. It is possible to display a custom sidebar by all or specific:

* Singulars - e.g. posts, pages, custom post types
* (Custom) Post types
* Medias
* Categories, Tags, Custom taxonomies
* Page Formats
* Page Templates

The custom sidebar manager makes it very easy for anyone to create and manage custom sidebars and widgetized areas without any line of code.

The plugin is compatible with every and any WordPress themes and is shortcode based.

= Features for users =

* Add and manage custom sidebars and replace existing ones using the familiar WordPress UI.
* Searchable and filterable custom sidebars.
* Shortcode based.

= Features for devs =

* The Sidebar Management Tool plugin is fully-based on the WordPress Plugin API.
* Uses PHPDoc conventions to document the code.
* This plugin has been translated in English and French.
* This plugin includes a .pot as a starting translation file.

= Shortcodes =

**[square_sidebars id="sidebar_id"]**
This shortcode allows users to display a sidebar in a post/page/custom post type.

= Languages and translations =
* English (default)
* French (fr_FR)

You can contribute translations to this plugin by sending your translation via GitHub: https://github.com/daniellapides/SQUARE-Sidebars/.

= Contributing and reporting bugs =

You can contribute code to this plugin via GitHub: https://github.com/daniellapides/SQUARE-Sidebars/.

== Installation ==

= Automatic installation =

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don't even need to leave your web browser. To do an automatic install: 

1. Log in to your WordPress admin panel.
2. Navigate to the Plugins menu.
3. Click on Add New.
4. In the search field, type "SQUARE Sidebars".
5. Click on Search Plugins.
6. Once you've found the plugin, you can install it by clicking on Install Now.

= Manual installation =

1. Copy the square-sidebars directory into your wp-content/plugins directory using your favorite FTP program or your hosting control panel.
2. Navigate to the Plugins dashboard page within the WordPress admin.
3. Click on Activate.

== Screenshots ==

1. Add a new SQR Sidebar.
2. All SQR Sidebars.
3. Add widgets to a new SQR Sidebar.

== Changelog ==

= 1.6.1 =
* Fixed: error when on archive page (category, tag, etc.).
* Fixed: code a bit cleaner.

= 1.6.0 =
* Added: [square_sidebars] shortcode, which is the same as the other one but probably easier to remember.
* Added: available shortcode is displayed inside the post and in the post list.
* Added: advanced options (before_widget, after_widget, before_title, after_title).
* Added: search through the display options.
* Fixed: character count for short description.
* Fixed: numbers and hyphens in sidebar ID (post name) is possible.

= 1.5.0 =
* Added: [square_sidebars] shortcode, which is the same as the other one but probably easier to remember.
* Added: error message when there are numbers and/or hyphens in sidebar ID (post name).
* Modified: uses the post_meta table.
* Modified: uses the dashicons default WordPress font.
* Modified: a little work on the design.

= 1.0.0 =
* New: SQUARE Sidebars launch.