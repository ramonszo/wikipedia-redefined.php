/**********************************************
* jQuery                                      *
***********************************************/

$(document).ready(function() {    
    transformWikiInput('q');

    $("#tasks .close").on("click", function() {
        $('#tasks').animate({
            height: 'hide',
            opacity: 'hide'
        },300);
    });
    
    $('#about').hover(function(){
        $(this).animate({
            marginRight: '0'
        }, 'medium');
    },function(){
        $(this).animate({
            marginRight: '-252px'
        }, 'medium');
    });
    
    if(use_jsapi==1){
        loadArticle();
    }
    
    $('#share-button').on("click", function(){            
        var left = (screen.width/2)-(600/2);
        var top = (screen.height/2)-(500/2);
        
        window.open('http://www.addthis.com/bookmark.php?url='+canonical_url, "addthis_window", "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=600, height=500, top="+top+", left="+left);
    });
        
    /*social floater*/
    if(document.getElementById("jumpr-share-float")){
        var contentWidth = document.getElementById('content-wrapper').offsetWidth;
        var float_margin = '-'+((contentWidth/2)+71)+'px';
        $('#jumpr-share-float').css('marginLeft', float_margin);
        
        if(use_jsapi == 0){
            $("#jumpr-share-float").css('display','block');   
        }
        
        setInterval(function(){
                var navbar_top = 409-20;
                var scrollTop=document.body.scrollTop;
                var box = $("#jumpr-share-float");
                
                if(scrollTop>=navbar_top && box.hasClass('fixed')==false) {
                        box.addClass("fixed");
                } else if (scrollTop<navbar_top && box.hasClass('fixed')==true) {
                        box.removeClass("fixed");
                }
        },10);
        
    }
});

function parseArticle(str){
    return str;
    //return str.replace(/\"\/\//gi,'http://').replace(/\"\//gi,'"');
}

function createArticle(json){
    if(json.error){
        //alert(error_msg);
        location.href = article_url;
    } else {
        var title = json.parse.title;
        var content = parseArticle(json.parse.text['*']);
        var languages = json.parse.langlinks;
        
        document.title = title+' – '+wikiSub;
        $('#firstHeading span').html(title);
        $('#main-wikipedia-article').html(content);
        
        var selectBox = $('#main-bar-wrapper .fright').html();
        var options = '';
        
        for(var i=0;i < languages.length; i++){
            var langcode = languages[i].lang;
            options += '<option value="'+langcode+'" title="'+languages[i]['url']+'">'+lang_names[langcode]+'</option>';
        }
        
        //I think you will not undestand this. Two words: Internet Explorer.
        var newSelect = selectBox.replace('</select>',options); //replace the </select> to add options to the old html of selectbox
        newSelect += '</select>'; //add the </select> again

        $('#main-bar-wrapper .fright').html(newSelect);
        $('#jumpr-share-float').css('display','block');
    }
}

function loadArticle(){
    var s = document.createElement("script");
    s.src = api_url;
    document.getElementsByTagName('head')[0].appendChild(s);
}
