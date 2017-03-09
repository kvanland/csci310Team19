<?php
/**
 * Created by PhpStorm.
 * User: peterzolintakis
 * Date: 3/8/17
 * Time: 10:02 PM
 */

include "ArtistSuggestions.php";

$partialString = $_GET["artist"];

echo SuggestionsDriver::getSuggestions($partialString);

class SuggestionsDriver
{
    public static function getSuggestions($partialName){
        // Make sure partialName has a value
        if(strlen($partialName) == 0){
            return null;
        }

        // Create the ArtistSuggestions object and get the artist names that contain the partial name
        $suggestions = new ArtistSuggestions();
        $artistNames = $suggestions->getSuggestion($partialName);
        $sendObj = array();

        // Check that suggestions exist
        if(empty($artistNames)){
            return null;
        }
        else{
            // Create associated array
            foreach ($artistNames as $x => $x_value) {
                array_push($sendObj, array("value" => $x, "icon" => $x_value));
            }
            // Turn associated array into JSON and send it to front end
            return json_encode($sendObj);
        }
    }

}

