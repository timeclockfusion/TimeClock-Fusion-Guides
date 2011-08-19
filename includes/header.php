<?php
/*
 * Returns the URL of current page
 */
function curPageURL() {
 $pageURL = 'http';
 if (isset($_SERVER["HTTPS"]) AND $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
$path = 'http://guides.timeclockfusion.com/';
?>
 
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <meta name="title" content="TimeClock Fusion - Guides">
        <meta name="keywords" content="TimeClock Fusion guides">
        <meta name="description" content="Guides and Howtos for the TimeClock Fusion Online timekeeping system.">
        <title>TimeClock Fusion - Guides</title>

        <link rel="stylesheet" href="<?php echo $path ?>includes/layout.css" type="text/css">

        <script type="text/javascript" src="<?php echo $path ?>includes/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="<?php echo $path ?>includes/jquery-ui-1.8.4.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo $path ?>includes/gen_validatorv31.js"></script>
        <script type="text/javascript" src="<?php echo $path ?>includes/jquery.fancybox-1.3.1.pack.js"></script>
        <script type="text/javascript" src="<?php echo $path ?>includes/jquery.easing-1.3.pack.js"></script>
        <script type="text/javascript" src="<?php echo $path ?>includes/jquery.innerfade.js"></script>
        <script type="text/javascript" src="<?php echo $path ?>includes/jquery.equalheights.js"></script>
        <script type="text/javascript" src="<?php echo $path ?>includes/jquery_functions.js"></script>
        <script type="text/javascript" src="<?php echo $path ?>includes/functions.js"></script>
        <script type="text/javascript" src="<?php echo $path ?>includes/jquery.livecalc.js"></script>
        <script type="text/javascript" src="<?php echo $path ?>includes/numberformat.js"></script>
		<script type="text/javascript">
	   $(document).ready(
                function(){
                    $('.testimonialsFade').innerfade({
                            speed: 800,
                            timeout: 8000,
                            type: 'random_start',
                            containerheight: '1.5em'
                    });
                    $('#homeHE').innerfade({
                            speed: 800,
                            timeout:8000,
                            type: 'random_start',
                            containerheight: '321px'
                    });
                    
            });



            $.fn.preload = function() {
            this.each(function(){
                $('<img/>')[0].src = this;
            });
        }
            $(window).bind("load", function() {
                $(".sides").equalHeights()
            });
        $(['<?php echo $path ?>includes/images/tabs/Center_Hover.png',
        '<?php echo $path ?>includes/images/tabs/Left_Curve_Hover.png',
        '<?php echo $path ?>includes/images/tabs/Right_Curve_Hover.png',
        '<?php echo $path ?>includes/images/tabs/Right_Corner_Hover.png']).preload();

  	</script>

        <!-- J-Query UI !-->
        <link href="<?php echo $path ?>includes/jquery-ui-1.8.4.custom.css" media="screen" rel="stylesheet" type="text/css">

        <!-- Beginning of compulsory code below -->

        <link rel="stylesheet" href="<?php echo $path ?>includes/jquery.fancybox-1.3.1.css" type="text/css" media="screen">
        <link href="<?php echo $path ?>includes/dropdown.css" media="screen" rel="stylesheet" type="text/css">
        <link href="<?php echo $path ?>includes/default.css" media="screen" rel="stylesheet" type="text/css">

        <!--[if lt IE 7]>
        <script type="text/javascript" src="js/jquery/jquery.js"></script>
        <script type="text/javascript" src="js/jquery/jquery.dropdown.js"></script>
        <![endif]-->

        <!--[if IE]>
                <link rel="stylesheet" type="text/css" href="https://hosted.phptimeclock.com/nexus/css/ie-only.css" />
        <![endif]-->

        <!-- / END -->

        <!-- CSS DropDown End !-->

        <script type="text/javascript">
            function strpos (haystack, needle, offset) {
                // Finds position of first occurrence of a string within another
                //
                // version: 1009.2513
                // discuss at: http://phpjs.org/functions/strpos    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
                // +   improved by: Onno Marsman
                // +   bugfixed by: Daniel Esteban
                // +   improved by: Brett Zamir (http://brett-zamir.me)
                // *     example 1: strpos('Kevin van Zonneveld', 'e', 5);    // *     returns 1: 14
                var i = (haystack+'').indexOf(needle, (offset || 0));
                return i === -1 ? false : i;
            }
            $(document).ready(function () {
                var path = 'http://timeclockfusion.com/includes/images/tabs/';

                $('#navMenu li').prepend('<div class="menuHover"></div>');

                $('#navMenu li').before('<li class="menuBefore"><img class="beforeImg" src="'+path+'Left_Curve.png" /><img class="afterImg" src="'+path+'Right_Curve.png" /></div></div></li>');

                $('#navMenu li:last-child').after('<li class="menuLast" title="lastItem"><img class="lastImg" src="'+path+'Right_Corner.png" /><img class="afterImg" src="'+path+'Right_Curve.png" /></li>');

                $('#navMenu li.active').prev().attr('id', 'activeBefore');
                $('#activeBefore .beforeImg').show();
                $('#navMenu li.active').addClass('activeMain');
                $('#navMenu li.active').next().attr('id', 'activeAfter');
                $('#activeAfter').attr('class', 'activeAfter');
                $('#activeAfter .afterImg').show();
                
                $('#navMenu li:last-child').attr('id', 'lastItem');
                if (strpos($('#lastItem').attr('class'), 'activeAfter') !== false){
                    $('#lastItem .lastImg').show();
                    $('#lastItem .afterImg').hide();
                }

                $('#navMenu li.item').hover(
                  //Mouseover
                    function() {
                        $(this).css('background-image', "url('"+path+"Center_Hover.png')");
                        $(this).css('background-repeat', 'repeat-x');

                        $(this).prev().attr('id', 'imgFadeLeft');
                        $('#imgFadeLeft').css('background', "url('"+path+"Left_Curve_Hover.png')");

                        $(this).next().attr('id', 'imgFadeRight');
                        
                        if ($('#imgFadeRight').attr('class') == 'menuLast')
                            $('#imgFadeRight').css('background', "url('"+path+"Right_Corner_Hover.png')");
                        else
                            $('#imgFadeRight').css('background', "url('"+path+"Right_Curve_Hover.png')");
                        $('#imgFadeLeft').attr('id', '');
                        $('#imgFadeRight').attr('id', '');
                    },
                //Mouseout
                    function() {
                        $(this).css('background', 'none');

                        $(this).prev().attr('id', 'imgFadeLeft');
                        $('#imgFadeLeft').css('background', '');

                        $(this).next().attr('id', 'imgFadeRight');
                        $('#imgFadeRight').css('background', '');

                        $('#imgFadeLeft').attr('id', '');
                        $('#imgFadeRight').attr('id', '');

                });
            });
        </script>
    <script type='text/javascript'>
        $(document).ready(function(){
        $("img.online_demo").hover(
        function() {
        $(this).stop().animate({"opacity": "0"}, "slow");
        },
        function() {
        $(this).stop().animate({"opacity": "1"}, "slow");
        });

        });
    </script>
            <script type='text/javascript'>
        $(document).ready(function(){
        $("img.try_now").hover(
        function() {
        $(this).stop().animate({"opacity": "0"}, "slow");
        },
        function() {
        $(this).stop().animate({"opacity": "1"}, "slow");
        });

        });
    </script>
            <script type='text/javascript'>
        $(document).ready(function(){
        $("img.take_tour").hover(
        function() {
        $(this).stop().animate({"opacity": "0"}, "slow");
        },
        function() {
        $(this).stop().animate({"opacity": "1"}, "slow");
        });

        });
    </script>
    </head>
    <body>
        <div id="wrapper">

            <div id="header">
                <div id="logo">
                    <img src="<?php echo $path ?>includes/images/Logo_With_TM.png" />
                </div>
                <?php $baseURL = 'http://timeclockfusion.com' ?>
                <?php
                    if (strpos(curPageURL(), 'about'))
                        $curPage = 'about';
                    else if (strpos(curPageURL(), 'features'))
                        $curPage = 'features';
                    else if (strpos(curPageURL(), 'price'))
                        $curPage = 'price';
                    else if (strpos(curPageURL(), 'contact'))
                        $curPage = 'contact';
                    else if (strpos(curPageURL(), 'faq'))
                        $curPage = 'faq';
                    else
                        $curPage = 'guides';
                ?>
                <div id="headerRight">
                    <div id="upperRight">
                        <div id="openSource">
                            <a href="http://timeclockfusion.org">Open Source Community</a>
                        </div>
                    </div>
                    <div id="topMenu">
                        <ul id="navMenu" class="dropdown dropdown-horizontal">
                            <li class="item <?php echo $curPage == 'guides' ? 'active' : ''?>"><a href="<?php echo $baseURL ?>/">Guides</a></li>
                        </ul>
                    </div>
                </div>
            </div>