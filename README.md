Wikipedia Redefined
===
A different way to read wiki articles.

> **Note:**
>
> The original design and all ideas came from Wikipedia Redefined
> (http://wikipediaredefined.com) by NEW! agency (http://newisnew.lt/en).


### Installation
To install this, just copy to a directory and edit the configuration.php

For now, this code is just the redesigned home page of Wikipedia.org and the
article page. If you can, please contribute by adding more functionalities.


### File structure
```
 cache/                      cache files if you use php to parse articles

 css/
    article.css              stylesheet for the article page
    formatting.css           stylesheet for the parsed article
    home.css                 stylesheet for home page
    reset.css                css reset & basic classnames

 images/
    icons/
    wikis/                   logos of the other wikis (quote, books, etc)

 includes/
    cache.inc.php            cache functions
    functions.inc.php        main functions
    langs.json               list of Wikipedias in their native language
    langs_english.json       list of Wikipedias in english

 javascripts/
    article.js               article page functions
    home.js                  home page functions
    jquery.js                jquery library
    jquery.tiptip.js         custom tooltips library
    utils.js                 basic functions
    
 languages/
    en.php                   the main language of the article page
                             (read the article page source to learn how to
                                             translate into your language)
                                                                    
 server.conf/
    htaccess.txt             htaccess rules if you use Apache Server
    nginx.conf               nginx rules if you use Nginx server
    
 w/                          use w/ because is the same structure of Wikipedia
    index.php                the article page
    
 configuration.php           script config (please edit this)
 index.php                   home page
 
```

### License
Some code of this program have their own license, please see the notes in their
respective source-code.

The main code (php files, some js, css) is free software; you can redistribute
it and/or modify it under the terms of the GNU General Public License as
published by the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
