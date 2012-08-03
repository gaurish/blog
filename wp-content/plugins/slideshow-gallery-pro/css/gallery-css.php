<?php header("Content-Type: text/css"); ?>
<?php $styles = array(); ?>
<?php
foreach ($_GET as $skey => $sval) :
    $styles[$skey] = urldecode($sval);
endforeach;
IF ($styles['width_temp']) {
    $styles['width'] = $styles['width_temp'];
}
IF ($styles['height_temp']) {
    $styles['height'] = $styles['height_temp'];
}
IF (!$styles['thumbheight']) {
    $styles['thumbheight'] = "75";
}
$navleft = "../images/left.gif";
$navright = "../images/right.gif";
IF ($styles['navbuttons'] == 0) {
    $navright = '../images/right.gif';
    $navleft = '../images/left.gif';
} ELSEIF ($styles['navbuttons'] == 1) {
    $navright = '../pro/images/right-sq.png';
    $navleft = '../pro/images/left-sq.png';
} ELSEIF ($styles['navbuttons'] == 2) {
    $navright = '../pro/images/right-rd.png';
    $navleft = '../pro/images/left-rd.png';
} ELSEIF ($styles['navbuttons'] == 3) {
    $navright = '../pro/images/right-pl.png';
    $navleft = '../pro/images/left-pl.png';
}
IF ($styles['infomin'] == "Y") {
    ?>
    #information h5 { margin:0 !important; }
    #information p {margin:0 !important; }
<?php } ?>
#sgpro_slideshow { list-style:none; color:#fff; }
#sgpro_slideshow span { display:none; }
#slideshow-wrapper { width:<?php echo ((int) $styles['width'] - 6); ?>px; background:<?php echo $styles['background']; ?>; padding:2px; border:<?php echo $styles['border']; ?>; margin:10px auto; display:none; float: <?php echo $styles['align']; ?> }
#fullsize { 
position:relative; z-index:1; overflow:hidden; width:<?php echo ((int) $styles['width'] - 6); ?>px; 
height:<?php echo ((int) $styles['height'] - 6); ?>px; 
}
#information { position:absolute; bottom:0; width:<?php echo ((int) $styles['width'] - 6); ?>px; height:0; background:<?php echo $styles['infobackground']; ?>; color:<?php echo $styles['infocolor']; ?>; overflow:hidden; z-index:200; opacity:.7; filter:alpha(opacity=70); }
#information h5 { color:<?php echo $styles['infocolor']; ?>; padding:4px 8px 3px; font-size:1.2em; }
#information p { color:<?php echo $styles['infocolor']; ?>; padding:0 8px 3px; font-size:.9 em;}
#sgpro_image { position:absolute; width:<?php echo ((int) $styles['width'] - 6); ?>px; height: <?php echo ((int) $styles['height'] - 6); ?>px}
#sgpro_image img { height:<?php echo ((int) $styles['height'] - 6); ?>px; }
<?php if (empty($styles['resizeimages']) || $styles['resizeimages'] == "Y") : ?>
    #sgpro_image img { 
    position:relative; 
    margin-left:auto;
    margin-right:auto;
    display:block;
    border:none; 
    width:<?php echo ((int) $styles['width'] - 6); ?>px;
    height:auto;
    padding: 0 !important;
    }
<?php else : ?>
    #sgpro_image img { position:absolute; border:none; width:auto; padding:0 !important;}<?php endif; ?> 
<?php if (empty($styles['resizeimages2']) || $styles['resizeimages2'] == "Y") : ?>
    #sgpro_image img#tall { 
    border:none; 
    width:auto;
    height:<?php echo ((int) $styles['height'] - 6); ?>px;
    }
<?php endif; ?>
.imgnav { position:absolute; width:25%; height:<?php echo ((int) $styles['height'] + 6); ?>px; cursor:pointer; z-index:150; top:0; }
#imgprev { left:0; background:url( <?php echo($navleft); ?>) left center no-repeat; }
#imgnext { right:0; background:url(<?php echo($navright); ?>) right center no-repeat; }
#imglink { position:absolute; top: 0px; left: <?php echo ((int) $styles['width'] * 0.25 - 2); ?>px; height:<?php echo ((int) $styles['height'] + 6); ?>px; width: <?php echo ((int) $styles['width'] * 0.5 - 2); ?>px; z-index:5000; opacity:.0; filter:alpha(opacity=0); background: #FFF;}
/*.linkhover*/
#imglink:hover { background:url('../images/link.gif') center center no-repeat; opacity:.4; filter:alpha(opacity=40)}
#thumbnails {  height:<?php echo ((int) $styles['thumbheight'] + 6); ?>px }
.thumbstop { margin-bottom:15px !important; }
.thumbsbot { margin-top:<?php echo ((int) $styles['thumbheight'] / 5); ?>px !important; }
#slideleft { float:left; width:20px; height:<?php echo ((int) $styles['thumbheight'] + 6); ?>px; background:url('../images/scroll-left.gif') center center no-repeat; background-color:<?php echo $styles['background']; ?> }
#slideleft:hover { background-color:#666; }
#slideright { float:right; width:20px; height:<?php echo ((int) $styles['thumbheight'] + 6); ?>px; background:<?php echo $styles['background']; ?> url('../images/scroll-right.gif') center center no-repeat; }
#slideright:hover { background-color:#aaa; }
#slidearea { float:left; background:<?php echo $styles['background']; ?>; position:relative; width:<?php echo ((int) $styles['width'] - 55); ?>px; margin-left:5px; height:<?php echo ((int) $styles['thumbheight'] + 6); ?>px; overflow:hidden; }
#thumbslider { position:absolute; left:0; height:<?php echo ((int) $styles['thumbheight'] + 6); ?>px; }
#thumbslider img { cursor:pointer; border:1px solid #666; padding:2px; -moz-border-radius:4px; -webkit-border-radius:4px; float:left !important; height:<?php echo ((int) $styles['thumbheight']); ?>px !important;}
#spinner { position:relative; top:50%; left:45%; }	
#spinner img {border:none;}