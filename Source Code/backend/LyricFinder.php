<?php

/**
 * Created by PhpStorm.
 * User: peterzolintakis
 * Date: 2/24/17
 * Time: 4:35 PM
 */
class LyricFinder
{

    public function getLyrics($song, $artist){
        $url = "http://azlyrics.com/lyrics/".$artist."/".$song.".html";
        echo $artist;
        echo $song;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $file = curl_exec($ch);
        curl_close($ch);

        echo $file;

        //$content = file_get_contents($url);

        /*echo "here";

        $up_partition = "<!-- Usage of azlyrics.com content by any third-party lyrics provider is prohibited by our licensing agreement. Sorry about that. -->";
        $down_partition = "<!-- MxM banner -->";

        $lyricsFirst = $lyrics.preg_split($up_partition, $content,1);
        $lyrics = $lyrics.preg_split($down_partition, $lyricsFirst[1],1);

        return $lyrics;*/
    }

}

$test = new LyricFinder();
$test-> getLyrics("Reaper", "Sia");