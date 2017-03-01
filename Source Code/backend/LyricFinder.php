<?php

/**
 * Created by PhpStorm.
 * User: peterzolintakis
 * Date: 2/24/17
 * Time: 4:35 PM
 */
class LyricFinder
{

    public function getLyrics($artist, $song){
        $url = "http://azlyrics.com/lyrics/".$artist."/".$song.".html";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        $lyricsFile = curl_exec($ch);
        curl_close($ch);

        $up_partition = "<!-- Usage of azlyrics.com content by any third-party lyrics provider is prohibited by our licensing agreement. Sorry about that. -->";
        $down_partition = "<!-- MxM banner -->";

        $lyricsFirst = preg_split($up_partition, $lyricsFile, -1);
        $lyricsArray = preg_split($down_partition, $lyricsFirst[1],-1);
        $lyrics = $lyricsArray[0];
        $lyrics = str_replace("<br>", "", $lyrics);
        $lyrics = str_replace("<div>", "", $lyrics);
        $lyrics = str_replace("</div>", "", $lyrics);
        $lyrics = str_replace(">", "", $lyrics);

        return $lyrics;
    }

}
