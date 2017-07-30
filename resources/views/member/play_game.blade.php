<html>
<head>
    <meta charset="UTF-8">
    <title>AGIN</title>
    <style>
        body,iframe {margin: 0px;height: 100%;width: 100%;background-color: #000;}
    </style>
</head>
<body>
<?php
if($url)
{
?>
<iframe  frameborder="0" src="<?php echo $url; ?>"></iframe>
<?php
}  else {
    echo "进入游戏失败，请稍后再试";
}
?>
</body>
</html>