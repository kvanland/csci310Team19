<?php

include "DatabaseAccesor.php";

// Class will get songs from database that are by a certain artist and contains a certain word
// Extends DatabaseAccessor
class SongsFinder extends DatabaseAccesor
{


    // Take an artist and word as parameters and return all songs by the artist that contain the word
    public function getSongs($word, $artistName){
        $artistID = $this->getArtistID($artistName);

        // If artist doesn't exist return null;
        if($artistID == null){
            return null;
        }

        // Create and execute prepared statement on MySQL database
        $songsStatement = $this->conn->prepare("SELECT Songs FROM Word WHERE Word = ? AND ArtistID = ?");
        $songsStatement->bind_param("si", $word, $artistID);
        $songsStatement->execute();
        $result = $songsStatement->get_result();
        if ($result->num_rows > 0) {
            // Create and return an associated array of songs, frequencies and artists
            if ($row = $result->fetch_assoc()) {
                $songsFrequencyString = $row["Songs"];
                $songsFrequencyArray = explode("*^*", $songsFrequencyString);
                $songsFrequencyAssociativeArray = array();
                for ($i = 0; $i < count($songsFrequencyArray); $i ++) {
                    $singleSong = explode("*$*", $songsFrequencyArray[$i]);
                    $artistFrequencyArray = array($singleSong[1], $artistName);
                    $songsFrequencyAssociativeArray[$singleSong[0]] = $artistFrequencyArray;
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



