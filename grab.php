<?php
ini_set('display_errors', 1);
require_once('TwitterAPIExchange.php');
$username = $_GET["username"];
echo "tweets from @".$username."<br><br>";
$ShowReTweet = false;
$showNumbering = false;
if (isset($_GET['chkNum']))
{
$showNumbering = true;
}
if (isset($_GET['chkRT'])){
$ShowReTweet = true;
}

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
	'oauth_access_token' => "YOUR_OAUTH_ACCESS_TOKEN",
	'oauth_access_token_secret' => "YOUR_OAUTH_ACCESS_TOKEN_SECRET",
	'consumer_key' => "YOUR_CONSUMER_KEY",
	'consumer_secret' => "YOUR_CONSUMER_SECRET_KEY"
	);

/** URL for REST request, see: https://dev.twitter.com/docs/api/1.1/ *
$url = 'https://api.twitter.com/1.1/blocks/create.json';
$requestMethod = 'POST';
 POST fields required by the URL above. See relevant docs as above *
$postfields = array(
	'screen_name' => 'JeffryantoW', 
	'skip_status' => '1'
	);
*/
/** Perform a POST request and echo the response **/
//$twitter = new TwitterAPIExchange($settings);
//echo $twitter->buildOauth($url, $requestMethod)
//            ->setPostfields($postfields)
//            ->performRequest();

/** Perform a GET request and echo the response **/
/** Note: Set the GET field BEFORE calling buildOauth(); **/
$startID=0;
$endID =1;
$res = 0;

$i=0;
$j=1;

$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$getfield = "?screen_name=".$username."&count=200&include_rts=".$ShowReTweet;
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
$obj =$twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest();
$array = json_decode($obj,TRUE);

while ($i<sizeof($array)) {
	if ($i == 0) {
		$endID= $array[$i]['id_str'];
	}
	if($showNumbering == true){
	echo $j;
	}
	$d = DateTime::createFromFormat('D M d H:i:s P Y',$array[$i]['created_at']);
	echo $d->format('ymd'),'||';
	echo $array[$i]['text'];
	echo '<br>';
	$i = $i +1;
	if ($i<sizeof($array)) {
		$startID= $array[$i]['id_str'];
	}
	$j = $j+1;
	
}

for ($k=0; $k < 16 ; $k++) { 
$getfield = "?screen_name=".$username."&max_id=".$startID."&count=200&include_rts=".$ShowReTweet;
$twitter = new TwitterAPIExchange($settings);
$obj =$twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest();
$array = json_decode($obj,TRUE);

$i = 1;
while ($i<sizeof($array)) {
	if ($i == 0) {
		$endID= $array[$i]['id_str'];
	}
	if($showNumbering == true){
	echo $j;
	}
$d = DateTime::createFromFormat('D M d H:i:s P Y',$array[$i]['created_at']);
	echo $d->format('ymd'),'||';
	echo $array[$i]['text'];
	echo '<br>';
	$i = $i+1;
	if ($i<sizeof($array)) {
		$startID= $array[$i]['id_str'];
	}
	$j = $j+1;
}
}