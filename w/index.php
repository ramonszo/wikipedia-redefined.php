<?php
	//load the config
	include('../configuration.php');
		
	//load the language
	include($wikiConfig['server-path'].'languages/'.$wikiConfig['language'].'.php');
	
	//load the libs
	include($wikiConfig['server-path'].'includes/cache.inc.php');
	include($wikiConfig['server-path'].'includes/functions.inc.php');

	//some variables
	$scheme = (($wikiConfig['use-https']==true)?'https':'http').'://';
	
	$articleLang = ((isset($_GET['lang']))?$_GET['lang']:$wikiConfig['language']);
	$article = $articleLang.':'.urlencode(strip_tags($_GET['q'])); //langcode:urlencoded_article_name
	$articlePieces = explode(':',$article); //explode the article hash into pieces
	$articleCache = 'wikipedia-'.$article; //create a unique cache key
	$articleEURL = $articlePieces[1]; //escaped title of article
	$articleURL = urldecode($articleEURL); //title of article in the wikipedia format
	
	$lang_json = file_get_contents($wikiConfig['server-path'].'includes/langs.json');
	$languages_association = json_decode($lang_json, true); //load the languages association because the wikipedia api only returns the language code
	$wikipedia_site_url = $scheme.$articlePieces[0].'.wikipedia.org'; //store wikipedia url in a variable
	
	$pageURL = ($wikiConfig['rewrite-urls']==true)?$scheme.$wikiConfig['site-url'].'wiki/'.$articleURL:$scheme.$wikiConfig['site-url'].'w/?q='.urlencode($articleURL); //this page url
	
	if($wikiConfig['rewrite-urls']==true){
		if(strpos($_SERVER['REQUEST_URI'],'w/')!==false){
			$language_url = (isset($_GET['lang']))?'?lang='.preg_replace("/[^a-zA-Z0-9 \-\_\.]+/",'',$_GET['lang']):'';
			
			header('location: '.$pageURL.$language_url);
			exit();
		}
	}
	
	$fullarticle = array('title'=>'','redirects'=>'','html'=>'','langs'=>''); //just to avoid errors
	$wikiURLs = array(
			'parsed'=>$wikipedia_site_url.'/w/api.php?format=json&action=parse&page='.$articleEURL.'&prop=text%7Clanglinks%7Cimages%7Cdisplaytitle&redirects=1', //full article parsed into html
			'revisions'=>$wikipedia_site_url.'/w/api.php?action=query&prop=revisions&titles='.$articleEURL.'&rvprop=content&format=json&rvsection=0', //full article in wikipedia code
			'extracts'=>$wikipedia_site_url.'/w/api.php?action=query&prop=extracts&titles='.$articleEURL.'&format=json&exintro=1' //the first paragraph of the article
	);
	
	//do I need to explain?
	if($wikiConfig['use-javascript-api']!=true){
		$cache = new WikiCache(); //init the cache system
		$cache->setFolder($wikiConfig['cache-path']); //set the folder
		$fullarticle = $cache->read($articleCache); //load the cache
		
		if (!$fullarticle) { //if cache doesn't exists, get the article by the Wikipedia API
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $wikiURLs['parsed']); //load the "parsed" url which contains the full article
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
			
			$wiki_contents = curl_exec($ch);
			curl_close($ch);
			$wiki_json = json_decode($wiki_contents, true); //decode the file we get from wikipedia
			
			if(isset($wiki_json['error'])){
				//redirects to wikipedia if errors (I include this to fix the "file:" links)
				redirectToWikipedia();
			}
			
			$fullarticle = array(
						'title'=>$wiki_json['parse']['title'],
						'redirects'=>$wiki_json['parse']['redirects'],
						'html'=>$wiki_json['parse']['text']['*'],
						'langs'=>$wiki_json['parse']['langlinks']
					); //create a new array with the contents
		
			$cache->save($articleCache, $fullarticle, '1 month'); //save to cache
		}
		
		if($fullarticle['title']==''){
			redirectToWikipedia();
		}
	}
?>
<!DOCTYPE html>
<html lang="mul" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<!--
		
		   The original design and all ideas come from Wikipedia Redefined (http://wikipediaredefined.com) by NEW! agency (http://newisnew.lt/en).  
		   I (Ramon) only do the code.
		   
		   Enjoy!
		
		-->
		
		<title><?php echo ($fullarticle['title']=='')?_WIKI_LOADING:htmlspecialchars($fullarticle['title']).' – '._WIKI_MAIN_TITLE; ?></title>
	
		<meta name="viewport" content="width=device-width">	   
		<link rel="shortcut icon" href="//<?php echo $wikiConfig['site-url']; ?>favicon.ico">
		<link rel="copyright" href="//creativecommons.org/licenses/by-sa/3.0/">
		<link rel="copyright" href="//www.gnu.org/copyleft/fdl.html">
		<link rel="license" href="//creativecommons.org/licenses/by-sa/3.0/">
		<link rel="license" href="//www.gnu.org/copyleft/fdl.html">
		<meta name="language" content="Many">
	
		<link rel="canonical" href="<?php echo $pageURL; ?>" />

		<link rel="stylesheet" href="//<?php echo $wikiConfig['site-url']; ?>css/reset.css">
		<link rel="stylesheet" href="//<?php echo $wikiConfig['site-url']; ?>css/formatting.css">
		<link rel="stylesheet" href="//<?php echo $wikiConfig['site-url']; ?>css/article.css">

		<!-- pass some vars to javascript api -->
		<script>
			var lang_names = <?php echo toOneLine($lang_json); ?>;
			
			var use_jsapi = <?php echo ($wikiConfig['use-javascript-api']==true)?1:0; ?>,
			api_url = "<?php echo $wikiURLs['parsed']; ?>&callback=createArticle",
			error_msg = "<?php echo htmlspecialchars(_WIKI_ERROR); ?>",
			article_url = "<?php echo $wikipedia_site_url.'/wiki/'.$articleURL; ?>",
			canonical_url = "<?php echo $pageURL; ?>",
			scheme = "<?php echo $scheme; ?>",
			wikiLang = "<?php echo $articleLang; ?>",
			wikiSub = "<?php echo _WIKI_MAIN_TITLE; ?>";
		</script>
		<script src="//<?php echo $wikiConfig['site-url']; ?>javascripts/utils.js"></script>
		<script src="//<?php echo $wikiConfig['site-url']; ?>javascripts/jquery.js"></script>
		<script src="//<?php echo $wikiConfig['site-url']; ?>javascripts/article.js"></script>
		
		<base href="<?php echo $scheme.$wikiConfig['site-url']; ?>">
		
		<?php if($wikiConfig['show-social-buttons']==true){ ?>
		<!-- social buttons -->
		<script type="text/javascript" src="http://jumpr-social-widgets.googlecode.com/files/jumpWidgets.js?load=buttons" ></script>
		<?php } ?>
	</head>
	<body class="mediawiki ltr sitedir-ltr ns-0 ns-subject skin-vector action-view vector-animateLayout">
		<?php echo aboutBox(); ?>

		<div id="wrapper">
			<?php
				if($wikiConfig['show-social-buttons']==true){
					echo '<div class="jump-share-icons" id="jumpr-share-float"><a target="_blank" href="http://jumpr.me/?redir=share&ref=widget-text&url='.urlencode($pageURL).'&msg=" data-url="'.$pageURL.'" data-msg="" data-remove="" data-fb="" data-sitename="Wikipedia" data-count="true" data-gplus-count="true" data-grey-style="false" data-layout="box" data-tooltip="bottom"></a></div>';
				}
			?>
				
			<nav id="main-bar">
				<div id="main-bar-wrapper">
					<div class="fleft">
						<?php echo '<a href="'.$wikipedia_site_url.'/wiki/Portal:Contents">'._WIKI_CONTENTS.'</a>'.
							   '<a href="'.$wikipedia_site_url.'/wiki/Portal:Featured_content">'._WIKI_FEATURED_CONTENT.'</a>'.
							   '<a href="'.$wikipedia_site_url.'/wiki/Portal:Current_events">'._WIKI_CURRENT_EVENTS.'</a>'.
							   '<a href="'.$wikipedia_site_url.'/wiki/Special:Random">'._WIKI_RANDOM_ARTICLE.'</a>'.
							   '<a href="//donate.wikimedia.org/wiki/Special:FundraiserRedirector?utm_source=donate&amp;utm_medium=sidebar&amp;utm_campaign=20120717SB001&amp;uselang=en">'._WIKI_DONATE.'</a>'.
							   '<a href="'.$wikipedia_site_url.'/wiki/Wikipedia:About">'._WIKI_ABOUT.'</a>'.
							   '<a href="'.$wikipedia_site_url.'/wiki/Help:Contents">'._WIKI_HELP.'</a>';
						?>
	
					</div>
					
					<div class="fright">
						<select name="langs" id="langs" class="big-input" onchange="selectLanguage(this);">
							<option>Select article language</option>
							<?php
								//use this function only if article is loaded via php
								if($wikiConfig['use-javascript-api']!=true){
									foreach($fullarticle['langs'] as $language){
										//load the languages from article and get the language name from the $languages_association array
										
										$langcode = $language['lang'];
										echo '
							<option value="'.$langcode.'" title="'.$language['url'].'">'.$languages_association[$langcode].'</option>';
									}
								}
							?>
							
						</select>
					</div>
				</div>
			</nav>
			<nav id="sub-bar">
				<div id="sub-bar-wrapper">
					<div class="fleft">	
						<a class="selected"><?php echo _WIKI_RESEARCH; ?></a>
						<a href="<?php echo $wikipedia_site_url.'/w/index.php?title='.$articleEURL.'&action=edit'; ?>"><?php echo _WIKI_EDIT; ?></a>
						<a href="<?php echo $wikipedia_site_url.'/wiki/Talk:'.$articleURL; ?>"><?php echo _WIKI_TALK; ?></a>
					</div>
					
					<a id="login" class="fright" href="<?php echo $wikipedia_site_url.'/w/index.php?title=Special:UserLogin&returnto='.$articleEURL; ?>"><?php echo _WIKI_LOGIN; ?></a>
				</div>
			</nav>
	
			<div id="content-wrapper">
				<header id="head">
					<div id="logo" class="fleft"><a href="//<?php echo $wikiConfig['site-url']; ?>"><img src="//<?php echo $wikiConfig['site-url']; ?>images/logo-notext-small.png" alt="Wikipedia Logo" title="Wikipedia" width="128" height="105"></a></div>
					<div id="head-tasks" class="fleft">
						<a href="<?php echo $wikipedia_site_url.'/w/index.php?title='.$articleEURL.'&amp;action=history'; ?>">
							<span><img src="//<?php echo $wikiConfig['site-url']; ?>images/icons/history.png"></span>
							<?php echo _WIKI_HISTORY; ?>
						</a>
						<a href="<?php echo $wikipedia_site_url.'/wiki/Special:WhatLinksHere/'.$articleURL; ?>">
							<span><img src="//<?php echo $wikiConfig['site-url']; ?>images/icons/quote.png"></span>
							<?php echo _WIKI_QUOTE; ?>
						</a>
						<a class="separator" href="<?php echo $wikipedia_site_url.'/wiki/Special:RecentChangesLinked/'.$articleURL; ?>">
							<span><img src="//<?php echo $wikiConfig['site-url']; ?>images/icons/connect.png"></span>
							<?php echo _WIKI_CONNECT; ?>
						</a>
						<a class="separator" id="share-button">
							<span><img src="//<?php echo $wikiConfig['site-url']; ?>images/icons/share.png"></span>
							<?php echo _WIKI_SHARE; ?>
						</a>
						<a class="separator" href="<?php echo $wikipedia_site_url.'/w/index.php?title='.$articleEURL.'&amp;printable=yes'; ?>">
							<span><img src="//<?php echo $wikiConfig['site-url']; ?>images/icons/print.png"></span>
							<?php echo _WIKI_PRINT; ?>
						</a>
					</div>
					<div id="search" class="fright">
						<form action="//<?php echo $wikiConfig['site-url']; ?>w/index.php" onsubmit="return false;">   
							<input id="q" name="q" class="big-input" size="30" value="<?php echo _WIKI_SEARCH; ?>" rel="<?php echo _WIKI_SEARCH; ?>" onfocus="jsPlaceholder(this);" onblur="jsPlaceholder(this);" autocomplete="off">
							<ul id="wikiResults"></ul>
						</form>
					</div>
				</header>
				
				<div id="fx-fix"></div>
				
				<div id="tasks">
					<nav id="tasks-wrapper">
						<a href="<?php echo $wikipedia_site_url.'/wiki/Wikipedia:Your_first_article'; ?>"><?php echo _WIKI_ADDARTICLE; ?><span>+</span></a>
						<a href="<?php echo $wikipedia_site_url.'/wiki/Special:ArticleFeedbackv5/'.$articleURL; ?>"><?php echo _WIKI_FEEDBACKS; ?></a>
						<a href="<?php echo $wikipedia_site_url.'/w/index.php?title=Special:Book&amp;bookcmd=render_article&amp;arttitle='.$articleEURL; ?>"><?php echo _WIKI_EXPORT; ?></a>
						<a href="<?php echo $wikipedia_site_url.'/w/index.php?title='.$articleEURL.'&action=watch'; ?>"><?php echo _WIKI_SAVE; ?></a>
						<a class="close">&times;</a>
					</nav>
				</div>

				<?php
					//display the article
					echo '
					<section id="full-article">
						<h1 id="firstHeading" class="firstHeading"><span dir="auto">'.(($fullarticle['title']=='')?_WIKI_LOADING:$fullarticle['title']).'</span></h1>
						<div id="bodyContent">
							<div id="siteSub">'._WIKI_FROM.' '._WIKI_MAIN_TITLE.'</div>
							<div id="contentSub"></div>
							<div id="main-wikipedia-article">
								'.parseWikiArticle($fullarticle['html']).'
							</div>
						</div>
					</section>';
				?>
			</div>
			
			<footer id="wiki-sites">
				<div>
					<a href="//www.wiktionary.org/" target="_blank"><img src="//<?php echo $wikiConfig['site-url']; ?>images/wikis/tionary.png" alt="Wiktionary" height="52" width="73" /></a>
					<a href="//www.wikinews.org/" target="_blank"><img src="//<?php echo $wikiConfig['site-url']; ?>images/wikis/news.png" alt="Wikinews" height="52" width="73" /></a>
					<a href="//www.wikiquote.org/" target="_blank"><img src="//<?php echo $wikiConfig['site-url']; ?>images/wikis/quote.png" alt="Wikiquote" height="52" width="73" /></a>
				  
					<a href="//www.wikibooks.org/" target="_blank"><img src="//<?php echo $wikiConfig['site-url']; ?>images/wikis/books.png" alt="Wikibooks" height="52" width="73" /></a>
					<a href="//species.wikimedia.org/" target="_blank"><img src="//<?php echo $wikiConfig['site-url']; ?>images/wikis/species.png" alt="Wikispecies" height="52" width="73" /></a>
					<a href="//www.wikisource.org/" target="_blank"><img src="//<?php echo $wikiConfig['site-url']; ?>images/wikis/source.png" alt="Wikisource" height="52" width="73" /></a>
				  
					<a href="//www.wikiversity.org/" target="_blank"><img src="//<?php echo $wikiConfig['site-url']; ?>images/wikis/versity.png" alt="Wikiversity" height="52" width="73" /></a>
					<a href="//commons.wikimedia.org/" target="_blank"><img src="//<?php echo $wikiConfig['site-url']; ?>images/wikis/commons.png" alt="Wikicommons" height="52" width="73" /></a>
					<a href="//meta.wikimedia.org/" target="_blank"><img src="//<?php echo $wikiConfig['site-url']; ?>images/wikis/meta.png" alt="MetaWiki" height="52" width="73" /></a>
					
					<span id="colspan"></span>
				</div>
			</footer>
		</div>
		
		<div id="copyrights-etc">
			<div class="fleft">
				<?php echo _WIKI_CC1; ?><br>
				<?php echo _WIKI_CC2; ?>
				<br><br>

				<a href="//en.wikipedia.org/wiki/Wikipedia:Contact_us"><?php echo _WIKI_CONTACTUS; ?></a>
				<a href="//wikimediafoundation.org/wiki/Privacy_policy" title="wikimedia:Privacy policy"><?php echo _WIKI_PRIVACYPOLICY; ?></a>
				<a href="//en.wikipedia.org/wiki/Wikipedia:About" title="Wikipedia:About"><?php echo _WIKI_ABOUTWIKIPEDIA; ?></a>
				<a href="//en.wikipedia.org/wiki/Wikipedia:General_disclaimer" title="Wikipedia:General disclaimer"><?php echo _WIKI_DISCLAMEIRS; ?></a>
				<a href="//<?php echo $articleLang; ?>.m.wikipedia.org/w/index.php?title=<?php echo $articleEURL;?>&amp;mobileaction=toggle_view_mobile" class="noprint"><?php echo _WIKI_MOBILEVIEW; ?></a>
			</div>
			<div class="fright">
				<a href="//www.mediawiki.org/"><img src="//<?php echo $wikiConfig['site-url']; ?>images/wmedia-logo.png" alt="<?php echo _WIKI_AWIKIMEDIAPROJECT; ?>" title="<?php echo _WIKI_AWIKIMEDIAPROJECT; ?>"></a>
			</div>
		</div>
		
		<?php echo googleAnalytics(); ?>
		
	</body>
</html>