<?php

// Class will get songs from database that are by a certain artist and contains a certain word
class Song
{
    //Constants
    const SERVER_NAME = 'localhost';
    const USERNAME = 'username';
    const PASSWORD = "password";
    const DB_NAME = "myDB";

    //properties
    private $conn;
    private $word;
    private $artistName;

    //constructor, make connection to database
    function __construct($artist, $clickedWord)
    {
        $this->conn = new mysqli(self::SERVER_NAME, self::USERNAME, self::PASSWORD, self::DB_NAME);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        else{
            $this->word = $clickedWord;
            $this->artistName = $artist;
            $this->getArtistID();
        }
    }


    // Gets the artist unique id for an artist name from the DB and then calls get songs
    private function getArtistID(){
        $artistIdStatement = mysqli_prepare("SELECT ArtistID FROM Artist WHERE ArtistName =?");
        $artistIdStatement->bind_param("s", $this->artistName);
        $artistIdStatement->execute();
        $result = $artistIdStatement->get_result();
        if ($result->num_rows > 0) {
            // output data of each row
            if($row = $result->fetch_assoc()) {
                $artistID = $row["id"];
                getSongs($artistID);
            }
        }
        $artistIdStatement->close();
    }

    // Gets the songs using an artistID and a word from the DB
    private function getSongs($word, $artistID){
        $songsStatement = mysqli_prepare("SELECT Songs FROM Word WHERE Word = ? AND ArtistID = ?");
        $songsStatement->bind_param("si", $word, $this->artistName);
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
        $songsStatement->close();

    }


}

