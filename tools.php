<?php
////////////////////////////////////////////////////
function resize_image($file, $w, $h, $crop=FALSE) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return $dst;
	}
////////////////////////////////////////////////////
function imagecreatefrombmp($p_sFile) {
        //    Load the image into a string
        $file    =    fopen($p_sFile,"rb");
        $read    =    fread($file,10);
        while(!feof($file)&&($read<>""))
            $read    .=    fread($file,1024);
       
        $temp    =    unpack("H*",$read);
        $hex    =    $temp[1];
        $header    =    substr($hex,0,108);
       
        //    Process the header
        //    Structure: http://www.fastgraph.com/help/bmp_header_format.html
        if (substr($header,0,4)=="424d") {
            //    Cut it in parts of 2 bytes
            $header_parts    =    str_split($header,2);
           
            //    Get the width        4 bytes
            $width            =    hexdec($header_parts[19].$header_parts[18]);
           
            //    Get the height        4 bytes
            $height            =    hexdec($header_parts[23].$header_parts[22]);
           
            //    Unset the header params
            unset($header_parts);
        	}
       
        //    Define starting X and Y
        $x                =    0;
        $y                =    1;
       
        //    Create newimage
        $image            =    imagecreatetruecolor($width,$height);
       
        //    Grab the body from the image
        $body            =    substr($hex,108);

        //    Calculate if padding at the end-line is needed
        //    Divided by two to keep overview.
        //    1 byte = 2 HEX-chars
        $body_size        =    (strlen($body)/2);
        $header_size    =    ($width*$height);

        //    Use end-line padding? Only when needed
        $usePadding        =    ($body_size>($header_size*3)+4);
       
        //    Using a for-loop with index-calculation instaid of str_split to avoid large memory consumption
        //    Calculate the next DWORD-position in the body
        for ($i=0;$i<$body_size;$i+=3) {
            //    Calculate line-ending and padding
            if ($x>=$width) {
                //    If padding needed, ignore image-padding
                //    Shift i to the ending of the current 32-bit-block
                if ($usePadding) {
                	$i    +=    $width%4;
                	}
               
                //    Reset horizontal position
                $x    =    0;
               
                //    Raise the height-position (bottom-up)
                $y++;
               
                //    Reached the image-height? Break the for-loop
                if ($y>$height)
                    break;
            }
           
            //    Calculation of the RGB-pixel (defined as BGR in image-data)
            //    Define $i_pos as absolute position in the body
            $i_pos    =    $i*2;
            $r        =    hexdec($body[$i_pos+4].$body[$i_pos+5]);
            $g        =    hexdec($body[$i_pos+2].$body[$i_pos+3]);
            $b        =    hexdec($body[$i_pos].$body[$i_pos+1]);
           
            //    Calculate and draw the pixel
            $color    =    imagecolorallocate($image,$r,$g,$b);
            imagesetpixel($image,$x,$height-$y,$color);
           
            //    Raise the horizontal position
            $x++;
        }
       
        //    Unset the body / free the memory
        unset($body);
       
        //    Return image-object
        return $image;
   	}
////////////////////////////////////////////////////

function generateuid() {
	$lenght = 100;
	if (function_exists("random_bytes")) {
     	$bytes = random_bytes(ceil($lenght / 2));
   	} elseif (function_exists("openssl_random_pseudo_bytes")) {
     	$bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
   	} else {
     	throw new Exception("no cryptographically secure random function available");
   	}
  	return substr(bin2hex($bytes), 0, $lenght);
	}
////////////////////////////////////////////////////
function numberToRomanRepresentation($number) {
    $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
    $returnValue = '';
    while ($number > 0) {
        foreach ($map as $roman => $int) {
            if($number >= $int) {
                $number -= $int;
                $returnValue .= $roman;
                break;
            }
        }
   	}
   return $returnValue;
	}
////////////////////////////////////////////////////
function correctimagepath($text, $courseid){
	return str_replace('![](', "![](media/assets/courses/{$courseid}/", $text);
	}
////////////////////////////////////////////////////
 function getRandomWeightedElement(array $weightedValues) {
	$rand = mt_rand(1, (int) array_sum($weightedValues));
	foreach ($weightedValues as $key => $value) {
		$rand -= $value;
     	if ($rand <= 0) {
     		return $key;
     		}
  		}
	}	
////////////////////////////////////////////////////
function my_simple_crypt( $string, $action = 'e' ) {
	//source: https://nazmulahsan.me/simple-two-way-function-encrypt-decrypt-string/
	// you may change these values to your own
	$secret_key = 'my_simple_secret_key';
	$secret_iv = 'my_simple_secret_iv';
	$output = false;
	$encrypt_method = "AES-256-CBC";
	$key = hash( 'sha256', $secret_key );
	$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
	if( $action == 'e' ) {
		$output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
		} else if( $action == 'd' ){
		$output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
		}
	return $output;
	}
////////////////////////////////////////////////////
function audiobutton($source, $id = '', $autoplay = true) {
	return "<div id=\"playbtn\"><button id=\"play_btn{$id}\" onclick=\"playPause{$id}();return false;\">▶️</button><audio id=\"listenlagu{$id}\"><source src=\"data:audio/mp3;base64," . base64_encode( $source )."\"></audio></div><script>initAudioPlayer{$id}();
function initAudioPlayer{$id}(){
var audio = new Audio();
var aContainer = document.getElementById('listenlagu{$id}');
audio.src = aContainer.querySelectorAll('source')[0].getAttribute('src');
audio.load();
audio.loop = false;
" . ($autoplay?'audio.play();':'') . "

var playbtn = document.getElementById(\"play_btn{$id}\");

  playbtn.addEventListener(\"click\", playPause{$id}(audio, playbtn));
}

function playPause{$id}(audio, playbtn){
    return function () {
       if(audio.paused){
         audio.play();
       } else {
         audio.pause();
       } 
    }
}</script>";
	}
////////////////////////////////////////////////////
function itemimage($source) {
	return "<img style=\"max-width:500px;\" src='data:image/png;base64," . base64_encode($source) . "' />";
	}
////////////////////////////////////////////////////
////////////////////////////////////////////////////
////////////////////////////////////////////////////
////////////////////////////////////////////////////
////////////////////////////////////////////////////
////////////////////////////////////////////////////
////////////////////////////////////////////////////
////////////////////////////////////////////////////