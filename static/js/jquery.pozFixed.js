(function($) { 
    $.fn.pozFixed = function(params) { 
        var defaults = { 
            top : 400, 
            left : '50%',
            interval:100
        }; 
        defaults = $.extend(defaults,params);     
        return this.each(function(i,o) { 
            var $this = $(this); 
            this.fixPosition = function() { 
            var st = $().scrollTop();  
                $this.css({
                    top:st + defaults.top,
                    left:'50%'
                });               
            };
            $this.css({position:'absolute',top:defaults.top,left:"50%"}); 
            setInterval(this.fixPosition,defaults.interval); 
        });
    };
})(jQuery);