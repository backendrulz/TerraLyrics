Terra Lyrics
============

Usage
-----

### Initialization

Simply require and initialize the Terra_lyrics class like so

	require_once 'Terra_lyrics.php';
	$lyrics = new Terra_lyrics;

### Simple usage

First check if the song exists and then, display the lyrics.

	if($lyrics->search('Iron Maiden - The Trooper')) {
		echo $lyrics->getLyrics();
	}