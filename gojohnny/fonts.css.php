<?php
/*
Panglossa go!Johnny PHP library
version 8.0
release 2017-07-05
Please see the readme.txt file that goes with this source.
Licensed under the GPL, please see:
http://www.gnu.org/licenses/gpl-3.0-standalone.html
panglossa@yahoo.com.br
Araçatuba - SP - Brazil - 2017
*/
header("Content-type: text/css");
//require_once('gojonny.php');
error_reporting(E_ERROR);
if (isset($_REQUEST['path'])){
	$path = $_REQUEST['path'];
	}else{
	$serverpath = 'http://' . $_SERVER['HTTP_HOST'];
	$path = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));
	$path = $serverpath . DIRECTORY_SEPARATOR . $path[count($path)-1] . DIRECTORY_SEPARATOR . 'fonts';
	}
/*
$ttfinfoclasspath = GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'ttfinfoplus' . DIRECTORY_SEPARATOR . 'ttfInfo.class.php';
if(file_exists($ttfinfoclasspath)){
	$css = '';
	require_once($ttfinfoclasspath);
	$ttfInfo = new ttfInfo;
    // Set the Font resource
    $ttfInfo->setFontsDir(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'fonts' . DIRECTORY_SEPARATOR);
    $ttfInfo->readFontsDir(); 
	foreach($ttfInfo->array AS $key => $var){
		$name = '';
		if (strpos(substr($key), '.otf')!==false){
			$format = " format('opentype')";
			}else{
			$format = '';
			}
		foreach ($var AS $row => $data){
			if (isset($row[4])){
				$name = trim($row[4]);
				}else if (isset($row[1])){
				$name = trim($row[1]);
				}else if (isset($row[6])){
				$name = trim($row[6]);
				}
			
			if ($name==''){
				$name = explode(DIRECTORY_SEPARATOR, $key);
				$name = $name[count($name)-1];
				}
			}
		$fname = $path . '/' . basename($key);
		$css .= "@font-face {\n	font-family: {$name}\n	src: url({$fname}){$format};\n	}\n\n";
		}
	}else{
*/	
$css = "@font-face {
	font-family: Graublau Sans Web;
	src: url({$path}/GraublauWeb.otf) format('opentype');
	}

@font-face {
	font-family: 'Diavlo';
	font-style: normal;
	font-weight: normal;
	src: local('Diavlo'), url('{$path}/Diavlo_MEDIUM_II_37.otf') format('opentype');
	}

@font-face {
	font-family: Vollkorn;
	src: url({$path}/Vollkorn-Regular.ttf);
	}

@font-face {
	font-family: Delicious;
	src: url({$path}/Delicious-Roman.otf) format('opentype');
	}

@font-face {
	font-family: Fontin Sans;
	src: url({$path}/Fontin_Sans_R_45b.otf) format('opentype');
	}

@font-face {
	font-family: Fontin;
	src: url({$path}/Fontin-Regular.otf) format('opentype');
	}

@font-face {
	font-family: Tallys;
	src: url({$path}/Tallys_15.otf) format('opentype');
	}

@font-face {
	font-family: Tlaymyts;
	src: url({$path}/tlaymyts.ttf);
	}

@font-face {
	font-family: Papyrus;
	src: url({$path}/PAPYRUS.TTF);
	}

@font-face {
	font-family: Doulos;
	src: url({$path}/DoulosSILR.ttf);
	}

@font-face {
	font-family: Book Antiqua;
	src: url({$path}/BookAntiqua.ttf);
	}
";
//	}
echo $css;