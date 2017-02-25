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
    /**
     * @param $partialName
     * @return array|null
     */
    public function getSuggestion($partialName){
        $songsStatement = $this->conn->prepare("SELECT * FROM Artist WHERE ArtistName LIKE ?%");
        $songsStatement->bind_param("s", $partialName);
        $songsStatement->execute();
        $result = $songsStatement->get_result();
        if ($result->num_rows > 0) {
            $i = 0;
            $suggestions = array();
            while($row = $result->fetch_assoc() && $i < 5) {
                $artistName = $row["ArtistName"];
                $artistImage = $row["ImageURL"];
                $suggestions[$artistName] = $artistImage;
                $i++;
            }
            return $suggestions;
        }
        return null;
    }


}