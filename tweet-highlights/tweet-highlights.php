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

require_once(TH_DIR.'rooh_vBtns.php') ;
include_once (TH_DIR.'rooh_hBtns.php') ;
//include_once (TH_DIR.'roohUtils.php') ;

$pathToBtns = "http://roohit.com/images/btns/v3/" ;

$tweetRooh_settings = array( array('offsetFromTop', ''), array('onRight', ''), array('buttonLook', '') );


define("TWT_HL_PLUGIN","Y", true);
include_once(RHAIO_PLUGIN_DIR."commons.inc.php");

add_action("plugins_loaded", "th_tweetRooh_init");
add_action("admin_menu", "th_tweetRooh_admin_menu");
add_action("wp_footer", "rh_showPoweredBy" );     // I have placed this function in an external file

$ROOH_BTN = 1 ;        // IMPORTANT: This should be AFTER the include of roohUtil.php

function th_tweetRooh_init()
{
    global $tweetRooh_hideHorz ;

    add_action( 'get_footer', 'th_getTRSnippet' );        // I have placed this function in an external file

    //register_sidebar_widget(__('Tweet Highlights'), 'widget_tweetRooh');

    // Add the user defined settings
  add_action("wp_head", "rh_alertNewUser_head") ;
  add_action("wp_footer", "rh_alertNewUser_footer") ;

    th_getTRUserSettings() ;

    /*
    if (!isset($tweetRooh_hideHorz)) $tweetRooh_hideHorz = get_option('tweetRooh_hideHorz');
    if ($tweetRooh_hideHorz == '') {
        add_filter('the_content', 'th_getHorzBtnSnippetTH');
        add_filter('the_excerpt', 'th_getHorzBtnSnippetTH');
    }
    */
    update_option('tweet_highlights_trk', '0');
    rh_roohSetup();
}


function th_tweetRooh_admin_menu() {
        $plugin = plugin_basename(__FILE__) ;
        add_options_page("&#9658; Sidebar Pen", "&#9658; Sidebar Pen", 8, "$plugin", "th_tweetRooh_settings");
    /*
    if ( version_compare( $wp_version, '2.8', '>=' ) ) {
    } else {
    //add_submenu_page('options.php', "&#9658; Sidebar Pen", "&#9658; Sidebar Pen", 8, "$plugin", "th_tweetRooh_settings");
    //add_submenu_page("fb-like-button", 'Easy-and-Quick-Installation', __('Installation', gxtb_fb_lB_lang), $this->pagelevel, 'fb-like-button');
    }
    */
}


function th_tweetRooh_settings() {
    global $pathToBtns ;
    global $tweetRooh_buttonStyles ;
    global $tweetRooh_offsetFromTop;
    global $tweetRooh_onRight;
    global $tweetRooh_buttonLook;
    global $tweetRooh_hideHorz ;

    $options = get_rhaio_options();
    if(!$options or !is_array($options))
        $options = array(
            "ap_status" => "disabled",
            "iwh_status" => "disabled",
            "th_status" => "disabled"
        );
?>
    <div class="wrap" style="height:2970px">
        <div id="wp_header"><strong>Rooh.it: instant web Highlighter</strong> <br/>Distribute cool highlights, drive new users to your Site
            <hr />
        </div>

    <!--
    <div align="center" id="message" class="updated fade" style="padding:5px;">
        <span style='float:left; font-weight:bold;'><a href='options-general.php?page=roohit-plugin/instant-web-highlighter/instant-web-highlighter.php'>Instant Highlighter</a></span>
        <span><a href="mailto:support@roohit.com?subject=WordPress: Tweet Highlights Plugin Feedback">Tell us</a> what you think of this plugin <b>please</b></span>
        <span style='float:right; font-weight:bold;'><a href='options-general.php?page=roohit-plugin/autopublish/autopublish.php'>AutoPublisher</a></span>
    </div>
    -->
    <div id="left_pane">
    <div id="rooh_tabs" style="padding: 20px 5px 20px 0px;">
        <ul>
                <li style='font-weight:bold;'>
                    <a href='options-general.php?page=rhaio-options'><img src='http://roohit.com/site/4wp/images/ic_home.png' border='0' alt='Home' title='Home' />&nbsp;</a>
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
                    <a href='options-general.php?page=rhaio-options' style='color:#aaa;' onClick='alert("Please ENABLE the AutoPublisher to personalize it.");'>AutoPublish</a>
            </li>
                <?php } ?>

                <?php if (isset($options['th_status']) and $options['th_status'] == "enabled") { ?>
                <li align='right' width='33%' style='font-weight:bold;'>
                    <a class="current" href='options-general.php?page=roohit-plugin/tweet-highlights/tweet-highlights.php'>Sidebar Pen</a>
                </li>
                <?php } else { ?>
            <li style='font-weight:normal;' >
                    <a href='options-general.php?page=rhaio-options' style='color:#aaa;' onClick='alert("Please ENABLE the Sidebar Pen to personalize it.");'>Sidebar Pen</a>
            </li>
                <?php } ?>
        </ul>
    </div>

   <div class="plg_box">
   <div class="inner" style="border-bottom:2px solid #6FC5F3; width:120px;">
     <div class="thumb">
      <img height="80px" border="0" src="http://roohit.com/site/images/aa/plg_tw_hl.png">
         <div class="thumb_preview">
               <div class="thumb_preview_title" > Example Screenshot </div>
            <img src="<?php echo $DOMAIN_PATH ; ?>/site/images/aa/tw_hl_prvw.png" align="absmiddle" border="0" />
         </div>
     </div>
   </div>
   </div>
   <h2>Visitors highlight your pages &rarr; <br />and Share your site to <i>their</i> social networks (like Twitter, Facebook etc...)</h2>

    <form method="post" action="options.php">
    <?php wp_nonce_field('update-options'); ?>

    <center style="margin-top:20px;padding-bottom:20px;"><input class="button-primary" type="submit" name="Submit" value="<?php _e('Save Changes') ?>" /></center>

    <table class="form-table" style="width:650px">
        <tr valign="top">
            <th scope="row"><?php _e("Show on which Side:", 'tweetRooh_trans_domain' ); ?></th>
            <td>
                <input type="radio" name="tweetRooh_onRight" value='0' id="tweetRooh_onRight_0" <?php if ($tweetRooh_onRight == '0') echo 'checked=\"checked\"' ?> /> <?php _e("Left", 'tweetRooh_trans_domain' ); ?>
                <input type="radio" name="tweetRooh_onRight" value='1' id="tweetRooh_onRight_1" <?php if ($tweetRooh_onRight == '1') echo 'checked=\"checked\"' ?> /> <?php _e("Right (recommended)", 'tweetRooh_trans_domain' ); ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e("Offset from top of Page:", 'tweetRooh_trans_domain' ); ?></th>
            <td>
                <input type="text" name="tweetRooh_offsetFromTop" size="3" maxlength="3" value="<?=$tweetRooh_offsetFromTop?>" />px
            </td>
        </tr>
        <tr>
            <!-- We should also display the gallery of horizontal buttons so that user can pick one to his/her taste -->
            <th scope="row"><?php _e("Hide horizontal button:", 'tweetRooh_trans_domain' ); ?></th>
            <td>
                <input type="checkbox" <?php if ($tweetRooh_hideHorz == 'on') { echo "checked='checked'"; }?> name="tweetRooh_hideHorz" /> (Recommended it is NOT CHECKED)
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e("Pick Button Style:<br>(2nd image is displayed on mouse over.)", 'roohit_trans_domain' ); ?></th>
        <!--
            <td>
                <table><tbody>
                    <tr>
                        <td valign="top"><table><tbody>
                            <tr>
                                <td align="top" onClick="document.getElementById('tweetRooh_buttonLook_0').checked=true;" > <input type="radio" name="tweetRooh_buttonLook" value="twit_pen_icon" id="tweetRooh_buttonLook_0" <?php // ($tweetRooh_buttonStyles[0]['img'] == $tweetRooh_buttonLook ? "checked=\"checked\"" : "")?>  /> <img src="http://roohit.com/images/btns/v3/twit_pen_iconL.png" border="0" alt="Use this button on your page" style="border:none;"  align="top" onMouseOver="javascript:document.getElementById('tweetRooh_buttonLook_0').src='http://roohit.com/images/btns/v3/twit_pen_iconL.png_hover.png';" /> </td>
                            </tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr>
                                 <td align="top" onClick="document.getElementById('tweetRooh_buttonLook_1').checked=true;" > <input type="radio" name="tweetRooh_buttonLook" value="vPen" id="tweetRooh_buttonLook_1" <?php // ($tweetRooh_buttonStyles[1]['img'] == $tweetRooh_buttonLook ? "checked=\"checked\"" : "")?>  /> <img src="http://roohit.com/images/btns/v3/vPenL.png"  border="0" alt="Use this button on your page" style="border:none;"  align="top" onMouseOver="javascript:document.getElementById('tweetRooh_buttonLook_1').src='http://roohit.com/images/btns/v3/vPenL.png_hover.png';" /> </td>
                            <tr>
                        </tbody></table></td>

                        <td align="top" onClick="document.getElementById('tweetRooh_buttonLook_2').checked=true;" > <input type="radio" name="tweetRooh_buttonLook" value="twit_40" id="tweetRooh_buttonLook_2"<?php//  ($tweetRooh_buttonStyles[2]['img'] == $tweetRooh_buttonLook ? "checked=\"checked\"" : "")?>  /> <img src="http://roohit.com/images/btns/v3/twit_40L.png" border="0" alt="Use this button on your page" style="border:none;"  align="top" onMouseOver="javascript:document.getElementById('tweetRooh_buttonLook_2').src='http://roohit.com/images/btns/v3/twit_40L.png_hover.png';" /> </td>

                        <td align="top" onClick="document.getElementById('tweetRooh_buttonLook_3').checked=true;" > <input type="radio" name="tweetRooh_buttonLook" value="twit_33" id="tweetRooh_buttonLook_3"<?php // ($tweetRooh_buttonStyles[3]['img'] == $tweetRooh_buttonLook ? "checked=\"checked\"" : "")?> /> <img src="http://roohit.com/images/btns/v3/twit_33L.png" border="0" alt="Use this button on your page" style="border:none;"  align="top" onMouseOver="javascript:document.getElementById('tweetRooh_buttonLook_3').src='http://roohit.com/images/btns/v3/twit_33L.png_hover.png';" /> </td>

                    </tr>
                    <?php
                    /*
                    */
                    ?>
                </tbody></table>
            </td>
        -->
        </tr>
    </table>


    <table style="width:650px;"><tbody>
   <?php

                        $numOfBtnsInARow = 4 ;
                        $fileSuffix = '' ;
                        $numStyles = sizeof($tweetRooh_buttonStyles) ;
                        for ($i=0; $i < $numStyles; )
                        {
                            echo "<tr>";
                            for ($j=0; $j < $numOfBtnsInARow; $j++)
                            {
                                if ($i > $numStyles)
                                    break ;
                                if ( $j < $numOfBtnsInARow/2 )
                                    $fileSuffix = 'L' ;
                                $filename = $pathToBtns . $tweetRooh_buttonStyles[$i]['img'] . $fileSuffix . ".png" ;
                                $fileExists = rh_url_validate($filename) ;
                                if ( !$fileExists)
                                {
                                    $filename = $pathToBtns . $tweetRooh_buttonStyles[$i]['img'] . ".png" ;
                                    $fileExists = rh_url_validate($filename) ;
                                }

                                if ( $fileExists )
                                {
                                    echo "<td align=\"top\" onClick=\"document.getElementById('tweetRooh_buttonLook_$i').checked=true;\" > <input type=\"radio\" name=\"tweetRooh_buttonLook\" value=\"" . $tweetRooh_buttonStyles[$i]['img'] . "\" id=\"tweetRooh_buttonLook_$i\"". ($tweetRooh_buttonStyles[$i]['img'] == $tweetRooh_buttonLook ? "checked=\"checked\"" : "") . "/> " . "<img src=\"$filename\" border=\"0\" alt=\"Use this button on your page\" style=\"border:none;\"  align=\"top\" onMouseOver=\"javascript:document.getElementById('tweetRooh_buttonLook_$i').src='" . $filename . "_hover.png';\" /> </td>" ;
                                }
                                else
                                {
                                    $j-- ;
                                }
                                $i++ ;
                            }
                            echo "</tr>" ;
                        }

                    ?>

    </tbody></table>

<!-- end added by fermin -->



    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="tweetRooh_offsetFromTop, tweetRooh_onRight, tweetRooh_buttonLook, tweetRooh_hideHorz"/>

    <input class="button-primary" type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />

    </form>
    </div>

    <div id="right_pane">
    <?php include_once(RHAIO_PLUGIN_DIR."right_pane.php");?>
    </div> <!--end right_pane -->
    </div>

   <!--
    <h2>Like this plugin?      &nbsp;&nbsp;      <iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Ffacebook.com/GoRoohIt&amp;layout=button_count&amp;show_faces=false&amp;width=120&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:120px; height:21px;" allowTransparency="true"></iframe>   </h2>    <p>We'd certainly appreciate it if you could please:</p>    <ul>        <li>&nbsp;&nbsp;&nbsp;&nbsp;&bull; <strong><a href="http://wordpress.org/extend/plugins/roohit-plugin/">Give us a good rating</a></strong> on WordPress.org</li>        <li>&nbsp;&nbsp;&nbsp;&nbsp;&bull; <strong>Write a blog</strong> post <a href="<?php echo $DOMAIN_NAME ;?>/site/blogThis.php" target="_rooh">about Rooh.it</a> so other folks can find out about this nifty tool.</li>        <li>&nbsp;&nbsp;&nbsp;&nbsp;&bull; <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7137089"><img src="http://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0"></a> a token of your appreciation.</li>    </ul>    <h2>Need support?</h2>    <p>If you have any problems or good ideas, please talk about them in the <a href="http://roohit.com/forum/viewforum.php?f=66" target="_rooh">Support forums</a>.</p>        <h2>About</h2>    <p><em>Rooh</em> means <em>soul</em>. When you <em>Rooh it</em> you get to the soul of the page. </p>    <p>The no-signup, no-download, highlighter was conceived and created by Rohit Chandra and has been maintained by <a href="<?php echo $DOMAIN_NAME ;?>" target="_rooh">Rooh.it</a> since the very beginning.</p>
    </div>
-->

<?php
}
?>
