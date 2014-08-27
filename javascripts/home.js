/**********************************************
* jQuery                                      *
***********************************************/

/**
* hoverIntent r5 // 2007.03.27 // jQuery 1.1.2+
* <http://cherne.net/brian/resources/jquery.hoverIntent.html>
* 
* @param  f  onMouseOver function || An object with configuration options
* @param  g  onMouseOut function  || Nothing (use configuration options object)
* @author    Brian Cherne <brian@cherne.net>
*/
(function($){$.fn.hoverIntent=function(f,g){var cfg={sensitivity:7,interval:100,timeout:0};cfg=$.extend(cfg,g?{over:f,out:g}:f);var cX,cY,pX,pY;var track=function(ev){cX=ev.pageX;cY=ev.pageY;};var compare=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);if((Math.abs(pX-cX)+Math.abs(pY-cY))<cfg.sensitivity){$(ob).unbind("mousemove",track);ob.hoverIntent_s=1;return cfg.over.apply(ob,[ev]);}else{pX=cX;pY=cY;ob.hoverIntent_t=setTimeout(function(){compare(ev,ob);},cfg.interval);}};var delay=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);ob.hoverIntent_s=0;return cfg.out.apply(ob,[ev]);};var handleHover=function(e){var p=(e.type=="mouseover"?e.fromElement:e.toElement)||e.relatedTarget;while(p&&p!=this){try{p=p.parentNode;}catch(e){p=this;}}if(p==this){return false;}var ev=jQuery.extend({},e);var ob=this;if(ob.hoverIntent_t){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);}if(e.type=="mouseover"){pX=ev.pageX;pY=ev.pageY;$(ob).bind("mousemove",track);if(ob.hoverIntent_s!=1){ob.hoverIntent_t=setTimeout(function(){compare(ev,ob);},cfg.interval);}}else{$(ob).unbind("mousemove",track);if(ob.hoverIntent_s==1){ob.hoverIntent_t=setTimeout(function(){delay(ev,ob);},cfg.timeout);}}};return this.mouseover(handleHover).mouseout(handleHover);};})(jQuery);

function fadeAllBut(v){
    $('#languages a').each(function(){
        if($(this).attr("id")!=$(v).attr("id")){
            $(this).animate({opacity: 0.5},200);
        }
    });    
}

function fadeAllOut(){
    $(this).addClass('active');
    $('#languages a').not(this).animate({opacity:0.5},300);
}

function fadeAllIn(){
    $('#languages a').removeClass('active').animate({opacity:1},200);
}

$(document).ready(function() {
    transformWikiInput('q');
    
    adjustBody();
    
    $("#languages a").not('#other').hoverIntent({
            over: fadeAllOut,
            timeout: 100,
            out: fadeAllIn
    }); 
    
    $("#languages a").not('#other').tipTip();
        
    $('#other').hover(function(){
        $('#other-languages').animate({
            height: 'toggle'
        }, 'medium');
    },function(){
        $('#other-languages').hover(function(){
            $(this).animate({
                height: 'show'
            }, 'medium');
        },function(){
            $(this).animate({
                height: 'hide'
            }, 'medium');            
        });
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
    
    $(document).mouseleave(function() {
        $('#other-languages').animate({
            height: 'hide'
        }, 'medium');  
    });

});
