<?php
	function parseWikiArticle($text){
            	//function to remove the first bars from a link and fix the broken images
                //$text = wikicontent
                
		global $scheme;
		
		return str_replace(array('"//','"/'),array('"'.$scheme,'"'),$text);
	}
        
        function redirectToWikipedia(){
            //function to redirect to wikipedia if errors on page
            
            global $wikipedia_site_url, $articleURL;
            
            header('location: '.$wikipedia_site_url.'/wiki/'.$articleURL);
	    exit();
        }
        
        function toOneLine($str){
            //replace the $str line breaks and whitespaces
            return trim(str_replace(array("\n","
                              ","
","\t"),'',$str));
        }
	
	function aboutBox(){
		//show the about box
		global $wikiConfig;
		
		return ($wikiConfig['show-about-panel']==false)?'':'
	<section id="about">
		<h2 id="about-btn">About</h2>
		
		<div id="about-wrapper">   
			The original design and all ideas come from the project "<a href="http://wikipediaredefined.com" target="_blank">Wikipedia Redefined</a>" by <a href="http://newisnew.lt/en" target="_blank">NEW! agency</a>.
			<br><br>
			
			I only did the code, which is available on github:
			<div>
				<iframe src="//ghbtns.com/github-btn.html?user=ramon82&repo=wikipedia-redefined&type=fork&count=true"  allowtransparency="true" frameborder="0" scrolling="0" width="95px" height="20px"></iframe>
				<iframe src="//ghbtns.com/github-btn.html?user=ramon82&repo=wikipedia-redefined&type=watch&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="95px" height="20px"></iframe>
			</div>
		</div>
         </section>';
	}
	
	function googleAnalytics(){
		//google analytics code
		global $wikiConfig;

		$domain = explode('/',$wikiConfig['site-url']);
		return '
		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(["_setAccount", "'.$wikiConfig['google-analytics'].'"]);
			/*_gaq.push(["_setDomainName", "'.$domain[0].'"]);*/
			_gaq.push(["_trackPageview"]);
			
			(function() {
			    var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
			    ga.src = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js";
			    var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>
		';
	}
?>
