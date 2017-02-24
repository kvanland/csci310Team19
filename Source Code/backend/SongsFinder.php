<?php

// Class will get songs from database that are by a certain artist and contains a certain word
class Song extends DatabaseAccesor
{
    //properties
    private $word;
    private $artistName;

    //constructor, make connection to database
    function __construct($artist, $clickedWord)
    {
        parent::__construct();
        $this->word = $clickedWord;
        $this->artistName = $artist;
        $this->getSongs();
    }


    // Gets the songs using an artistID and a word from the DB
    private function getSongs(){
        $artistID = $this->getArtistID($this->artistName);
        if($artistID == null){
            sendsongs(null);
            return;
        }
        $songsStatement = $this->conn->prepare("SELECT Songs FROM Word WHERE Word = ? AND ArtistID = ?");
        $songsStatement->bind_param("si", $this->word, $this->artistName);
        $songsStatement->execute();
        $result = $songsStatement->get_result();
        if ($result->num_rows > 0) {
            // output data of each row
            if($row = $result->fetch_assoc()) {
                $songsFrequencyString = $row["Songs"];
                $songsFrequencyArray = explode(",", $songsFrequencyString);
                $songsFrequencyAssociativeArray = array();
                for($i = 0; $i <= count($songsFrequencyArray)/2; $i+=2){
                    $songsFrequencyAssociativeArray[$songsFrequencyArray[i]] = $songsFrequencyArray[i+1];
                }
                arsort($songsFrequencyAssociativeArray);
                sendSongs($songsFrequencyAssociativeArray);
            }
        }
        else{
            sendSongs(null);
        }
        $songsStatement->close();

    }


}

