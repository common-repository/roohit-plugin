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

if( !defined( 'ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') )
    exit();
# Uninstall AutoPublish
delete_option('roohWidget_trk');
delete_option('myhighlights_enctickerid');
delete_option('myhighlights_tickerwidth');
delete_option('myhighlights_tickerheight');
# Uninstall TweetHighlights
delete_option('tweetRooh_trk');
delete_option('tweetRooh_onRight');
delete_option('tweetRooh_hideHorz');
delete_option('tweetRooh_buttonLook');
delete_option('tweetRooh_offsetFromTop');
# Uninstall Instant WebHighlighter
delete_option('roohit_style') ;
delete_option('roohit_hoverbox') ;
delete_option('roohit_language') ;
delete_option('roohit_label') ;
delete_option('roohit_btnText') ;
delete_option('roohit_options') ;
delete_option('roohit_hvrOptions_titleBg') ;
delete_option('roohit_hvrOptions_btmBg') ;
delete_option('instant_web_highlights_trk') ;
delete_option('tweet_highlights_trk') ;

#Header("location:http://www.surveymonkey.com/s/HF9QRKZ") ;
?>
