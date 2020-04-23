;
(function ($) {

    $.fn.cs_tooltip = function(options){
        var defaults = {
            hover_duration:3000,
            bg_width:200,
            bg_height:305,
            hover_alpha:1,
            position:"center",
            easing:"easeInOutSine",
            style_object: null,
            tooltip_resource_attribute:"title",
            use_tooltip:true,
            add_click_evt:false

        };
        var main        =   $(this);
        var config      =   $.extend({}, defaults, options);
        var title_attr  =   null;
        var relX        =   null;
        var relY        =   null;
        //console.log(main);

        /**********************************************************************/

        var cTip = {
            init: function(){
                main.hover(this.overFX, this.outFX);
                
                main.mousemove(this.mouseMoveAction);
                if(config.add_click_evt){
                    main.click( this.outFX);

                }
            },

            mouseMoveAction:function(e){
                var lbl_div     = $("div.label_div");
                //relX = e.pageX+10;
                cTip.updateRelXY(e, lbl_div);
                lbl_div.css({
                    top:relY  + "px",
                    left:relX + "px"
                });
            },

            overFX: function(e){
                var dis     = $(this);
                if( !dis.attr('data-blind')){ //(title_attr  = $(dis).attr(config.tooltip_resource_attribute) )
                    title_attr  = $(dis).attr(config.tooltip_resource_attribute);
                    var lbl_div = $('div.label_div');
                    cTip.updateRelXY(e, lbl_div);
                    title_attr  = title_attr.replace("\n", "<br />");

                    dis.data('title', title_attr );
                    dis.attr('title', '');

                    $('.label_div').remove();
                    $("<div />", {
                        html: dis.data('title'),
                        "class": "label_div"
                    }).appendTo("body");

                    if( dis.attr('pix_data') ){
                        $("<img />", {
                            "src": dis.attr('pix_data'),
                            "class": "tooltip_pix"
                        }).css({
                                "float":"left",
                                "clear":"both",
                                width:"50px"
                            }).appendTo("div.label_div");
                    }
                    if(config.style_object != null){
                        $('div.label_div').css(
                            config.style_object
                        );
                    }else{
                        $("div.label_div").css({
                            padding:"10px",
                            background:"rgba(10, 18, 200, 0.5)",
                            borderRadius:"5px",
                            textAlign:"center"
                        })
                    }

                    $("div.label_div").css({
                        position:"absolute",
                        top:relY + "px",
                        left:relX + "px",
                        zIndex:999999,
                        backgroundPosition: "50% 50%"
                    }).hide();
                    $("div.label_div").fadeIn({"duration":250, "easing":"easeInOutSine"});
                }
            },
            
            updateRelXY: function(e, lbl_div){
                if(lbl_div && lbl_div.offset()){
                    const offSets   = lbl_div.offset();
                    switch(config.position){
                        case 'bottom':
                        case 'center':
                        default:
                            relX    = e.pageX-( lbl_div.outerWidth()/2);
                            relY    = e.pageY+15;
                            break;
        
                        case 'left':
                            relX    = e.pageX -  lbl_div.outerWidth() - 10;
                            relY    = e.pageY+5;
                            break;
        
                        case 'right':
                            relX    = e.pageX + 10;
                            relY    = e.pageY+5;
                            break;
        
                        case 'top':
                            relX    = e.pageX-( lbl_div.outerWidth()/2);
                            relY    = e.pageY+5;
                            break;
                    }
                }
                return {relX, relY};
            },

            outFX: function(evt){
                var dis = $(this);
                if( !dis.attr('data-blind')){ //(title_attr  = $(dis).attr(config.tooltip_resource_attribute) )
                    //dis.attr('title', dis.data('title'));
                    $("div.label_div").fadeOut({"duration":150, "easing":"easeInOutSine", "complete" : function() {$(this).remove(); }});
                }
            }

        };
        cTip.init();

    };

}(jQuery) );