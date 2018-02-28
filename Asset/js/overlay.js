$(function() {
    /**
     * timeout to control the display of the overlay/highlight
     */
    var highlight_timeout;

    /**
     * user hovers one image:
     * create a absolute div with the same image inside,
     * and append it to the body
     */
    $('img.ih_image').bind('mouseenter',function () {
        var $thumb = $(this);

        var $clone = $('<div />',{
            'id'		: 'ih_clone',
            'className': 'ih_image_clone_wrap',
            'html'     	: '<img src="'+$thumb.attr('src')+'" alt="'+$thumb.attr('alt')+'"/><span class="ih_zoom"></span>',
            'style'		: 'top:'+$thumb.offset().top+'px;left:'+$thumb.offset().left+'px;'
        });

        var highlight = function (){
            $('#ih_overlay').show();
            $('BODY').append($clone);
        }
        //show it after some time ...
        highlight_timeout = setTimeout(highlight,700);

        /**
         * when we click on the zoom,
         * we display the image in the center of the window,
         * and enlarge it to the size of the real image,
         * fading this one in, after the animation is over.
         */
        $clone.find('.ih_zoom').bind('click',function(){
            var $zoom = $(this);
            $zoom.addClass('ih_loading').removeClass('ih_zoom');
            var imgL_source = $thumb.attr('alt');

            $('<img class="ih_preview" style="display:none;"/>').load(function(){
                var $imgL = $(this);
                $zoom.hide();
                var windowW = $(window).width();
                var windowH = $(window).height();
                var windowS = $(window).scrollTop();

                $clone.append($imgL).animate({
                    'top'			: windowH/2 + windowS + 'px',
                    'left'			: windowW/2  + 'px',
                    'margin-left'	: -$thumb.width()/2 + 'px',
                    'margin-top'	: -$thumb.height()/2 + 'px'
                },400,function(){
                    var $clone = $(this);
                    var largeW = $imgL.width();
                    var largeH = $imgL.height();
                    $clone.animate({
                        'top'			: windowH/2 + windowS + 'px',
                        'left'			: windowW/2  + 'px',
                        'margin-left'	: -largeW/2 + 'px',
                        'margin-top'	: -largeH/2 + 'px',
                        'width'			: largeW + 'px',
                        'height'		: largeH + 'px'
                    },400).find('img:first').animate({
                        'width'			: largeW + 'px',
                        'height'		: largeH + 'px'
                    },400,function(){
                        var $thumb = $(this);
                        /**
                         * fade in the large image. Replace the zoom with a cross,
                         * so the user can close the preview mode
                         */
                        $imgL.fadeIn(function(){
                            $zoom.addClass('ih_close').removeClass('ih_loading').fadeIn(function(){
                                $(this).bind('click',function(){
                                    $clone.remove();
                                    clearTimeout(highlight_timeout);
                                    $('#ih_overlay').hide();
                                });
                            });
                            $thumb.remove();
                        });
                    });
                });
            }).error(function(){
                /**
                 * error loading image. Maybe show a message : 'no preview available'?
                 */
                $zoom.fadeOut();
            }).attr('src',imgL_source);
        });
    }).bind('mouseleave',function(){
        /**
         * the user moves the mouse out of an image.
         * if there's no clone yet, clear the timeout
         * (user was probably scolling through the article, and
         * doesn't want to view the image)
         */
        if($('#ih_clone').length) return;
        clearTimeout(highlight_timeout);
    });

    /**
     * the user moves the mouse out of the clone.
     * if we don't have yet the cross option to close the preview, then
     * clear the timeout
     */
    $('#ih_clone').live('mouseleave',function() {
        var $clone = $('#ih_clone');
        if(!$clone.find('.ih_preview').length){
            $clone.remove();
            clearTimeout(highlight_timeout);
            $('#ih_overlay').hide();
        }
    });
});