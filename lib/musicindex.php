<?php
    require_once ('config.php');
    require_once ('lib/id3.php');
    require_once ('lib/constants.php');
    
    function getDirListRecursive($directory) {
		$array_items = array();
		if ($handle = opendir($directory)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					if (is_dir($directory. "/" . $file)) {
						$array_items = array_merge($array_items, getDirListRecursive($directory. "/" . $file));
					}
                    $file = $directory . '/' . $file;
                    if(!is_dir($file)){
					    $array_items[] = $file;
                    }
				}
			}
			closedir($handle);
		}
		return $array_items;
	}
    function getAllMp3s(){
        $files=getDirListRecursive(MUSIC_DIR);
        $id3=getId3s($files);
        return array_slice(array_filter($id3,function($v){return isset($v['filename']) && !empty($v['filename']);}),0);
    }
    function getId3s($files){
		$id3=new ID3('');
		$info=array();
		for($i=0;$i<count($files)-1;$i++){
			$id3->setFilename($files[$i]);
            $obj=array();
            $obj[ID3_ARTIST]=stripBinaryShit($id3->getArtist());
            $obj[ID3_TITLE]=stripBinaryShit($id3->getTitle());
            $obj[ID3_ALBUM]=stripBinaryShit($id3->getAlbum());
            $obj[FILENAME]=$files[$i];
            $info[]=$obj;
        }
        return $info;
	}
	
	function stripBinaryShit($string){
		return preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $string);
	}

?>
