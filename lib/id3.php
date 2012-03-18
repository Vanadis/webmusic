<?php
 
function read_id3($mp3){
	static $genre_arr = array("Blues","Classic Rock","Country","Dance","Disco","Funk","Grunge",
		"Hip-Hop","Jazz","Metal","New Age","Oldies","Other","Pop","R&B",
		"Rap","Reggae","Rock","Techno","Industrial","Alternative","Ska",
		"Death Metal","Pranks","Soundtrack","Euro-Techno","Ambient",
		"Trip-Hop","Vocal","Jazz+Funk","Fusion","Trance","Classical",
		"Instrumental","Acid","House","Game","Sound Clip","Gospel",
		"Noise","AlternRock","Bass","Soul","Punk","Space","Meditative",
		"Instrumental Pop","Instrumental Rock","Ethnic","Gothic",
		"Darkwave","Techno-Industrial","Electronic","Pop-Folk",
		"Eurodance","Dream","Southern Rock","Comedy","Cult","Gangsta",
		"Top 40","Christian Rap","Pop/Funk","Jungle","Native American",
		"Cabaret","New Wave","Psychadelic","Rave","Showtunes","Trailer",
		"Lo-Fi","Tribal","Acid Punk","Acid Jazz","Polka","Retro",
		"Musical","Rock & Roll","Hard Rock","Folk","Folk-Rock",
		"National Folk","Swing","Fast Fusion","Bebob","Latin","Revival",
		"Celtic","Bluegrass","Avantgarde","Gothic Rock","Progressive Rock",
		"Psychedelic Rock","Symphonic Rock","Slow Rock","Big Band",
		"Chorus","Easy Listening","Acoustic","Humour","Speech","Chanson",
		"Opera","Chamber Music","Sonata","Symphony","Booty Bass","Primus",
		"Porn Groove","Satire","Slow Jam","Club","Tango","Samba",
		"Folklore","Ballad","Power Ballad","Rhythmic Soul","Freestyle",
		"Duet","Punk Rock","Drum Solo","Acapella","Euro-House","Dance Hall");
		 
	$filesize = filesize($mp3);
	$file = fopen($mp3, "r");
	fseek($file, -128, SEEK_END);

	$tag = fread($file, 3);
	$data=array();
	if($tag == "TAG") {
		$data["filename"] = $mp3;
		$data["song"] = trim(fread($file, 30));
		$data["artist"] = trim(fread($file, 30));
		$data["album"] = trim(fread($file, 30));
		$data["year"] = trim(fread($file, 4));
		$data["comment"] = trim(fread($file, 30));
		$data["genre"] = @$genre_arr[ord(trim(fread($file, 1)))];

	}
	fclose($file);
	return $data;
}

?> 
