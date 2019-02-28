
**Panglossa go!Johnny PHP Library**

version 8.0

release 2017-07-05

Author: Sérgio Domingues (known aliases: panglossa, QVASIMODO, Darth Andur)

panglossa@yahoo.com.br

Licensed under the GPL, please see:

http://www.gnu.org/licenses/gpl-3.0-standalone.html

Araçatuba - SP - Brazil - 2017







# What is it?

The go!Johnny library is a set of classes built with the purpose of automating the generation of html code in your projects. This approach allows you to write only php code, without bothering to mix up html (except in special cases). Each HTML5 tag has its own class. Besides, there are some special classes for html pages, databases, configuration and more. As an example, instead of writing the whole HTML markup for a page, you can do just this:

----------------------------------------

```
TPage(
	'Here goes the page title', 
	'Here you add any content you want the page to include.', 
	'mypage.ico'
	)->render();
```

----------------------------------------

and the whole html5 markup, from <!DOCTYPE html><html ... to ... /html>, will be generated for you.

However, the classes are highly flexible, so there are many ways in which you can create a page. You can, for example, instantiate a `TPage` class object, then change its properties (like js files and css stylesheets to include, page title, page icon), add content to it, then, when everything is in place, render it to the client browser. Ex.:

----------------------------------------

```
$page = TPage();
$page->css[] = 'mystyle.css';
$page->js[] = 'myscript.js';
$page->icon = 'myicon.ico';
$page->title = 'Testing';
$page->add(
	TH1('Hello!') .
	TDiv('This is some text inside a div.')
	);
$page->render();
```

----------------------------------------

Each element can also be handled in a similar manner. Ex.:

----------------------------------------

```
$panel = new TDiv();
$panel->add('Some text');
$panel->properties['id'] = 'panel1';
$panel->properties['onclick'] = "alert('you clicked me');";
$panel->properties['style']['background-color'] = 'silver';
$page->add($panel);
```

----------------------------------------

There are shortcuts for almost everything. Ex., the code above can be rewritten as:

----------------------------------------

```
$panel = TDiv('Some text');
$panel->setID('panel1');
$panel->p('onclick', "alert('you clicked me');");
$panel->style('background-color', 'silver');
$page->add($panel);
```
----------------------------------------

and even as a one-liner:

----------------------------------------

```
$page->add(o(array('id' => 'panel1', 'onclick' => "alert('you clicked me');", 'style' => 'background-color:silver'), TDiv('Some text')));
```

----------------------------------------

where the function `o()` stands for "object instantiation".

The idea this library is that the classes should adapt to the user's preferences, not the opposite.



# What it is not

This is not a framework. At least not as what is commonly understood by the word 'framework'. It can be used in a similar manner, after you get used to working with it. But I see it as it was designed to be: a set of usefull classes.



# The Latest Version

You can always get the latest version at GitHub:

https://github.com/panglossa/gojohnny




# Documentation

The documentation is still being written. Full tutorials, including videos, are planned. However, as for now, the only documentation is this README file you are looking at.




# Installation & Use

These classes have been tested with the latest versions of apache and php (version 5.0 required), both on Linux (Debian) and Windows (Seven) machines. You have to unzip the package contents to a folder in your server that your php scripts have access to. Then, in your scripts, you set some options in the global variable $gj_options and include the main `<classes.php>` file. Ex.:

----------------------------------------

```
global $gj_options = array(
	'LOCALPATH' => '/usr/share/gojohnny',
	'WEBPATH' => 'http://myserveraddress/gojohnny'
	);
require_once("{$gj_options['LOCALPATH']}/gojohnny.php");
```

----------------------------------------


Obs.:
1. `$gj_options['LOCALPATH']` is an internal path, used by php; it must contain the path to where you placed the library files (viz. the classes.php file), in a format understood by your server's local filesystem.
1. `$gj_options['WEBPATH']` is an external path, used by javascript and css; it must refer to the same path, but in the format of a url, i.e., a format that a client browser can understand. This one is not necessary if you use full urls when referring to javascripts or css files.

The classes make use of third-party libraries, when available. These have to be placed in the <lib> subfolder. The blueprint css framework and the jQuery library are included by default, both in the release package and in the page's js and css references. The latest versions of these libraries can be found at: 

http://www.blueprintcss.org/

and

http://jquery.com/



# Licensing

http://creativecommons.org/licenses/by-sa/3.0/deed.en_GB
You can use any of the files in this release as you want. If you use re-publish any portion of this project in any medium or if you use it in a project of your own, please be sure to credit the original author or at least include a link to the project's main page (https://sourceforge.net/projects/gojohnny/).
