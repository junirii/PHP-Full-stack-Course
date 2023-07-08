<?php
function delFile($path){
    
}

function getRandomFileNm($fileName){
    $ranFileName = gen_uuid_v4();
    $ext = getExt($fileName);
    return $ranFileName . "." . $ext;
}

function getExt($fileName){
    $arrFileName = explode(".", $fileName);
    return end($arrFileName);

    // return pathinfo($fileName, PATHINFO_EXTENSION);
    // return substr($fileName, strrpos($fileName, ".") + 1);
}

function gen_uuid_v4() { 
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x'
        , mt_rand(0, 0xffff)
        , mt_rand(0, 0xffff)
        , mt_rand(0, 0xffff)
        , mt_rand(0, 0x0fff) | 0x4000
        , mt_rand(0, 0x3fff) | 0x8000
        , mt_rand(0, 0xffff)
        , mt_rand(0, 0xffff)
        , mt_rand(0, 0xffff) 
    ); 
}

function LIB_removeAllData( $URL ) {
	if( is_dir( $URL ))	{
		if( $dh = opendir( $URL ) ) {
			while( ( $file = readdir( $dh ) ) !== false ) {
				if( $file == '.' || $file == ".." ) continue;
				if( filetype( $URL.$file ) == "dir" ) LIB_removeAllData( $URL.$file.'/' );
				else @unlink( $URL.$file ); // 파일 삭제

			}
			@rmdir( $URL ); // 폴더 삭제
			closedir( $dh );
		}
	}
}