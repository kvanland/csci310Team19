<?php
/**
 * Created by PhpStorm.
 * User: AlecFong
 * Date: 2/24/17
 * Time: 5:40 PM
 */
include 'WordCloud.php';
$wc = new WordCloud();
$wc->createWordCloud("Drake");
echo $wc->getWords();

?>