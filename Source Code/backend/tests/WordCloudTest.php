\<?php


use PHPUnit\Framework\TestCase;

/**
 * @covers WordCloud
 */
final class WordCloudTest extends TestCase
{
    public function testWordsAreFromCorrectArtist(){
        $wc = new WordCloud();
        $wc->createWordCloud("Drake");
        $words = $wc->getWords();
        //for all words
        $songNames = $words->fetch_assoc()["Songs"];

        $this->assertEquals("Best I Ever Had*$*26*^*Forever*$*5*^*Over*$*1*^*Hold On, We're Going Home*$*7*^*Take Care*$*14",$songNames);
    }

    public function testWordCloudProvides250Words(){
        $wc = new WordCloud();
        $wc->createWordCloud("Drake");
        $words = $wc->getWords();
        //for all words
        $count = 0;
        while($row = $words->fetch_assoc()){
            $count += 1;
        }
        $this->assertEquals(250,$count);
    }

    public function testListIsDescending(){
        $wc = new WordCloud();
        $wc->createWordCloud("Drake");
        $words = $wc->getWords();

        $isDesc = true;
        while ($row = $words->fetch_assoc()) {
            if ($row["Occurences"]> $last) {
                $isDesc = false;
            }
        }

        $this->assertEquals(true, $isDesc);
    }

}