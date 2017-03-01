
/***************************************************************
                      Word Cloud Model
***************************************************************/
var autoCompleteList; //JSON object array
var wordCloudData; //JSON object array
var lyrics; //String
var songList; //JSON object array

function setAutoCompleteList(autoCompleteListData){ //void
	//autoCompleteListData: JSON object array
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

function autoQueryList(query, callback) { //JSON object array
  callback(requestAutoCompleteList(query));
}

/***************************************************************
                     Data Requester
***************************************************************/

function requestAutoCompleteList(search){ //JSON object array
	var bar;
	var artist = search;
	var search = "http://localhost/Source Code/backend/getSuggestions.php?artist=" + artist;


	  $.ajax({
        url: search,
        success: function (result) {
            bar = JSON.parse(result);
        },
        async: false
    });


  return bar;
	/*
		 TODO
		use AJAX to request autocompleteList raw data
		parse string into json object array
		return array
	*/

}

function requestLyrics(songTitle, artist){ //String
	//songTitle: string, artist: string
	var search = "http://localhost/Source Code/backend/getLyrics.php?artist=" + artist + "&song=" + songTitle;
	 $.get(search, function(data, status){

    });
}

function requestWordCloudData(artistList){ //Map<String, int>
	//artistList: JSON object array
	var artist = document.getElementById("searchBar").value;
	var search = "http://localhost/Source Code/backend/getWordCloud.php?artist=" + artist;

	 $.get(search, function(data, status){
         wordCloudData = JSON.parse(data);

         populateWordCloud();

    });
	
}

function requestSongList(word, artist){ //JSON object array
	//word: string, artistList: JSON onject array
	/*
	var search = "http://localhost/cumulyrics/backend/getSongs.php?word=" + word + "&artist=" + "drake";
	alert(search);
	 $.get(search, function(data, status){
         alert(data);

    });
	*/
}

/***************************************************************
                      Word Cloud View Model
***************************************************************/
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
	setHeight("wCCanvas", "500px");
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

/***************************************************************
                      Lyrics
***************************************************************/
var lyricsCanvas = document.getElementById("lyricsCanvas");

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

/***************************************************************
                      Song List
***************************************************************/
var songListCanvas = document.getElementById("songListCanvas");

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

/***************************************************************
                      HTML
***************************************************************/

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

function homeAction(){
	if(PAGE[0]) {
		// if user is already all the way home do nothing
		return;
	}
	else if(PAGE[1]){ 
		//If the user is on the cloud page go all the way home
		clearView();
		searchButton.disabled = true;
		searchBar.value = "";
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
		searchButton.disabled = true;
		searchBar.value = "";
		
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

/***************************************************************
                      WordCloud
***************************************************************/
var wCCanvas = document.getElementById("wCCanvas");

function colorToggle() {
	/*
		TODO
		update color on wordcloud
	*/
  populateWordCloud();
  
        
}
function populateWordCloud(){ //void
	clearWordCloud(); // reset canvas
	var words = wordCloudData;
	
              var width = wCCanvas.clientWidth;
               if(document.getElementById('blackAndWhite').checked) { 
    d3.wordcloud()
        .size([width, 500])
        .font('Raleway')
        .selector("#wCCanvas")
        .fill(d3.scale.ordinal().range(["black", "white"]))
        .words(words)
        .start();
  }
  else {
    d3.wordcloud()
        .size([width, 500])
        .font('Raleway')
        .selector("#wCCanvas")
        .fill(d3.scale.ordinal().range(["#ff7f7f", "#ffb481", "#fffa8b", "#9cff86", "#89d8ff", "#a8e6cf", "#ECCDFA"]))
        .words(words)
        .start();
  }

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

	setCurrentWord(word)
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

/***************************************************************
                      Search
***************************************************************/
var searchButton = document.getElementById("searchButton");
var searchBar = document.getElementById("searchBar");
var shareButton = document.getElementById("shareButton");
var mergeButton = document.getElementById("mergeButton");
var searchContainer = document.getElementById("Search");


//jQuery function to set up the auto complete functionality for the search bar
$("#searchBar").autocomplete({
    minLength: 3, //Sets the minimum search length before autocomplete begins
    source: function(request, callback) { //Obtains an up to date autocomplete list
      var searchParam = request.term;
      autoQueryList(searchParam, callback)
    },
    focus: function (event, ui) {
    	$("#searchBar").val(ui.item.label);
    	document.getElementById("searchButton").disabled = false;
    	return false;
    }
  });

//Setting the types of data for the auto complete function
$("#searchBar").data("ui-autocomplete")._renderItem = function(ul, item){
    var $li = $('<li>'),
      $img = $('<img>');

      //Displays the artist image
      $img.attr({
        src: item.icon,
        alt: item.value
      });
      $img.css("width", "32px");
      $img.css("height", "32px");


      //Displays the artist name
      $li.attr('data-value', item.label);
      $li.append('<a href="#">');
      $li.find('a').append($img).append(item.label);    

      return $li.appendTo(ul);

  }
 

function userTypes() {
	/*
		TODO 
		update autolistevery time user types
	*/
	searchButton.disabled = true;
  var searchString = d3.select("#searchBar").value;
  setAutoCompleteList(requestSongList(searchString));
}

function showAutoComplete(search){ //void
//TODO get rid of this function it serves no purpose
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
	setPage(1);
	requestWordCloudData();
	showWordCloudPage();

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

/***************************************************************
                      Animation Functions
***************************************************************/

function shiftInputsDown(){ //void
	searchContainer.style.paddingTop = "0%";
}

function shiftInputsCenter(){ //void
	setHeight("wCCanvas", "1");
	setHeight("songListCanvas", "1");
	setHeight("lyricsCanvas", "1");
	searchContainer.style.paddingTop = "10%";
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
