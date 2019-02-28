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
jQuery.expr[':'].containsIgnoreCase = function(e,i,m){
    return jQuery(e).text().toUpperCase().indexOf(m[3].toUpperCase())>=0;
	};

function ajax(anarea, aurl, img){
	//alert(aurl);
	if (img == null) {
		img = "media/wait.gif";
		}
	jQuery("#" + anarea).html('<div align="center"><img src="' + img + '"></div>');//copy this file to where it is accessible for your application
	jQuery("#" + anarea).load(aurl);
	//jQuery("#" + anarea + "_wait").attr("src", "");
	}
	
function modalajax(aurl){
	$('#modal_content').html('<img src="media/wait.gif" />');
	$('#modal').show();
	$('#modal_content').load(aurl);
	}
////////////////////////////////////////////////////////////////
function  hiddenajax(aurl){
	$('#modal_content').load(aurl);
	}
////////////////////////////////////////////////////////////////
document.onkeydown = function(evt) {
    evt = evt || window.event;
    if (evt.keyCode == 27) {
        $('#modal').hide();
        $('#modal_content').html('');
        $('#message').fadeOut(1500);
    	}
	};
////////////////////////////////////////////////////////////////
function hidemodal(){
	$('#modal').hide();
	}

function urlEncodeCharacter(c){
	return '%' + c.charCodeAt(0).toString(16);
	};

function urlDecodeCharacter(str, c){
	return String.fromCharCode(parseInt(c, 16));
	};

function urlEncode(s){
	return encodeURIComponent( s ).replace( /\%20/g, '+' ).replace( /[!'()*~]/g, urlEncodeCharacter );
	};

function urlDecode(s){
	return decodeURIComponent(s.replace( /\+/g, '%20' )).replace( /\%([0-9a-f]{2})/g, urlDecodeCharacter);
	};

function content(area, newval){
	et = jQuery(area).prop('nodeName').toLowerCase();
	if (
		(et=='div')
		||(et=='p')
		||(et=='span')
		) {
		return html(area, newval);
		}else{
		return val(area, newval);
		}
	}

function val(area, newval){
	if (newval!=null){
		jQuery(area).val(newval);
		}
	return jQuery(area).val();
	}

function html(area, newval){
	if (newval!=null){
		jQuery(area).html(newval);
		}
	return jQuery(area).html();
	}	

function include(filename){
	//source: http://forums.digitalpoint.com/showthread.php?t=146094
	var head = document.getElementsByTagName('head')[0];
	script = document.createElement('script');
	script.src = filename;
	script.type = 'text/javascript';
	
	head.appendChild(script)
	}

function harvest(){
	//return a string passing urlEncoded values of the specified fields as parameters
	s = '';
	for (var i = 0; i < arguments.length; i++) {
		if (s!=''){
			s = s + '&';
			}
		if (jQuery('#' + arguments[i]).is(':checkbox')){
			if(jQuery('#' + arguments[i]).attr('checked')){
				s = s + arguments[i] + '=' + jQuery('#' + arguments[i]).val();
				}else{
				s = s + arguments[i] + '=0';
				}
			
			}else if (jQuery('input[name=' + arguments[i] + ']').is(':radio')){
			s = s + arguments[i] + '=' + urlEncode(jQuery('input[name=' + arguments[i] + ']:checked').val());
			}else{
			s = s + arguments[i] + '=' + urlEncode(jQuery('#' + arguments[i]).val());
			}
		}	
	return s;
	}

function go(where){
	window.location = where;
	}

function submitform(formid, fields){
	jQuery('#' + formid).submit();
	url = jQuery('#' + formid).attr('action');
	s = '';
	if (fields==null){
		jQuery('#' + formid).find(':input').each(function(){
			if (s!=''){
				s = s + '&';
				}
			s = s + jQuery(this).attr('name') + '=' + urlEncode(jQuery(this).val());
			});
		}else{
		for (var i = 0; i < fields.length; i++) {
			if (s!=''){
				s = s + '&';
				}
			if (jQuery('#' + fields[i]).is(':checkbox')){
				if(jQuery('#' + fields[i]).attr('checked')){
					s = s + fields[i] + '=' + jQuery('#' + fields[i]).val();
					}else{
					s = s + fields[i] + '=0';
					}
				
				}else if (jQuery('input[name=' + fields[i] + ']').is(':radio')){
				s = s + fields[i] + '=' + urlEncode(jQuery('input[name=' + fields[i] + ']:checked').val());
				}else{
				s = s + fields[i] + '=' + urlEncode(jQuery('#' + fields[i]).val());
				}
			}
		}
	if(url.indexOf('?') === -1){
		url = url + '?';
		}
	go(url + s);
	}

