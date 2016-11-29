<?php
/******
Parallelize downloads across hostnames for WordPress. 
Useful to boost static resources load speed on websites.
Recommended by GTmetrix, Pingdom, Google Speed Insights, and others.
See full post > https://medium.com/p/32e9dc2fec0c
In order to work properly, all subdomains/hostnames MUST have the same structure/path. Ex:
http://mydomain.com/wp-content/uploads/2015/11/myimage.jpg
http://media1.mydomain.com/wp-content/uploads/2015/11/myimage.jpg
http://media2.mydomain.com/wp-content/uploads/2015/11/myimage.jpg
Add to functions.php
******/
function parallelize_hostnames($url, $id) {
	$hostname = par_get_hostname($url); //call supplemental function
	$url =  str_replace(parse_url(get_bloginfo('url'), PHP_URL_HOST), $hostname, $url);
	return $url;
}
function par_get_hostname($name) {
	$subdomains = array('media1.mydomain.com','media2.mydomain.com'); //add your subdomains here, as many as you want.
	$host = abs(crc32(basename($name)) % count($subdomains));
	$hostname = $subdomains[$host];
	return $hostname;
}
add_filter('wp_get_attachment_url', 'parallelize_hostnames', 10, 2);