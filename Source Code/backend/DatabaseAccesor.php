<?php

/**
 * Created by PhpStorm.
 * User: peterzolintakis
 * Date: 2/23/17
 * Time: 4:21 PM
 */

include "Constants.php";
class DatabaseAccesor
{
    protected $conn;

    function __construct()
    {
        $this->conn = new mysqli(Constants::SERVER_NAME, Constants::USERNAME, Constants::PASSWORD, Constants::DB_NAME);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    protected function getArtistID($artistName){
        $artistIdStatement = $this->conn->prepare("SELECT ArtistID FROM Artist WHERE ArtistName =?");
        $artistIdStatement->bind_param("s", $artistName);
        $artistIdStatement->execute();
        $result = $artistIdStatement->get_result();
        if ($result->num_rows > 0) {
            // output data of each row
            if($row = $result->fetch_assoc()) {
                $artistID = $row["ArtistID"];
                return $artistID;
            }
        }
        return null;
    }

}