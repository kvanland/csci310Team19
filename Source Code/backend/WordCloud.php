<?php

/**
 * Created by PhpStorm.
 * User: AlecFong
 * Date: 2/22/17
 * Time: 7:44 PM
 */
class WordCloud extends DatabaseAccesor
{
    private $wordCloudData;

    //creates data for word cloud
    public function createWordCloud($artist){
        $id = $this->getArtistID($artist);
        $findWords = $this->conn->prepare("SELECT TOP 250 Word,Occurrences,Songs FROM Words WHERE ArtistID = ? 
                                    ORDER BY Occurences DESC");
        $findWords->bind_param("s", $id);
        $findWords->execute();
        $this->wordCloudData = mysqli_fetch_row($findWords->get_result());
    }

    //get words
    public function getWords(){
        if (!isset($this->wordCloudData)){
            return null;
        }
        return $this->wordCloudData[0];
    }

    public function getOccurrences(){
        if (!isset($this->wordCloudData)){
            return null;
        }
        return $this->wordCloudData[1];
    }


}