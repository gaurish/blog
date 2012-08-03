<?php 
header("Content-Type: text/css");
$styles = array();
foreach ($_GET as $skey => $sval) :
	$styles[$skey] = urldecode($sval);
endforeach;
IF ($styles['width_temp']) {
	$styles['width'] = $styles['width_temp'];
}
IF ($styles['height_temp']) {
	$styles['height'] = $styles['height_temp'];
}
if ($styles['background'] == '#000000') {
	$loadbg = $styles['background']." url('../images/loading.gif')";
} else {
	$loadbg = $styles['background']." url('../images/spinner.gif')";
}
IF ($styles['navbuttons'] == 0) { $navright = 'url(../images/right-arrow.png) no-repeat 0 0';$navleft = 'url(../images/left-arrow.png) no-repeat 0 0'; }
IF ($styles['navbuttons'] == 1) { $navright = 'url("../pro/images/right-sq.png") no-repeat 30px 0';$navleft = 'url(../pro/images/left-sq.png) no-repeat 0 0'; }
IF ($styles['navbuttons'] == 2) { $navright = 'url(../pro/images/right-rd.png) no-repeat 30px 0';$navleft = 'url(../pro/images/left-rd.png) no-repeat 0 0'; }
IF ($styles['navbuttons'] == 3) { $navright = 'url(../pro/images/right-pl.png) no-repeat 30px 0';$navleft = 'url(../pro/images/left-pl.png) no-repeat 0 0'; }
?>

/* CSS for jQuery Orbit Plugin 1.2.3
 * www.ZURB.com/playground
 * Copyright 2010, ZURB
 * Free to use under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 
 
 
/* PUT IN YOUR SLIDER ID AND SIZE TO MAKE LOAD BEAUTIFULLY
   ================================================== */
#featured { 
	width: <?php echo $styles['width'] ?>px;
	height: <?php echo $styles['height'] ?>px;
	background:<?php echo($loadbg)?> no-repeat center center;
	overflow: hidden; }
#featured>img,  
#featured>div,
#featured>a { display: none; }

/* CONTAINER
   ================================================== */

div.orbit-wrapper {
    width: 1px;
    height: 1px;
	margin: 0 auto;
    position: relative; }

div.orbit {
    width: 1px;
    height: 1px;
    position: relative;
    overflow: hidden }

div.orbit>img {
    position: absolute;
    top: 0;
    left: 0;
    display: none; }

div.orbit>a {
    border: none;
    position: absolute;
    top: 0;
    left: 0;
    line-height: 0; 
    display: none; }

.orbit>div {
    position: absolute;
    top: 0;
    left: 0;
    width: <?php echo $styles['width'] ?>px;
    height: <?php echo $styles['height'] ?>px; }
/* Note: If your slider only uses content or anchors, you're going to want to put the width and height declarations on the ".orbit>div" and "div.orbit>a" tags in addition to just the .orbit-wrapper */
/* SPECIAL IMAGES */

div.sorbit-tall, div.sorbit-wide, div.sorbit-basic {
	background:<?php echo $styles['background']?>; /* VAR BACKGROUND */
}
div.sorbit-tall img {
	height: <?php echo $styles['height'] ?>px; /* VAR HEIGHT */
	margin: 0 auto;
	display:block;
        max-width:100%;}
	
div.sorbit-wide {
	display: table-cell;
        text-align:center;
	vertical-align:middle;
	height: <?php echo $styles['height'] ?>px; /* VAR HEIGHT */
        width: <?php echo $styles['width'] ?>px; 
        
        }
div.sorbit-wide * {
    vertical-align:middle;
    }
/*\*//*/
div.sorbit-wide {
    display: block;
}
div.sorbit-wide span {
    display: inline-block;
    height: 100%;
    width: 1px;
}
/**/
div.sorbit-wide img{
	width:<?php echo $styles['width'] ?>px; /* VAR Width */
        max-width:<?php echo $styles['width'] ?>px; /* VAR Width */
	margin: 0 auto;
	vertical-align:middle;
	display:inline-block;}
	
div.sorbit-basic img{
	height: 100%;
	margin: 0 auto;
	vertical-align:middle;
	display:block;
        max-width:100%;}	
	
/* TIMER
   ================================================== */
div.timer {
    width: 40px;
    height: 40px;
    overflow: hidden;
    position: absolute;
    top: 10px;
    right: 10px;
    opacity: .6;
    cursor: pointer;
    z-index: 100; }
span.rotator {
    display: block;
	/*display:none\9;  ie8 and below hack */
    width: 40px;
    height: 40px;
    position: absolute;
    top: 0;
    left: -20px;
    /*opacity: .6;*/
	/*filter: alpha(opacity=60);	*/
    background: url(../images/rotator-black.png) no-repeat;
    z-index: 3; }
span.mask {
    display: block;
    width: 20px;
    height: 40px;
    position: absolute;
    top: 0;
    right: 0;
    z-index: 2;
    overflow: hidden; }
span.rotator.move {
    left: 0 }
span.mask.move {
    width: 40px;
    left: 0;
    background: url(../images/timer-black.png) repeat 0 0; }
span.pause {
    display: block;
    width: 40px;
    height: 40px;
    position: absolute;
    top: 0;
    left: 0;
    background: url(../images/pause-black.png) no-repeat;
    z-index: 4;
    opacity: .5; }
span.pause.active {
    background: url(../images/pause-black.png) no-repeat 0 -40px }
div.timer:hover span.pause,
span.pause.active {
    opacity: 1 }

/* CAPTIONS
   ================================================== */
.orbit-caption {
    display: none;
    font-family: "HelveticaNeue", "Helvetica-Neue", Helvetica, Arial, sans-serif; }
.orbit-wrapper .orbit-caption {
    background: #000;
    background: rgba(0,0,0,.6);
    z-index: 100;
    color: #fff;
	text-align: center;
	padding: 7px 0;
    font-size: 13px;
    position: absolute;
    right: 0;
    bottom: 0;
    width: 100%; }
@media \0screen {
   .orbit-wrapper .orbit-caption { background:transparent !important; filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000050,endColorstr=#99000050);zoom: 1;   }
}
    
.orbit-caption h1 {
    color:#FFF;}
/* DIRECTIONAL NAV
   ================================================== */
div.slider-nav {
    display: block }
div.slider-nav span {
    width: 78px;
    height: 100px;
    text-indent: -9999px;
    position: absolute;
    z-index: 100;
    top: 50%;
    margin-top: -50px;
    cursor: pointer; }
div.slider-nav span.right {
    background: <?php echo($navright); ?>;
	/*background: background: url(../images/right-arrow.png) no-repeat 0 0*/
    right: 0; }
div.slider-nav span.left {
    background: <?php echo($navleft); ?>;
    left: 0; }

/* BULLET NAV
   ================================================== */

.orbit-bullets {
    position: absolute;
    z-index: 100;
    list-style: none;
    left: 50%;
    margin-left: -50px;
    padding: 0 0 0 15px; }

.orbit-bullets li {
    float: left;
    margin: 0 3px;
    cursor: pointer;
    color: #999;
    text-indent: -9999px;
    background: url(../images/bullets.jpg) no-repeat 4px 0;
    width: 13px;
    height: 12px;
    overflow: hidden; }

.orbit-bullets li.active {
    color: #222;
    background-position: -8px 0; }
    
.orbit-bullets li.has-thumb {
    background: none;
    width: 100px;
    height: 75px; }

.orbit-bullets li.active.has-thumb {
    background-position: 0 0;
    border-top: 2px solid #000; }	
