////////////////////////////////////////////////////////////////////////
$(document).ready(function(){ 
var tx = document.getElementsByTagName('textarea');
//alert(tx.length);
for (var i = 0; i < tx.length; i++) {
  tx[i].setAttribute('style', 'height:' + (tx[i].scrollHeight) + 'px;overflow-y:hidden;');
  tx[i].addEventListener("input", OnInput, false);
	}

function OnInput() {
  this.style.height = 'auto';
  this.style.height = (this.scrollHeight) + 'px';
	}
})
////////////////////////////////////////////////////////////////////////
var refreshTime = 300000; // every 5 minutes in milliseconds
window.setInterval( function() {
    $.ajax({
        cache: false,
        type: "GET",
        url: "index.php?keepsession=1",
        success: function(data) {
        }
    });
}, refreshTime );
////////////////////////////////////////////////////////////////////////
function setnewquestiontype(atype){
	jQuery('#newquestionlabelopen').hide();
	jQuery('#newquestionlabelyesno').hide();
	jQuery('#newquestionlabeltranslate').hide();
	
	jQuery('#newanswer1labelopen').hide();
	jQuery('#newanswer1labelyesno').hide();
	jQuery('#newanswer1labeltranslate').hide();
	
	jQuery('#newanswer2labelopen').hide();
	jQuery('#newanswer2labelyesno').hide();
	jQuery('#newanswer2labeltranslate').hide();
	
	jQuery('#newquestionlabel' + atype).show();
	jQuery('#newanswer1label' + atype).show();
	jQuery('#newanswer2label' + atype).show();
	if (atype=='translate'){
		jQuery('#newquestionanswer2').hide();
		}else{
		jQuery('#newquestionanswer2').show();
		}
	}
////////////////////////////////////////////////////////////////////////
function batch_add_question() {
	jQuery('#txt_batch').val(jQuery('#txt_batch').val() + '\n\nquestion=\nanswer1=\nanswer2=\ninfo=\n');
	var tx = document.getElementsByTagName('textarea');
	for (var i = 0; i < tx.length; i++) {
  		tx[i].setAttribute('style', 'height:' + (tx[i].scrollHeight) + 'px;overflow-y:hidden;');
  		tx[i].addEventListener("input", OnInput, false);
		}
	function OnInput() {
  		this.style.height = 'auto';
  		this.style.height = (this.scrollHeight) + 'px';
		}
	jQuery('#txt_batch').focus();
	}
////////////////////////////////////////////////////////////////////////
function add_char(achar, targetid){
	var cursorPosStart = $(targetid).prop('selectionStart');
	var cursorPosEnd = $(targetid).prop('selectionEnd');
	var v = $(targetid).val();
	var textBefore = v.substring(0,  cursorPosStart );
	var textAfter  = v.substring( cursorPosEnd, v.length );
	$(targetid).val( textBefore+ achar +textAfter );
	$(targetid).focus();
	}
////////////////////////////////////////////////////////////////////////
function loadlevel(i){
	window.location = 'index.php?c=courses/level/' + i;
	}
////////////////////////////////////////////////////////////////////////
function viewcourse(courseid){
	window.location = 'index.php?c=courses/view/' + courseid;
	}
////////////////////////////////////////////////////////////////////////
function showcorrectanswer(){
	jQuery('#correctanswer').show();
	jQuery('#frm_translation').hide();
	jQuery('#showcorrectanswer').hide();
	}
////////////////////////////////////////////////////////////////////////
// chronometer / stopwatch JS script - coursesweb.net

// Here set the minutes, seconds, and tenths-of-second when you want the chronometer to stop
// If all these values are set to 0, the chronometer not stop automatically

function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
		} else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
	}
////////////////////////////////////////////////////////////////////////
function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
	return null;
	}
////////////////////////////////////////////////////////////////////////
function eraseCookie(name) {
	createCookie(name,"",-1);
	}
////////////////////////////////////////////////////////////////////////
var stmints = 0;
var stseconds = 0;
var stzecsec = 0;

// function to be executed when the chronometer stops
function toAutoStop() {
  //alert('Your life goes on');
	}
////////////////////////////////////////////////////////////////////////
var dateFormat = function () {
	var	token = /d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZ]|"[^"]*"|'[^']*'/g,
		timezone = /\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,
		timezoneClip = /[^-+\dA-Z]/g,
		pad = function (val, len) {
			val = String(val);
			len = len || 2;
			while (val.length < len) val = "0" + val;
			return val;
		};

	// Regexes and supporting functions are cached through closure
	return function (date, mask, utc) {
		var dF = dateFormat;

		// You can't provide utc if you skip other args (use the "UTC:" mask prefix)
		if (arguments.length == 1 && Object.prototype.toString.call(date) == "[object String]" && !/\d/.test(date)) {
			mask = date;
			date = undefined;
		}

		// Passing date through Date applies Date.parse, if necessary
		date = date ? new Date(date) : new Date;
		if (isNaN(date)) throw SyntaxError("invalid date");

		mask = String(dF.masks[mask] || mask || dF.masks["default"]);

		// Allow setting the utc argument via the mask
		if (mask.slice(0, 4) == "UTC:") {
			mask = mask.slice(4);
			utc = true;
		}

		var	_ = utc ? "getUTC" : "get",
			d = date[_ + "Date"](),
			D = date[_ + "Day"](),
			m = date[_ + "Month"](),
			y = date[_ + "FullYear"](),
			H = date[_ + "Hours"](),
			M = date[_ + "Minutes"](),
			s = date[_ + "Seconds"](),
			L = date[_ + "Milliseconds"](),
			o = utc ? 0 : date.getTimezoneOffset(),
			flags = {
				d:    d,
				dd:   pad(d),
				ddd:  dF.i18n.dayNames[D],
				dddd: dF.i18n.dayNames[D + 7],
				m:    m + 1,
				mm:   pad(m + 1),
				mmm:  dF.i18n.monthNames[m],
				mmmm: dF.i18n.monthNames[m + 12],
				yy:   String(y).slice(2),
				yyyy: y,
				h:    H % 12 || 12,
				hh:   pad(H % 12 || 12),
				H:    H,
				HH:   pad(H),
				M:    M,
				MM:   pad(M),
				s:    s,
				ss:   pad(s),
				l:    pad(L, 3),
				L:    pad(L > 99 ? Math.round(L / 10) : L),
				t:    H < 12 ? "a"  : "p",
				tt:   H < 12 ? "am" : "pm",
				T:    H < 12 ? "A"  : "P",
				TT:   H < 12 ? "AM" : "PM",
				Z:    utc ? "UTC" : (String(date).match(timezone) || [""]).pop().replace(timezoneClip, ""),
				o:    (o > 0 ? "-" : "+") + pad(Math.floor(Math.abs(o) / 60) * 100 + Math.abs(o) % 60, 4),
				S:    ["th", "st", "nd", "rd"][d % 10 > 3 ? 0 : (d % 100 - d % 10 != 10) * d % 10]
			};

		return mask.replace(token, function ($0) {
			return $0 in flags ? flags[$0] : $0.slice(1, $0.length - 1);
		});
	};
}();
////////////////////////////////////////////////////////////////////////
// Some common format strings
dateFormat.masks = {
	"default":      "ddd mmm dd yyyy HH:MM:ss",
	shortDate:      "m/d/yy",
	mediumDate:     "mmm d, yyyy",
	longDate:       "mmmm d, yyyy",
	fullDate:       "dddd, mmmm d, yyyy",
	shortTime:      "h:MM TT",
	mediumTime:     "h:MM:ss TT",
	longTime:       "h:MM:ss TT Z",
	isoDate:        "yyyy-mm-dd",
	isoTime:        "HH:MM:ss",
	isoDateTime:    "yyyy-mm-dd'T'HH:MM:ss",
	isoUtcDateTime: "UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"
};
////////////////////////////////////////////////////////////////////////
// Internationalization strings
dateFormat.i18n = {
	dayNames: [
		"Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat",
		"Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
	],
	monthNames: [
		"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
		"January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
	]
};
////////////////////////////////////////////////////////////////////////
// For convenience...
Date.prototype.format = function (mask, utc) {
	return dateFormat(this, mask, utc);
	};
// the initial tenths-of-second, seconds, and minutes
var zecsec = 0;
var seconds = 0;
var mints = 0;

var startchron = 0;

function chronometer() {
  if(startchron == 1) {
    zecsec += 1;       // set tenths of a second

    // set seconds
    if(zecsec > 9) {
      zecsec = 0;
      seconds += 1;
    }

    // set minutes
    if(seconds > 59) {
      seconds = 0;
      mints += 1;
    }

    // adds data in #showtm
    if (seconds<10) {
    	sseconds = '0' + seconds;
    	}else{
    	sseconds = seconds;
    	}
    if (zecsec<10) {
    	szecsec = '0' + zecsec;
    	}else{
    	szecsec = zecsec;
    	}	
    document.getElementById('showtm').innerHTML = mints+ ':'+ sseconds+ ':'+ szecsec;

    // if the chronometer reaches to the values for stop, calls whenChrStop(), else, auto-calls chronometer()
    if(zecsec == stzecsec && seconds == stseconds && mints == stmints) toAutoStop();
    else setTimeout("chronometer()", 100);
  }
}
////////////////////////////////////////////////////////////////////////
function restorechron() {
	if (readCookie('chronometer_running')=='1') {
		//alert('Chronometer is running!');
		var starteddatetime = new Date(readCookie('chronometer_started_datetime'));
		var now = new Date();
		var currentdatetime = new Date(now.format("m/d/yyyy HH:MM:ss"));
		var timeDiff = Math.abs(currentdatetime.getTime() - starteddatetime.getTime());
		var diffSecs = Math.ceil(timeDiff / 1000);
		//alert (diffSecs);
		zecsec = 0;
		
		if (diffSecs>59) {
			mints = Math.floor(diffSecs / 60);
			seconds = diffSecs - (mints * 60);
			}else{
			seconds = diffSecs;
			mints = 0;
			}
		$('#btnStart').hide();
		$('#btnStop').show();
		//$('#btnReset').show(); 
		startchron = 1; 
		chronometer(); 
		}
	}
////////////////////////////////////////////////////////////////////////
function startChr() {
	zecsec = 0;
	seconds = 0;
	mints = 0;
	var currentdatetime = new Date();
	//alert(now.format("y"));
	createCookie('chronometer_running', 1, 7);
	createCookie('chronometer_started_datetime', currentdatetime.format("m/d/yyyy HH:MM:ss"), 7);
	createCookie('chronometer_started_year', currentdatetime.format("yyyy"), 7);
	createCookie('chronometer_started_month', currentdatetime.format("mm"), 7);
	createCookie('chronometer_started_day', currentdatetime.format("dd"), 7);
	createCookie('chronometer_started_hour', currentdatetime.format("HH"), 7);
	createCookie('chronometer_started_minute', currentdatetime.format("MM"), 7);
	createCookie('chronometer_started_second', currentdatetime.format("ss"), 7);
	
	$('#btnStart').hide();
	$('#btnStop').show();
	//$('#btnReset').show(); 
	startchron = 1; 
	chronometer(); 
	}      // starts the chronometer
////////////////////////////////////////////////////////////////////////
function stopChr() {
	eraseCookie('chronometer_running');
	eraseCookie('chronometer_started_datetime');
	eraseCookie('chronometer_started_year');
	eraseCookie('chronometer_started_month');
	eraseCookie('chronometer_started_day');
	eraseCookie('chronometer_started_hour');
	eraseCookie('chronometer_started_minute');
	eraseCookie('chronometer_started_second');
	$('#btnStart').show();
	$('#btnStop').hide();
	//$('#btnReset').show(); 
	 
	startchron = 0; 
	}                      // stops the chronometer
////////////////////////////////////////////////////////////////////////
function resetChr() {
  zecsec = 0;  seconds = 0; mints = 0; startchron = 0; 
    if (seconds<10) {
    	sseconds = '0' + seconds;
    	}else{
    	sseconds = seconds;
    	}
    if (zecsec<10) {
    	szecsec = '0' + zecsec;
    	}else{
    	szecsec = zecsec;
    	}	
  document.getElementById('showtm').innerHTML = mints+ ':'+ sseconds+ ':'+ szecsec;
	eraseCookie('chronometer_running');
	eraseCookie('chronometer_started_datetime');
	eraseCookie('chronometer_started_year');
	eraseCookie('chronometer_started_month');
	eraseCookie('chronometer_started_day');
	eraseCookie('chronometer_started_hour');
	eraseCookie('chronometer_started_minute');
	eraseCookie('chronometer_started_second');
}
////////////////////////////////////////////////////////////////////////
// start the chronometer, delete this line if you want to not automatically start the stopwatch
