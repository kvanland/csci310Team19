<?php
/**
 * Created by PhpStorm.
 * User: peterzolintakis
 * Date: 2/24/17
 * Time: 4:12 PM
 */

$partialName = $_GET["artist"];

if(strlen($partialName = 0)){
    echo null;
    exit(1);
}

$suggestions = new ArtistSuggestions();
$artistNames = $suggestions->getSuggestion($partialName);

echo json_encode($artistNames);