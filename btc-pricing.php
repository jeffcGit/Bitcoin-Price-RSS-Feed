<?php

/**
* BTC RSS FEED 
* @author Jeff Cyprien
* Created: 01/01/2015
* Modified: 06/10/2021
**/


//variables
$url = "https://bitpay.com/api/rates";
$json = file_get_contents($url);
$data = json_decode($json, true);
$rate = $data[1]["rate"];
$bitcoin_price = 1; #price for a dollar
$usd_price = round($bitcoin_price * $rate, 8);
date_default_timezone_set("US/Eastern");
$current_time = date("g:i a");
$now = time();
$pubDate = date("r", $now);
$url = "https://bitpay.com/api/rates";
$json = file_get_contents($url);
$data = json_decode($json, true);
$rate = $data[2]["rate"];
$bitcoin_price = 1; #price for a dollar
$usd_price = round($bitcoin_price * $rate, 8);

// Condition to display a void, avoiding capturing a zero price value
if ($usd_price === 0) {
     die();
}

// Random text creation for our feed content
$strings = array(
    'Latest',
    'Recent',
    'Most recent',
    'Late',
);
$new_syn = array_rand($strings);
// echo $strings[$new_syn];
$strings1 = array(
    'price',
    'cost',
    'value',
    'worth of cash',
    'monetary value',
);
$price_syn = array_rand($strings1);
// echo $strings1[$price_syn];
$strings2 = array(
    'Just a while ago',
    'Lately',
    'A few minutes ago',
    'About 15 minutes ago',
    'Recently',
    'A few moment ago',
    'Most recently ',
    '15 minutes ago',
);
$recently_syn = array_rand($strings2);
// echo $strings2[$recently_syn];


//	This is where we are creating our RSS Feed
echo header('Content-Type: application/rss+xml; charset=utf-8');
echo "<?xml version='1.0' encoding='UTF-8' ?>\n";
echo "<rss version='2.0' xmlns:atom='http://www.w3.org/2005/Atom'
xmlns:content='http://purl.org/rss/1.0/modules/content/'
xmlns:wfw='http://wellformedweb.org/CommentAPI/'
xmlns:dc='http://purl.org/dc/elements/1.1/'
xmlns:sy='http://purl.org/rss/1.0/modules/syndication/'
xmlns:slash='http://purl.org/rss/1.0/modules/slash/'>\n";
	
echo "<channel>\n";

echo "<title>Bitcoin Price</title>\n";
echo "<description>Latest Bitcoin Price Reminder</description>\n";
echo "<link>https://s.fidex.tech/rss_feed_btc.php</link>\n";
echo "<language>en-us</language>\n";
echo "<copyright>Copyright 2021 fidextech</copyright>\n";
echo "<lastBuildDate>$pubDate</lastBuildDate>\n";
echo "<pubDate>$pubDate</pubDate>\n";
echo "<ttl>60</ttl>\n";

echo "<atom:link href='https://s.fidex.tech/rss_feed_btc.php' rel='self' type='application/rss+xml'/>\n";

echo "\n";
echo "<image>\n";
echo "	<url>https://blog.fidex.tech/wp-content/uploads/2018/11/cropped-cropped-inline_blog.resized.png</url>\n";
echo "<title>Bitcoin Price</title>\n";
echo "<link>https://s.fidex.tech/rss_feed_btc.php</link>\n";
echo "	<width>32</width>\n";
echo "	<height>32</height>\n";
echo "</image> \n";
echo "\n";

// news items to produce RSS feed
$items = array(
    array(
        'title' => "$strings[$new_syn] Bitcoin $strings1[$price_syn]: $$usd_price USD for ฿1 BTC. ;) Current time: $current_time US/Eastern. #bitcoin #bitcoinprice",
        'link' => "https://fidex.tech",
        'desc' => "$strings2[$recently_syn] :) ฿1 Bitcoin was worth $$usd_price USD. Current time: $current_time US/Eastern.",
        'gui' => "fe1956d3-b3ef-4b2b-8096-bea477358ca4",
        'cat' => "![CDATA[Cryptocurrency]]",
        'cat2' => "![CDATA[Bitcoin]]",
        'pubdate' => "$pubDate"
    ) ,
    array(
        'title' => "$strings2[$recently_syn] ฿1 Bitcoin was worth $$usd_price USD. ;) Current time: $current_time US/Eastern. #bitcoin #bitcoinprice",
        'link' => "https://s.fidex.tech/rss_feed_btc.php",
        'desc' => "The $strings1[$price_syn] of ฿1 Bitcoin is about $$usd_price USD.:) Current time: $current_time US/Eastern....",
        'gui' => "ce7fb530-8ec1-453e-9f0d-2e4fa6af8705",
        'cat' => "![CDATA[Cryptocurrency]]",
        'cat2' => "![CDATA[Bitcoin]]",
        'pubdate' => "$pubDate"

    )
);

foreach ($items as $item)
  {
    echo "<item>\n";
    echo "<title>{$item[title]}</title>\n";
    echo "<link>{$item[link]}</link>\n";
    echo "<description>{$item[desc]}</description>\n";
    echo "<guid isPermaLink='false'>{$item[gui]}</guid>\n";
    echo "<category>{$item[cat]}</category>\n";
    echo "<category>{$item[cat2]}</category>\n";
    echo "<pubDate>{$item[pubdate]}</pubDate>\n";
	echo "</item>\n";
  }

echo "</channel>\n";
echo "</rss>\n";
?>
