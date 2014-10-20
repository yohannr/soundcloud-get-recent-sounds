<html>
<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php

require_once('config.php');
require_once('soundcloud.class.php');

$soundcloud = new Soundcloud(CLIENT_ID);

$arr_following = array();
$arr_result = array();


$arr_following = $soundcloud->getFollowing(USER_ID);
$arr_result = $soundcloud->getRecentSounds($arr_following);


if (is_null($arr_result)) {
	echo 'No result';
}
else {
	echo '<pre>';
	print_r($arr_result);
	echo '</pre>';
}
?>
</body>
</html>
