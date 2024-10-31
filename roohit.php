<?php
/*
Plugin Name: Rooh.it Highlighter, AutoPublisher, and Sidebar Pen
Plugin URI: http://roohit.com/site/wpPlugins.php
Description: Add a Highlighter: Saves, Shares, Cites, Distributes, Posts, Publishes & Generates links to your site.
Version: 6.8.7
Author: Rooh.it
Author URI: http://roohit.com
*/
/*
* +--------------------------------------------------------------------------+
* | Copyright (c) 2006 onwards Rooh.it           (email : support@roohit.com) |
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

/* vim: set expandtab tabstop=4 shiftwidth=4: */
error_reporting(NULL);

# Define Globals Start
define("RHAIO_PLUGIN_DIR", dirname(__file__)."/" );
define("AP_DIR", dirname(__file__)."/autopublish/" );
define("IWH_DIR", dirname(__file__)."/instant-web-highlighter/" );
define("TH_DIR", dirname(__file__)."/tweet-highlights/" );

define("RHAIO_PLUGIN_URL", get_bloginfo('url')."/wp-content/plugins/roohit-plugin/");
# Declare Globals End

register_activation_hook(__FILE__, 'activate_roohit');
register_deactivation_hook(__FILE__, 'deactivate_roohit');

add_action('admin_menu', 'rhaio_options_menu');
add_action('init', 'enque_jquery');

include_once(ABSPATH.'/wp-admin/includes/plugin.php');
$redir = false;
if (is_plugin_active('instant-web-highlighter/roohit.php')) {
//Ajax call and other logic can be put here.
deactivate_plugins('instant-web-highlighter/roohit.php', true);
$redir = true;
}
if (is_plugin_active('tweet-highlights/tweetRooh.php')) {
//Ajax call and other logic can be put here.
deactivate_plugins('tweet-highlights/tweetRooh.php', true);
$redir = true;
}
if (is_plugin_active('autopublish/autoPublish.php')) {
//Ajax call and other logic can be put here.
deactivate_plugins('autopublish/autoPublish.php', true);
$redir = true;
}


function enque_jquery() {
  wp_enqueue_script('jquery');

  $ua=$_SERVER['HTTP_USER_AGENT'];
  //if ( strpos(strpos($ua,'MSIE 5.0') == true || strpos($ua,'MSIE 6.0') == true  || $ua,'MSIE 7.0') == true || strpos($ua,'MSIE 8.0') == true ) {
  //if ( strpos($ua,'MSIE 5.0') == true || strpos($ua,'MSIE 6.0') == true  || strpos($ua,'MSIE 7.0') == true || strpos($ua,'MSIE 8.0') == true ) {
  if ( strpos($ua,'MSIE') == true ) {
      wp_register_style('roohit-plugin-ie.3.css', RHAIO_PLUGIN_URL . 'roohit-plugin-ie.3.css');
      wp_enqueue_style('roohit-plugin-ie.3.css');
  } else {
      wp_register_style('roohit-plugin.3.css', RHAIO_PLUGIN_URL . 'roohit-plugin.3.css?'.rand() );
      wp_enqueue_style('roohit-plugin.3.css');
  }
}
/*
* @return void
* @param  void
* @desc   Run on the Plugin Deactivation
*/
function deactivate_roohit() {
  delete_option("tracking_done");
  delete_option("autopublish_widget_added");

  $blogurl = urlencode(get_bloginfo('url')) ;   // RC thinks this will fetch the URL of the home page, not the site
  $owners_email = urlencode(get_bloginfo('admin_email')) ;
  //$blogTitle = urlencode(get_bloginfo('name')) ;
  //$wp_version = urlencode(get_bloginfo('version')) ;
  $pl_status = 'Deactivated' ;
  $trk = file_get_contents("http://roohit.com/wpRoohPlugin.php?pl_status=$pl_status&blogurl=$blogurl&owners_email=$owners_email&blogTitle=$blogTitle&myHighlightsWidget=".$ROOH_WDGT."&box=".$ROOH_BOX."&btn=".$ROOH_BTN."&rnd=".rand()."&wp_version=$wp_version");
}
/*
* @return void
* @param  void
* @desc   Get the Plugin Options
*/
function get_rhaio_options() {
  $rhaio_status = get_option('rhaio_status');
  if(is_array($rhaio_status)) return $rhaio_status;
  else return unserialize($rhaio_status);
}
/*
* @return array
* @param  void
* @desc   Sets the Plugin Options
*/
function set_rhaio_options($data) {
  if(is_array($data)) {
    $update_data = array(
                        "ap_status" => $data['ap_status'],
                        "iwh_status" => $data['iwh_status'],
                        "th_status" => $data['th_status']
                        );
    update_option('rhaio_status', serialize($update_data));
  }
}
/*
* @return void
* @param  void
* @desc   Run on the Plugin Activation
*/
function activate_roohit() {
  $rhaio_status = get_option('rhaio_status');
  if(!$rhaio_status) set_rhaio_options(array( "ap_status" => 'enabled', "iwh_status" => 'enabled', "th_status" => 'enabled' ));
}
/*
* @return void
* @param  void
* @desc   Add Options Menu
*/
function rhaio_options_menu() {
    add_options_page('RoohIt', 'ROOH.IT', 'manage_options', 'rhaio-options', 'rhaio_options');
    add_menu_page('Rooh.it', 'Rooh.it', 'manage_options', 'rhaio-options', 'rhaio_options', 'http://roohit.com/site/4wp/rooh_favicon2_1.png' );
  if ( version_compare( $wp_version, '2.8', '>=' ) )
  {
  } else
  {
  }
  /*
  */
}
/*
* @return void
* @param  void
* @desc   Options Page Form
*/
function rhaio_options() {
  if (!current_user_can('manage_options'))  {
    wp_die( __('You do not have sufficient permissions to access this page.') );
  }
  if($_POST) {
    set_rhaio_options($_POST);
    ?>
    <div class="updated settings-error" id="setting-error-rhaio-settings_updated">
      <p>
        <strong>Settings saved.
         <meta http-equiv="refresh" content="0;url=<?= $_SERVER['PATH_INFO']; ?>">
        </strong>
      </p>
    </div>
    <?php
  }
  $options = get_rhaio_options();
  if(!$options or !is_array($options))
    $options = array(
                      "ap_status" => "disabled",
                      "iwh_status" => "disabled",
                      "th_status" => "disabled"
                      );
  ?>
  <script type="text/javascript">
    jQuery(function(){
      jQuery("input.change_status").click(function(){
        jQuery(this).parents('form:first').submit();
      });
    });
  </script>
   <?php
   $insthl_thumbnail = '
    <div class="plg_box">
    <div class="inner" style="border-bottom:2px solid #6FC5F3; width:120px;">
      <div class="thumb">
        <img height="80px" border="0" src="http://roohit.com/site/images/aa/plg_inst_hl.png" />
            <div class="thumb_preview">
               <img src="' . $DOMAIN_PATH . '/site/images/aa/inst_hl_prvw.png" align="absmiddle" border="0" />
            </div>
      </div>
    </div>
    </div>
    ' ;
   $insthl_thumbnail = "<img src='http://roohit.com/site/images/aa/plg_inst_hl.png' border='0' height='80px'/>" ;
   $ap_thumbnail = '
   <div class="plg_box">
    <div class="inner" style="border-bottom:2px solid #6FC5F3; width:120px;">
      <div class="thumb">
        <img height="80px" border="0" src="http://roohit.com/site/images/aa/plg_auto_pub.png">
            <div class="thumb_preview">
               <img src="' . $DOMAIN_PATH . '/site/images/aa/auto_pub_prvw.png" align="absmiddle" border="0" />
            </div>
      </div>
    </div>
   </div>
   ' ;
   $ap_thumbnail = "<img src='http://roohit.com/site/images/aa/plg_auto_pub.png' border='0' height='80px'/>" ;
   $tw_thumbnail = '
   <div class="plg_box">
    <div class="inner" style="border-bottom:2px solid #6FC5F3; width:120px;">
      <div class="thumb">
        <img height="80px" border="0" src="http://roohit.com/site/images/aa/plg_tw_hl.png">
            <div class="thumb_preview">
               <img src="' . $DOMAIN_PATH . '/site/images/aa/tw_hl_prvw.png" align="absmiddle" border="0" />
            </div>
      </div>
    </div>
   </div>
   ' ;
   $tw_thumbnail = "<img src='http://roohit.com/site/images/aa/plg_tw_hl.png' border='0' height='80px'/>" ;
  ?>
   <div class="wrap">
      <div id="wp_header"><strong>Rooh.it: instant web Highlighter</strong> <br/>Distribute cool highlights, drive new users to your Site
           <hr />
       </div>

    <!-- <h2>Highlighter, AutoPublisher (show My-Highlights), AutoTweet (from Sidebar)</h2> -->
      <div id="left_pane">
         <div id="rooh_tabs" style="padding: 20px 5px 20px 0px;">
            <ul>
                  <li style='font-weight:bold;'>
                                                <a class="current" href='options-general.php?page=rhaio-options'><img src='http://roohit.com/site/4wp/images/ic_home.png' border='0' alt='Home' title='Home' />&nbsp;</a>
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
                  <li style='font-weight:bold;'>
                     <a href='options-general.php?page=roohit-plugin/autopublish/autopublish.php'>AutoPublisher</a>
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
            <li style='font-weight:normal;'>
                     <a href='options-general.php?page=rhaio-options' style='color:#aaa;' onClick='alert("Please ENABLE the Sidebar Pen to personalize it.");'>Sidebar Pen</a>
            </li>
            <?php } ?>
            <!--
            <li align='center'>
                     <a href="mailto:support@roohit.com?subject=WordPress: Instant Highlighter Plugin Feedback">Tell us</a> what you think of this plugin <b>please</b>
                  </li>
                  <li id='rooh_icon' style="padding: 5px -5px 10px 0px ;">
                     <a href='http://roohit.com/forum/viewforum.php?f=53' target='rooh'><img src='http://yankton.fdconline.net/img/lib/metaHeadings/Government_and_Community.png' border='0'/></a>
                  </li>
            -->
            </ul>
         </div>
         <form action="" method="post">
           <table class="form-table">
            <tbody>
              <tr valign="middle">
               <td width='80px'>
            <?= ((isset($options['iwh_status'])) and $options['iwh_status'] == "disabled") ? $insthl_thumbnail : "<a href='options-general.php?page=roohit-plugin/instant-web-highlighter/instant-web-highlighter.php' title='Personalize'>" . $insthl_thumbnail . "</a>" ?></td>
      <!-- onClick=\"document.getElementById('iwh_status_enabled').checked='checked'; -->
               <td width='130px'><strong>Instant Highlighter</strong><br/>(Horizontal Pen)</td>
               <td width="150px">
                 <label for="iwh_status_enabled">
                  <input type="radio"<?= ((isset($options['iwh_status'])) and $options['iwh_status'] == "enabled") ?
                    ' checked="checked"' : "" ?> value="enabled" id="iwh_status_enabled" name="iwh_status" class="change_status" />
              <?= ((isset($options['iwh_status'])) and $options['iwh_status'] == "disabled") ? "<span style='color:red'>Enable</span>" : "Enabled" ?>
                 </label>
                 <label for="iwh_status_disabled">
                  <input type="radio"<?= ((isset($options['iwh_status'])) and $options['iwh_status'] == "disabled") ?
                    ' checked="checked"' : "" ?> value="disabled" id="iwh_status_disabled" name="iwh_status" class="change_status" />
                   Disable
                 </label>
               </td>
               <td>
                 <?php if((isset($options['iwh_status'])) and $options['iwh_status'] == "enabled") { ?>
                 <a href="options-general.php?page=roohit-plugin/instant-web-highlighter/instant-web-highlighter.php" style="font-size:18px">Personalize</a>
                 <?php } else {  ?>
                 <img src='http://roohit.com/images/wp/red_arrow.png' height='36px'/>
              <?php } ?>
               </td>
              </tr>

              <tr valign="middle">
               <td width='80px'>
            <?= ((isset($options['ap_status'])) and $options['ap_status'] == "disabled") ? $ap_thumbnail : "<a href='options-general.php?page=roohit-plugin/autopublish/autopublish.php' title='Personalize'>" . $ap_thumbnail . "</a>" ?></td>
               <td width='130px'><strong>AutoPublisher</strong><br/>(show My-Highlights)</td>
               <td>
                 <label for="ap_status_enabled">
                  <input type="radio"<?= ((isset($options['ap_status'])) and $options['ap_status'] == "enabled") ?
                    ' checked="checked"' : "" ?> value="enabled" id="ap_status_enabled" name="ap_status" class="change_status" />
                   <?= ((isset($options['ap_status'])) and $options['ap_status'] == "disabled") ? "<span style='color:red'>Enable</span>" : "Enabled" ?>
                 </label>
                 <label for="ap_status_disabled">
                  <input type="radio"<?= ((isset($options['ap_status'])) and $options['ap_status'] == "disabled") ?
                    ' checked="checked"' : "" ?> value="disabled" id="ap_status_disabled" name="ap_status" class="change_status" />
                   Disable
                 </label>
               </td>
               <td>
                 <?php if((isset($options['ap_status'])) and $options['ap_status'] == "enabled") { ?>
                 <a href="options-general.php?page=roohit-plugin/autopublish/autopublish.php" style="font-size:18px">Personalize</a>
                 <?php } else {  ?>
                 <img src='http://roohit.com/images/wp/red_arrow.png' height='36px'/>
              <?php } ?>
               </td>
              </tr>

              <tr valign="middle">
               <td width='80px'>
            <?= ((isset($options['th_status'])) and $options['th_status'] == "disabled") ? $ap_thumbnail : "<a href='options-general.php?page=roohit-plugin/tweet-highlights/tweet-highlights.php' title='Personalize'>" . $tw_thumbnail . "</a>" ?></td>
               <td width='130px'><strong>Sidebar Pen</strong><br/>(Vertical Pen)</td>
               <td>
                 <label for="th_status_enabled">
                  <input type="radio"<?= ((isset($options['th_status'])) and $options['th_status'] == "enabled") ?
                    ' checked="checked"' : "" ?> value="enabled" id="th_status_enabled" name="th_status" class="change_status" />
             <?= ((isset($options['th_status'])) and $options['th_status'] == "disabled") ? "<span style='color:red'>Enable</span>" : "Enabled" ?>
                 </label>
                 <label for="th_status_disabled">
                  <input type="radio"<?= ((isset($options['th_status'])) and $options['th_status'] == "disabled") ?
                    ' checked="checked"' : "" ?> value="disabled" id="th_status_disabled" name="th_status" class="change_status" />
                   Disable
                 </label>
               </td>
               <td>
                 <?php if((isset($options['th_status'])) and $options['th_status'] == "enabled") { ?>
                 <a href="options-general.php?page=roohit-plugin/tweet-highlights/tweet-highlights.php" style="font-size:18px">Personalize</a>
                 <?php } else {  ?>
                 <img src='http://roohit.com/images/wp/red_arrow.png' height='36px'/>
              <?php } ?>
               </td>
              </tr>

            </tbody>
           </table>
           <p class="submit" align="center">
            <input type="submit" value="Save Changes" class="button-primary" name="Save">
           </p>
         </form>
      </div><!--endl left_pane -->
      <div id="right_pane">
       <?php include_once(RHAIO_PLUGIN_DIR."right_pane.php");?>
      </div>
  </div>
  <?php
}

//add_action('wp_dashboard_setup', 'roohit_dashboard_widgets');


/*
* @return void
* @param  void
* @desc   Sets-up Dashboard Widgets
*/
function roohit_dashboard_widgets() {
  global $wp_meta_boxes;
  wp_add_dashboard_widget('roohit_latest_highlights_widget', 'Latest Highlights', 'roohit_latest_highlights');
  wp_add_dashboard_widget('tips_from_roohit_widget', 'Tips from RoohIt', 'tips_from_roohit');
}

/*
* @return string url
* @param  void
* @desc   Displays RSS Feeds
*/
function display_rss($url) {
  include_once(ABSPATH . WPINC . '/feed.php');
  $rss = fetch_feed($url);
  if (!is_wp_error( $rss ) ){
    $maxitems = $rss->get_item_quantity(5);
    $rss_items = $rss->get_items(0, $maxitems);
  }
  ?>
  <ul>
    <?php if ($maxitems == 0) echo '<li>No items.</li>';
    else
    // Loop through each feed item and display each item as a hyperlink.
    foreach ( $rss_items as $item ) : ?>
    <li>
        <a href='<?php echo $item->get_permalink(); ?>'
        title='<?php echo 'Posted '.$item->get_date('j F Y | g:i a'); ?>'>
        <?php echo $item->get_title(); ?></a>
    </li>
    <?php endforeach; ?>
  </ul>
  <?php
}

/*
* @return void
* @param  void
* @desc   The RoohIt Latest HighLights callback
*/
function roohit_latest_highlights() {
  display_rss("http://roohit.com/site/wp/dashrss.php"); # Change the Feed URL accordingly
}

/*
* @return void
* @param  void
* @desc   The Tips From RoohIt callback
*/
function tips_from_roohit() {
  display_rss("http://wordpress.org/news/feed/"); # Change the Feed URL accordingly
}

$get_rhaio_status = get_rhaio_options();

if( (isset($get_rhaio_status)) and $get_rhaio_status['iwh_status'] == "enabled" ) {
# Enable Instant Web Highlighter
  include_once("instant-web-highlighter/instant-web-highlighter.php");
}

if( (isset($get_rhaio_status)) and $get_rhaio_status['ap_status'] == "enabled" ) {
# Enable AutoPublish
  include_once("autopublish/autopublish.php");
} else {
  delete_option("autopublish_widget_added");
}

if( (isset($get_rhaio_status)) and $get_rhaio_status['th_status'] == "enabled" ) {
# Enable Tweet Highlights
  include_once("tweet-highlights/tweet-highlights.php");
}

function rhaio_settings_link($links) {
  $settings_link = '<A href="options-general.php?page=rhaio-options" title="Personalize to your liking">Personalize</A>';
  array_unshift($links, $settings_link);
  return $links;
}

function rhaio_donate_link($links) {
  $donate_link = '<A href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7137089" target="_blank" title="Support the developers of this plugin">Donate</A>';
  array_push($links, $donate_link);
  return $links;
}
$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'rhaio_donate_link' );
add_filter("plugin_action_links_$plugin", 'rhaio_settings_link' );
if ( version_compare( $wp_version, '2.8', '>=' ) ) {
//add_filter( 'plugin_row_meta', array( $this, 'rhaio_donate_link' ), 10, 2 ); // only 2.8 and higher
}

?>
