<?php

/**
 * Created by PhpStorm.
 * User: peterzolintakis
 * Date: 2/23/17
 * Time: 4:53 PM
 */

// This class gets a list of suggested artist names that start with the inputted string
class ArtistSuggestions extends DatabaseAccesor
{

    public function __construct($partialName){
        parent::__construct();
        $this->getSuggestion($partialName);
    }


    private function getSuggestion($partialName){
        $songsStatement = $this->conn->prepare("SELECT * FROM Artist WHERE ArtistName LIKE ?%");
        $songsStatement->bind_param("s", $partialName);
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
    }


}