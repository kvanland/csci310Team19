DROP DATABASE if exists CUMULYRICS;
CREATE DATABASE CUMULYRICS;
USE CUMULYRICS;
CREATE TABLE Artist (
	ArtistID int primary key auto_increment not null,
    ArtistName tinytext not null,
    ImageURL tinytext not null
);
CREATE TABLE Word (
	WordID int primary key auto_increment not null,
    Word tinytext not null,
    ArtistID int not null,
    foreign key (ArtistID) references Artist(ArtistID),
    Occurences int not null,
    Songs text not null
);