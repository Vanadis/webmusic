<?php
/*
 * Copyright (C) 2007 Michael Zeising <michael AT michaels-website DOT de>
 * 
 * PHP ID3 & MPEG Parser v0.2.3
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public Licence as published by the Free Software
 * Foundation; either version 2 of the Licence, or (at your option) any later
 * version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public Licence for more 
 * details.
 * 
 * You should have received a copy of the GNU General Public Licence along with
 * this program; if not, write to the Free Software Foundation, Inc., 51 Franklin
 * Street, Fifth Floor, Boston, MA  02110-1301, USA
 */

# define bit masks
define('V3_IS_COMPRESSED', 0x80);
define('V4_IS_COMPRESSED', 0x8);

# ID3v1 genres table
$v1Genres = array(
		0   => 'Blues',
		1   => 'Classic Rock',
		2   => 'Country',
		3   => 'Dance',
		4   => 'Disco',
		5   => 'Funk',
		6   => 'Grunge',
		7   => 'Hip-Hop',
		8   => 'Jazz',
		9   => 'Metal',
		10  => 'New Age',
		11  => 'Oldies',
		12  => 'Other',
		13  => 'Pop',
		14  => 'R&B',
		15  => 'Rap',
		16  => 'Reggae',
		17  => 'Rock',
		18  => 'Techno',
		19  => 'Industrial',
		20  => 'Alternative',
		21  => 'Ska',
		22  => 'Death Metal',
		23  => 'Pranks',
		24  => 'Soundtrack',
		25  => 'Euro-Techno',
		26  => 'Ambient',
		27  => 'Trip-Hop',
		28  => 'Vocal',
		29  => 'Jazz+Funk',
		30  => 'Fusion',
		31  => 'Trance',
		32  => 'Classical',
		33  => 'Instrumental',
		34  => 'Acid',
		35  => 'House',
		36  => 'Game',
		37  => 'Sound Clip',
		38  => 'Gospel',
		39  => 'Noise',
		40  => 'Alternative Rock',
		41  => 'Bass',
		42  => 'Soul',
		43  => 'Punk',
		44  => 'Space',
		45  => 'Meditative',
		46  => 'Instrumental Pop',
		47  => 'Instrumental Rock',
		48  => 'Ethnic',
		49  => 'Gothic',
		50  => 'Darkwave',
		51  => 'Techno-Industrial',
		52  => 'Electronic',
		53  => 'Pop-Folk',
		54  => 'Eurodance',
		55  => 'Dream',
		56  => 'Southern Rock',
		57  => 'Comedy',
		58  => 'Cult',
		59  => 'Gangsta',
		60  => 'Top 40',
		61  => 'Christian Rap',
		62  => 'Pop/Funk',
		63  => 'Jungle',
		64  => 'Native US',
		65  => 'Cabaret',
		66  => 'New Wave',
		67  => 'Psychadelic',
		68  => 'Rave',
		69  => 'Showtunes',
		70  => 'Trailer',
		71  => 'Lo-Fi',
		72  => 'Tribal',
		73  => 'Acid Punk',
		74  => 'Acid Jazz',
		75  => 'Polka',
		76  => 'Retro',
		77  => 'Musical',
		78  => 'Rock & Roll',
		79  => 'Hard Rock',
		80  => 'Folk',
		81  => 'Folk-Rock',
		82  => 'National Folk',
		83  => 'Swing',
		84  => 'Fast Fusion',
		85  => 'Bebob',
		86  => 'Latin',
		87  => 'Revival',
		88  => 'Celtic',
		89  => 'Bluegrass',
		90  => 'Avantgarde',
		91  => 'Gothic Rock',
		92  => 'Progressive Rock',
		93  => 'Psychedelic Rock',
		94  => 'Symphonic Rock',
		95  => 'Slow Rock',
		96  => 'Big Band',
		97  => 'Chorus',
		98  => 'Easy Listening',
		99  => 'Acoustic',
		100 => 'Humour',
		101 => 'Speech',
		102 => 'Chanson',
		103 => 'Opera',
		104 => 'Chamber Music',
		105 => 'Sonata',
		106 => 'Symphony',
		107 => 'Booty Bass',
		108 => 'Primus',
		109 => 'Porn Groove',
		110 => 'Satire',
		111 => 'Slow Jam',
		112 => 'Club',
		113 => 'Tango',
		114 => 'Samba',
		115 => 'Folklore',
		116 => 'Ballad',
		117 => 'Power Ballad',
		118 => 'Rhytmic Soul',
		119 => 'Freestyle',
		120 => 'Duet',
		121 => 'Punk Rock',
		122 => 'Drum Solo',
		123 => 'Acapella',
		124 => 'Euro-House',
		125 => 'Dance Hall',
		126 => 'Goa',
		127 => 'Drum & Bass',
		128 => 'Club-House',
		129 => 'Hardcore',
		130 => 'Terror',
		131 => 'Indie',
		132 => 'BritPop',
		133 => 'Negerpunk',
		134 => 'Polsk Punk',
		135 => 'Beat',
		136 => 'Christian Gangsta Rap',
		137 => 'Heavy Metal',
		138 => 'Black Metal',
		139 => 'Crossover',
		140 => 'Contemporary Christian',
		141 => 'Christian Rock',
		142 => 'Merengue',
		143 => 'Salsa',
		144 => 'Trash Metal',
		145 => 'Anime',
		146 => 'Jpop',
		147 => 'Synthpop');

# mapping from id3v2.3 to the obsolete id3v2.2 frame IDs
$frameIDs3To2 = array('TPE1' => 'TP1',
		'TIT2' => 'TT2',
		'TALB' => 'TAL',
		'TCON' => 'TCO',
		'TYER' => 'TYE',
		'TRCK' => 'TRK',
		'COMM' => 'COM');

# bitrate tables for [MPEG-1 Layer 2, MPEG-1 Layer 3, MPEG-2 Layer 3]
$bitrates = array(
		array(0,32,48,56,64,80,96,112,128,160,192,224,256,320,384),
		array(0,32,40,48,56,64,80, 96,112,128,160,192,224,256,320),
		array(0, 8,16,24,32,64,80, 56, 64,128,160,112,128,256,320));

class ID3 {
	var $_filename;
	var $_utf8;
	var $_error = NULL;
	var $_fileParsed = FALSE;
	
	var $_v1Found = FALSE;			# id3v1 section found
	var $_v1Body = FALSE;			# id3v1 body
	
	var $_v2Found = FALSE;			# id3v2 section found	
	var $_v2Version = array(0, 0);	# id3v2 version like [major,minor]
	var $_v2Header = NULL;			# id3v2 header
	var $_v2Body = NULL;			# id3v2 body
	
	var $_mpegFrameFound = FALSE;	# MPEG frame found
	var $_mpegFrameOffset = 0;		# offset of the first MPEG frame
	var $_mpegFrameHeader = NULL;	# header of the first MPEG frame (4 bytes/32 bits)
	
	/*
	 * constructor
	 * stores the filename and sets the output encoding to UTF-8 if utf8 is TRUE, to ISO-8859-1 otherwise
	 */
	function ID3($filename, $utf8 = TRUE) {
		$this->_filename = $filename;
		$this->_utf8 = $utf8;
	}
	
	/*
	 * set new filename
	 */
	function setFilename($filename) {
		$this->_filename = $filename;
		$this->_fileParsed = FALSE;
		$this->_error = NULL;
		$this->_v1Found = FALSE;
		$this->_v2Found = FALSE;
	}
	
	/*
	 * isolates and checks ID3 tags
	 */
	function _parseFile() {
		if ($this->_fileParsed)
			return TRUE;

		if (!file_exists($this->_filename) || !is_readable($this->_filename) || (filesize($this->_filename) < 128)) {
			$this->_error = 'Invalid file';
			return FALSE;
		}

		$file = fopen($this->_filename, 'r');
		
		# read id3v2 part
		$this->_v2Header = fread($file, 10);
		if (substr($this->_v2Header, 0, 3) == 'ID3') {
			$this->_v2Found = TRUE;
			$tagLen = VToInt(substr($this->_v2Header, 6, 4), TRUE);
			$this->_v2Body = fread($file, ($tagLen - 10));
			$this->_v2Version = array(ord($this->_v2Header[3]), ord($this->_v2Header[4]));
		}

		rewind($file);
		# search for an MPEG frame
		$eof = FALSE;
		$sync=0;
		while ($sync != chr(255) && !$eof) {
			if (feof($file))
				$eof = TRUE;
			else 
				$sync = fread($file, 1);
		}

		if (!$eof) {
			$this->_mpegFrameFound = TRUE;
			fseek($file, ftell($file) - 1);
			$this->_mpegFrameOffset = ftell($file) - 1;
			$this->_mpegFrameHeader = fread($file, 4);
		} else
			$this->_mpegFrameFound = FALSE;
		
		# read id3v1 part	
		fseek($file, filesize($this->_filename) - 128);
		$this->_v1Body = fread($file, 128);
		$this->_v1Found = (bool)(substr($this->_v1Body, 0, 3) == 'TAG');

		fclose($file);
		
		$this->_fileParsed = TRUE;
		return TRUE;
	}
	
	function _getFrame($frameID) {
		global $frameIDs3To2;
		$offset = 0;
		$size = 0;
		$flags = '';
		$content = '';

		switch ($this->_v2Version[0]) {
			case 2:
				/* v2.2 frame
				 *
				 * +----------------------------+
				 * | frame ID (3 bytes, char[]) |
				 * +----------------------------+
				 * | length (3 bytes, int)      |
				 * +----------------------------+
				 * | contents                   |
				 */
				# translate frame id to v2.2 format
				$frameID = $frameIDs3To2[$frameID];

				$offset = strpos($this->_v2Body, $frameID);
				if ($offset === FALSE)
					return '';
				$length = vToInt(substr($this->_v2Body, $offset + 3, 3));
				
				return substr($this->_v2Body, $offset + 6, $length);
			case 3:
				/* v2.3 frame
				 *
				 * +----------------------------+
				 * | frame ID (4 bytes, char[]) |
				 * +----------------------------+
				 * | length (4 bytes, int)      |
				 * +----------------------------+
				 * | flags (2 bytes)            |
				 * +----------------------------+
				 * | contents                   |
				 *
				 * flags:
				 * %abc00000 %ijk00000
				 * a	tag alter preservation
				 * b	file alter preservation
				 * c	read only
				 *
				 * i	compression (zlib)
				 * j	encryption
				 * k	group identity
				 */
				$offset = strpos($this->_v2Body, $frameID);
				if ($offset === FALSE)
					return '';
				$length = vToInt(substr($this->_v2Body, $offset + 4, 4));
				
				$flags = array(ord(substr($this->_v2Body, $offset + 8, 1)),
						ord(substr($this->_v2Body, $offset + 9, 1)));
				
				if ($flags[1] & V3_IS_COMPRESSED) {
					$lengthUn = vToInt(substr($this->_v2Body, $offset + 10, 4));
					$compressed = substr($this->_v2Body, $offset + 14, $length - 4);
					return gzuncompress($compressed, $lengthUn);
				}
				
				return substr($this->_v2Body, $offset + 10, $length);
			case 4:
				/* v2.4 frame
				 *
				 * +---------------------------------------------------+
				 * | frame ID (4 bytes, char[])                        |
				 * +---------------------------------------------------+
				 * | length (4 bytes, synchsafe int, 28-bit effective) |
				 * +---------------------------------------------------+
				 * | flags (2 bytes)                                   |
				 * +---------------------------------------------------+
				 * | contents                                          |
				 *
				 * flags:
				 * %0abc0000 %0h00kmnp
				 * a	tag alter preservation
				 * b	file alter preservation
				 * c	read only
				 *
				 * h	grouping identity
				 * k	compression (zlib deflate)
				 * m	encryption
				 * n	unsynchronisation
				 * p	data length indicator
				 */
				$offset = strpos($this->_v2Body, $frameID);
				if ($offset === FALSE)
					return '';
				$length = vToInt(substr($this->_v2Body, $offset + 4, 4), TRUE);
				
				$flags = array(ord(substr($this->_v2Body, $offset + 8, 1)),
						ord(substr($this->_v2Body, $offset + 9, 1)));
				
				if ($flags[1] & V4_IS_COMPRESSED) {
					$lengthUn = vToInt(substr($this->_v2Body, $offset + 10, 4));
					$deflated = substr($this->_v2Body, $offset + 14, $length - 4);
					return gzinflate($deflated, $lengthUn);
				}
				
				return @substr($this->_id3v2, $offset + 10, $length);
		}
	}
	
	/*
	 * decodes a text frame to the default encoding
	 */
	function _decodeTextFrame($frame) {
		/* 'T...' frame (not TXXX)
		 * +---------------------------+
		 * | frame header T...         |
		 * +---------------------------+
		 * | text encoding ID (1 byte) |
		 * +---------------------------+
		 * | contents                  |
		 *
		 * possible encoding IDs:
		 * $00	ISO 8859-1
		 * $01 	UTF-16 with byte order mark (BOM)
		 * $02	UTF-16 without BOM
		 * $03 	UTF-8
		 */
		$encodingID = ord(substr($frame, 0, 1));
		$data = substr($frame, 1, strlen($frame) - 1);
		return $this->_decodeString($data, $encodingID);
	}
	
	/*
	 * returns the ID3 version
	 */
	function getVersion() {
		if (!$this->_parseFile())
			return '';
		if ($this->_v2Found)
			return 'ID3v2.'.implode('.', $this->_v2Version);
		elseif ($this->_v1Found)
			if (substr($this->_v1Body, 125, 1) == "\0" && substr($this->_v1Body, 126, 1) != "\0")
				return 'ID3v1.1';
			else
				return 'ID3v1';
		else
			return '';
	}
	
	function getArtist() {
		if (!$this->_parseFile())
			return '';
		if ($this->_v2Found)
			return $this->_decodeTextFrame($this->_getFrame('TPE1'));
		elseif ($this->_v1Found)
			return chop(substr($this->_v1Body, 33, 30));
		else
			return '';
	}
	
	function getTitle() {
		if (!$this->_parseFile())
			return '';
		if ($this->_v2Found)
			return $this->_decodeTextFrame($this->_getFrame('TIT2'));
		elseif ($this->_v1Found)
			return chop(substr($this->_v1Body, 3, 30));
		else
			return '';
	}
	
	function getAlbum() {
		if (!$this->_parseFile())
			return '';
		if ($this->_v2Found)
			return $this->_decodeTextFrame($this->_getFrame('TALB'));
		elseif ($this->_v1Found)
			return chop(substr($this->_v1Body, 63, 30));
		else
			return '';
	}
	
	function getGenre() {
		global $v1Genres;
		if (!$this->_parseFile())
			return '';
		if ($this->_v2Found)
			return $this->_decodeTextFrame($this->_getFrame('TCON'));
		elseif ($this->_v1Found)
			return $v1Genres[ord(substr($this->_v1Body, -1, 1))];
		else
			return '';
	}
	
	function getYear() {
		if (!$this->_parseFile())
			return '';
		if ($this->_v2Found)
			return $this->_decodeTextFrame($this->_getFrame('TYER'));
		elseif ($this->_v1Found) {
			$year = substr($this->_v1Body, 93, 4);
			if ($year > 0)
				return $year;
			else
				return '';
		} else
			return '';
	}
	
	function getTrack() {
		if (!$this->_parseFile())
			return 0;
		if ($this->_v2Found)
			return $this->_decodeTextFrame($this->_getFrame('TRCK'));
		elseif ($this->_v1Found)
			if (substr($this->_v1Body, 125, 1) == "\0" && substr($this->_v1Body, 126, 1) != "\0")
				# ID3v1.1 only
				return ord(substr($this->_v1Body, 126, 1));
		else
			return 0;
	}
	
	function getComment() {
		/* pattern for 'COMM' frame
		 * +--------------------+
		 * | frame header COMM  |
		 * +--------------------+
		 * | encoding (1 byte)  |
		 * +--------------------+
		 * | language (3 bytes) |
		 * +--------------------+
		 * | description + $00  |
		 * +--------------------+
		 * | content            |
		 *
		 * see _decodeTextFrame for encodings
		 */
		if (!$this->_parseFile())
			return '';
		if ($this->_v2Found) {
			$frame = $this->_getFrame('COMM');
			if (strlen($frame) > 4) {
				$term = strpos($frame, "\0", 4);
				if ($term === FALSE)
					return '';
			} else
				return '';
			$content = substr($frame, $term + 1, strlen($frame) - $term - 1);
			$encodingID = ord(substr($frame, 0, 1));
			return $this->_decodeString($content, $encodingID);
		} elseif ($this->_v1Found) {
			if (substr($this->_v1Body, 125, 1) == "\0" && substr($this->_v1Body, 126, 1) != "\0") {
				# ID3v1.1
				return chop(substr($this->_v1Body, 97, 28));
			} else {
				# ID3v1
				return chop(substr($this->_v1Body, 97, 30));
			}
		}
	}
	
	/*
	 * decodes <string> to UTF-8 or ISO 8859-1 according to <encodingID>
	 */
	function _decodeString($string, $encodingID) {
		switch ($encodingID) {
			case 0: 	# ISO 8859-1
				if ($this->_utf8)
					return utf8_encode($string);
				else
					return $string;
			case 1:		# UTF-16 with BOM
				$this->_error = 'UTF-16 text encoding is not yet supported.';
				return $string;
			case 2:		# UTF-16 without BOM
				$this->_error = 'UTF-16 text encoding is not yet supported.';
				return $string;
			case 3:
				if ($this->_utf8)
					return $string;
				else
					return utf8_decode($string);
			default:
				$this->_error = 'Unknown text encoding: '.$encodingID;
				return $string;
		}
	}
	
	/**********************************
	 * MPEG audio specific
	 **********************************/
	
	/*
	 * returns the duration of the file in seconds or in mm:ss format
	 */
	function getDuration($formatted = FALSE) {
		if (!$this->_parseFile())
			return 0;
		$bitrate = $this->getBitrate();
		if (!$bitrate)
			return 0;
		$duration = floor(((8 * filesize($this->_filename)) / 1000) / $bitrate);
		if ($formatted)
			return sprintf('%01d:%02d', floor($duration/60), floor($duration-(floor($duration/60)*60)));
		else
			return $duration; 
	}
	
	/*
	 * returns TRUE if the MPEG frames are padded, FALSE otherwise
	 */
	function framesPadded() {
		if (!$this->_parseFile())
			return FALSE;
		return (bool)((ord(substr($this->_mpegFrameHeader, 2, 1)) % 4) / 2);
	}
	
	/*
	 * returns the constant bitrate (CBR) of the MPEG audio in kbps
	 */
	function getBitrate() {
		global $bitrates;
		if (!$this->_parseFile())
			return 0;
		$layer = ord(substr($this->_mpegFrameHeader,1,1)) / 2 % 4;
		switch ($layer) {
			case 3:
				# MPEG-1 Audio Layer 1
				return (ord(substr($this->_mpegFrameHeader, 2, 1)) / 16) * 32;
			case 2:
				# MPEG-1 Audio Layer 2 (MP2)
				return $bitrates[0][ord(substr($this->_mpegFrameHeader, 2, 1)) / 16];
			case 1:
				# Layer 3
				if ((ord(substr($this->_mpegFrameHeader, 1, 1)) / 8 % 2) == 0) {
					# MPEG-2 Audio Layer 3
					return $bitrates[2][ord(substr($this->_mpegFrameHeader, 2, 1)) / 16];
				} 
				else {
					# MPEG-1 Audio Layer 3 (MP3)
					return $bitrates[1][ord(substr($this->_mpegFrameHeader, 2, 1)) / 16];
				}
		}
		
		return 0;
	}
	
	/*
	 * returns the audio compression algorithm
	 */
	function getCompression() {
		if (!$this->_parseFile())
			return 0;
		$layer = ord(substr($this->_mpegFrameHeader,1,1)) / 2 % 4;
		switch ($layer) {
			case 3:
				return 'MPEG-1 Audio Layer 1';
			case 2:
				return 'MP2';
			case 1:
				if ((ord(substr($this->_mpegFrameHeader, 1, 1)) / 8 % 2) == 0)
					return 'MPEG-2 Audio Layer 3';
				else
					return 'MP3';
		}
	}
	
	/*
	 * returns the sample frequency in Hz
	 */
	function getSamplerate() {
		if (!$this->_parseFile())
			return 0;
		$mpeg1 = array(44100,48000,32000);
		$mpeg2 = array(22050,24000,16000);
		
		if ((ord(substr($this->_mpegFrameHeader,1,1))/8 % 2) == 0)
			return $mpeg2[(ord(substr($this->_mpegFrameHeader, 2, 1)) % 16) / 4];
		else
			return $mpeg1[(ord(substr($this->_mpegFrameHeader, 2, 1)) % 16) / 4];
	}
	
	/*
	 * returns the boolean MPEG flags [private,copyright,original]
	 */
	function getFlags() {
		if (!$this->_parseFile())
			return array(FALSE, FALSE, FALSE);
		return array(
				(bool)(ord(substr($this->_mpegFrameHeader, 2, 1)) % 2),
				(bool)((ord(substr($this->_mpegFrameHeader, -1, 1)) % 16) / 8),
				(bool)(ord((substr($this->_mpegFrameHeader, -1, 1) % 8) / 4)));
	}
	
	/*
	 * returns the emphasizing method
	 */
	function getEmphasis() {
		if (!$this->_parseFile())
			return '';
		$emphasis = array('-','50/15ms','','CCITT j.17');
		return $emphasis[ord(substr($this->_mpegFrameHeader, -1, 1)) % 4];
	}
	
	/*
	 * returns the size of the MPEG frames
	 */
	function getFrameSize() {
		if (!$this->_parseFile())
			return 0;
		return floor((144 * $this->getBitrate() * 1000 / $this->getSampleRate()) + intval($this->getPadding()));
	}
	
	/*
	 * returns TRUE if the MPEG frames contain CRCs, FALSE otherwise
	 */
	function framesProtected() {
		if (!$this->_parseFile())
			return FALSE;
		return (bool)((ord(substr($this->_mpegFrameHeader,1,1)) % 2) == 0);
	}
	
	/*
	 * returns the last error occured
	 */
	function getError() {
		return $this->_error;
	}
}

/*
 * returns the integer value of byte vector
 */
function vToInt($vector, $synchsafe = False, $signed = False) {
	$value = 0;
	$length = strlen($vector);
	
	if ($synchsafe) {
		# neglect the most significant bit of each byte (results in 7-bit bytes)
		for ($i = 0; $i < $length; $i++)
			$value = $value | (ord($vector[$i]) & 0x7F) << (($length - 1 - $i) * 7);
	} else {
		for ($i = 0; $i < $length; $i++)
			$value += ord($vector[$i]) * pow(256, ($length - 1 - $i));
	}
	
	if ($signed && !$synchsafe) {		# synchsafe values may not be signed
		if ($length == 4) {
			$bitmask = 0x80 << (8 * ($length - 1));
			if ($value & $bitmask)
				$value = 0 - ($value & ($bitmask - 1));
		}
	}
	
	return intval(floor($value));
}

?>
