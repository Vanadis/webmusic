<?php
    require_once ('config.php');
    require_once ('lib/id3.php');
    
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
        $id3=array(); 
        for($i=0;$i<count($files)-1;$i++){
            $id3[]=read_id3($files[$i]); 
        }
        return array_slice(array_filter($id3,function($v){return isset($v['filename']);}),0);
    }

?>
