<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

/* 
* +--------------------------------------------------------------------------+
* | Copyright (c) 2006 RoohIt                   (email : support@roohit.com) |
* +--------------------------------------------------------------------------+
*/

$ROOHBTN_SIG_CMNT_BGN = "<!-- RoohIt Button BEGIN -->" ;
$ROOHBTN_SIG_CMNT_END = "<!-- RoohIt Button END -->" ;

$default_Hbutton = '27' ;
$roohit_styles_old = array(
                        '1' => array('img'=>'http://roohit.com/images/btns/hlBtnNEW.png')
                      , '2' => array('img'=>'http://roohit.com/images/btns/aSS.png')
                      , '3' => array('img'=>'http://roohit.com/images/btns/aSH.png')
                      , '4' => array('img'=>'http://roohit.com/images/btns/aSvH.png')
                      , '5' => array('img'=>'http://roohit.com/images/btns/aMB.png')
                      , '6' => array('img'=>'http://roohit.com/images/btns/aMS.png')
                      , '7' => array('img'=>'http://roohit.com/images/btns/aAB.png')
                      , '8' => array('img'=>'http://roohit.com/images/btns/aCSS.png')

                      , '9'  => array('img'=>'http://roohit.com/images/btns/2RH-3.png')
                      , '10'  => array('img'=>'http://roohit.com/images/btns/2RH-2.png')
                      , '11'  => array('img'=>'http://roohit.com/images/btns/2RH.png')

                      , '12'  => array('img'=>'http://roohit.com/images/btns/btn_MB.png')
                      , '13' => array('img'=>'http://roohit.com/images/btns/btn_CSC.png')

                      , '14'  => array('img'=>'http://roohit.com/images/btns/btn_HP.png')
                      , '15' => array('img'=>'http://roohit.com/images/btns/btn_SH.png')
                      , '16' => array('img'=>'http://roohit.com/images/btns/btn_BAT.png')

                      , '17'  => array('img'=>'http://roohit.com/images/btns/hlThisPage.png')
                      , '18' => array('img'=>'http://roohit.com/images/instHler.gif')

                      , '19'  => array('img'=>'http://roohit.com/site/images/button1.gif')
                      , '20'  => array('img'=>'http://roohit.com/site/images/hilight_button.gif')

                      , '21' => array('img'=>'http://roohit.com/images/pen2.gif')

                      , '22' => array('img'=>'http://roohit.com/images/btns/ssh_256.png')
                      , '23' => array('img'=>'http://roohit.com/images/btns/htp_256.png')
                      , '24' => array('img'=>'http://roohit.com/images/btns/shp_256.png')

                      , '25' => array('img'=>'http://roohit.com/images/btns/thp_256.png')
                      , '26' => array('img'=>'http://roohit.com/images/btns/thp2_256.png')
                      , '27' => array('img'=>'http://roohit.com/images/btns/ssh_tfbd_256.png')                    
                      , '28' => array('img'=>'http://roohit.com/images/btns/dth_256.png')
                      , '29' => array('img'=>'http://roohit.com/images/btns/dth2_256.png')
                      , '30' => array('img'=>'http://roohit.com/images/btns/tyh_256.png')
                      , '31' => array('img'=>'http://roohit.com/images/btns/ssh_t256.png')

                      /* Add your own style here, like this:
                        , 'custom' => array('img'=>'http://example.com/button.gif') */
                    );

$roohit_languages = array('zh'=>'Chinese', 'da'=>'Danish', 'nl'=>'Dutch', 'en'=>'English', 'fi'=>'Finnish', 'fr'=>'French', 'de'=>'German', 'he'=>'Hebrew', 'it'=>'Italian', 'ja'=>'Japanese', 'ko'=>'Korean', 'no'=>'Norwegian', 'pl'=>'Polish', 'pt'=>'Portugese', 'ru'=>'Russian', 'es'=>'Spanish', 'sv'=>'Swedish');

function th_getUserSettings4HorzBtnTH()
{
    global $roohit_settings;
    global $default_Hbutton ;

    $language = get_option('roohit_language');
    $roohit_settings['language'] = $language;
    
    if (!isset($style)) $style = get_option('roohit_style');
    if (strlen($style) == 0) $style = $default_Hbutton ;
    $roohit_settings['style'] = $style;

    if (!isset($hoverBox)) $hoverBox = get_option('roohit_hoverbox');
    if (strlen($hoverBox) == 0) $hoverBox = 1;
    $roohit_settings['hoverBox'] = $hoverBox;

    if (!isset($label)) $label = get_option('roohit_label');
    if (strlen($label) == 0) $label = 1;
//echo "label is $label" ;
    $roohit_settings['label'] = $label;
}

function th_getHorzBtnSnippetTH($content)
{
    global $roohit_settings;
    global $default_Hbutton ;
    global $ROOHBTN_SIG_CMNT_BGN ;
    global $ROOHBTN_SIG_CMNT_END ;

    $content .= "\n" . $ROOHBTN_SIG_CMNT_BGN ;
        $link  = get_permalink(); 
        //href="http://roohit.com/$link
        $content .= '<div class="roohit_container" style=" height:30px;">' ;
        /*
        if ($roohit_settings['label'] == 1)
            $content .= 'Highlight <span style="background-color:#ffff00;">any portion</span> you want: ' ;
        */

        $content .= ' <a class="roohitBtn" href="http://roohit.com/'.$link.'" title="Use a Highlighter on this page">' ;
        //$content .= roohit_get_button_img() . '</a>' ;
        $content .= th_getHorzBtnImgTH() . '</a>' ;

        if ($roohit_settings['hoverBox']== 0)
            $content .= '<script type="text/javascript"><!--var showHover=false;--></script>' ;
        else 
            $content .= '<script type="text/javascript"><!--var showHover=true;--></script>' ;
        // $content .= 'hoverBox value=' . '.' .$roohit_settings['hoverBox'] ;        //debugging statement
        $content .= '<script type="text/javascript" src="http://roohit.com/site/btn.js"></script>' ;
    $content .= "</div>\n" . $ROOHBTN_SIG_CMNT_END ;
    return $content;
}

//function roohit_get_button_img()
function th_getHorzBtnImgTH()
{
    global $roohit_settings ;
    global $roohit_styles_old ;
    global $default_Hbutton ;

    $btnStyle = $roohit_settings['style'];

    // The id condition is commented so that for Tweet-Highlights plugin we don't use the new pen styles
    //if (!isset($roohit_styles_old[$btnStyle])) 
    $btnStyle = $default_Hbutton ;
    $btnRecord = $roohit_styles_old[$btnStyle];
    $btnUrl =  $btnRecord['img'];    
    return <<<EOF
<img src="$btnUrl" border="0" alt="Use a Highlighter on this page" style="border:none; vertical-align:middle;"/>
EOF;
}

/*
echo '----------------------------------------------------------------------------------------------------<br>' ;
echo '----------------------------------------------------------------------------------------------------<br>' ;
echo 'something = ', $something, '<br>' ;
echo '----------------------------------------------------------------------------------------------------<br>' ;
echo '----------------------------------------------------------------------------------------------------<br>' ;
*/

function CurrentPageURL()
{

   $pageURL = $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://';
   $pageURL .= $_SERVER['SERVER_PORT'] != '80' ? $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"] : $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
   return $pageURL;
   
   /*
    $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') 
                    === FALSE ? 'http' : 'https';
    $host     = $_SERVER['HTTP_HOST'];
    $script   = $_SERVER['SCRIPT_NAME'];
    $params   = $_SERVER['QUERY_STRING'];
    $currentUrl = $protocol . '://' . $host . $script . '?' . $params;
    return $currentUrl;
   */
}
?>
