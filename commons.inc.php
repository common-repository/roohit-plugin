<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/* 
* +--------------------------------------------------------------------------+
* | Copyright (c) 2006 RoohIt                   (email : support@roohit.com) |
* +--------------------------------------------------------------------------+
* | This program is free software; you can redistribute it and/or modify     |
* | it under the terms of the GNU General Public License as published by     |
* | the Free Software Foundation; either version 2 of the License, or        |
* | (at your option) any later version.                                      |
* |                                                                          |
* | This program is distributed in the hope that it will be useful,          |
* | but WITHOUT ANY WARRANTY; without even the implied warranty of           |
* | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            |
* | GNU General Public License for more details.                             |
* |                                                                          |
* | You should have received a copy of the GNU General Public License        |
* | along with this program; if not, write to the Free Software              |
* | Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA |
* +--------------------------------------------------------------------------+
*/

function rh_to_sentence($glue1, $glue2, $array) {
    return ((sizeof($array) > 2)? implode($glue1, array_slice($array, 0, -2)).$glue1 : "").implode($glue2, array_slice($array, -2));
}
/*
* @return string
* @param  void
* @desc   The common attibution method
*/
function rh_common_attribution() {
  $roohit_msg = file_get_contents("http://roohit.com/site/4wp/roohit.msg.php");
  $roohit_array = json_decode($roohit_msg);
  $enabled_plugins = array();
  if(INST_HL_PLUGIN=="Y") array_push($enabled_plugins, $roohit_array->INST_HL);
  if(AUTO_PUB_PLUGIN=="Y") array_push($enabled_plugins,  $roohit_array->AUTO_PUB);
  if(TWT_HL_PLUGIN=="Y") array_push($enabled_plugins,  $roohit_array->TWT_HL);
  $msg = rh_to_sentence(", ", " and ", $enabled_plugins);
  $op = str_replace( "{{ ENABLED_PLUGINS }}", $msg, $roohit_array->THE_DIV);
  return $op;
}
/*
* @return void
* @param  void
* @desc   The head section to alert new user. Contains the JavaScript and styles
*/
function rh_alertNewUser_head()
{
  $enabled_plugins = array();
  if(INST_HL_PLUGIN=="Y") array_push($enabled_plugins, "Highligher");
  if(AUTO_PUB_PLUGIN=="Y") array_push($enabled_plugins, "My Highlights");
  if(TWT_HL_PLUGIN=="Y") array_push($enabled_plugins, "Tweet-Highlights");
  $h_contents = '<script type="text/javascript" src="'.RHAIO_PLUGIN_URL.'js/wp_2rooh.js"></script> 
<script type="text/javascript" language="javascript">
//  var instHLPluginEnabled = '.((INST_HL_PLUGIN=="Y") ? 'true' : 'false').';
//  var autoPubPluginEnabled = '.((AUTO_PUB_PLUGIN=="Y") ? 'true' : 'false').';
  var roohNotify = getCookieValue("roohNotify");
  jQuery(function(){
    if (roohNotify != "Done") {
      showNotificationContent2("blanket", 2000, "common_notification", 7000);
      setCookie("roohNotify", "Done", cookieExpNoOfDays);
    }
  });
</script>
<style type="text/css"> 
  div#widget_nt_box{ background:url(http://roohit.com/site/4wp/images/widget_nt_box2.png) no-repeat top left; height:144px; width:287px; padding:19px 21px 0px 21px; font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#000000; line-height:18px; position:absolute; bottom:0px; right:0px; z-index:1000000000000; text-align:left; }
  body > div#widget_nt_box{ position:fixed; }
  div#widget_nt_box h2{ font-size:12px; color:#CC0000; margin:0px 0px 0px 0px; padding:0px 0px 5px 0px; }
  div#widget_nt_box .row{ width:100%; padding-bottom:5px; font-size:11px; float:left; }
  div#widget_nt_box .bottom_text{ color:#1466A3; }
  .text_center{ text-align:center; }
  div#nt_box{ background:url(http://roohit.com/site/4wp/images/btn_nt_bg.png) no-repeat top left; height:132px; width:209px; padding:20px 25px 0px 25px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000000; line-height:18px; position:absolute; z-index:1000000000000; bottom: 0px; right:0px; text-align:center; }
  body > div#nt_box{ position:fixed; }
  div#nt_box h2{ font-size:14px; color:#CC0000; margin:0px 0px 0px 0px; padding:0px 0px 5px 0px; }
</style>';
  echo $h_contents;
}
/*
* @return void
* @param  void
* @desc   The foot section of the alert new user. Contains the HTML part of the code
*/
function rh_alertNewUser_footer() {
  echo '
<div id="blanket" style="display:none; background-color:#111; opacity: 0.50; filter:alpha(opacity=50); position:absolute; z-index: 9001;top:0px;left:0px;width:100%;height: 100%"> 
</div> 
<div id="common_notification" style="display: none;"> 
  <div id="widget_nt_box">
  '.rh_common_attribution().'
  </div>
</div>
';
}
/*
* @return boolean
* @param  void
* @desc   Shows the PoweredBy attribution
*/
function rh_showPoweredBy() {
  $enabled_plugins = array();
  if(INST_HL_PLUGIN=="Y") array_push($enabled_plugins, '<a href="http://roohit.com/site/1click.php">Highlighter</a>');
  if(AUTO_PUB_PLUGIN=="Y") array_push($enabled_plugins, 'My Highlights <a href="http://roohit.com/site/s_lite.php">Widget</a>');
  if(TWT_HL_PLUGIN=="Y") array_push($enabled_plugins, '<a href="http://roohit.com/site/buttons.php">Sidebar Pen</a>');
  $msg = rh_to_sentence(", ", " and ", $enabled_plugins);
  echo '
    <div class="sub_footer" style="display: block; text-align:center; vertical-align:middle;">'.$msg.'
    powered by
    <a href="http://roohit.com/"><span style="color:#000000; font-face:Geneva, Arial, Helvetica, sans-serif"><span style="background-color:#FFFF00;">Rooh</span>.<span style="color:#FF0000;">it</span></span></a>
    (<a href="http://wordpress.org/extend/plugins/roohit-plugin">for WordPress</a>)
    <br/><br/>';
}

$ROOH_WDGT = 0 ;
$ROOH_BOX = 0 ;
$ROOH_BTN = 0 ;
/*
* @return string
* @param  void
* @desc   Checks the browser and version of the client
*/
function rh_chkBrowser()
{
    $ua=$_SERVER['HTTP_USER_AGENT'];
    if     (strpos($ua,'MSIE 8.0') == true) {       $browserVer='IE8';      }
    elseif (strpos($ua,'MSIE 9.0') == true) {       $browserVer='IE9';      }
    elseif (strpos($ua,'MSIE 7.0') == true) {       $browserVer='IE7';      }
    elseif (strpos($ua,'MSIE 6.0') == true) {       $browserVer="IE6";      }
    elseif (strpos($ua,'Gecko') == true)    {       $browserVer="firefox";  }
    elseif (strpos($ua,'Chrome') == true)   {       $browserVer="Chrome";    }
    elseif (strpos($ua,'Safari') == true)   {       $browserVer="Safari";    }
    else $browserVer = "unknown" ;
    return $browserVer ;
}

/*
* @return boolean
* @param  string $link
* @desc   .berpr.ft die angegeben URL auf Erreichbarkeit (HTTP-Code: 200)
*/
function rh_url_validate( $link ) {
  $url_parts = @parse_url( $link );
  if ( empty( $url_parts["host"] ) ) return( false );
  if ( !empty( $url_parts["path"] ) ) {
    $documentpath = $url_parts["path"];
  } else {
    $documentpath = "/";
  }
  if ( !empty( $url_parts["query"] ) ) {
    $documentpath .= "?" . $url_parts["query"];
  }
  $host = $url_parts["host"];
  $port = $url_parts["port"];
  // Now (HTTP-)GET $documentpath at $host";

  if (empty( $port ) ) $port = "80";
  $socket = @fsockopen( $host, $port, $errno, $errstr, 30 );
  if (!$socket) {
    return(false);
  } else {
    fwrite ($socket, "HEAD ".$documentpath." HTTP/1.0\r\nHost: $host\r\n\r\n");
    $http_response = fgets( $socket, 22 );
    if ( ereg("200 OK", $http_response, $regs ) ) {
      return(true);
      fclose( $socket );
    } else {
//                echo "HTTP-Response: $http_response<br>";
      return(false);
    }
  }
}
/*
* @return void
* @param  void
* @desc   SetsUp the Plugin
*/
function rh_roohSetup() {
  $blogurl = urlencode(get_bloginfo('url')) ;   // RC thinks this will fetch the URL of the home page, not the site 
  $owners_email = urlencode(get_bloginfo('admin_email')) ;
  $blogTitle = urlencode(get_bloginfo('name')) ;
  $wp_version = urlencode(get_bloginfo('version')) ;
  $ROOH_WDGT = 0; $ROOH_BOX = 0; $ROOH_BTN = 0; 
  if(get_option('autopublish_trk') != '1'){
    $ROOH_WDGT = '1';
    update_option('autopublish_trk', '1');
  }
#  if(get_option('tweet_highlights_trk') != '1'){
#    $ROOH_BOX = '1';
#    update_option('tweet_highlights_trk', '1');
#  }
  if(get_option('instant_web_highlights_trk') != '1'){
    $ROOH_BTN = '1';
    update_option('instant_web_highlights_trk', '1');
  }
  if(get_option('tracking_done') != '1') {
    $trk = file_get_contents("http://roohit.com/wpRoohPlugin.php?blogurl=$blogurl&owners_email=$owners_email&blogTitle=$blogTitle&myHighlightsWidget=".$ROOH_WDGT."&box=".$ROOH_BOX."&btn=".$ROOH_BTN."&rnd=".rand()."&wp_version=$wp_version");
    wp_redirect(get_option('siteurl') . '/wp-admin/options-general.php?page=roohit-plugin/autopublish/autopublish.php');
    update_option('tracking_done', '1');
  }
}

?>
