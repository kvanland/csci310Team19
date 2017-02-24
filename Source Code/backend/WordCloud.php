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

    public function createWordCloud($artist){
        $id = $this->getArtistID($artist);
        $findWords = $this->conn->prepare("SELECT TOP 250 * FROM Words WHERE ArtistID = ? 
                                    ORDER BY Occurences DESC");
        $findWords->bind_param("s", $id);
        $findWords->execute();
        $this->wordCloudData = $findWords->get_result();
    }

}
