import requests
import re
from collections import Counter
from nltk.corpus import stopwords
import mysql.connector

# MYSQL setup
mysql_config = { "user": "root",
        "password": "root",
        "host": "127.0.0.1",
        "database": "cumulyrics",
        }
# statements
get_auto_increment = ("SELECT AUTO_INCREMENT FROM information_schema.tables "
        "WHERE table_name = %s AND table_schema = DATABASE()")
insert_artist = ("INSERT INTO Artist "
        "(ArtistName, ImageURL) "
        "VALUES (%s, %s)")
insert_song = ("INSERT INTO Word "
        "(Word, ArtistID, Occurences, Songs) "
        "VALUES (%s, %s, %s, %s)")
cnx = mysql.connector.connect(**mysql_config) # start connection
cursor = cnx.cursor()

stops = set(stopwords.words("English")) # english stop words

# Scraping options
artists_per_page = 50 # num of artists requested from api per page. Max 1000
num_pages = 2 # number of pages to go through 
song_list_delimiter = '$' # seperates song names in database
lyrics_url = "http://localhost:8081/api/find/" # api url for lyrics-api
 
cursor.execute(get_auto_increment, ("Artist",))
artist_id = int(cursor.fetchone()[0]) # starting artist id (auto increments)

# base api url
base_url = "http://ws.audioscrobbler.com/2.0/?method=geo.gettopartists&country=united%20states&limit=" + str(artists_per_page) + "&page=" 
for page in range(num_pages):
    url = base_url+str(page+1)+"&api_key=d01318ecdfb319d6bb8ef0ea5895f7a0&format=json"
    response = requests.get(url)
    # Parse response
    artists = response.json()["topartists"]["artist"]
    for artist in artists:
        mbid = artist["mbid"] # id for lookup
        artist_name = artist["name"]
        artist_image = artist["image"][2]["#text"] # image url
        print(artist_name)
        # get list of songs for artist
        song_request_url = "http://ws.audioscrobbler.com/2.0/?method=artist.gettoptracks&mbid=" + mbid + "&api_key=d01318ecdfb319d6bb8ef0ea5895f7a0&limit=5&format=json"
        song_response = requests.get(song_request_url)
        # parse song response
        songs = song_response.json()["toptracks"]["track"]
        # special object to count things
        word_count = Counter({}) # will hold word:occurances pairs
        word_song_map = {} # matches words to songs
        for song in songs:
            song_name = song["name"]
            # this is needed to avoid saving "song" and "song accoustic version" twice
            disqualifiers = [
                    "version",
                    "remaster",
                    "live",
                    "edit",
                    "mix"]
            unique = True
            for i in disqualifiers:
                if i.casefold() in song_name.casefold():
                    unique = False
                    break
            if not unique:
                continue
            # only continue if song doesn't contain a disqualifying word
            try:
                lyrics = requests.get(lyrics_url + artist_name + "/" + song_name).json()["lyric"]
            except:
                print("404'd in artist: " + artist_name + ", page " + str(page+1))
                quit()
            lyric_array = re.split("\n| ", lyrics) # split string into tokens by \n and space
            filtered_lyrics = [word.lower() for word in lyric_array if word not in stops] # remove stop words
            more_filtered_lyrics = [re.sub('["(),\.\?]', '', word) for word in filtered_lyrics]
            lyrics_map = Counter(more_filtered_lyrics) # count word occurances in this song
            for i in lyrics_map: # loop over words to add songs to their tracking
                current_list = word_song_map.get(i) # current list of songs
                if word_song_map.get(i) is None:
                    word_song_map[i] = song_name
                else:
                    word_song_map[i] += '$' + song_name
            word_count.update(lyrics_map) # update overall count for artist
        del(word_count['']) # delete empty string which is a result of double spaces in lyrics
        del(word_song_map[''])
        cursor.execute(insert_artist, (artist_name, artist_image))
        for i in word_count.keys():
            cursor.execute(insert_song, (i, artist_id, word_count[i], word_song_map[i]))
        cnx.commit()
        artist_id += 1;
cursor.close()
cnx.close()
