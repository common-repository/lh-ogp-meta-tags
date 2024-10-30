=== LH OGP Meta ===
Contributors: shawfactor
Donate link: https://lhero.org/portfolio/lh-ogp-meta-tags/
Tags: open graph, ogp, facebook open graph, facebook meta, open graph meta, facebook share, facebook like, facebook
Requires at least: 3.0.
Tested up to: 4.9
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds OGP and Facebook meta to your website 

== Description ==
This plugin adds accurate Open Graph Meta tags and the Facebook specific meta tags to your site. The idea is to keep minimal settings and options as to remain out of your way and in the background while still proving the options you need to share content flexibly. Without the bloat of some other plugins.

= Image Handling =
if the post page or CPT is singular it firstly look for the OGP image specified on the post edit screen image. It will then look for the featured image. If that isn't there either, then it will default to using the site icon image (usually set under Appearance->Customiser. If THAT isn't there then... well you fail and you won't have an image.

= Description Handling =
The plugin looks in three places for an Open Graph description.

1. The OGP description in the sidebar
2. if the above is not specified it will try to use the post excerpt.
3. If the above aren't specified it will use the post content (stripped of invalid tags).

= Testing Your Site =
Once you've enabled the plugin head over to Facebook's testing tool and paste in one of your post/page url's or your home page to see what info Facebook is pulling in. This tool is located here: <a href="https://developers.facebook.com/tools/debug">https://developers.facebook.com/tools/debug</a>


Check out [our documentation][docs] for more information. 

All tickets for the project are being tracked on [GitHub][].


[docs]: http://lhero.org/plugins/lh-ogp-meta-tags/
[GitHub]: https://github.com/shawfactor/lh-ogp-meta-tags

Features:

* Select a post image specifically for sharing
* Handles Facebook specific meta like fb:admins and fb:app_id
* maps different users to different article:author properties
* Automatic generation of the description or add a custom description


== Installation ==

1. Upload the entire `lh-ogp-meta-tags` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Optionally navigate to Settings->LH OGP Meta and set the image and optionally, the facebook meta
4. Optionally navigate to the User profile page and add the users facebook url.


== Changelog ==

**1.0 September 08, 2015**  
Initial release.


**1.1 September 17, 2015**  
Add settings link

**1.2 November 7, 2015**  
Fixed JS

**1.32 March 7, 2016**  
Added custom description

**1.40 March 10, 2016**  
Use Site Icon

**1.50 March 28, 2016**  
Major bug fix

**1.51 April 02, 2016**  
Documentation

**1.60 April 18, 2016**
complete OOP rewrite

**1.62 April 19, 2016**  
Bug Fix

**1.63 May 12, 2016**  
Escape Attribute and sanitize

**1.64 October 10, 2016**  
Added AMP check for xmlns output

**1.66 October 12, 2016**  
Bugfix for amp check


**1.67 April 2, 2017**  
Minor bugfixes and moved options to own file

**1.68 May 04, 2017**  
Added nonce

**1.70 September 10, 2017**  
Added additional images

**1.72 October 18, 2017**  
Code simplification

**1.73 November 30, 2017**  
Added locale