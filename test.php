<?php
function expand_options($s){
	$res = array();
	$res[] = '';
	$tmp = array();
	$orlines = explode("\n", $s);
	foreach ($orlines as $line){
		$line = trim($line);
		if ($line!=''){
			if ((strpos($line, '[')!==false)&&(strpos($line, '|')!==false)&&(strpos($line, ']')!==false)){
				$pos1 = strpos($line, '[');
				$pos2 = strpos($line, '|');
				$pos3 = strpos($line, ']');
				while (($pos1!==false)&&($pos2!==false)&&($pos3!==false)) {
					$part1 = substr($line, 0, $pos1);
					$options = explode('|', substr($line, $pos1 + 1, $pos3-$pos1-1));
					$line = substr($line, $pos3 + 1);

					$pos1 = strpos($line, '[');
					$pos2 = strpos($line, '|');
					$pos3 = strpos($line, ']');
					$tmp = array();
					if (count($res)==0){
						$res[] = $part1;
						}else{
						foreach($res as $item){
							foreach($options as $option){
								$tmp[] = "{$item}{$part1}{$option}";
								}
							}
						}
					$res = $tmp;
					}
				$tmp = array();
				if (count($res)==0){
					$tmp[] = $line;
					}else{
					foreach($res as $item){
						$tmp[] = "{$item}{$line}";
						}
					}
				$res = $tmp;
				}else{
				$res[] = $line;
				}
			} 
		}
	return $res;
	}

print_r(expand_options("[He|She] [does|is] not [work|working] [at|] home."));

?>