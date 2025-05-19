=== Devicons ===
Contributors: ryderdamen
Donate link: https://ryderdamen.com/buy-me-a-beer
Tags: devicon, devicons, development icons, software icons, html5 icon, css3 icon, web development icons
Requires at least: 3.5.1
Requires PHP: 5.6
Tested up to: 4.9.4
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display Devicons (Software and Web Developer Icons) on your WordPress site.

== Description ==

Devicons is a plugin that allows you to easily display Devicons (Software and Web Developer icons) on your WordPress site. Show off your skills by including them in a graphical way. This plugin is based on the [Devicon project by Julien Monty](http://konpa.github.io/devicon/).
 


== Installation ==

= Using The WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Search for 'Devicons'
3. Click 'Install Now'
4. Activate the plugin on the Plugin dashboard

== Frequently Asked Questions ==

= How do I display one devicon? =

You can show one devicon as an inline style by using the shortcode ` [devicon icon="wordpress"] ` in a page or a post. This will return the colour, non-title version of that icon inline. This means it's returned in the html tag you put it in. If you wrap the shortcode in a h1 tag, it will return with the same font-size as your h1 (page titles), or the same with a regular p (paragraph) tag.

= How do I display multiple devicons? =
You can display multiple devicons either by stringing together the above 'devicon' shortcode, or by using the following shortcode:


`
[devicons]
wordpress
facebook
illustrator
[/devicons]

`

Simply list the ones you want within the shortcode, (separated by a space, comma, or enter key) and the plugin will display them for you. These once again default to colour without titles, but are not displayed inline. These instead are displayed as 50px size icons, giving you a better way to showcase a bunch of skills for a particular project.

= How do I display icon titles (wordmarks)? = 
If you hover over an icon, it will always return the title of that icon for web accessibility purposes. You can however show the title right on the icon if you like. This is available for most (but not all) icons, but the plugin will simply return the non-titled version if it's not available. To show titles, simply add the title="true" parameter to the shortcode. Here are a few examples:

When requesting a single devicon with a title: 
`
[devicon icon="wordpress" title="true"]
`

When requesting multiple devicons with titles: 
`
[devicons title="true"] wordpress docker [/devicons]
`


= How do I set a custom colour? = 
Icon colours can be customized with the color="#cc0000" (American spelling) tag. You can input any CSS-valid colour here, but most people will just put in a hex code like #cc0000. Here are a few examples:

When requesting a single devicon with the colour #cc0000:
`
[devicon icon="wordpress" color="#cc0000"]
`

When requesting multiple devicons with the colour #cc0000: 
`
[devicons color="#cc0000"] wordpress docker [/devicons]
`


== Screenshots ==

1. A screenshot showing a full list of rendered, coloured devicons without titles.
2. A screenshot showing devicons with titles, of a specific colour.

== Changelog ==

= 1.0 =
* The first release.

== Upgrade Notice ==

= 1.0 =
* The first release.