<?php

// Class will get songs from database that are by a certain artist and contains a certain word
class SongsFinder extends DatabaseAccesor
{


    // Gets the songs using an artistID and a word from the DB
    public function getSongs($partialName, $artistName){
        $artistID = $this->getArtistID($artistName);
        if($artistID == null){
            return null;
        }
        $songsStatement = $this->conn->prepare("SELECT Songs FROM Word WHERE Word = ? AND ArtistID = ?");
        $songsStatement->bind_param("si", $partialName, $artistName);
        $songsStatement->execute();
        $result = $songsStatement->get_result();
        if ($result->num_rows > 0) {
            // output data of each row
            if ($row = $result->fetch_assoc()) {
                $songsFrequencyString = $row["Songs"];
                $songsFrequencyArray = explode(",", $songsFrequencyString);
                $songsFrequencyAssociativeArray = array();
                for ($i = 0; $i <= count($songsFrequencyArray) / 2; $i += 2) {
                    $songsFrequencyAssociativeArray[$songsFrequencyArray[$i]] = $songsFrequencyArray[$i + 1];
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

