# Youtube No Cookie 

Lets you drop a regular Youtube video link into your post and will turn this link into a privacy enhanced embed when shown to visitors.

## Description 

This plugin rewrites Youtube embed links so that they become privacy friendly. 

It also adds a simple wrapper so that you can make your embedded videos responsive (see below).

This plugin won't work if you also have the Jetpack module Shortcode enabled. This module is enabled by default if you are using Jetpack, so if you do not wish to use the Shortcode module and you do wish to use the Youtube No Cookie plugin, you will have to disable the former first.

So what is the deal with privacy-enhanced Youtube videos?

Wordpress has a useful feature where if you drop a Youtube link in your post, the link will be turned into a video player. 

When a visitor arrives on a page that has a Youtube video on it, Youtube will immediately start to place cookies, regardless of whether the visitor wants to view the video or not.

Youtube has a privacy-enhanced mode, but unfortunately Wordpress doesn't know about this. The privacy-enhanced mode waits with placing cookies until the visitor has started watching the video.

Without a plugin like this, the only way you could use this privacy-enhanced mode, is by using your own player. For example, if you go to the video you wish to share on Youtube and click on Share, then click on Embed, Youtube will generate a video embed code that you can copy and paste to any website, including your Wordpress website. Scroll down a little before you copy and you will find a small number of options that Youtube will let you set. 

Among those options is "Enable privacy-enhanced mode". If you set this option, Youtube will change the embed code on the fly. You can now copy and paste the privacy-enhanced embed code to your website.

In practice I find this to be cumbersome, and I have also noticed editors tend to forget about the privacy-enhanced settings.

The Wordpress embed functionality makes it simple to drop a link into a post and forget about it, but that also means that it becomes simple to forget about the privacy of your visitors.

This plugin in turn makes it so you can safely drop Youtube URLs in your posts and they will be turned into privacy enhanced embeds.

The plugin provides the following functionality: 

* Turns regular Youtube video embeds into Youtube privacy-enhanced video embeds.
* Adds class names that help you determine the aspect ratio of the video.
* Adds a wrapper element, so that you can make responsive videos (see below).


### Responsive videos 

Add the following to your stylesheet for responsive videos. 

The following CSS will make it so the iframe spans the width of its container and that the height is derived from that width using a sensible formula.

    .videowrapper {
      display: block;
	  position: relative;
	  height: 0; /* Gives IE 5 and IE 6 'lay-out'. */
	  padding-bottom: 56.25%; /* Default to 16:9 aspect ratio. */
    }

    .videowrapper iframe {
      border: none;
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
    }

A 16:9 aspect ratio is a good guess for Youtube videos, as this is the default for computers, but in case you need a different aspect ratio, you can use the class names provided by the plugin:

    .videowrapper.aspect_ratio_500 { padding-bottom: 50%;    /* 2:1 */ }
    .videowrapper.aspect_ratio_541 { padding-bottom: 54.05%; /* 1.85:1 */ }
    .videowrapper.aspect_ratio_563 { padding-bottom: 56.25%; /* 16:9 */ }
    .videowrapper.aspect_ratio_750 { padding-bottom: 75%;    /* 4:3 */ }

See https://support.google.com/youtube/answer/6375112 for more info on Youtube's aspect ratios.



## Installation 

1. Check if you are running the Shortcode Embeds module of the Jetpack plugin. The Youtube No Cookie plugin will not work with it.
1.a. If you do run that plugin (it is enabled by default when you install Jetpack) and you don't intend to use its functionality, disable it.
2. Put the directory containing Youtube No Cookie into the plugins directory of your Wordpress website: wp-content/plugins.
3. In the administration interface of your Wordpress website, go to Plugins.
4. Locate the entry called Youtube No Cookie and click Activate.
5. That is it.



## Changelog 

### 0.1 

* First release.



## Rationale 

How do these things go? 

I needed a privacy enhancer for my website, but it also had to be ready for responsiveness. None existed, so I made one myself.

## Authors

* Branko Collin.

## License

This project is licensed under GPL2, see https://www.gnu.org/licenses/gpl-2.0.html for more information.

