<?php
/*
Panglossa go!Johnny PHP library
version 7.0
release 2017-07-05
Please see the readme.txt file that goes with this source.
Licensed under the GPL, please see:
http://www.gnu.org/licenses/gpl-3.0-standalone.html
panglossa@yahoo.com.br
Araçatuba - SP - Brazil - 2017
*/
class TMeta extends TElement {
	var $charset = GJ_CHARSET;//see end of this file
	var $items = array(
		'http-equiv' => array(),
		'name' => array()
		);
	////////////////////////////////////////////////
	function __construct(){
		foreach(array(
				'keywords' => array(),
				'description' => '',
				'subject' => '',
				'copyright' => '',
				'language' => 'en',
				'robots' => array('index', 'follow'),
				'revised' => '',
				'abstract' => '',
				'topic' => '',
				'summary' => '',
				'Classification' => '',
				'author' => '',
				'designer' => '',
				'copyright' => '',
				'reply-to' => '',
				'owner' => '',
				'url' => '',
				'identifier-URL' => '',
				'directory' => '',
				'category' => '',
				'coverage' => 'Worldwide',
				'distribution' => 'Global',
				'rating' => 'General',
				'revisit-after' => '',
			) as $key => $val){
			$this->items['name'][$key] = $val;
			$this->$key = &$this->items['name'][$key];
			}
		foreach(array(
				'Content-Type' => 'text/html; charset=__CHARSET__', //instead of the short declaration, in order to pass validators
				'Expires' => '0',
				'Pragma' => 'no-cache',
				'Cache-Control' => 'no-cache'
			) as $key => $val){
			$this->items['http-equiv'][$key] = $val;
			$this->$key = &$this->items['http-equiv'][$key];
			}
		if (GJ_OPENGRAPH_METATAGS){
			foreach(array(
					'og:title' => '',
					'og:type' => '',
					'og:url' => '',
					'og:image' => '',
					'og:site_name' => '',
					'og:description' => '',
					'fb:page_id' => '',
					'og:email' => '',
					'og:phone_number' => '',
					'og:fax_number' => '',
					'og:latitude' => '',
					'og:longitude' => '',
					'og:street-address' => '',
					'og:locality' => '',
					'og:region' => '',
					'og:postal-code' => '',
					'og:country-name' => ''
					) as $key => $val){
				$this->items['name'][$key] = $val;
				$this->$key = &$this->items['name'][$key];
				}
			foreach(array(
					'og:type' => '',
					'og:points' => '',
					'og:video' => '',
					'og:video:height' => '',
					'og:video:width' => '',
					'og:video:type' => '',
					'og:audio' => '',
					'og:audio:title' => '',
					'og:audio:artist' => '',
					'og:audio:album' => '',
					'og:audio:type' => ''			
					) as $key => $val){
				$this->items['property'][$key] = $val;
				$this->$key = &$this->items['name'][$key];
				}
			}
		}
	////////////////////////////////////////////////
	function add($key = '', $val = '', $type = null){
		if($type==null){
			$type = $this->correcttype($key);
			}
		if(($key!='')&&($val!='')){
			if($type==''){
				$type = 'name';
				}
			$this->items[$type][$key] = $val;
			$this->$key = &$this->items[$type][$key];
			}
		}
	////////////////////////////////////////////////
	function show(){
		$res = "<!-- starting page meta section -->\n";
		foreach($this->items as $type => $typeitems){
			foreach($typeitems as $key => $val){
				if (is_array($val)){
					$val = implode(',', $val);
					}
				if ($val!=''){
					if (strtolower($key)=='content-type'){
						$val = str_replace('__CHARSET__', $this->charset, $val);
						}
					$res .= "<meta {$type}=\"{$key}\" content=\"{$val}\">\n";
					}
				}
			}
		return $res . "<!-- finishing page meta section -->\n";
		}
	////////////////////////////////////////////////
	function correcttype($id){
		$id = trim(strtolower($id));
		$res = 'name';
		foreach($this->items as $type => $typeitems){
			foreach($typeitems as $key => $val){
				if ($id==trim(strtolower($key))){
					$res = $type;
					}
				}
			}
		return $res;
		}
	////////////////////////////////////////////////
	////////////////////////////////////////////////
	////////////////////////////////////////////////
	////////////////////////////////////////////////
	////////////////////////////////////////////////
	}
/*
Possible values for charset:

(Source: http://webtools.live2support.com/misc_htmlcharset.php)

big5: Chinese Traditional (Big5)
euc-kr: Korean (EUC)
iso-8859-1: Western Alphabet
iso-8859-2: Central European Alphabet (ISO)
iso-8859-3: Latin 3 Alphabet (ISO)
iso-8859-4: Baltic Alphabet (ISO)
iso-8859-5: Cyrillic Alphabet (ISO)
iso-8859-6: Arabic Alphabet (ISO)
iso-8859-7: Greek Alphabet (ISO)
iso-8859-8: Hebrew Alphabet (ISO)
koi8-r: Cyrillic Alphabet (KOI8-R)
shift-jis: Japanese (Shift-JIS)
x-euc: Japanese (EUC)
utf-8: Universal Alphabet (UTF-8)
windows-1250: Central European Alphabet (Windows)
windows-1251: Cyrillic Alphabet (Windows)
windows-1252: Western Alphabet (Windows)
windows-1253: Greek Alphabet (Windows)
windows-1254: Turkish Alphabet      
windows-1255: Hebrew Alphabet (Windows)
windows-1256: Arabic Alphabet (Windows)
windows-1257: Baltic Alphabet (Windows)
windows-1258: Vietnamese Alphabet (Windows)
windows-874: Thai (Windows)
ASMO-708: Arabic (ASMO 708) 
DOS-720: Arabic (DOS) 
iso-8859-6: Arabic (ISO) 
x-mac-arabic: Arabic (Mac) 
windows-1256: Arabic (Windows) 
ibm775: Baltic (DOS) 
iso-8859-4: Baltic (ISO) 
windows-1257: Baltic (Windows) 
ibm852: Central European (DOS) 
iso-8859-2: Central European (ISO) 
x-mac-ce: Central European (Mac) 
windows-1250: Central European (Windows) 
EUC-CN: Chinese Simplified (EUC) 
gb2312: Chinese Simplified (GB2312) 
hz-gb-2312: Chinese Simplified (HZ) 
x-mac-chinesesimp: Chinese Simplified (Mac) 
big5: Chinese Traditional (Big5) 
x-Chinese-CNS: Chinese Traditional (CNS) 
x-Chinese-Eten: Chinese Traditional (Eten) 
x-mac-chinesetrad: Chinese Traditional (Mac) 
950: Chinese Traditional (Mac) 
cp866: Cyrillic (DOS) 
iso-8859-5: Cyrillic (ISO) 
koi8-r: Cyrillic (KOI8-R) 
koi8-u: Cyrillic (KOI8-U) 
x-mac-cyrillic: Cyrillic (Mac) 
windows-1251: Cyrillic (Windows) 
x-Europa: Europa 
x-IA5-German: German (IA5) 
ibm737: Greek (DOS) 
iso-8859-7: Greek (ISO) 
x-mac-greek: Greek (Mac) 
windows-1253: Greek (Windows) 
ibm869: Greek, Modern (DOS) 
DOS-862: Hebrew (DOS) 
iso-8859-8-i: Hebrew (ISO-Logical) 
iso-8859-8: Hebrew (ISO-Visual) 
x-mac-hebrew: Hebrew (Mac) 
windows-1255: Hebrew (Windows) 
x-EBCDIC-Arabic: IBM EBCDIC (Arabic) 
x-EBCDIC-CyrillicRussian: IBM EBCDIC (Cyrillic Russian) 
x-EBCDIC-CyrillicSerbianBulgarian: IBM EBCDIC (Cyrillic Serbian-Bulgarian) 
x-EBCDIC-DenmarkNorway: IBM EBCDIC (Denmark-Norway) 
x-ebcdic-denmarknorway-euro: IBM EBCDIC (Denmark-Norway-Euro) 
x-EBCDIC-FinlandSweden: IBM EBCDIC (Finland-Sweden) 
x-ebcdic-finlandsweden-euro: IBM EBCDIC (Finland-Sweden-Euro) 
x-ebcdic-finlandsweden-euro: IBM EBCDIC (Finland-Sweden-Euro) 
x-ebcdic-france-euro: IBM EBCDIC (France-Euro) 
x-EBCDIC-Germany: IBM EBCDIC (Germany) 
x-ebcdic-germany-euro: IBM EBCDIC (Germany-Euro) 
x-EBCDIC-GreekModern: IBM EBCDIC (Greek Modern) 
x-EBCDIC-Greek: IBM EBCDIC (Greek) 
x-EBCDIC-Hebrew: IBM EBCDIC (Hebrew) 
x-EBCDIC-Icelandic: IBM EBCDIC (Icelandic) 
x-ebcdic-icelandic-euro: IBM EBCDIC (Icelandic-Euro) 
x-ebcdic-international-euro: IBM EBCDIC (International-Euro) 
x-EBCDIC-Italy: IBM EBCDIC (Italy) 
x-ebcdic-italy-euro: IBM EBCDIC (Italy-Euro) 
x-EBCDIC-JapaneseAndKana: IBM EBCDIC (Japanese and Japanese Kaakana) 
x-EBCDIC-JapaneseAndJapaneseLatin: IBM EBCDIC (Japanese and Japanese-Latin) 
x-EBCDIC-JapaneseAndUSCanada: IBM EBCDIC (Japanese and US-Canada) 
x-EBCDIC-JapaneseKatakana: IBM EBCDIC (Japanese katakana) 
x-EBCDIC-KoreanAndKoreanExtended: IBM EBCDIC (Korean and Korean Extended) 
x-EBCDIC-KoreanExtended: IBM EBCDIC (Korean Extended) 
CP870: IBM EBCDIC (Multilingual Latin-2) 
x-EBCDIC-SimplifiedChinese: IBM EBCDIC (Simplified Chinese) 
X-EBCDIC-Spain: IBM EBCDIC (Spain) 
x-ebcdic-spain-euro: IBM EBCDIC (Spain-Euro) 
x-EBCDIC-Thai: IBM EBCDIC (Thai) 
x-EBCDIC-TraditionalChinese: IBM EBCDIC (Traditional Chinese) 
CP1026: IBM EBCDIC (Turkish Latin-5) 
x-EBCDIC-Turkish: IBM EBCDIC (Turkish) 
x-EBCDIC-UK: IBM EBCDIC (UK) 
x-ebcdic-uk-euro: IBM EBCDIC (UK-Euro) 
ebcdic-cp-us: IBM EBCDIC (US-Canada) 
x-ebcdic-cp-us-euro: IBM EBCDIC (US-Canada-Euro) 
ibm861: Icelandic (DOS) 
x-mac-icelandic: Icelandic (Mac) 
x-iscii-as: ISCII Assamese 
x-iscii-be: ISCII Bengali 
x-iscii-de: ISCII Devanagari 
x-iscii-gu: ISCII Gujarathi 
x-iscii-ka: ISCII Kannada 
x-iscii-ma: ISCII Malayalam 
x-iscii-or: ISCII Oriya 
x-iscii-pa: ISCII Panjabi 
x-iscii-ta: ISCII Tamil 
x-iscii-te: ISCII Telugu 
euc-jp : Japanese (EUC) 
x-euc-jp: Japanese (EUC) 
iso-2022-jp: Japanese (JIS) 
iso-2022-jp: Japanese (JIS-Allow 1 byte Kana - SO/SI) 
csISO2022JP: Japanese (JIS-Allow 1 byte Kana) 
x-mac-japanese: Japanese (Mac) 
shift_jis: Japanese (Shift-JIS) 
ks_c_5601-1987: Korean 
euc-kr: Korean (EUC) 
iso-2022-kr: Korean (ISO) 
Johab: Korean (Johab) 
x-mac-korean: Korean (Mac) 
iso-8859-3: Latin 3 (ISO) 
iso-8859-15: Latin 9 (ISO) 
x-IA5-Norwegian: Norwegian (IA5) 
IBM437: OEM United States 
x-IA5-Swedish: Swedish (IA5) 
windows-874: Thai (Windows) 
ibm857: Turkish (DOS) 
iso-8859-9: Turkish (ISO) 
x-mac-turkish: Turkish (Mac) 
windows-1254: Turkish (Windows) 
unicode: Unicode 
unicodeFFFE: Unicode (Big-Endian) 
utf-7: Unicode (UTF-7) 
utf-8: Unicode (UTF-8) 
us-ascii: US-ASCII 
windows-1258: Vietnamese (Windows) 
ibm850: Western European (DOS) 
x-IA5: Western European (IA5) 
iso-8859-1: Western European (ISO) 
macintosh: Western European (Mac) 
Windows-1252 : Western European (Windows) 
*/
?>