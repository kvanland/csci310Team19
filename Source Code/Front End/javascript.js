
//Global variables

//PAGE[0] initial, PAGE[1] cloud, PAGE[2] songs, PAGE[3] lyrics
var PAGE = [true, false, false, false];


//Helper functions


function setPage(page){
	var length = PAGE.length;
	var i;
	for(i = 0; i < length; i++){
		PAGE[i] = false;
	}
	PAGE[page] = true;
}

//Word Cloud Model
var autoCompleteList; //JSON object array
var wordCloudData; //JSON object array
var lyrics; //String
var songList; //JSON object array

function setAutoCompleteList(autoCompleteListData){ //void
	//autoList: JSON object array
	autoCompleteList = autoCompleteListData;
}

function setWordCloudData(data){ //void
	//wordCloudData: Map<String, int>
	wordCloudData = data;
}

function setLyrics(lyricsData){ //void
	//lyrics: string
	lyrics = lyricsData;
}

function setSongList(songListData){ //void
	//songList: JSON object array
	songList = songListData;
}

function getSongList(){ //JSON object array
	return songList;
}

function getWordCloudData(){ //Map<String, int>
	return wordCloudData;
}

function getLyrics(){ //String
	return Lyrics;
}

function getAutoCompleteList(){ //JSON object array
	return autoCompleteList;
}

//Data requester 
function requestAutoCompleteList(search){ //JSON object array
	/*
		 TODO
		use AJAX to request autocompleteList raw data
		parse string into json object array
		return array
	*/

}

function requestLyrics(songTitle, artist){ //String
	//songTitle: string, artist: string

	/*
		 TODO
		use AJAX to request lyrics string
		return String
	*/
}

function requestWordCloudData(artistList){ //Map<String, int>
	//artistList: JSON object array

	/*
		 TODO
		use AJAX to request wordcloud raw data
		parse string into json object array
		return String
	*/
}

function requestSongList(word, artistList){ //JSON object array
	//word: string, artistList: JSON onject array

	/*
		TODO 
		use AJAX to request songList rawdata
		parse string into json Object array
		return array
	*/
}

//Word Cloud View Model 
var currentWord; //String
var currentSong; //JSON object
var currentArtistList; //JSON object array

function clearArtistList(){ //void 
	artistList = new Array();
}

function addToArtistList(artist){ //void 
	//artist: JSON object

	artistList.push(artist);
}

function setCurrentWord(word){ //void
	//word: string

	currentWord = word;
}

function setCurrentSong(song){ //void
	//song: JSON Object

	currentSong = song;
}

function clearView(){ //void 
	//Set screen to initial state
	setInvisible("WordCloud");
	setInvisible("Lyrics");
	setInvisible("SongList");
	setInvisible("back");
	clearArtistList();
	shiftInputsCenter();
	showSearch();
	setPage(0);

}

function showWordCloudPage(){ //void
	setPage(1);
	setVisible("WordCloud");
	setHeight("wCCanvas", "60vh");
}

function hideWordCloudPage(){ //void 
	setInvisible("WordCloud");
	setHeight("wCCanvas", "0");
}

function showLyricPage(){ //void
	setPage(3);
	setVisible("Lyrics");
	setHeight("lyricsCanvas", "60vh");
}

function hideLyricPage(){ //void
	setInvisible("Lyrics");
	d3.select("#lyricsCanvas").selectAll("*").remove();
	setHeight("lyricsCanvas", "0");
}

function showSongListPage(){ //void
	setPage(2);
	setVisible("SongList");
	setHeight("songListCanvas", "60vh");
	populateSongList(getSongList());
}

function hideSongListPage(){ //void
	setInvisible("SongList");
	d3.select("#songListCanvas").selectAll("*").remove();
	setHeight("songListCanvas", "0");
}

//Lyrics
function populateLyrics(lyrics, artist, word){ //void

	/*
		TODO
		use lyrics from model
		format page
	*/

	var lyric = " SMAMLKDSGjlag dahafadhfdah gahfd"
	d3.select("#lyricsCanvas")
		.append("text")
		.text(lyric);
}

function clearLyrics(){ //void
	lyrics = '';
}

//SongList
function populateSongList(songData){ //void
	clearSongList();
	var nameArray = new Array();
	var artistArray = new Array();
	var countArray = new Array();
	var songArray = new Array();

	for (var i = 0; i < songData.length; i++) {
    	nameArray.push(songData[i].songName);
    	artistArray.push(songData[i].artist);
    	countArray.push(songData[i].wordCount);
    	songArray.push(songData[i].songName);
    	songArray.push(songData[i].artist);
    	songArray.push(songData[i].wordCount);

	}
	d3.select("#songListCanvas").selectAll("text")
		.data(songArray)
		.enter()
		.append("text")
		.text(function (d, i) {
			return d;
		})
		.attr("x", function(d, i) {
			var x;
			if(i % 3 == 0){ //must be songName
				x = 20;
			}
			else if(i % 3 == 1) { // must be artist
				x = 120;
			}
			else {
				x = 200;
			}
			return x;
		})
		.attr("y", function(d, i) {
			return 50*Math.floor(i/3) + 20;
		})
		.on("click", function(d, i) {
			var songIndex = Math.floor(i/3);
			setCurrentSong(songData[songIndex]);
			songClickAction(songData[songIndex].songName, songData[songIndex].artist);
		})


}

function clearSongList(){ //void
	d3.select("#songListCanvas").selectAll("*").remove();
}

function songClickAction(name, artist){ //void
	// Function requests song lyrics, then displays the lyrics
	var lyricData = requestLyrics(name, artist);
	setLyrics(lyricData);
	populateLyrics(getLyrics(), artist, currentWord);
	hideSearch();
	hideSongListPage();
	showLyricPage();
	setPage(3);
}

//HTML
function homeAction(){
	if(PAGE[0]) {
		// if user is already all the way home do nothing
		return;
	}
	else if(PAGE[1]){ 
		//If the user is on the cloud page go all the way home
		clearView();
		setPage(0);
	} else { 
		// take user back to cloud page
		setPage(1);
		shiftInputsDown();
		showSearch();
		hideSongListPage();
		hideLyricPage();
		showWordCloudPage();
	}

}

function backAction(){
		if(PAGE[1]){ 
		//If the user is on the cloud page, reset page
		setPage(0);
		clearView();
		
	}else if(PAGE[2]){ 
		//If the user is on the songList page, go to wordCloudPage
		setPage(1);
		shiftInputsDown();
		showSearch();
		hideSongListPage();
		showWordCloudPage();
	}else if(PAGE[3]){ 
		//If the user is on the lyrics page, go to songListPage
		setPage(2);
		hideLyricPage();
		showSongListPage();
	}
}

//WordCloud
function colorToggle() {
	/*
		TODO
		update color on wordcloud
	*/
}
function populateWordCloud(){ //void
	clearWordCloud(); // reset canvas
	var words = [
  {text: 'have', size: 102},
  {text: 'Oliver', size: 47},
  {text: 'say', size: 46},
  {text: 'said', size: 36},
  {text: 'bumble', size: 29, href: 'https://en.wikipedia.org/wiki/Beadle'},
  {text: 'will', size: 29},
  {text: 'Mrs', size: 56, href: 'https://en.wikipedia.org/wiki/Mrs.'},
  {text: 'Mann', size: 27, href: 'http://educationcing.blogspot.nl/2012/06/oliver-twist-mrs-manns-character.html'},
  {text: 'Mr', size: 27},
  {text: 'very', size: 26},
  {text: 'child', size: 20},
  {text: 'all', size: 19},
  {text: 'boy', size: 19},
  {text: 'gentleman', size: 19, href: 'http://www.thefreelibrary.com/The+gentleman+in+the+white+waistcoat%3a+Dickens+and+metonymy.-a0154239625'},
  {text: 'great', size: 19},
  {text: 'take', size: 19},
  {text: 'but', size: 18},
  {text: 'beadle', size: 16},
  {text: 'twist', size: 16},
  {text: 'board', size: 15},
  {text: 'more', size: 15},
  {text: 'one', size: 15},
  {text: 'workhouse', size: 15},
  {text: 'parish', size: 14},
  {text: 'there', size: 14},
  {text: 'come', size: 13},
  {text: 'hand', size: 13},
  {text: 'know', size: 13},
  {text: 'sir', size: 13},
  {text: 'being', size: 12},
  {text: 'head', size: 12},
  {text: 'make', size: 12},
  {text: 'out', size: 12},
  {text: 'can', size: 11},
  {text: 'little', size: 11},
  {text: 'reply', size: 11},
  {text: 'any', size: 10},
  {text: 'cry', size: 10},
  {text: 'good', size: 10},
  {text: 'name', size: 10},
  {text: 'poor', size: 10},
  {text: 'time', size: 10},
  {text: 'two', size: 10},
  {text: 'after', size: 9},
  {text: 'dear', size: 9},
  {text: 'get', size: 9},
  {text: 'gruel', size: 9},
  {text: 'long', size: 9},
  {text: 'may', size: 9},
  {text: 'never', size: 9},
  {text: 'some', size: 9},
  {text: 'well', size: 9},
  {text: 'white', size: 9},
  {text: 'woman', size: 9},
  {text: 'chair', size: 8},
  {text: 'day', size: 8},
  {text: 'give', size: 8},
  {text: 'inquire', size: 8},
  {text: 'made', size: 8},
  {text: 'next', size: 8},
  {text: 'now', size: 8},
  {text: 'other', size: 8},
  {text: 'over', size: 8},
  {text: 'small', size: 8},
  {text: 'surgeon', size: 8},
  {text: 'think', size: 8},
  {text: 'too', size: 8},
  {text: 'walk', size: 8},
  {text: 'want', size: 8},
  {text: 'bless', size: 7},
  {text: 'eye', size: 7},
  {text: 'man', size: 7},
  {text: 'master', size: 7},
  {text: 'most', size: 7},
  {text: 'old', size: 7},
  {text: 'people', size: 7},
  {text: 'see', size: 7},
  {text: 'another', size: 6},
  {text: 'at all', size: 6},
  {text: 'authorities', size: 6},
  {text: 'authority', size: 6},
  {text: 'away', size: 6},
  {text: 'face', size: 6},
  {text: 'gate', size: 6},
  {text: 'half', size: 6},
  {text: 'hands', size: 6},
  {text: 'heart', size: 6},
  {text: 'last', size: 6},
  {text: 'might', size: 6},
  {text: 'nurse', size: 6},
  {text: 'once', size: 6},
  {text: 'place', size: 6},
  {text: 'room', size: 6},
  {text: 'table', size: 6},
  {text: 'three', size: 6},
  {text: 'voice', size: 6},
  {text: 'waistcoat', size: 6},
  {text: 'wash', size: 6},
  {text: 'water', size: 6},
  {text: 'a little', size: 5},
  {text: 'bow', size: 5},
  {text: 'business', size: 5},
  {text: 'drop', size: 5},
  {text: 'eyes', size: 5},
  {text: 'fall', size: 5},
  {text: 'find', size: 5},
  {text: 'gin', size: 5},
  {text: 'high', size: 5},
  {text: 'house', size: 5},
  {text: 'infant', size: 5},
  {text: 'night', size: 5},
  {text: 'nobody', size: 5},
  {text: 'orphan', size: 5},
  {text: 'pauper', size: 5},
  {text: 'perhaps', size: 5},
  {text: 'rather', size: 5},
  {text: 'round', size: 5},
  {text: 'sit', size: 5},
  {text: 'world', size: 5},
  {text: 'young', size: 5},
  {text: 'add', size: 4},
  {text: 'ask', size: 4},
  {text: 'at once', size: 4},
  {text: 'behind', size: 4},
  {text: 'bottle', size: 4},
  {text: 'bread', size: 4},
  {text: 'care', size: 4},
  {text: 'copper', size: 4},
  {text: 'die', size: 4},
  {text: 'farm', size: 4},
  {text: 'fat', size: 4},
  {text: 'father', size: 4},
  {text: 'fell', size: 4},
  {text: 'female', size: 4},
  {text: 'going', size: 4},
  {text: 'happen', size: 4},
  {text: 'hat', size: 4},
  {text: 'here', size: 4},
  {text: 'however', size: 4},
  {text: 'hungry', size: 4},
  {text: 'in this', size: 4},
  {text: 'keep', size: 4},
  {text: 'large', size: 4},
  {text: 'low', size: 4},
  {text: 'matter', size: 4},
  {text: 'out of', size: 4},
  {text: 'pound', size: 4},
  {text: 'public', size: 4},
  {text: 'quarter', size: 4},
  {text: 'quite', size: 4},
  {text: 'raise', size: 4},
  {text: 'sleep', size: 4},
  {text: 'spirit', size: 4},
  {text: 'ten', size: 4},
  {text: 'turn', size: 4},
  {text: 'wanted', size: 4},
  {text: 'washing', size: 4},
  {text: 'week', size: 4},
  {text: 'word', size: 4},
  {text: 'age', size: 3},
  {text: 'arm', size: 3},
  {text: 'ask for', size: 3},
  {text: 'assistant', size: 3},
  {text: 'be born', size: 3},
  {text: 'bed', size: 3},
  {text: 'bill', size: 3},
  {text: 'body', size: 3},
  {text: 'born', size: 3},
  {text: 'brick', size: 3},
  {text: 'bring', size: 3},
  {text: 'cane', size: 3},
  {text: 'case', size: 3},
  {text: 'Christian', size: 3},
  {text: 'circumstance', size: 3},
  {text: 'cock', size: 3},
  {text: 'cocked hat', size: 3},
  {text: 'cold', size: 3},
  {text: 'come to', size: 3},
  {text: 'companion', size: 3},
  {text: 'consequence', size: 3},
  {text: 'corner', size: 3},
  {text: 'deposit', size: 3},
  {text: 'dress', size: 3},
  {text: 'eat', size: 3},
  {text: 'eight', size: 3},
  {text: 'expect', size: 3},
  {text: 'expected', size: 3},
  {text: 'experimental', size: 3},
  {text: 'feed', size: 3},
  {text: 'fire', size: 3},
  {text: 'glass', size: 3},
  {text: 'go to', size: 3},
  {text: 'green', size: 3},
  {text: 'halfpenny', size: 3},
  {text: 'hang', size: 3},
  {text: 'have got', size: 3},
  {text: 'hint', size: 3},
  {text: 'hunger', size: 3},
  {text: 'interest', size: 3},
  {text: 'known', size: 3},
  {text: 'latter', size: 3},
  {text: 'lay', size: 3},
  {text: 'lead', size: 3},
  {text: 'let', size: 3},
  {text: 'live', size: 3},
  {text: 'mention', size: 3},
  {text: 'month', size: 3},
  {text: 'morning', size: 3},
  {text: 'ninth', size: 3},
  {text: 'offer', size: 3},
  {text: 'old woman', size: 3},
  {text: 'open', size: 3},
  {text: 'operation', size: 3},
  {text: 'order', size: 3},
  {text: 'pale', size: 3},
  {text: 'pick', size: 3},
  {text: 'possess', size: 3},
  {text: 'possible', size: 3},
  {text: 'pray', size: 3},
  {text: 'process', size: 3},
  {text: 'proper', size: 3},
  {text: 'purpose', size: 3},
  {text: 'raised', size: 3},
  {text: 'remove', size: 3},
  {text: 'removed', size: 3},
  {text: 'render', size: 3},
  {text: 'set', size: 3},
  {text: 'shake', size: 3},
  {text: 'sitting', size: 3},
  {text: 'smile', size: 3},
  {text: 'somewhat', size: 3},
  {text: 'speak', size: 3},
  {text: 'spoon', size: 3},
  {text: 'supper', size: 3},
  {text: 'sure', size: 3},
  {text: 'system', size: 3},
  {text: 'tender', size: 3},
  {text: 'thin', size: 3},
  {text: 'troublesome', size: 3},
  {text: 'twenty', size: 3},
  {text: 'usually', size: 3},
  {text: 'words', size: 3},
  {text: 'yes', size: 3},
  {text: 'a great deal', size: 2},
  {text: 'accident', size: 2},
  {text: 'accompanied', size: 2},
  {text: 'accompany', size: 2},
  {text: 'advance', size: 2},
  {text: 'advancing', size: 2},
  {text: 'allowance', size: 2},
  {text: 'answer', size: 2},
  {text: 'appear', size: 2},
  {text: 'apron', size: 2},
  {text: 'arrive', size: 2},
  {text: 'assign', size: 2},
  {text: 'astonishment', size: 2},
  {text: 'at last', size: 2},
  {text: 'attend', size: 2},
  {text: 'basin', size: 2},
  {text: 'bedstead', size: 2},
  {text: 'besides', size: 2},
  {text: 'birth', size: 2},
  {text: 'birthday', size: 2},
  {text: 'bowed', size: 2},
  {text: 'bowl', size: 2},
  {text: 'bowls', size: 2},
  {text: 'breast', size: 2},
  {text: 'brief', size: 2},
  {text: 'bring up', size: 2},
  {text: 'cast', size: 2},
  {text: 'catch', size: 2},
  {text: 'class', size: 2},
  {text: 'clothe', size: 2},
  {text: 'common', size: 2},
  {text: 'compel', size: 2},
  {text: 'compose', size: 2},
  {text: 'conduct', size: 2},
  {text: 'considerable', size: 2},
  {text: 'consolation', size: 2},
  {text: 'contract', size: 2},
  {text: 'convince', size: 2},
  {text: 'convinced', size: 2},
  {text: 'cook', size: 2},
  {text: 'countenance', size: 2},
  {text: 'couple', size: 2},
  {text: 'cry for', size: 2},
  {text: 'crying', size: 2},
  {text: 'cuff', size: 2},
  {text: 'deal', size: 2},
  {text: 'decidedly', size: 2},
  {text: 'deeply', size: 2},
  {text: 'diet', size: 2},
  {text: 'difficulty', size: 2},
  {text: 'dinner', size: 2},
  {text: 'directly', size: 2},
  {text: 'discover', size: 2},
  {text: 'draw', size: 2},
  {text: 'ecstasy', size: 2},
  {text: 'elderly', size: 2},
  {text: 'evening', size: 2},
  {text: 'excellent', size: 2},
  {text: 'except', size: 2},
  {text: 'experience', size: 2},
  {text: 'extraordinary', size: 2},
  {text: 'faint', size: 2},
  {text: 'fall into', size: 2},
  {text: 'fist', size: 2},
  {text: 'floor', size: 2},
  {text: 'follow', size: 2},
  {text: 'food', size: 2},
  {text: 'fool', size: 2},
  {text: 'forehead', size: 2},
  {text: 'frighten', size: 2},
  {text: 'frightened', size: 2},
  {text: 'garden', size: 2},
  {text: 'gaze', size: 2},
  {text: 'glance', size: 2},
  {text: 'go along', size: 2},
  {text: 'grasp', size: 2},
  {text: 'grasping', size: 2},
  {text: 'great deal', size: 2},
  {text: 'hope', size: 2},
  {text: 'horse', size: 2},
  {text: 'humane', size: 2},
  {text: 'humility', size: 2},
  {text: 'impress', size: 2},
  {text: 'impressed', size: 2},
  {text: 'in no time', size: 2},
  {text: 'in other words', size: 2},
  {text: 'increase', size: 2},
  {text: 'inmate', size: 2},
  {text: 'inside', size: 2},
  {text: 'instead', size: 2},
  {text: 'interesting', size: 2},
  {text: 'interpose', size: 2},
  {text: 'ladle', size: 2},
  {text: 'lady', size: 2},
  {text: 'leaving', size: 2},
  {text: 'loud', size: 2},
  {text: 'mile', size: 2},
  {text: 'misery', size: 2},
  {text: 'nearly', size: 2},
  {text: 'necessary', size: 2},
  {text: 'notwithstanding', size: 2},
  {text: 'oakum', size: 2},
  {text: 'on the table', size: 2},
  {text: 'opened', size: 2},
  {text: 'overseer', size: 2},
  {text: 'philosopher', size: 2},
  {text: 'picking', size: 2},
  {text: 'piece', size: 2},
  {text: 'pillow', size: 2},
  {text: 'please', size: 2},
  {text: 'pocket', size: 2},
  {text: 'poor people', size: 2},
  {text: 'possessed', size: 2},
  {text: 'probable', size: 2},
  {text: 'proceed', size: 2},
  {text: 'produce', size: 2},
  {text: 'provide', size: 2},
  {text: 'putt', size: 2},
  {text: 'putting', size: 2},
  {text: 'red', size: 2},
  {text: 'relief', size: 2},
  {text: 'remain', size: 2},
  {text: 'repeat', size: 2},
  {text: 'result', size: 2},
  {text: 'reward', size: 2},
  {text: 'roll', size: 2},
  {text: 'rose', size: 2},
  {text: 'seat', size: 2},
  {text: 'sense', size: 2},
  {text: 'shaking', size: 2},
  {text: 'sight', size: 2},
  {text: 'situation', size: 2},
  {text: 'six', size: 2, href: 'https://en.wikipedia.org/wiki/Six'},
  {text: 'slice', size: 2},
  {text: 'society', size: 2},
  {text: 'spoke', size: 2},
  {text: 'start', size: 2},
  {text: 'starve', size: 2},
  {text: 'starved', size: 2},
  {text: 'station', size: 2},
  {text: 'stop', size: 2},
  {text: 'stranger', size: 2},
  {text: 'suffer', size: 2},
  {text: 'supply', size: 2},
  {text: 'support', size: 2},
  {text: 'suppose', size: 2},
  {text: 'take care', size: 2},
  {text: 'taking', size: 2},
  {text: 'talk', size: 2},
  {text: 'tap', size: 2},
  {text: 'teach', size: 2},
  {text: 'tear', size: 2},
  {text: 'tears', size: 2},
  {text: 'telling', size: 2},
  {text: 'to that', size: 2},
  {text: 'tone', size: 2},
  {text: 'too much', size: 2},
  {text: 'town', size: 2},
  {text: 'trade', size: 2},
  {text: 'treat', size: 2},
  {text: 'trouble', size: 2},
  {text: 'useful', size: 2},
  {text: 'usher', size: 2},
  {text: 'view', size: 2},
  {text: 'walk in', size: 2},
  {text: 'warden', size: 2},
  {text: 'wicket', size: 2},
  {text: 'wild', size: 2},
  {text: 'wisdom', size: 2},
  {text: 'wretched', size: 2},
  {text: 'young woman', size: 2},
  {text: 'a couple of', size: 1},
  {text: 'accurate', size: 1},
  {text: 'address', size: 1},
  {text: 'advertise', size: 1},
  {text: 'affect', size: 1},
  {text: 'affected', size: 1},
  {text: 'affix', size: 1},
  {text: 'agony', size: 1},
  {text: 'aim', size: 1},
  {text: 'alarm', size: 1},
  {text: 'alarmed', size: 1},
  {text: 'alive', size: 1},
  {text: 'all over', size: 1},
  {text: 'all the way', size: 1},
  {text: 'allot', size: 1},
  {text: 'allotted', size: 1},
  {text: 'aloud', size: 1},
  {text: 'alphabet', size: 1},
  {text: 'alphabetical', size: 1},
  {text: 'alternately', size: 1},
  {text: 'alternative', size: 1},
  {text: 'anciently', size: 1},
  {text: 'animate', size: 1},
  {text: 'animated', size: 1},
  {text: 'anxious', size: 1},
  {text: 'apparently', size: 1},
  {text: 'apparition', size: 1},
  {text: 'appendage', size: 1},
  {text: 'appetite', size: 1},
  {text: 'applicant', size: 1},
  {text: 'applied', size: 1},
  {text: 'apply', size: 1},
  {text: 'apprentice', size: 1},
  {text: 'approach', size: 1},
  {text: 'approaching', size: 1},
  {text: 'appropriate', size: 1},
  {text: 'approvingly', size: 1},
  {text: 'arrive at', size: 1},
  {text: 'articulate', size: 1},
  {text: 'articulated', size: 1},
  {text: 'as it is', size: 1},
  {text: 'assiduously', size: 1},
  {text: 'assigned', size: 1},
  {text: 'assist', size: 1},
  {text: 'assisted', size: 1},
  {text: 'astound', size: 1},
  {text: 'astounded', size: 1},
  {text: 'at length', size: 1},
  {text: 'atrociously', size: 1},
  {text: 'attended', size: 1},
  {text: 'attending', size: 1},
  {text: 'attribute', size: 1},
  {text: 'awaken', size: 1},
  {text: 'bachelor', size: 1},
  {text: 'badge', size: 1},
  {text: 'bait', size: 1},
  {text: 'balance', size: 1},
  {text: 'baptize', size: 1},
  {text: 'baptized', size: 1},
  {text: 'Beadle', size: 1},
  {text: 'beer', size: 1},
  {text: 'befall', size: 1},
  {text: 'beg', size: 1},
  {text: 'beggar', size: 1},
  {text: 'behold', size: 1},
  {text: 'benevolent', size: 1},
  {text: 'bestow', size: 1},
  {text: 'bid', size: 1},
  {text: 'bidding', size: 1},
  {text: 'biography', size: 1},
  {text: 'bitterly', size: 1},
  {text: 'blandness', size: 1},
  {text: 'blanket', size: 1},
  {text: 'blessed', size: 1},
  {text: 'blessing', size: 1},
  {text: 'blow', size: 1},
  {text: 'bolt', size: 1},
  {text: 'bosom', size: 1},
  {text: 'branch', size: 1},
  {text: 'brat', size: 1},
  {text: 'bread and butter', size: 1},
  {text: 'breakfast', size: 1},
  {text: 'breathe', size: 1},
  {text: 'breathed', size: 1},
  {text: 'brown', size: 1},
  {text: 'brush', size: 1},
  {text: 'brushed', size: 1},
  {text: 'buffet', size: 1},
  {text: 'buffeted', size: 1},
  {text: 'build', size: 1},
  {text: 'burden', size: 1},
  {text: 'burst', size: 1},
  {text: 'butter', size: 1},
  {text: 'by hand', size: 1},
  {text: 'by no means', size: 1},
  {text: 'calico', size: 1},
  {text: 'calling', size: 1},
  {text: 'calm', size: 1},
  {text: 'cap', size: 1},
  {text: 'capital', size: 1},
  {text: 'captivate', size: 1},
  {text: 'captivating', size: 1},
  {text: 'careful', size: 1},
  {text: 'carelessly', size: 1},
  {text: 'catch sight', size: 1},
  {text: 'catch up', size: 1},
  {text: 'catching', size: 1},
  {text: 'cellar', size: 1},
  {text: 'chafe', size: 1},
  {text: 'chafed', size: 1},
  {text: 'check', size: 1},
  {text: 'checked', size: 1},
  {text: 'cheerfulness', size: 1},
  {text: 'childish', size: 1},
  {text: 'choleric', size: 1},
  {text: 'circumference', size: 1},
  {text: 'clean', size: 1},
  {text: 'clearly', size: 1},
  {text: 'cling', size: 1},
  {text: 'cloth', size: 1},
  {text: 'clothes', size: 1},
  {text: 'clothing', size: 1},
  {text: 'coal', size: 1},
  {text: 'coat', size: 1},
  {text: 'cold water', size: 1},
  {text: 'combination', size: 1},
  {text: 'come on', size: 1},
  {text: 'come out', size: 1},
  {text: 'comfort', size: 1},
  {text: 'comfortable', size: 1},
  {text: 'Commons', size: 1},
  {text: 'commons', size: 1},
  {text: 'compelling', size: 1},
  {text: 'complacently', size: 1},
  {text: 'completed', size: 1},
  {text: 'compliment', size: 1},
  {text: 'composed', size: 1},
  {text: 'composition', size: 1},
  {text: 'comprise', size: 1},
  {text: 'concise', size: 1},
  {text: 'conclave', size: 1},
  {text: 'confinement', size: 1},
  {text: 'consideration', size: 1},
  {text: 'consign', size: 1},
  {text: 'consolatory', size: 1},
  {text: 'contents', size: 1},
  {text: 'contracted', size: 1},
  {text: 'contrive', size: 1},
  {text: 'contrived', size: 1},
  {text: 'controvert', size: 1},
  {text: 'cork', size: 1},
  {text: 'corn', size: 1},
  {text: 'cottage', size: 1},
  {text: 'cough', size: 1},
  {text: 'coupled', size: 1},
  {text: 'cover', size: 1},
  {text: 'covering', size: 1},
  {text: 'coverlet', size: 1},
  {text: 'crop', size: 1},
  {text: 'culprit', size: 1},
  {text: 'cupboard', size: 1},
  {text: 'curtsey', size: 1},
  {text: 'custom', size: 1},
  {text: 'darkly', size: 1},
  {text: 'date', size: 1},
  {text: 'deceive', size: 1},
  {text: 'deception', size: 1},
  {text: 'decision', size: 1},
  {text: 'define', size: 1},
  {text: 'defined', size: 1},
  {text: 'delegate', size: 1},
  {text: 'deliberation', size: 1},
  {text: 'deliver', size: 1},
  {text: 'demolition', size: 1},
  {text: 'demonstrate', size: 1},
  {text: 'demonstrated', size: 1},
  {text: 'depict', size: 1},
  {text: 'depicted', size: 1},
  {text: 'depth', size: 1},
  {text: 'desperate', size: 1},
  {text: 'despise', size: 1},
  {text: 'despised', size: 1},
  {text: 'destitute', size: 1},
  {text: 'determine', size: 1},
  {text: 'devotional', size: 1},
  {text: 'devour', size: 1},
  {text: 'dietary', size: 1},
  {text: 'dignified', size: 1},
  {text: 'dignify', size: 1},
  {text: 'dignity', size: 1},
  {text: 'diminutive', size: 1},
  {text: 'dirt', size: 1},
  {text: 'disappear', size: 1},
  {text: 'discussion', size: 1},
  {text: 'dispatch', size: 1},
  {text: 'display', size: 1},
  {text: 'dispose', size: 1},
  {text: 'disposed', size: 1},
  {text: 'distinctly', size: 1},
  {text: 'divide', size: 1},
  {text: 'divided', size: 1},
  {text: 'divorce', size: 1},
  {text: 'doctor', size: 1},
  {text: 'Doctor', size: 1},
  {text: 'domicile', size: 1},
  {text: 'dressed', size: 1},
  {text: 'drudge', size: 1},
  {text: 'duly', size: 1},
  {text: 'dying', size: 1},
  {text: 'eager', size: 1},
  {text: 'ease', size: 1},
  {text: 'eating', size: 1},
  {text: 'educate', size: 1},
  {text: 'educated', size: 1},
  {text: 'education', size: 1},
  {text: 'emanate', size: 1},
  {text: 'embrace', size: 1},
  {text: 'employ', size: 1},
  {text: 'encrust', size: 1},
  {text: 'encrusted', size: 1},
  {text: 'engender', size: 1},
  {text: 'entertainment', size: 1},
  {text: 'envelop', size: 1},
  {text: 'enviable', size: 1},
  {text: 'establish', size: 1},
  {text: 'established', size: 1},
  {text: 'establishment', size: 1},
  {text: 'evaporate', size: 1},
  {text: 'evaporated', size: 1},
  {text: 'event', size: 1},
  {text: 'every night', size: 1},
  {text: 'every quarter', size: 1},
  {text: 'evident', size: 1},
  {text: 'evidently', size: 1},
  {text: 'excitement', size: 1},
  {text: 'exercise', size: 1},
  {text: 'exertion', size: 1},
  {text: 'exist', size: 1},
  {text: 'expand', size: 1},
  {text: 'expense', size: 1},
  {text: 'expensive', size: 1},
  {text: 'experienced', size: 1},
  {text: 'extant', size: 1},
  {text: 'faced', size: 1},
  {text: 'factor', size: 1},
  {text: 'fail', size: 1},
  {text: 'faithful', size: 1},
  {text: 'fall back', size: 1},
  {text: 'fall out', size: 1},
  {text: 'farming', size: 1},
  {text: 'favour', size: 1},
  {text: 'feebly', size: 1},
  {text: 'feint', size: 1},
  {text: 'festive', size: 1},
  {text: 'fetch', size: 1},
  {text: 'fictitious', size: 1},
  {text: 'fictitious name', size: 1},
  {text: 'find out', size: 1},
  {text: 'finding', size: 1},
  {text: 'finger', size: 1},
  {text: 'finish', size: 1},
  {text: 'firmly', size: 1},
  {text: 'fling', size: 1},
  {text: 'flock', size: 1},
  {text: 'flutter', size: 1},
  {text: 'folk', size: 1},
  {text: 'folks', size: 1},
  {text: 'fond', size: 1},
  {text: 'fondling', size: 1},
  {text: 'for the first time', size: 1},
  {text: 'forever', size: 1},
  {text: 'forgotten', size: 1},
  {text: 'forthwith', size: 1},
  {text: 'fortunate', size: 1},
  {text: 'fortunately', size: 1},
  {text: 'furious', size: 1},
  {text: 'gasp', size: 1},
  {text: 'gather', size: 1},
  {text: 'gathered', size: 1},
  {text: 'generation', size: 1},
  {text: 'gesture', size: 1},
  {text: 'get behind', size: 1},
  {text: 'get to', size: 1},
  {text: 'gloom', size: 1},
  {text: 'glove', size: 1},
  {text: 'go away', size: 1},
  {text: 'go to sleep', size: 1},
  {text: 'go with', size: 1},
  {text: 'going away', size: 1},
  {text: 'good-looking', size: 1},
  {text: 'goodness', size: 1},
  {text: 'grace', size: 1},
  {text: 'gracious', size: 1},
  {text: 'gradual', size: 1},
  {text: 'grandmother', size: 1},
  {text: 'gratified', size: 1},
  {text: 'gratify', size: 1},
  {text: 'grief', size: 1},
  {text: 'grown', size: 1},
  {text: 'gruff', size: 1},
  {text: 'hall', size: 1},
  {text: 'hand over', size: 1},
  {text: 'handed', size: 1},
  {text: 'hastily', size: 1},
  {text: 'haughty', size: 1},
  {text: 'headed', size: 1},
  {text: 'healthy', size: 1},
  {text: 'hesitate', size: 1},
  {text: 'hesitating', size: 1},
  {text: 'hitherto', size: 1},
  {text: 'horror', size: 1},
  {text: 'human being', size: 1},
  {text: 'humanely', size: 1},
  {text: 'humble', size: 1},
  {text: 'hurried', size: 1},
  {text: 'hurry', size: 1},
  {text: 'hush', size: 1},
  {text: 'ill-usage', size: 1},
  {text: 'illustration', size: 1},
  {text: 'impart', size: 1},
  {text: 'imperfectly', size: 1},
  {text: 'impertinence', size: 1},
  {text: 'implant', size: 1},
  {text: 'implanted', size: 1},
  {text: 'implicitly', size: 1},
  {text: 'importance', size: 1},
  {text: 'impose', size: 1},
  {text: 'imposed', size: 1},
  {text: 'imprint', size: 1},
  {text: 'in full', size: 1},
  {text: 'in hand', size: 1},
  {text: 'inadvertently', size: 1},
  {text: 'inconvenience', size: 1},
  {text: 'increased', size: 1},
  {text: 'indubitably', size: 1},
  {text: 'induce', size: 1},
  {text: 'inducing', size: 1},
  {text: 'inestimable', size: 1},
  {text: 'inevitably', size: 1},
  {text: 'inflame', size: 1},
  {text: 'inflaming', size: 1},
  {text: 'inform', size: 1},
  {text: 'informed', size: 1},
  {text: 'inheritance', size: 1},
  {text: 'inquest', size: 1},
  {text: 'inquiring', size: 1},
  {text: 'inseparable', size: 1},
  {text: 'instant', size: 1},
  {text: 'intelligence', size: 1},
  {text: 'interrogation', size: 1},
  {text: 'invariably', size: 1},
  {text: 'invitation', size: 1},
  {text: 'issue', size: 1},
  {text: 'item', size: 1},
  {text: 'jury', size: 1},
  {text: 'juvenile', size: 1},
  {text: 'keeping', size: 1},
  {text: 'kick', size: 1},
  {text: 'kill', size: 1},
  {text: 'kindly', size: 1},
  {text: 'kindness', size: 1},
  {text: 'kindred', size: 1},
  {text: 'knock', size: 1},
  {text: 'knowing', size: 1},
  {text: 'lace', size: 1},
  {text: 'laced', size: 1},
  {text: 'lady of the house', size: 1},
  {text: 'lamb', size: 1},
  {text: 'large white', size: 1},
  {text: 'lean', size: 1},
  {text: 'leave behind', size: 1},
  {text: 'left hand', size: 1},
  {text: 'leg', size: 1},
  {text: 'lie', size: 1},
  {text: 'lie in', size: 1},
  {text: 'lighted', size: 1},
  {text: 'liked', size: 1},
  {text: 'linger', size: 1},
  {text: 'lingering', size: 1},
  {text: 'lip', size: 1},
  {text: 'listen', size: 1},
  {text: 'literary', size: 1},
  {text: 'literature', size: 1},
  {text: 'lively', size: 1},
  {text: 'lock', size: 1},
  {text: 'lock up', size: 1},
  {text: 'loneliness', size: 1},
  {text: 'long time', size: 1},
  {text: 'long-headed', size: 1},
  {text: 'loosely', size: 1},
  {text: 'lots', size: 1},
  {text: 'lowest', size: 1},
  {text: 'lump', size: 1},
  {text: 'lung', size: 1},
  {text: 'lustily', size: 1},
  {text: 'luxuriant', size: 1},
  {text: 'magnanimously', size: 1},
  {text: 'maintain', size: 1},
  {text: 'majestic', size: 1},
  {text: 'make it', size: 1},
  {text: 'male', size: 1},
  {text: 'mar', size: 1},
  {text: 'marry', size: 1},
  {text: 'marvellously', size: 1},
  {text: 'material', size: 1},
  {text: 'mattress', size: 1},
  {text: 'meal', size: 1},
  {text: 'mealtime', size: 1},
  {text: 'meanwhile', size: 1},
  {text: 'medical', size: 1},
  {text: 'member', size: 1},
  {text: 'memoir', size: 1},
  {text: 'mercy', size: 1},
  {text: 'merit', size: 1},
  {text: 'miserable', size: 1},
  {text: 'misty', size: 1},
  {text: 'mix', size: 1},
  {text: 'mixing', size: 1},
  {text: 'mollify', size: 1},
  {text: 'morrow', size: 1},
  {text: 'mortality', size: 1},
  {text: 'mortar', size: 1},
  {text: 'narrative', size: 1},
  {text: 'naturally', size: 1},
  {text: 'neat', size: 1},
  {text: 'necessity', size: 1},
  {text: 'neglect', size: 1},
  {text: 'neighbor', size: 1},
  {text: 'nobleman', size: 1},
  {text: 'noticed', size: 1},
  {text: 'notion', size: 1},
  {text: 'nourishment', size: 1},
  {text: 'novel', size: 1},
  {text: 'nudge', size: 1},
  {text: "o'clock", size: 1},
  {text: 'oatmeal', size: 1},
  {text: 'oblige', size: 1},
  {text: 'obliged', size: 1},
  {text: 'observe', size: 1},
  {text: 'occasionally', size: 1},
  {text: 'occasions', size: 1},
  {text: 'occur', size: 1},
  {text: 'occurrence', size: 1},
  {text: 'offend', size: 1},
  {text: 'offended', size: 1},
  {text: 'offender', size: 1},
  {text: 'offering', size: 1},
  {text: 'officiously', size: 1},
  {text: 'once again', size: 1},
  {text: 'onion', size: 1},
  {text: 'oratorical', size: 1},
  {text: 'originally', size: 1},
  {text: 'ounce', size: 1},
  {text: 'outer', size: 1},
  {text: 'overload', size: 1},
  {text: 'overlook', size: 1},
  {text: 'overlooked', size: 1},
  {text: 'page', size: 1},
  {text: 'palm', size: 1},
  {text: 'paralyse', size: 1},
  {text: 'pardon', size: 1},
  {text: 'parental', size: 1},
  {text: 'parishioner', size: 1},
  {text: 'parlour', size: 1},
  {text: 'parochial', size: 1},
  {text: 'participate', size: 1},
  {text: 'participating', size: 1},
  {text: 'passionately', size: 1},
  {text: 'paste', size: 1},
  {text: 'pasted', size: 1},
  {text: 'patchwork', size: 1},
  {text: 'patient', size: 1},
  {text: 'pause', size: 1},
  {text: 'per diem', size: 1},
  {text: 'perception', size: 1},
  {text: 'perform', size: 1},
  {text: 'periodical', size: 1},
  {text: 'periodically', size: 1},
  {text: 'perspective', size: 1},
  {text: 'perspiration', size: 1},
  {text: 'persuasively', size: 1},
  {text: 'perversely', size: 1},
  {text: 'philosophical', size: 1},
  {text: 'philosophy', size: 1},
  {text: 'pick up', size: 1},
  {text: 'pilgrimage', size: 1},
  {text: 'pinion', size: 1},
  {text: 'pinioned', size: 1},
  {text: 'pity', size: 1},
  {text: 'placid', size: 1},
  {text: 'plenty', size: 1},
  {text: 'poise', size: 1},
  {text: 'poised', size: 1},
  {text: 'polish', size: 1},
  {text: 'polished', size: 1},
  {text: 'porringer', size: 1},
  {text: 'portion', size: 1},
  {text: 'possibility', size: 1},
  {text: 'possibly', size: 1},
  {text: 'prayer', size: 1},
  {text: 'prefix', size: 1},
  {text: 'presume', size: 1},
  {text: 'pride', size: 1},
  {text: 'profound', size: 1},
  {text: 'proof', size: 1},
  {text: 'prophetic', size: 1},
  {text: 'prospect', size: 1},
  {text: 'protect', size: 1},
  {text: 'protecting', size: 1},
  {text: 'prudent', size: 1},
  {text: 'put on', size: 1},
  {text: 'quantity', size: 1},
  {text: 'quite a', size: 1},
  {text: 'raising', size: 1},
  {text: 'range', size: 1},
  {text: 'rare', size: 1},
  {text: 'reader', size: 1},
  {text: 'readiness', size: 1},
  {text: 'reasonably', size: 1},
  {text: 'rebel', size: 1},
  {text: 'rebelliously', size: 1},
  {text: 'recent', size: 1},
  {text: 'reckless', size: 1},
  {text: 'recollection', size: 1},
  {text: 'red-faced', size: 1},
  {text: 'reference', size: 1},
  {text: 'reflection', size: 1},
  {text: 'refrain', size: 1},
  {text: 'refusal', size: 1},
  {text: 'regret', size: 1},
  {text: 'regular', size: 1},
  {text: 'regulation', size: 1},
  {text: 'rejoice', size: 1},
  {text: 'rejoicing', size: 1},
  {text: 'relax', size: 1},
  {text: 'relaxed', size: 1},
  {text: 'remonstrance', size: 1},
  {text: 'reported', size: 1},
  {text: 'resolve', size: 1},
  {text: 'resolved', size: 1},
  {text: 'respectful', size: 1},
  {text: 'respiration', size: 1},
  {text: 'respond', size: 1},
  {text: 'right hand', size: 1},
  {text: 'ring', size: 1},
  {text: 'robe', size: 1},
  {text: 'rolled', size: 1},
  {text: 'rough', size: 1},
  {text: 'rub', size: 1},
  {text: 'run out', size: 1},
  {text: 'rush', size: 1},
  {text: 'rushed', size: 1},
  {text: 'rustle', size: 1},
  {text: 'sage', size: 1},
  {text: 'salutation', size: 1},
  {text: 'satisfaction', size: 1},
  {text: 'scald', size: 1},
  {text: 'scarce', size: 1},
  {text: 'scrub', size: 1},
  {text: 'scrubbed', size: 1},
  {text: 'seated', size: 1},
  {text: 'select', size: 1},
  {text: 'self', size: 1},
  {text: 'sending', size: 1},
  {text: 'sequel', size: 1},
  {text: 'set down', size: 1},
  {text: 'set up', size: 1},
  {text: 'setting', size: 1},
  {text: 'settlement', size: 1},
  {text: 'shine', size: 1},
  {text: 'shoe', size: 1},
  {text: 'shoes', size: 1},
  {text: 'shook', size: 1},
  {text: 'shop', size: 1},
  {text: 'shriek', size: 1},
  {text: 'shrieked', size: 1},
  {text: 'shrunken', size: 1},
  {text: 'shudder', size: 1},
  {text: 'sicken', size: 1},
  {text: 'signature', size: 1},
  {text: 'sink', size: 1},
  {text: 'sit down', size: 1},
  {text: 'sit in', size: 1},
  {text: 'sleep in', size: 1},
  {text: 'sleeping', size: 1},
  {text: 'slow', size: 1},
  {text: 'smother', size: 1},
  {text: 'smothered', size: 1},
  {text: 'snappish', size: 1},
  {text: 'sneeze', size: 1},
  {text: 'sob', size: 1},
  {text: 'soften', size: 1},
  {text: 'softened', size: 1},
  {text: 'solemn', size: 1},
  {text: 'sorrow', size: 1},
  {text: 'spare', size: 1},
  {text: 'specimen', size: 1},
  {text: 'speedily', size: 1},
  {text: 'spirited', size: 1},
  {text: 'spirits', size: 1},
  {text: 'splash', size: 1},
  {text: 'spoken', size: 1},
  {text: 'stammer', size: 1},
  {text: 'stand in', size: 1},
  {text: 'stare', size: 1},
  {text: 'staring', size: 1},
  {text: 'start up', size: 1},
  {text: 'startle', size: 1},
  {text: 'startled', size: 1},
  {text: 'starvation', size: 1},
  {text: 'stature', size: 1},
  {text: 'stipend', size: 1},
  {text: 'stipendiary', size: 1},
  {text: 'stir', size: 1},
  {text: 'stirred', size: 1},
  {text: 'stomach', size: 1},
  {text: 'stone', size: 1},
  {text: 'stoop', size: 1},
  {text: 'stoop to', size: 1},
  {text: 'stooped', size: 1},
  {text: 'straw', size: 1},
  {text: 'stray', size: 1},
  {text: 'stretch', size: 1},
  {text: 'stretch out', size: 1},
  {text: 'stretched', size: 1},
  {text: 'stride', size: 1},
  {text: 'strive', size: 1},
  {text: 'striving', size: 1},
  {text: 'struggle', size: 1},
  {text: 'stupefied', size: 1},
  {text: 'stupefy', size: 1},
  {text: 'sturdy', size: 1},
  {text: 'suck', size: 1},
  {text: 'sucking', size: 1},
  {text: 'sugar', size: 1},
  {text: 'suit', size: 1},
  {text: 'summon', size: 1},
  {text: 'superintendence', size: 1},
  {text: 'superlative', size: 1},
  {text: 'surly', size: 1},
  {text: 'surround', size: 1},
  {text: 'surrounded', size: 1},
  {text: 'survive', size: 1},
  {text: 'swallow', size: 1},
  {text: 'swear', size: 1},
  {text: 'sweetness', size: 1},
  {text: 'systematic', size: 1},
  {text: 'take down', size: 1},
  {text: 'take in', size: 1},
  {text: 'take on', size: 1},
  {text: 'take out', size: 1},
  {text: 'take place', size: 1},
  {text: 'take up', size: 1},
  {text: 'talk about', size: 1},
  {text: 'talk of', size: 1},
  {text: 'tall', size: 1},
  {text: 'taste', size: 1},
  {text: 'tasting', size: 1},
  {text: 'tavern', size: 1},
  {text: 'tea', size: 1},
  {text: 'tear into', size: 1},
  {text: 'temerity', size: 1},
  {text: 'temple', size: 1},
  {text: 'temporary', size: 1},
  {text: 'termination', size: 1},
  {text: 'testimony', size: 1},
  {text: 'thanks', size: 1},
  {text: 'the Street', size: 1},
  {text: 'theory', size: 1},
  {text: 'thereby', size: 1},
  {text: 'thereon', size: 1},
  {text: 'theretofore', size: 1},
  {text: 'thingummy', size: 1},
  {text: 'think about', size: 1},
  {text: 'thirteen', size: 1},
  {text: 'thirty', size: 1},
  {text: 'thrash', size: 1},
  {text: 'thrashing', size: 1},
  {text: 'thrust', size: 1},
  {text: 'thrusting', size: 1},
  {text: 'ticket', size: 1},
  {text: 'to be sure', size: 1},
  {text: 'to wit', size: 1},
  {text: 'torture', size: 1},
  {text: 'treachery', size: 1},
  {text: 'tremble', size: 1},
  {text: 'tremendous', size: 1},
  {text: 'trot', size: 1},
  {text: 'turn up', size: 1},
  {text: 'twice', size: 1},
  {text: 'uncomfortable', size: 1},
  {text: 'unconsciously', size: 1},
  {text: 'unconsciousness', size: 1},
  {text: 'undertake', size: 1},
  {text: 'undertaker', size: 1},
  {text: 'undo', size: 1},
  {text: 'unequally', size: 1},
  {text: 'unexpectedly', size: 1},
  {text: 'unfortunately', size: 1},
  {text: 'uniform', size: 1},
  {text: 'unlimited', size: 1},
  {text: 'unquestionably', size: 1},
  {text: 'unwonted', size: 1},
  {text: 'upstairs', size: 1},
  {text: 'upward', size: 1},
  {text: 'usage', size: 1},
  {text: 'venture', size: 1},
  {text: 'victim', size: 1},
  {text: 'vindicate', size: 1},
  {text: 'vindicated', size: 1},
  {text: 'violent', size: 1},
  {text: 'voracious', size: 1},
  {text: 'wake', size: 1},
  {text: 'walk away', size: 1},
  {text: 'ward', size: 1},
  {text: 'washed', size: 1},
  {text: 'waste', size: 1},
  {text: 'wasted', size: 1},
  {text: 'wave', size: 1},
  {text: 'waving', size: 1},
  {text: 'weak', size: 1},
  {text: 'weakly', size: 1},
  {text: 'wed', size: 1},
  {text: 'wedding', size: 1},
  {text: 'weekly', size: 1},
  {text: 'weep', size: 1},
  {text: 'weeping', size: 1},
  {text: 'whisper', size: 1},
  {text: 'whispered', size: 1},
  {text: 'wildly', size: 1},
  {text: 'wink', size: 1},
  {text: 'wink at', size: 1},
  {text: 'wipe', size: 1},
  {text: 'wise', size: 1},
  {text: 'wit', size: 1},
  {text: 'worn', size: 1},
  {text: 'wrap', size: 1},
  {text: 'wrapped', size: 1},
  {text: 'yellow', size: 1},
  {text: 'Young', size: 1}
];

	//TODO use model data

	var data = getWordCloudData(currentArtistList);
	d3.wordcloud()
        .size([500, 300])
        .selector("#wCCanvas")
        .fill(d3.scale.ordinal().range(["#884400", "#448800", "#888800", "#444400"]))
        .words(words)
        .start();
      d3.select("#wCCanvas").selectAll("text").on("click", function(d, i) { wordClickAction(d3.select(this).text()); });
}


function clearWordCloud(){ //void
	d3.select("#wCCanvas").selectAll("*").remove();
}

function wordClickAction(word){ //void
	//word: string

	/*
		TODO
		use model data
	*/

	setCurrentWord(word);
	var sList = requestSongList(currentWord, currentArtistList);
	var song = '[{ \"songName\" : \"Song 1\", \"artist\" : \"Artist 1\",\"wordCount\" : 23},{\"songName\" : \"Song 2\",\"artist\" : \"Artist 2\",\"wordCount\" : 267},{\"songName\" : \"Song 3\",\"artist\" : \"Artist 2\",\"wordCount\" : 64}]';
	var songData = JSON.parse(song);
	songData.sort(function(a, b) {
    	return parseFloat(b.wordCount) - parseFloat(a.wordCount);
	});
	setSongList(songData);
	hideWordCloudPage();
	hideSearch();
	showSongListPage();
}

//Search
function userTypes() {
	/*
		TODO 
		update autolistevery time user types
	*/
}
function showAutoComplete(search){ //void
	//search: JSON object array
	setVisible("autoList");
}

function hideAutoComplete(){ //void
	setInvisible("autoList");
}

function searchAction(){ //void

	/*
		TODO
		add selected artist to artistList
		handle bad input
	*/

	 shiftInputsDown();
	setVisible("back");
	var artistName = 
	showWordCloudPage();
	setPage(1);
	populateWordCloud();

}

function shareAction(){ //void
	//facebook API
}

function mergeAction(){ //void
	/*
		TODO
		add selected artist to artistList
		update WC to add artist
		handle bad input
	*/
}

function hideSearch(){ //void 
	setInvisible("Search");
}

function showSearch(){ //void
	setVisible("Search");
}

//Animation Functions
function shiftInputsDown(){ //void
	document.getElementById("Search").style.paddingTop = "0%";
}

function shiftInputsCenter(){ //void
	setHeight("wCCanvas", "1");
	setHeight("songListCanvas", "1");
	setHeight("lyricsCanvas", "1");
	document.getElementById("Search").style.paddingTop = "10%";
}

function setHeight(id, height){ //void
	//id: string, height: string
	document.getElementById(id).style.height = height;
}

function setInvisible(id){ //void 
	//id: string
	document.getElementById(id).style.visibility = "hidden";
}

function setVisible (id) { //void 
	//id: string
	document.getElementById(id).style.visibility = "visible";
}
