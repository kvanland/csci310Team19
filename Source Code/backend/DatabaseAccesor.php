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
    // Property that will be connection with MySQL database
    protected $conn;

    //Constructor
    function __construct()
    {
        // Create connection from the MySQL databse
        $this->conn = new mysqli(Constants::SERVER_NAME, Constants::USERNAME, Constants::PASSWORD, Constants::DB_NAME);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Takes an artist as a parameter and returns its ID in the database
    public function getArtistID($artistName){
        // // Create and execute prepared statement on MySQL database
        $artistIdStatement = $this->conn->prepare("SELECT ArtistID FROM Artist WHERE ArtistName =?");
        $artistIdStatement->bind_param("s", $artistName);
        $artistIdStatement->execute();
        $result = $artistIdStatement->get_result();
        if ($result->num_rows > 0) {
            // Return artist ID
            if($row = $result->fetch_assoc()) {
                $artistID = $row["ArtistID"];
                return $artistID;
            }
        }
        return null;
    }

}