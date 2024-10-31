<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/* 
* +--------------------------------------------------------------------------+
* | Copyright (c) 2006 onwards RoohIt           (email : support@roohit.com) |
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

if (!defined('MyHighlights_INIT')) 
   define('MyHighlights_INIT', 1);
else 
   return;

$DOMAIN_NAME = 'http://roohit.com' ;
// Define a constant indicating that Auto Pub. is enabled
define("AUTO_PUB_PLUGIN","Y", true);

// Pre-2.6 compatibility
if ( ! defined( 'WP_CONTENT_URL' ) )
      define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
      define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) )
      define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) )
      define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );

#include_once (AP_DIR.'roohUtilsDup.php') ;
#$ROOH_WDGT = 1 ;

define("ROOH_WDGT", "1");

$myhighlightspluginpath = WP_CONTENT_URL.'/plugins/'.plugin_basename(dirname(__FILE__)).'/';

$AUTOPUB_SIG_CMNT_BGN = "<!-- Begin My Highlights Widget Plugin by RoohIt -->" ;
$AUTOPUB_SIG_CMNT_END = "<!-- End My Highlights Widget Plugin by RoohIt -->" ;
include_once(RHAIO_PLUGIN_DIR."commons.inc.php");

add_action("wp_footer", "rh_showPoweredBy" );     // I have placed this function in an external file
add_action("wp_head", "rh_alertNewUser_head") ;
add_action("wp_footer", "rh_alertNewUser_footer") ;

$myhighlights_settings = array(   
                     array('enctickerid', '')
                     , array('tickerwidth', '')
                     , array('tickerheight', '')
                     , array('language', 'en')
                  );

$myhighlights_languages = array('zh'=>'Chinese', 'da'=>'Danish', 'nl'=>'Dutch', 'en'=>'English', 'fi'=>'Finnish', 'fr'=>'French', 'de'=>'German', 'he'=>'Hebrew', 'it'=>'Italian', 'ja'=>'Japanese', 'ko'=>'Korean', 'no'=>'Norwegian', 'pl'=>'Polish', 'pt'=>'Portugese', 'ru'=>'Russian', 'es'=>'Spanish', 'sv'=>'Swedish');

function ap_myHighlights_widget($args) {
   extract($args);
   $widget_options = get_option("widget_myHighlights");
   echo $before_widget;
   //echo $before_title . '<strong>What I\'m Reading...</strong>' . $after_title;
   //echo $before_title . '<strong>Look at this...</strong>' . $after_title;
   $widget_title = (!empty($widget_options['title'])) ? $widget_options['title'] : "See what I Am Reading..";
   echo $before_title . '<strong>'.$widget_title.'</strong>' . $after_title;
   echo '<div style="text-align: center;">';
   $enctickerid = get_option('myhighlights_enctickerid');

   $tickerwidth = get_option('myhighlights_tickerwidth');
   if ($tickerwidth == '') $tickerwidth = 220 ; 

   $tickerheight = get_option('myhighlights_tickerheight');
   if ($tickerheight == '') $tickerheight = 550 ; 


   $linkUrl = 'wp-admin/options-general.php?page=roohit-plugin/autopublish/autopublish.php' ;
   if ( current_user_can('edit_plugins') )   {}
   else
      $linkUrl = 'mailto:' . get_bloginfo('admin_email') . '?subject=Please configure your widget&body=Visit ' . get_bloginfo('url') .'/'. $linkUrl . '%0A to Personalize the look and feel of your AutoPublish Widget.' . '%0a%0A--%0AHighlighting technology powered for FREE using http://rooh.it' ;


    global $DOMAIN_NAME ;
    global $AUTOPUB_SIG_CMNT_BGN ;
    global $AUTOPUB_SIG_CMNT_END ;

    echo $AUTOPUB_SIG_CMNT_BGN ;
    echo '
        <span id="plsConfigure" style="display:none; height:20px; width:'.$tickerwidth.'px; color:#ffffff; background-color:#ff0000; vertical-align:middle; padding:5px; float:left; text-align:center;"><a href="'.$linkUrl.'" style="color:#ffffff;font-weight:bold;">Configure your widget</a></span>
        ' ;

   // Extra 10 pixels is being added for a cleaner display
   $tickerwidth += 10 ;

        // Call the Widget wrapper which will check for the user preference and return either Flash/HTML code
   $ticker_widget = file_get_contents($DOMAIN_NAME . "/site/s_widget_wrapper.php?kR7s7Gj8uTzx07=" . $enctickerid );
   if(strstr($ticker_widget,"s_widget.swf")) {
      echo $ticker_widget;
   } else {
      echo '<iframe src="'.$DOMAIN_NAME . "/site/s_widget_wrapper.php?kR7s7Gj8uTzx07=" . $enctickerid.'" frameBorder="0" border="0" style="height: '.($tickerheight).'px; width: '.($tickerwidth).'px; border: none; overflow: none;" scrolling="no"></iframe>';
   }
?>

    <script type="text/javascript" src="<?php echo $DOMAIN_NAME ;?>/site/4wp/wp_autoPub.php"></script>
    <script type="text/javascript" language="javascript">
   <?php 
      if ( (false == $enctickerid) || (enctickerid == '') )
      {
      ?>   
         // Ask user to configure his/her widget
         elemid = document.getElementById('plsConfigure').style ;
         elemid.display='' ;
   
         // Make the background behind our widget red to indicate error/draw user's attention to this
         elemid = document.getElementById('myHighlightsWidget').style ;
         elemid.backgroundColor='red' ;
      <?php
      }
   ?>
   </script>
    
<?php
     echo '
         <!-- RoohIt Button BEGIN -->
         <div style="text-align:center;">
             <a id="roohitBtn" href="http://roohit.com/go" title="Highlight It"><img src="http://roohit.com/images/btns/h20/01_HTP.png" alt="Highlight It"
style="border:none;"></img></a>
         </div>
         <script type="text/javascript" src="http://roohit.com/site/btn.js"></script>
         <!-- RoohIt Button END -->
     ' ;

   echo $AUTOPUB_SIG_CMNT_END ;

   // Lets update the DB with the fact that the widget has been displayed again
   $viewed_count = get_option('myhighlights_viewedCount') ;
   update_option('myhighlights_viewedCount', $viewed_count+1);
   echo '</div>';
   echo $after_widget;
   // after_widget should be displayed here
}

function ap_myHighlights_widget_control(){
  $options = get_option("widget_myHighlights");
  if (!is_array( $options )) {
    $options = array(
      'title' => "What I'm Reading"
    );
  }
  if ($_POST['myHighlights-Submit']) {
    $options['title'] = htmlspecialchars($_POST['myHighlights-WidgetTitle']);
    update_option("widget_myHighlights", $options);
  }
  ?>
  <p>
    <label for="myHighlights-WidgetTitle">Widget Title: </label>
    <input type="text" id="myHighlights-WidgetTitle" name="myHighlights-WidgetTitle" value="<?php echo $options['title'];?>" />
    <input type="hidden" id="myHighlights-Submit" name="myHighlights-Submit" value="1" />
  </p>
  <p><a href="options-general.php?page=roohit/autopublish/autopublish.php">My Highlights Settings</a></p>
  <?php
}

function ap_init_myHighlights(){
    global $myhighlights_settings ;

    add_action("plugins_loaded", "ap_init_myHighlights");
    register_sidebar_widget("My Highlights", "ap_myHighlights_widget");
    register_widget_control("My Highlights", "ap_myHighlights_widget_control");
    add_filter('admin_menu', 'ap_myHighlights_admin_menu');

    add_option('myhighlights_enctickerid');
    add_option('myhighlights_tickerwidth');
    add_option('myhighlights_tickerheight');

#    if (!isset($tweetRooh_inited)) $roohWidget_trked = get_option('roohWidget_trk');
#    if (strlen($roohWidget_trked) == 0)
#        rh_roohSetup() ;
#    else
#        $roohWidget_trked = '1';
}

add_action( 'init', 'ap_myHighlights_admin_warnings' );

function ap_myHighlights_admin_warnings() {
    //global $myhighlights_enctickerid;
      function ap_myHighlights_admin_warning() {
         //global $myhighlights_enctickerid;
         $myhighlights_enctickerid = get_option('myhighlights_enctickerid'); 
         if ( $myhighlights_enctickerid == '') {
            echo '<iframe src="options-general.php?page=roohit/autopublish/autopublish.php" style="display: none;"></iframe>';
         }
         $myhighlights_dragDone = get_option('myhighlights_viewedCount');
      }
   
add_action('admin_notices', 'ap_myHighlights_admin_warning');
//add_action('admin_notices', 'myHighlights_admin_wrong_settings');
return;
}


function ap_myHighlights_admin_menu()
{
    add_options_page('&#9658; AutoPublisher', '&#9658; AutoPublisher', 8, __FILE__, 'ap_myhighlights_plugin_options_php4');
}


function ap_myHighlights_plugin_options_php4() {
    global $DOMAIN_NAME ;
    global $myhighlights_enctickerid;
    global $myhighlights_tickerwidth;
    global $myhighlights_tickerheight;

    $options = get_rhaio_options();
    if(!$options or !is_array($options))
        $options = array(
            "ap_status" => "disabled",
            "iwh_status" => "disabled",
            "th_status" => "disabled"
        );
?>

<script type="text/javascript" language="javascript">
</script>
    <div class="wrap" style="height:1160px;"><!--height:990px-->
         <div id="wp_header"><strong>Rooh.it: instant web Highlighter</strong> <br/>Distribute cool highlights, drive new users to your Site
        <hr />             
        </div>

    <!--
    <div align="center" id="message" class="updated fade" style="padding:5px;">
        <span style='float:left; font-weight:bold;'><a href='options-general.php?page=roohit-plugin/instant-web-highlighter/instant-web-highlighter.php'>Instant Highlighter</a></span>
        <span><a href="mailto:support@roohit.com?subject=WordPress: My Highlights Plugin Feedback">Tell us</a> what you think of this plugin <b>please</b></span>
        <span style='float:right; font-weight:bold;'><a href='options-general.php?page=roohit-plugin/tweet-highlights/tweet-highlights.php'>Sidebar Pen</a></span>
    </div>
    -->
    <div id="left_pane"> 
    <div id="rooh_tabs" style="padding: 20px 5px 20px 0px; width:633px;">
        
      <ul>
                <li style='font-weight:bold;'>
                <a href='options-general.php?page=rhaio-options'><img src='<?php echo $DOMAIN_NAME;?>/site/4wp/images/ic_home.png' border='0' alt='Home' title='Home' />&nbsp;</a>
                </li>

                <?php if (isset($options['iwh_status']) and $options['iwh_status'] == "enabled") { ?>
            <li style='font-weight:bold;'> 
                    <a href='options-general.php?page=roohit-plugin/instant-web-highlighter/instant-web-highlighter.php'>Instant Highlighter</a>
            </li>    
                <?php } else { ?>
            <li style='font-weight:normal;' > 
                    <a href='options-general.php?page=rhaio-options' style='color:#aaa;' onClick='alert("Please ENABLE the Instant Highlighter to personalize it.");'>Instant Highlighter</a>
            </li>    
                <?php } ?>

                <?php if (isset($options['ap_status']) and $options['ap_status'] == "enabled") { ?>
                <li class="current" style='font-weight:bold;'>
                    <a class="current" href='options-general.php?page=roohit-plugin/autopublish/autopublish.php'>AutoPublisher</a>
                </li> 
                <?php } else { ?>
            <li style='font-weight:normal;' > 
                    <a href='options-general.php?page=rhaio-options' style='color:#aaa;' onClick='alert("Please ENABLE the AutoPublisher to personalize it.");'>AutoPublisher</a>
            </li>    
                <?php } ?>
               
                <?php if (isset($options['th_status']) and $options['th_status'] == "enabled") { ?>
                <li align='right' width='33%' style='font-weight:bold;'>
                    <a href='options-general.php?page=roohit-plugin/tweet-highlights/tweet-highlights.php'>Sidebar Pen</a>
                </li>
                <?php } else { ?>
            <li style='font-weight:normal;' > 
                    <a href='options-general.php?page=rhaio-options' style='color:#aaa;' onClick='alert("Please ENABLE the Sidebar Pen to personalize it.");'>Sidebar Pen</a>
            </li>    
                <?php } ?>
            
        </ul>
    </div>


   <?php require_once RHAIO_PLUGIN_DIR.'js/roohUtils.js' ; ?>

    <!--<h3>My Highlights Ticker Options</h3>-->
   
   <div class="option_container">

<style>
a.save_changes{
   color:#FF3300; text-decoration:underline; cursor:pointer;
}
a.save_changes:hover{
   color:#21759B; text-decoration:none;
}
</style>

    <form method="post" action="options.php" name="autoPublish">
<?php 
   $enctickerid = get_option('myhighlights_enctickerid');
   $tickerwidth = get_option('myhighlights_tickerwidth');
   if ($tickerwidth == '') $tickerwidth = 210 ; 
   $tickerheight = get_option('myhighlights_tickerheight');
   if ($tickerheight == '') $tickerheight = 550 ;  
?>

    <?php wp_nonce_field('update-options'); ?>


      <?php
      if ($enctickerid == '') { ?>
      <div class="row text_center" style="text-align:center; line-height:20px; padding-top:10px; padding-bottom:10px; background:#FFFFFF; border:1px dashed #CCCCCC;">
         Please make sure to <input class="button-primary" type="submit" name="Submit" value="<?php _e('Save Changes') ?>" /></center>
      </div>
      <?php } else {  /*?>
         If you <strong>change the Height & Width</strong> of your widget, please <strong><a class="save_changes" onClick='window.location.reload()'>SAVE YOUR CHANGES</a></strong>
         <br />(all other changes will <em>take effect immediately and automatically</em>).<br />
      <?php */ } ?>       
      
        <!--
        <span class="row text_center" style="text-align:left; float:left; width:50%; line-height:20px; padding-top:5px; padding-bottom:10px; margin-top    :3px;">
            <a href="mailto:support@roohit.com?subject=WordPress: My Highlights plugin Feedback">Tell us</a> what you think of this plugin <b>please</b>
        </span>
        -->
        <div>

      <div class="plg_box">
      <div class="inner" style="border-bottom:2px solid #6FC5F3; width:120px;">
        <div class="thumb">
         <img height="80px" border="0" src="http://roohit.com/site/images/aa/plg_auto_pub.png">
            <div class="thumb_preview">
                   <div class="thumb_preview_title" > Example Screenshot </div>
               <img src="<?php echo $DOMAIN_PATH ; ?>/site/images/aa/auto_pub_prvw.png" align="absmiddle" border="0" />
            </div>
        </div>
      </div>
      </div>
      <h2>You make highlights anywhere &rarr; <br />they are automatically Displayed on your site</h2>

         </div>
      

    <!--
    <script type="text/javascript" src="<?php echo $DOMAIN_NAME ;?>/js/commonJS.8.js"></script>
   <script>standardizeForDuplicateCookies();</script>
    -->
   <!--fermin 12/15/11 -->
   
    <div id="iframe" style="overflow:hidden;margin-top:15px;">
   <iframe id="RoolHits" src="<?php echo $DOMAIN_NAME;?>/site/s_lite_wp_narrow.php" style="margin-top:5px;" frameborder="0" width="640px"  height="820px" ></iframe> <!--width="640px" height="665" -->
    </div>

      <div class="row">
         <div class="option_col1 show_arrow">
            <input type="hidden" size="24" name="myhighlights_enctickerid" id="myhighlights_enctickerid" value="<?php echo $enctickerid; ?>"/>
         </div>

         <div class="option_col2 show_arrow">
                <input type="hidden" size="3" name="myhighlights_tickerwidth" id="myhighlights_tickerwidth" style='color:#999999;' value="<?php echo $tickerwidth; ?>" onClick="this.select(); this.style.color='#000000';"/>
         </div>

         <div class="option_col2 show_arrow">
                <input type="hidden" size="4" name="myhighlights_tickerheight" id="myhighlights_tickerheight" style='color:#999999;' value="<?php echo $tickerheight; ?>" onClick="this.select(); this.style.color='#000000';" />
         </div>
      </div>


         <!--<br /><span>If any value is blank:<em>first</em> <strong>Login</strong>, then <strong>Personalize</strong> (change the size, colors, font etc.) & <strong>Publish</strong> <a href='<?php echo $DOMAIN_NAME ;?>/site/s_lite.php'>directly from here</a>.<br/></span>-->

        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="myhighlights_enctickerid, myhighlights_tickerwidth, myhighlights_tickerheight "/>
    
    <!-- Get the enc4ticker cookie value and automatically set it in this installation of WP -->
    <script type="text/javascript" src="<?php echo $DOMAIN_NAME ;?>/site/4wp/wp_autoPub.php"></script>
    <script type="text/javascript" language="javascript">
    document.getElementById('myhighlights_enctickerid').value = enc4tickerCookie ;
    document.getElementById('myhighlights_tickerwidth').value = twidth ;
    document.getElementById('myhighlights_tickerheight').value = theight ;
    if ( (enc4tickerCookie != '<?php echo get_option('myhighlights_enctickerid') ; ?>' )  ||
       (twidth != '<?php echo get_option('myhighlights_tickerwidth') ; ?>' ) || 
       (theight != '<?php echo get_option('myhighlights_tickerheight') ;?>' ) 
   )
    {
        document.autoPublish.submit();
    }
    </script>
    
            <p class='submit'><input class='button-primary' onClick='window.location.reload()' name='submit' value="Save Height&nbsp;/&nbsp;Width"></p> 
   </form>
   </div><!-- end option_container--> 
   </div><!-- end left_pane-->

    
    <div id="right_pane">
    <?php include_once(RHAIO_PLUGIN_DIR."right_pane.php");?>

    <div id="tipsbox" class="stylebox">
        <h2 class="tips text_center" style="padding-left:8px;">Tips:</h2>
       <p>1. Settings not being saved? Make a <a href="http://roohit.com/google.com" target="_blank">highlight</a> and then return here.</p> 
      <p>2. Can't see the AutoPublish widget? Go to '<em>Appearance->Widgets</em>' and <strong>Drag the '<em>My Highlights</em>' box to your Sidebar</strong><br> (<a href="http://roohit.com/images/wp/AutoPub_Drag_and_Drop.png" target="_blank">see screenshot</a>)</p><br>

    </div><!--end tipsbox -->

    </div><!--end right_pane-->
    </div>   
      
<?php
}

ap_init_myHighlights() ;

/*
* @return array
* @param  array haystack, mixed needle
* @desc   Delete an element from the array
*/
function ap_array_delete_elements($array, $element) {
  foreach($array as $k=>$v) {
    if($v == $element) 
      unset($array[$k]);
  }
  return $array;
}

/*
* @return void
* @param  void
* @desc   Activate the Auto Publish Widget
*/
function ap_activateAutoPublishWidget() {
  $this_widget = 'my-highlights';
  $sidebar_widgets = wp_get_sidebars_widgets();
  $theme_sidebar_defaults = wp_get_widget_defaults();
  $theme_first_sidebar = "";
  $c = 0;
  foreach($theme_sidebar_defaults as $k=>$v) {
    if($c == 0) {
      $theme_first_sidebar = $k;
      break;
    }
  }
  $sidebar_widgets['wp_inactive_widgets'] = ap_array_delete_elements($sidebar_widgets['wp_inactive_widgets'], $this_widget);
  $sidebar_widgets['wp_inactive_widgets'] = array_values($sidebar_widgets['wp_inactive_widgets']);
  if($theme_first_sidebar) {
    if(isset($sidebar_widgets[$theme_first_sidebar])) {
      if(!in_array($this_widget, $sidebar_widgets[$theme_first_sidebar])) 
        array_unshift($sidebar_widgets[$theme_first_sidebar], $this_widget);
    } else {
      $sidebar_widgets[$theme_first_sidebar] = array($this_widget);
    }
    wp_set_sidebars_widgets( $sidebar_widgets );
  }
  return true;
}


/*
* @return void
* @param  void
* @desc   Add Auto Publish Widget Activation Action
*/
function ap_addAPWidget() {
  global $pagenow;
  if ( is_admin() && isset($_GET['activated']) && $pagenow == 'themes.php' ) {
    ap_activateAutoPublishWidget();
  } elseif(get_option("autopublish_widget_added") != "1") {
    ap_activateAutoPublishWidget();
    update_option("autopublish_widget_added", "1");
  }
}
add_action('shutdown', 'ap_addAPWidget');
?>
