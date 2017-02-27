<?php

include "DatabaseAccesor.php";

// Class will get songs from database that are by a certain artist and contains a certain word
class SongsFinder extends DatabaseAccesor
{


    // Gets the songs using an artistID and a word from the DB
    public function getSongs($word, $artistName){
        $artistID = $this->getArtistID($artistName);
        if($artistID == null){
            return null;
        }
        $songsStatement = $this->conn->prepare("SELECT Songs FROM Word WHERE Word = ? AND ArtistID = ?");
        $songsStatement->bind_param("si", $word, $artistID);
        $songsStatement->execute();
        $result = $songsStatement->get_result();
        if ($result->num_rows > 0) {
            // output data of each row
            if ($row = $result->fetch_assoc()) {
                $songsFrequencyString = $row["Songs"];
                $songsFrequencyArray = explode("*^*", $songsFrequencyString);
                $songsFrequencyAssociativeArray = array();
                for ($i = 0; $i < count($songsFrequencyArray); $i ++) {
                    $singleSong = explode("*$*", $songsFrequencyArray[$i]);
                    $songsFrequencyAssociativeArray[$singleSong[0]] = $singleSong[1];
                }
                arsort($songsFrequencyAssociativeArray);
                $songsStatement->close();
                return $songsFrequencyAssociativeArray;
            }
        }
        $songsStatement->close();
        return null;

    }
}



