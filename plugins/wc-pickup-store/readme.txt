=== WC Pickup Store ===
Contributors: keylorcr
Donate link: https://www.paypal.me/keylorcr
Tags: ecommerce, e-commerce, store, local pickup, store pickup, woocommerce, local shipping, store post type, recoger en tienda
Requires at least: 4.7
Tested up to: 5.2.4
Stable tag: 1.1.1
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WC Pickup Store is a custom shipping method that lets you to set up one or multiple stores to local pickup in the Checkout page in WooCommerce

== Description ==
WC Pickup Store is a shipping method that lets you to set up a custom post type "store" to manage stores in WooCommerce and activate them for shipping method "Local Pickup" in checkout page. It also includes several options to show content by Widget or a WPBakery Page Builder component. Configuration of shipping costs are also available globally or per stores.


### Features And Options:
* Shipping costs globally or per stores.
* Compatible with WPBakery Page Builder with its own addon.
* Widget option.
* Dropdown of stores on the Checkout page.
* Local pickup details in thankyou page, order details and emails.
* Archive template is now available.
* All templates from /wc-pickup-store/templates/ can be overridden in your custom themes.
* Filters and actions are available throughout the code to manage your own custom options.
* Font Awesome and Bootstrap CSS libraries are included in the plugin. You can disable them from the plugin configuration page
* Shipping email notification to stores in the store admin page
* New order and orderby options


== Installation ==

= Requires WooCommerce =

1. Upload the plugin files to the `/wp-content/plugins/wc-pickup-store` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Go to settings page from `Menu > Stores > Settings` or the shipping methods page in WC to activate `WC Pickup Store` shipping method.
4. Done.


== Frequently Asked Questions ==

= How to setup? =
Just activate the plugin, go to settings page and enable the shipping method. Customize the shipping method title, default store and checkout notification message.

= How to manage stores? =
Go to Menu > Stores > All Stores > Add New

= Can I edit the store templates? =
Yes, you can override all the templates. Just copy from /plugins/wc-pickup-store/templates/ to /theme/template-parts/. Single store and archive page might be overriden in /theme/ directory as WordPress does.

= How do I replace or remove waze icon? =
Simply use filters wps_store_get_waze_icon or wps_store_get_vc_waze_icon to manage waze icon

= Can I set a default store in checkout? =
Yes, just go to Menu > Appearance > Customize > WC Pickup Store > Default Store

= Can I set custom page without using WPBakery Page Builder? =
The shortcode functionality had been removed since previous versions but since version 1.5.13 you can use the `archive-store.php` located in the plugin templates directory

= Is there a way to add a price for the shipping method? =
Fortunately since version 1.5.13 the option to set custom costs by shipping method or per stores is available. Hope you enjoy it!

= Can I send an email to the store with the order details, is that possible? =
Sure, now you can add an email address into the store admin page and it will be notified on order sent to this store.

== Screenshots ==
1. WC Pickup Store shipping configurations.
2. Default Store.	
3. Checkout page.
4. Order details.
5. VC element.
6. VC element Result.
7. Widget Element.
8. Widget Element Result.
9. Published store validation.
10. WC error after store validation.
11. Email notification
12. Shipping cost by shipping method
13. Shipping cost per stores
14. Order Email Notification
15. Order and Orderby options


== Changelog ==
= 1.5.20 =
* Fix filter wps_order_shipping_item_label parameter

= 1.5.19 =
* Update textdomain as a global variable
* New filter wps_order_shipping_item_label wrapping the shipping order/checkout label
* New order and orderby options are added to the configuration page

= 1.5.18 =
* Fix BS+4 conflict with .col class in includes/vc_stores.php

= 1.5.17 =
* Fix FA+5 icon in VC template

= 1.5.16 =
* Fixing issue with local and external libraries validation

= 1.5.15 =
* Validation for local and external libraries
* Function to return main instance for WC_PICKUP_STORE
* New admin fields store_order_email and enable_order_email

= 1.5.14 =
* Change of wp_enqueue_style instead of using wp_register_style with bootstrap and font awesome libraries

= 1.5.13 =
* **New** shipping method custom price
* **New** adding shipping method price per store
* Fix in VC element initialization
* Fix in image custom size validation used in VC custom element
* **New** Archive Template
* New .pot file
* Font Awesome and Bootstrap css have been included

= 1.5.12 =
* Logo waze svg
* Filters wps_store_get_waze_icon and wps_store_get_vc_waze_icon to manage waze icon

= 1.5.11 =
* Single store template
* Filter wps_store_query_args for store query args
* Fix esc_html to print content in template
* VC element and widget from template

= 1.5.10 =
* Validate whether all stores are published, otherwise, shipping method is not applicable
* Fix selected store notification in emails
* Notification was added in admin panel 
* Editor field was added to stores

= 1.5.9 =
* Latest stable version


== Upgrade Notice ==
= 1.5.20 =
* Fix filter wps_order_shipping_item_label parameter

= 1.5.19 =
* New filter wps_order_shipping_item_label wrapping the shipping order/checkout label
* New order and orderby options are added to the configuration page

= 1.5.18 =
* Fix BS+4 conflict with .col class in includes/vc_stores.php

= 1.5.17 =
* Fix FA+5 icon in VC template

= 1.5.16 =
* Fixing issue with local and external libraries validation

= 1.5.15 =
* Validation for local and external libraries
* New admin fields store_order_email and enable_order_email
* Compatibility for WC 3.6.4 and WP 5.2.2

= 1.5.14 =
* Change of wp_enqueue_style instead of using wp_register_style with bootstrap and font awesome libraries

= 1.5.13 =
* Shipping costs added by shipping method or per each store
* Archive template added
* File .pot updaded
* Fixes in VC element
* Font Awesome and Bootstrap css have been included

= 1.5.12 =
* Filters wps_store_get_waze_icon and wps_store_get_vc_waze_icon to manage waze icon

= 1.5.11 =
* Fix esc_html to print content in template

= 1.5.10 =
* Fix selected store notification in emails
* Fix validation for available stores in checkout

= 1.5.9 =
* Fix: Validate shipping method before to show the store in checkout page
* Update: Change in shipping method title to remove the amount ($0.00)

= 1.5.8 =
* Update: Textdomain and function names
* Delete: provincias taxonomy
* Add: Minify VC element styles file
