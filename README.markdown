# cosmTriggers
Cosm is an awesome web service for collecting any kind of data. It offers the possibility to set triggers on certain events, such as reaching a certain threshold, or the lack of updates (freeze). However, it can only post a twitter message, or send a HTTP request. In my case, I wanted to be notified via email when one of my datastreams froze. So I wrote this small php script, which sends out emails, based on templates, whenever a triggering event happens.

## Features
* Different templates for different kinds of triggers
* Restriction to a list of feeds
* ...

## Installation
1. Clone the repository, or download and extract the .zip somewhere into your web root or a subdirectory.
2. Open `post.php` and change the config parameters to your needs.
  * `$email` is the email address, which will recieve the notification emails.
  * `$authorized_feeds` is an array of feed ids, which are allowed to use your installation of cosmTriggers.
3. Adjust templates to your liking.
4. Go to your Cosm feeds, add a trigger, select "HTTP Request" as your method of notification, and insert the full URL to your `post.php` file.
5. Enjoy your email notifications.
