<!DOCTYPE html>
<html>
<head>
    <meta property="wb:webmaster" content="3df8a9a1aa580df4" />
    <meta charset="UTF-8">
    <title>WeiConnet</title>
</head>
<body>
It works!
<br/>

<?php
$code = $_GET['code'];
echo $code;

$url = "https://api.weibo.com/oauth2/access_token?client_id=3128512954&client_secret=f4b76f3f0ebf32b31e06748cb10b6327&grant_type=authorization_code&redirect_uri=weiconnect.coding.io/home.php&code=" . $code;
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$json = curl_exec($curl);
curl_close($curl);
$obj = json_decode($json);
var_dump($obj);
global $token = $obj->access_token;
$uid = $obj->uid;
//get user information
$url = "https://api.weibo.com/2/users/show.json?access_token=" . $token."&uid=" . $uid;
echo "<hr/>";
echo $url;
echo "<hr/>";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$json = curl_exec($curl);
curl_close($curl);
$array = json_decode($json, true);// information
$con = mysql_connect("10.9.1.188:3306", "LW70AGqB1OOFgzAO", "HJmN4DfBEnQ0ajEH");
if (!$con) {
    die('Could not connect: ' . mysql_error());
}
if (mysql_num_rows(mysql_query("show tables like 'users'"))==0) {
    mysql_query("create table users(
                 id int not null primary key,
                 screen_name varchar(20),
                 )default charset=utf8;
                ", $con);
}
mysql_query("insert into users (id, screen_name) values ('".$array['id'].
            "','".$array['screen_name']."')");
mysql_close($con);

//save 100 posts
//save keywords


?>

</body>
</html>