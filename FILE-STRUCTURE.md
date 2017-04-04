Wikipedia Redefined
===

File structure:
---

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