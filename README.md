# WP Starter `v 2.6.7`

A simple & lean WordPress Framework theme, with the latest Bootstrap and other WordPress handy functions.
This is meant to be used as a Parent Theme, therefore it needs a companion, like [WP-Starter Child Theme](https://github.com/Jany-M/WP-Starter-Child-Theme) to work as intended.
Place both in your WordPress wp-contents/themes folder, and activate the Child Theme.

The Framework has been developed throughout the years, for various projects and it constantly gets updated.
All updates go directly to your site, you don't have to check back here, you'll see an updated icon (like for other Themes).

Comes with:

> Twitter Bootstrap JS/CSS

> Font Awesome CSS

> Custom Modernizr built

> ImagesLoaded, Isotope & Infinite Scroll scripts (not registered by default during setup) - Check out the [guide](http://www.shambix.com/en/isotope-twitter-bootstrap-infinite-scroll-fluid-responsive-layout/) to use them all at once

> Theme Support (menus, html, woocommerce, post-thumbnails)

> Latest jQuery (not using WordPress built-in one)

> Localization support (create a /languages folder in Child Theme and place po/mo files there, then use $theme_name as domain name)

> Developer scripts for backend use / debug

> Integration with TGM plugin activation, for mandatory/recommended plugins (might move it to Child Theme build)

> A bunch of handy scripts and shortcodes for buttons and styles in content editor (must uncomment the files from functions.php)

Ready to use with [WP Imager](https://github.com/Jany-M/WP-Imager) - Download it separately and place it inside /library/helpers.


## History

**1/3/2016**
- version 2.6.7
- changed `function shorten` and `function custom_excerpt` to return, instead of echo
- added  `function custom_query_pagination`
- added wp starter version constant
- minor edits

**23/3/2015**
- version 2.5
- leaner framework
- updated boostrap
- updated functions
- added fontawesome, modernizr
- removed styles
- removed WP theme files (moved to Child Theme)

**10/1/2015**
- updated bootstrap
- updated timthumbs
- re-ordered structure
- updated WP-Imager

**31/8/2014**
- `release` version 1.0

## Credits

[Twitter Bootstrap](https://github.com/twbs/bootstrap)

## Author

Jany Martelli @ [Shambix](http://www.shambix.com)

## License

Released under the [GPL v3 License](http://choosealicense.com/licenses/gpl-v3/)