=== Plugin Name ===
Contributors: raymond8505
Donate link: http://www.interslicedesigns.com
Tags: media, image, plugin
Requires at least: 3.0.1
Tested up to: 4.0
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Creates a jpg version of any TIFF file you upload.

== Description ==

When you upload a TIFF attachment, a second jpeg attachment will be created that can be used as the preview of the TIFF. The plugin also makes it so the preview image stands in for the tif image for normal image functions like wp_get_attachment_image() it also sets the preview image as the tif's featured image so calling get_post_thumbnail_id() on the tif ID returns the id for its preview REQUIRES IMAGE MAGICK. Also if you're going to be uploading TIFF files to your site, you'll probably want to increase your upload limit.

== Frequently Asked Questions ==

= Do I really need Imagick? =

Yup.

== Screenshots ==

1.

== Installation ==

1. Just Click Activate, if your server doesn't have the Image Magick extension installed in PHP, it will not activate

== Changelog ==

= 1.0 =
* Plugin Created

== Upgrade Notice ==

= 1.0 =
Plugin Created

== Arbitrary section ==

== A brief Markdown Example ==

Ordered list:

1. When you upload a TIFF attachment, a second jpeg attachment will be created that can be used as the preview of the TIFF. 
1. Makes it so the preview image stands in for the tif image for normal image functions like wp_get_attachment_image()
1. sets the preview image as the tif's featured image so calling get_post_thumbnail_id() on the tif ID returns the id for its preview 