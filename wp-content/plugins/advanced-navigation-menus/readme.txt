=== Advanced Navigation Menus ===
Contributors: caiocrcosta
Tags: navigation, menu, wp_nav_menu, advanced, shortcode, css, class
Requires at least: 3.0
Tested up to: 3.4
Stable tag: 0.6.5

Adds shortcodes capability and advanced CSS classes to navigation menus.

== Description ==

Advanced Navigation Menus adds missing functionality in the navigation system by accepting shortcodes and adding
CSS tags on each item.

= Features =
* CSS classes for nearly every need
* Shortcodes
* URL replacements (no link, login, logout)

= Classes =
* *first-item* and *last-item* in each depth
* Sub-menus have their own *depth-#*.
* Parent ID on each menu item
* Menu Parent ID on each menu item
* No parent class
* Global item order
* Menu item order
* Identify menus with sub-menus

= Shortcodes =
* [%user_login%] - User login
* [%user_ID%] - User ID
* [%user_firstname%] - User first name
* [%user_lastname%] - User last name
* [%user_email%] - User email
* [%user_displayname%] - User display name

See more on the [usage instructions page](http://wordpress.org/extend/plugins/advanced-navigation-menus/other_notes/ "Advanced Navigation Menus Usage").

== Installation ==

1. Upload the folder `advanced-navigation-menus` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place the menus in your template using wp_nav_menu()

See [usage instructions](http://wordpress.org/extend/plugins/advanced-navigation-menus/other_notes/ "Advanced Navigation Menus Usage")
for more information.

== Usage ==


= CSS =
After activating the plugin you will already have several CSS classes added to your menu. Check the
[screenshots](http://wordpress.org/extend/plugins/advanced-navigation-menus/screenshots/) to take a look at them.
No more browser incompatibility with :last-child!

= URL replacements =
Use the following in a custom link URL field
* *#nolink#* - The item will not be printed as a link.
* *#login#* - Login link. Same as *wp_login_url( get_permalink() )*.
* *#logout#* - Login link. Same as *wp_logout_url( get_permalink() )*.

= Shortcodes =
You can also use shortcodes in your menus, like *Hi, user!*.

**Accepted shortcodes**

* [%user_login%] - User login
* [%user_ID%] - User ID
* [%user_firstname%] - User first name
* [%user_lastname%] - User last name
* [%user_email%] - User email
* [%user_displayname%] - User display name

* [%date%] - Current date


== Screenshots ==

1. CSS classes everywhere!
2. Menu item name on backend
3. Menu item name on frontend

== Changelog ==

= 0.6.5 =
* Added: #login# and #logout# URL replacements

= 0.6.4 =
* Changed: class "have_sub-menu" to "has_sub-menu"

= 0.6.3 =
* Little code improvement

= 0.6.2 =
* Fixed: variable reference bug with plugin.php

= 0.6.1 =
* Fixed: first-item and last-item placed only in the last item

= 0.6 =
* Added: CSS class for menus with sub-menus
* Deprecated: identify_first_and_last in favor of identify_nodes

= 0.5 =
* Changed: date shortcode now returns localized date

= 0.4.1 =
* Added: menu item order (former sub-menu item order), gone in last update
* Added: date shortcode

= 0.4 =
* Added: support to sub-menus deeper than one level
* Changed: Sub-menu depth now starts at 1 (*ul.sub-menu.depth-1*)

= 0.3.1 =
* Bugfix
* Added: *span.text* wrapper to dummy texts

= 0.3 =
* Added: support to dummy text (no link)

= 0.2 =
* Added: shortcodes.
* Added: screenshots.
* Changed: description, to better reflect the plugin purpose.

= 0.1 =
* Unstable, untested, don't-use-it-yet beta version