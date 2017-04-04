<?php
      //ini_set('display_errors',1);
      //load the config
      include('configuration.php');
         
      //load the libs
      include($wikiConfig['server-path'].'includes/cache.inc.php');
      include($wikiConfig['server-path'].'includes/functions.inc.php');
        
      //load the language
      include($wikiConfig['server-path'].'languages/'.$wikiConfig['language'].'.php');
        
      $scheme = (($wikiConfig['use-https']==true)?'https':'http').'://';
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
   
            <title>Wikipedia</title>
            <meta name="description" content="Wikipedia, the free encyclopedia that anyone can edit.">
            <meta name="author" content="Ramon Souza">
            <meta name="viewport" content="width=device-width">
               
            <link rel="shortcut icon" href="favicon.ico">
            <link rel="copyright" href="//creativecommons.org/licenses/by-sa/3.0/">
            <link rel="copyright" href="//www.gnu.org/copyleft/fdl.html">
            <link rel="license" href="//creativecommons.org/licenses/by-sa/3.0/">
            <link rel="license" href="//www.gnu.org/copyleft/fdl.html">
            <meta name="language" content="Many">
   
            <link rel="stylesheet" href="//<?php echo $wikiConfig['site-url']; ?>css/reset.css?v=3">
            <link rel="stylesheet" href="//<?php echo $wikiConfig['site-url']; ?>css/home.css?v=3">
   
            <script>wikiLang="<?php echo $wikiConfig['language']; ?>";</script>
            <script src="//<?php echo $wikiConfig['site-url']; ?>javascripts/utils.js?v=4"></script>
            <script src="//<?php echo $wikiConfig['site-url']; ?>javascripts/jquery.js?v=3"></script>
            <script src="//<?php echo $wikiConfig['site-url']; ?>javascripts/jquery.tiptip.js?v=3"></script>
            <script src="//<?php echo $wikiConfig['site-url']; ?>javascripts/home.js?v=3"></script>
            
            <base href="<?php echo $scheme.$wikiConfig['site-url']; ?>">
   </head>
   <body onresize="adjustBody();">
      <nav id="languages">
         <a id="pt" title="Português — 742 000+ artigos" href="//pt.wikipedia.org"></a>
         <a id="it" title="Italiano — 939 000+ voci" href="//it.wikipedia.org"></a>
         <a id="ru" title="Русский — 875 000+ статей" href="//ru.wikipedia.org"></a>
         <a id="en" title="English — 4 000 000+ articles" href="//en.wikipedia.org"></a>
         <a id="zh" title="中文 — 500 000+ 條目" href="//zh.wikipedia.org"></a>
         <a id="pl" title="Polski — 908 000+ haseł" href="//pl.wikipedia.org"></a>
         <a id="de" title="Deutsch — 1 430 000+ Artikel" href="//de.wikipedia.org"></a>
         <a id="fr" title="Français — 1 270 000+ articles" href="//fr.wikipedia.org"></a>
         <a id="es" title="Español — 900 000+ artículos" href="//es.wikipedia.org"></a>
         <a id="other" title="" href="#other" onclick="return false;"></a>
      </nav>
      
      <div id="wrapper">
         <header id="other-languages">
            <div id="list-lang">
               <div id="articles-100">
                  More than 100,000 articles:
                  
                  <div class="wiki-list">
                     <a href="//ar.wikipedia.org/" lang="ar" title="Al-ʿArabīyah"><span dir="rtl">العربية</span></a>&nbsp;•
                     <a href="//bg.wikipedia.org/" lang="bg" title="Bulgarski">Български</a>&nbsp;•
                     <a href="//ca.wikipedia.org/" lang="ca">Català</a>&nbsp;•
                     <a href="//cs.wikipedia.org/" lang="cs">Česky</a>&nbsp;•
                     <a href="//da.wikipedia.org/" lang="da">Dansk</a>&nbsp;•
                     <a href="//de.wikipedia.org/" lang="de">Deutsch</a>&nbsp;•
                     <a href="//en.wikipedia.org/" lang="en">English</a>&nbsp;•
                     <a href="//es.wikipedia.org/" lang="es">Español</a>&nbsp;•
                     <a href="//eo.wikipedia.org/" lang="eo">Esperanto</a>&nbsp;•
                     <a href="//eu.wikipedia.org/" lang="eu">Euskara</a>&nbsp;•
                     <a href="//fa.wikipedia.org/" lang="fa" title="Fārsi"><span dir="rtl">فارسی</span></a>&nbsp;•
                     <a href="//fr.wikipedia.org/" lang="fr">Français</a>&nbsp;•
                     <a href="//ko.wikipedia.org/" lang="ko" title="Hangugeo">한국어</a>&nbsp;•
                     <a href="//hi.wikipedia.org/" lang="hi" title="Hindī">हिन्दी</a>&nbsp;•
                     <a href="//hr.wikipedia.org/" lang="hr">Hrvatski</a>&nbsp;•
                     <a href="//id.wikipedia.org/" lang="id">Bahasa Indonesia</a>&nbsp;•
                     <a href="//it.wikipedia.org/" lang="it">Italiano</a>&nbsp;•
                     <a href="//he.wikipedia.org/" lang="he" title="‘Ivrit"><span dir="rtl">עברית</span></a>&nbsp;•
                     <a href="//lt.wikipedia.org/" lang="lt">Lietuvių</a>&nbsp;•
                     <a href="//hu.wikipedia.org/" lang="hu">Magyar</a>&nbsp;•
                     <a href="//ms.wikipedia.org/" lang="ms">Bahasa Melayu</a>&nbsp;•
                     <a href="//nl.wikipedia.org/" lang="nl">Nederlands</a>&nbsp;•
                     <a href="//ja.wikipedia.org/" lang="ja" title="Nihongo">日本語</a>&nbsp;•
                     <a href="//no.wikipedia.org/" lang="nb">Norsk (bokmål)</a>&nbsp;•
                     <a href="//pl.wikipedia.org/" lang="pl">Polski</a>&nbsp;•
                     <a href="//pt.wikipedia.org/" lang="pt">Português</a>&nbsp;•
                     <a href="//kk.wikipedia.org/" lang="kk"><span lang="kk-Cyrl">Қазақша</span> / <span lang="kk-Latn">Qazaqşa</span> / <span lang="kk-Arab" dir="rtl">قازاقشا</span></a>&nbsp;•
                     <a href="//ro.wikipedia.org/" lang="ro">Română</a>&nbsp;•
                     <a href="//ru.wikipedia.org/" lang="ru" title="Russkiy">Русский</a>&nbsp;•
                     <a href="//sk.wikipedia.org/" lang="sk">Slovenčina</a>&nbsp;•
                     <a href="//sl.wikipedia.org/" lang="sl">Slovenščina</a>&nbsp;•
                     <a href="//sr.wikipedia.org/" lang="sr"><span lang="sr-Cyrl">Српски</span> / <span lang="sr-Latn">Srpski</span></a>&nbsp;•
                     <a href="//fi.wikipedia.org/" lang="fi">Suomi</a>&nbsp;•
                     <a href="//sv.wikipedia.org/" lang="sv">Svenska</a>&nbsp;•
                     <a href="//tr.wikipedia.org/" lang="tr">Türkçe</a>&nbsp;•
                     <a href="//uk.wikipedia.org/" lang="uk" title="Ukrayins’ka">Українська</a>&nbsp;•
                     <a href="//vi.wikipedia.org/" lang="vi">Tiếng Việt</a>&nbsp;•
                     <a href="//vo.wikipedia.org/" lang="vo">Volapük</a>&nbsp;•
                     <a href="//war.wikipedia.org/" lang="war">Winaray</a>&nbsp;•
                     <a id="zh_wiki" href="//zh.wikipedia.org/" lang="zh" title="Zhōngwén">中文</a>
                  </div>
               </div>
               <div id="articles-10">
                  More than 10,000 articles:
              
                  <div class="wiki-list">    
                     <a href="//af.wikipedia.org/" lang="af">Afrikaans</a>&nbsp;•
                     <a href="//als.wikipedia.org/" lang="gsw">Alemannisch</a>&nbsp;•
                     <a href="//am.wikipedia.org/" lang="am" title="Āmariññā">አማርኛ</a>&nbsp;•
                     <a href="//an.wikipedia.org/" lang="an">Aragonés</a>&nbsp;•
                     <a href="//roa-rup.wikipedia.org/" lang="rup">Armãneashce</a>&nbsp;•
                     <a href="//ast.wikipedia.org/" lang="ast">Asturianu</a>&nbsp;•
                     <a href="//ht.wikipedia.org/" lang="ht">Kreyòl Ayisyen</a>&nbsp;•
                     <a href="//az.wikipedia.org/" lang="az"><span lang="az-Latn">Azərbaycan</span> / <span lang="az-Arab" dir="rtl">آذربايجان ديلی</span></a>&nbsp;•
                     <a href="//bn.wikipedia.org/" lang="bn" title="Bangla">বাংলা</a>&nbsp;•
                     <a href="//map-bms.wikipedia.org/" lang="map-x-bms">Basa Banyumasan</a>&nbsp;•
                     <a href="//ba.wikipedia.org/" lang="ba" title="Başqortsa">Башҡортса</a>&nbsp;•
                     <span lang="be" title="Belaruskaya">Беларуская (<a href="//be.wikipedia.org/" title="Akademichnaya">Акадэмічная</a>&nbsp;•&nbsp;<a href="//be-x-old.wikipedia.org/" title="Taraškievica">Тарашкевiца</a>)</span>&nbsp;•
                     <a href="//bpy.wikipedia.org/" lang="bpy" title="Bishnupriya Manipuri">বিষ্ণুপ্রিযা় মণিপুরী</a>&nbsp;•
                     <a href="//bs.wikipedia.org/" lang="bs">Bosanski</a>&nbsp;•
                     <a href="//br.wikipedia.org/" lang="br">Brezhoneg</a>&nbsp;•
                     <a href="//cv.wikipedia.org/" lang="cv" title="Čăvašla">Чӑвашла</a>&nbsp;•
                     <a href="//cy.wikipedia.org/" lang="cy">Cymraeg</a>&nbsp;•
                     <a href="//et.wikipedia.org/" lang="et">Eesti</a>&nbsp;•
                     <a href="//el.wikipedia.org/" lang="el" title="Ellīniká">Ελληνικά</a>&nbsp;•
                     <a href="//fy.wikipedia.org/" lang="fy">Frysk</a>&nbsp;•
                     <a href="//ga.wikipedia.org/" lang="ga">Gaeilge</a>&nbsp;•
                     <a href="//gl.wikipedia.org/" lang="gl">Galego</a>&nbsp;•
                     <a href="//gu.wikipedia.org/" lang="gu" title="Gujarati">ગુજરાતી</a>&nbsp;•
                     <a href="//hy.wikipedia.org/" lang="hy" title="Hayeren">Հայերեն</a>&nbsp;•
                     <a href="//io.wikipedia.org/" lang="io">Ido</a>&nbsp;•
                     <a href="//ia.wikipedia.org/" lang="ia">Interlingua</a>&nbsp;•
                     <a href="//is.wikipedia.org/" lang="is">Íslenska</a>&nbsp;•
                     <a href="//jv.wikipedia.org/" lang="jv">Basa Jawa</a>&nbsp;•
                     <a href="//kn.wikipedia.org/" lang="kn" title="Kannada">ಕನ್ನಡ</a>&nbsp;•
                     <a href="//ka.wikipedia.org/" lang="ka" title="Kartuli">ქართული</a>&nbsp;•
                     <a href="//ku.wikipedia.org/" lang="ku"><span lang="ku-Latn">Kurdî</span> / <span lang="ku-Arab" dir="rtl">كوردی</span></a>&nbsp;•
                     <a href="//la.wikipedia.org/" lang="la">Latina</a>&nbsp;•
                     <a href="//lv.wikipedia.org/" lang="lv">Latviešu</a>&nbsp;•
                     <a href="//lb.wikipedia.org/" lang="lb">Lëtzebuergesch</a>&nbsp;•
                     <a href="//lmo.wikipedia.org/" lang="lmo">Lumbaart</a>&nbsp;•
                     <a href="//mk.wikipedia.org/" lang="mk" title="Makedonski">Македонски</a>&nbsp;•
                     <a href="//mg.wikipedia.org/" lang="mg">Malagasy</a>&nbsp;•
                     <a href="//ml.wikipedia.org/" lang="ml" title="Malayalam">മലയാളം</a>&nbsp;•
                     <a href="//mr.wikipedia.org/" lang="mr" title="Marathi">मराठी</a>&nbsp;•
                     <a href="//my.wikipedia.org/" lang="my" title="Myanmarsar">မြန်မာဘာသာ</a>&nbsp;•
                     <a href="//new.wikipedia.org/" lang="new" title="Nepal Bhasa">नेपाल भाषा</a>&nbsp;•
                     <a href="//ne.wikipedia.org/" lang="ne" title="Nepālī">नेपाली</a>&nbsp;•
                     <a href="//nn.wikipedia.org/" lang="nn">Norsk (nynorsk)</a>&nbsp;•
                     <a href="//nap.wikipedia.org/" lang="nap">Nnapulitano</a>&nbsp;•
                     <a href="//oc.wikipedia.org/" lang="oc">Occitan</a>&nbsp;•
                     <a href="//uz.wikipedia.org/" lang="uz">O’zbek</a>&nbsp;•
                     <a href="//pms.wikipedia.org/" lang="pms">Piemontèis</a>&nbsp;•
                     <a href="//nds.wikipedia.org/" lang="nds">Plattdüütsch</a>&nbsp;•
                     <a href="//qu.wikipedia.org/" lang="qu">Runa Simi</a>&nbsp;•
                     <a href="//pnb.wikipedia.org/" lang="pnb" title="Shāhmukhī Pañjābī"><span dir="rtl">شاہ مکھی پنجابی</span></a>&nbsp;•
                     <a href="//sq.wikipedia.org/" lang="sq">Shqip</a>&nbsp;•
                     <a href="//scn.wikipedia.org/" lang="scn">Sicilianu</a>&nbsp;•
                     <a href="//simple.wikipedia.org/" lang="en">Simple English</a>&nbsp;•
                     <a href="//ceb.wikipedia.org/" lang="ceb">Sinugboanon</a>&nbsp;•
                     <a href="//sh.wikipedia.org/" lang="sh"><span lang="sh-Latn">Srpskohrvatski</span> / <span lang="sh-Cyrl">Српскохрватски</span></a>&nbsp;•
                     <a href="//su.wikipedia.org/" lang="su">Basa Sunda</a>&nbsp;•
                     <a href="//sw.wikipedia.org/" lang="sw">Kiswahili</a>&nbsp;•
                     <a href="//tl.wikipedia.org/" lang="tl">Tagalog</a>&nbsp;•
                     <a href="//ta.wikipedia.org/" lang="ta" title="Tamiḻ">தமிழ்</a>&nbsp;•
                     <a href="//tt.wikipedia.org/" lang="tt"><span lang="tt-Cyrl">Татарча</span> / <span lang="tt-Latn">Tatarça</span></a>&nbsp;•
                     <a href="//te.wikipedia.org/" lang="te" title="Telugu">తెలుగు</a>&nbsp;•
                     <a href="//tg.wikipedia.org/" lang="tg" title="Tojikī">Тоҷикӣ</a>&nbsp;•
                     <a href="//th.wikipedia.org/" lang="th" title="Thai">ไทย</a>&nbsp;•
                     <a href="//bug.wikipedia.org/" lang="bug"><span lang="bug-Bugi">ᨅᨔ ᨕᨙᨁᨗ</span> / <span lang="bug-Latn">Basa Ugi</span></a>&nbsp;•
                     <a href="//ur.wikipedia.org/" lang="ur" title="Urdu"><span dir="rtl">اردو</span></a>&nbsp;•
                     <a href="//wa.wikipedia.org/" lang="wa">Walon</a>&nbsp;•
                     <a href="//yo.wikipedia.org/" lang="yo">Yorùbá</a>&nbsp;•
                     <a href="//zh-yue.wikipedia.org/" lang="yue" title="Yuet6yue5">粵語</a>&nbsp;•
                     <a href="//diq.wikipedia.org/" lang="diq">Zazaki</a>&nbsp;•
                     <a href="//bat-smg.wikipedia.org/" lang="sgs">Žemaitėška</a>
                  </div>
               </div>
               
               <div id="complete-list"><a href="//meta.wikimedia.org/wiki/List_of_Wikipedias">Complete list of Wikipedias</a></div>
            </div>
         </header>
         
         <section id="search">
            <h1><a href="http://wikipediaredefined.com"><img id="logo" src="//<?php echo $wikiConfig['site-url']; ?>images/logo-notext.png" alt="Wikipedia Logo" title="Wikipedia" height="210"></a></h1>
            
            <div id="search-fields">
               <form action="//<?php echo $wikiConfig['site-url']; ?>w/index.php" onsubmit="return false;">   
                  <ul id="wikiResults"></ul>
                  <input id="q" name="q" class="big-input" size="30" value="Search" rel="Search" onfocus="jsPlaceholder(this);" onblur="jsPlaceholder(this);" autocomplete="off">
                  <span id="in">in</span>
                  <select name="lang" class="big-input">
                     <option value="ar" lang="ar">العربية</option><!-- Al-ʿArabīyah -->
                     <option value="bg" lang="bg">Български</option><!-- Bulgarski -->
                     <option value="ca" lang="ca">Català</option>
                     <option value="cs" lang="cs">Česky</option>
                     <option value="da" lang="da">Dansk</option>
                     <option value="de" lang="de">Deutsch</option>
                     <option value="en" lang="en" selected="selected">English</option>
                     <option value="es" lang="es">Español</option>
                     <option value="eo" lang="eo">Esperanto</option>
                     <option value="eu" lang="eu">Euskara</option>
                     <option value="fa" lang="fa">فارسی</option><!-- Fārsi -->
                     <option value="fr" lang="fr">Français</option>
                     <option value="ko" lang="ko">한국어</option><!-- Hangugeo -->
                     <option value="hi" lang="hi">हिन्दी</option><!-- Hindī -->
                     <option value="hr" lang="hr">Hrvatski</option>
                     <option value="id" lang="id">Bahasa Indonesia</option>
                     <option value="it" lang="it">Italiano</option>
                     <option value="he" lang="he">עברית</option><!-- ‘Ivrit -->
                     <option value="lt" lang="lt">Lietuvių</option>
                     <option value="hu" lang="hu">Magyar</option>
                     <option value="ms" lang="ms">Bahasa Melayu</option>
                     <option value="nl" lang="nl">Nederlands</option>
                     <option value="ja" lang="ja">日本語</option><!-- Nihongo -->
                     <option value="no" lang="nb">Norsk (bokmål)</option>
                     <option value="pl" lang="pl">Polski</option>
                     <option value="pt" lang="pt">Português</option>
                     <option value="kk" lang="kk">Қазақша / Qazaqşa / قازاقشا</option>
                     <option value="ro" lang="ro">Română</option>
                     <option value="ru" lang="ru">Русский</option><!-- Russkiy -->
                     <option value="sk" lang="sk">Slovenčina</option>
                     <option value="sl" lang="sl">Slovenščina</option>
                     <option value="sr" lang="sr">Српски / Srpski</option>
                     <option value="fi" lang="fi">Suomi</option>
                     <option value="sv" lang="sv">Svenska</option>
                     <option value="tr" lang="tr">Türkçe</option>
                     <option value="uk" lang="uk">Українська</option><!-- Ukrayins’ka -->
                     <option value="vi" lang="vi">Tiếng Việt</option>
                     <option value="vo" lang="vo">Volapük</option>
                     <option value="war" lang="war">Winaray</option>
                     <option value="zh" lang="zh">中文</option><!-- Zhōngwén -->
                  </select>
               </form>
            </div>
         </section>
         
         <?php echo aboutBox(); ?>
         
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
      
      <div id="media-wiki">
         <a href="http://www.mediawiki.org/"><img src="//<?php echo $wikiConfig['site-url']; ?>images/wmedia-logo.png" alt="A Wikimedia project" title="A Wikimedia project"></a>
      </div>
      
      <?php echo googleAnalytics(); ?>
      
   </body>
</html>