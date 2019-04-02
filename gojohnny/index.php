<?php
require_once('options.php');
require_once(GJ_PATH_LOCAL . '/gojohnny.php');
$page = new THtml();
$page->addtext('
# Test
## Test
### Test
#### Test
##### Test
###### Test
Hello!!!

You can add text with [**markdown**](https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet) notation.

1. this
2. is
3. a
4. test

* this 
* is
* another
* test

This is a *table*:

| Tables        | Are           | Cool  |
| ------------- |:-------------:| -----:|
| col 3 is      | right-aligned | $1600 |
| col 2 is      | centered      |   $12 |
| zebra stripes | are neat      |    $1 |

And an image: ![](media/g!j_256.jpg)
');
$page->render();
?>

