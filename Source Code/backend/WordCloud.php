<?php

/**
 * Created by PhpStorm.
 * User: AlecFong
 * Date: 2/22/17
 * Time: 7:44 PM
 */
include 'DatabaseAccesor.php';

class WordCloud extends DatabaseAccesor
{
    private $wordCloudData;

    //creates data for word cloud
    public function createWordCloud($artist){
        $id = $this->getArtistID($artist);
        $findWords = $this->conn->prepare("SELECT Word,Occurences,Songs FROM CUMULYRICS.Word WHERE ArtistID = ? 
                                    ORDER BY Occurences DESC LIMIT 0,250");
        $findWords->bind_param("s", $id);
        $findWords->execute();
        $this->wordCloudData = $findWords->get_result();

    }

    //get words
    public function getWords(){
        if (!isset($this->wordCloudData)){
            return null;
        }
        return $this->wordCloudData;
    }

}