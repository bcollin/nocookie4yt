<?php
/*
Plugin Name: No Cookie for Youtube
Description: Lets you drop a regular Youtube video link into your post and will turn this link into a privacy enhanced embed when shown to visitors.
Version: 0.1
Author: Branko Collin
Author URI: http://www.abeleto.nl
License: GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/



// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}



/**
 * 
 * Handles registered video embeds.
 * 
 * @param string $html The HTML returned by the oEmbed provider.
 * @param string $url  The URL returned by the oEmbed provider.
 * @param array $attr Some attributes returned by the oEmbed provider.
 *  
 * @return string The altered HTML.
 * 
 */
function nocookie4yt_video_embed_handler( $html, $url, $attr ) {

  $segments = parse_url($url);
	$is_yt = preg_match('/youtube\.com$/', $segments['host']);
	if ( !$is_yt ) {
		return $html;
  }

	$aspect_ratio = 0;
  $out = '';

	$width = empty( $attr['width'] ) ? 0 : $attr['width'];
	$height = empty( $attr['height'] ) ? 0 : $attr['height'];

	// Sometimes Wordpress will fill the width and height attributes
	// with what it calls 'default values', though it is not clear
	// to me why. Check the HTML to see if we have better values.
	$test1 = preg_match( '/<iframe[^>]*>/', $html, $matches );
	if ( ! empty( $matches[0] ) ) {
		$test2 = preg_match_all( '/(width|height)=[\'"]([0-9]+)[\'"]/', $matches[0], $matches_attr );
		if ( false !== $test2 && ! empty( $matches_attr[2] ) ) {
			foreach( $matches_attr[1] as $key => $value ) {
				if ( 'width' === $value ) {
					$width = $matches_attr[2][ $key ];
				}
				if ( 'height' === $value ) {
					$height = $matches_attr[2][ $key ];
				}
			}
		}
	}

	if ( ( 0 !== $width ) && ( 0 !== $height ) ) {
		$aspect_ratio = nocookie4yt_get_aspect_ratio( $width, $height );
	}

	$out = str_replace( 'youtube.com/embed', 'youtube-nocookie.com/embed', $html );
	$out = nocookie4yt_wrap_iframe( $out, $aspect_ratio );

	return $out;
}

// Filters embedded videos.
add_filter( 'embed_oembed_html', 'nocookie4yt_video_embed_handler', 10, 3 );



/**
 *
 * Adds a wrapper to an iframe.
 *
 * @param string $html HTML that needs to be wrapped.
 * @param string $aspect_ratio Aspect ratio of a video.
 *
 * @return string Altered HTML.
 *
 */
function nocookie4yt_wrap_iframe( $html = '', $aspect_ratio = '0' ) {

	$out = '';
	$arclass = 'aspect_ratio_' . $aspect_ratio;

	$out = '<span class="videowrapper embed-youtube-nocookie ';
	$out .= $arclass . '">' . $html . '</span> <!-- /.videowrapper -->';

	return $out;
}



/**
 *
 * Calculates the aspect ratio of a video.
 *
 * Make sure you pass either two parameters or none.
 *
 * @param int $width The width of the video.
 * @param int $height The height of the video.
 *
 * @return string A string representing a number between '000' 
 *       and '999'. On error, the string returned will be '0'.
 *
 */
function nocookie4yt_get_aspect_ratio( $width = 16, $height = 9 ) {

	if ( $width < 1 || $height < 1 ) {
		return '0';
	}

	$long = $width;
	$short = $height;

	if ( $width < $height ) {
		$long = $height;
		$short = $width;
	}

	$aspect_ratio = $short / $long;

	$aspect_ratio_s = (string) ceil( $aspect_ratio * 1000 );

	if ( '1000' === $aspect_ratio_s ) {
		// Square format.
		$aspect_ratio_s = '000';
	}

	return $aspect_ratio_s;
}


/**
 *
 * Displays an error message. 
 *
 */
function yt_cookie_jetpack_error() {
	$jetpack_settings = get_site_url() . '/wp-admin/admin.php?page=jetpack_modules#related-posts';
	?>
	<div class="notice notice-error is-dismissible">
	<p>The Jetpack Shortcodes Embed module is enabled. That means that the Youtube No Cookie plugin won't work and that the privacy of your visitors is at risk. <a href="<?php print $jetpack_settings; ?>">Disable the Jetpack Shortcodes Embed module</a>, or better yet, take Jetpack out back and burn it.*</p> 
	<p>*) Note: only burn Jetpack if you don't need Jetpack anymore.</p> 
	</div>
	<?php
}

// Action 'yt_cookie_jetpack_error' for 'admin_notices'.
if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'shortcodes' ) ) {
	add_action( 'admin_notices', 'yt_cookie_jetpack_error' );
}
