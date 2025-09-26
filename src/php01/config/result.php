<?php
$name = htmlspecialchars($_POST["name"], ENT_QUOTES);
$set = htmlspecialchars($_POST["set"], ENT_QUOTES);
$count = htmlspecialchars($_POST["count"], ENT_QUOTES);

echo "私の名前は、" . $name . "<br>";
echo "ご希望の商品は、" . $set . "<br>";
echo "注文数は、" . $count;