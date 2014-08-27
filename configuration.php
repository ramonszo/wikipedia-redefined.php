<?php
    $wikiConfig = array(
        'language'=>            'en',              //domain to get the articles from wikipedia. see the full list at libs/langs.json
                                                   //this work for the language of the site too. Currently, only the english language is available.
                                                   //you can translate to your language by editing a file called "<yourlanguagecode>.php" and using the english.php file as example.
                                                   //remember that the main wikipedia page is in english, so if you want to translate the home page, just translate directly in the index.php
        
        'use-javascript-api'=>  true,              //use javascript api to save server resources
        'server-path'=>         '',                //server directory which the script is installed
        'cache-path'=>          'cache/',          //server cache
        'site-url'=>            '',                //url without http or https
        'use-https'=>           false,             //use secure protocol
        'rewrite-urls'=>        true,              //rewrite urls to /wiki/Article Name
        'show-about-panel'=>    true,              //show about panel
        'show-social-buttons'=> true,              //show social buttons on article/about panel
        'google-analytics'=>    ''                 //your google analytics code
    );
?>