<?php

/**
 * Created by PhpStorm.
 * User: AlecFong
 * Date: 2/22/17
 * Time: 7:44 PM
 */
class WordCloud
{
    private $conn;
    //constructor, make connection to database
    function __construct()
    {
        $this->conn = new mysqli(Constants::SERVER_NAME, Constants::USERNAME, Constants::PASSWORD, Constants::DB_NAME);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getWords($artist){
        $id = $this->getArtistID($artist);
        $findWords = mysqli_prepare("SELECT ");
    }

    private function getArtistID($artist){
        $artistIdStatement = mysqli_prepare("SELECT ArtistID FROM Artist WHERE ArtistName =?");
        $artistIdStatement->bind_param("s", $artist);
        $artistIdStatement->execute();
        $result = $artistIdStatement->get_result();
        $artistIdStatement->close();
        if ($result->num_rows > 0) {
            // output data of each row
            if($row = $result->fetch_assoc()) {
                $artistID = $row["id"];
                return $artistID;
            }
        }

    }
}
