<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

/*
* +--------------------------------------------------------------------------+
* | Copyright (c) 2006 RoohIt                   (email : support@roohit.com) |
* +--------------------------------------------------------------------------+
*/

$TWTHL_SIG_CMNT_BGN = "<!-- Begin Tweet Highlights Plugin by RoohIt -->" ;
$TWTHL_SIG_CMNT_END = "<!-- End Tweet Highlights Plugin by RoohIt -->" ;

$default_Vbutton = 1 ;   // index in array
$default_offset_from_top = 200 ;

$tweetRooh_buttonStyles = array(
         '0' => array('img'=>'twit_pen_icon',    'width' => '24', 'height' => '24')

         , '1' => array('img'=>'vPen',    'width' => '20', 'height' => '110')

         ,  '2' => array('img'=>'twit_40',    'width' => '30', 'height' => '300')
         ,  '3' => array('img'=>'twit_33',    'width' => '30', 'height' => '300')
         ,  '4' => array('img'=>'twit_34',    'width' => '30', 'height' => '300')
         ,  '5' => array('img'=>'twit_50',    'width' => '30', 'height' => '300')
         ,  '6' => array('img'=>'twit_51',    'width' => '30', 'height' => '300')
         ,  '7' => array('img'=>'twit_52',    'width' => '30', 'height' => '300')
         ,  '8' => array('img'=>'twit_35',    'width' => '30', 'height' => '300')

         ,  '9' => array('img'=>'twit_02',    'width' => '75', 'height' => '300')     //clouds
         , '10'  => array('img'=>'twit_00',   'width' => '75', 'height' => '300')     //banner
         // ,  '9' => array('img'=>'twit_06',    'width' => '75', 'height' => '300')
         //,  '9' => array('img'=>'twit_09',    'width' => '75', 'height' => '300')
         , '11' => array('img'=>'twit_11',    'width' => '60', 'height' => '265')     //branch

         , '12'  => array('img'=>'twit_01',   'width' => '75', 'height' => '300')     // up
         , '13' => array('img'=>'twit_39U',    'width' => '49', 'height' => '300')
         , '14' => array('img'=>'twit_39',    'width' => '49', 'height' => '300')
         , '15' => array('img'=>'twit_32',    'width' => '49', 'height' => '300')
         , '16' => array('img'=>'twit_48',    'width' => '49', 'height' => '300')
         , '17' => array('img'=>'twit_49',    'width' => '49', 'height' => '300')
         , '18' => array('img'=>'twit_30',    'width' => '49', 'height' => '300')
         , '19' => array('img'=>'twit_31',    'width' => '49', 'height' => '300')
         , '20' => array('img'=>'twit_47',    'width' => '49', 'height' => '300')

         // 4
         , '21' => array('img'=>'twit_26',    'width' => '47', 'height' => '274')
         , '22' => array('img'=>'twit_27',    'width' => '47', 'height' => '274')
         , '23' => array('img'=>'twit_28',    'width' => '47', 'height' => '274')
         , '24' => array('img'=>'twit_29',    'width' => '47', 'height' => '274')

         // 6
         , '25' => array('img'=>'twit_36',    'width' => '35', 'height' => '300') //with cap
         , '26' => array('img'=>'twit_37',    'width' => '35', 'height' => '300')
         , '27' => array('img'=>'twit_38',    'width' => '35', 'height' => '300')
         , '28' => array('img'=>'twit_41',    'width' => '35', 'height' => '300')
         , '29' => array('img'=>'twit_07',    'width' => '35', 'height' => '300')

         // 6
         , '30' => array('img'=>'twit_04',    'width' => '75', 'height' => '300')
         , '31' => array('img'=>'twit_10',    'width' => '50', 'height' => '239')
         , '32' => array('img'=>'twit_22',    'width' => '50', 'height' => '239')
         , '33' => array('img'=>'twit_23',    'width' => '50', 'height' => '239')
         , '34' => array('img'=>'twit_24',    'width' => '50', 'height' => '239')
         , '35' => array('img'=>'twit_25',    'width' => '50', 'height' => '239')

         , '36' => array('img'=>'twit_05',    'width' => '41', 'height' => '229')
         , '37' => array('img'=>'twit_03',    'width' => '39', 'height' => '277')
         , '38' => array('img'=>'twit_08',    'width' => '60', 'height' => '265')
         , '39' => array('img'=>'twit_15',    'width' => '49', 'height' => '277')
         , '40' => array('img'=>'twit_12',    'width' => '49', 'height' => '277')
         , '41' => array('img'=>'twit_13',    'width' => '49', 'height' => '277')
         , '42' => array('img'=>'twit_14',    'width' => '49', 'height' => '277')

         , '43' => array('img'=>'twit_16',    'width' => '49', 'height' => '277')
         , '44' => array('img'=>'twit_17',    'width' => '49', 'height' => '277')
         , '45' => array('img'=>'twit_18',    'width' => '49', 'height' => '277')
         //  , '46' => array('img'=>'twit_19',    'width' => '49', 'height' => '277')
         , '46' => array('img'=>'twit_20',    'width' => '49', 'height' => '277')
         , '47' => array('img'=>'twit_21',    'width' => '49', 'height' => '277')

         , '48' => array('img'=>'twit_42',    'width' => '36', 'height' => '300')
         , '49' => array('img'=>'twit_46',    'width' => '36', 'height' => '300')
         , '50' => array('img'=>'twit_43',    'width' => '36', 'height' => '300')
         , '51' => array('img'=>'twit_44',    'width' => '36', 'height' => '300')
         , '52' => array('img'=>'twit_45',    'width' => '36', 'height' => '300')
         , '53' => array('img'=>'twit_03B',    'width' => '57', 'height' => '300')

         , '54' => array('img'=>'vPen2',    'width' => '28', 'height' => '119')

         /* Add your own style here, like this:
         , 'custom' => array('img'=>'http://example.com/button.gif', 'width' => '36', 'height' => '200')
         */
                    );

function th_getTRUserSettings()
{
    global $tweetRooh_offsetFromTop;
    global $tweetRooh_onRight;
    global $tweetRooh_buttonLook;
    global $tweetRooh_buttonStyles ;

   global $default_Vbutton ;
    global $default_offset_from_top ;

   if (!isset($tweetRooh_buttonLook)) $tweetRooh_buttonLook = get_option('tweetRooh_buttonLook');
   if (strlen($tweetRooh_buttonLook) == 0) $tweetRooh_buttonLook = $tweetRooh_buttonStyles[$default_Vbutton]['img'] ;
   //$tweetRooh_settings['buttonLook'] = $tweetRooh_buttonLook;

   if (!isset($tweetRooh_offsetFromTop)) $tweetRooh_offsetFromTop = get_option('tweetRooh_offsetFromTop');
   if (strlen($tweetRooh_offsetFromTop) == 0) $tweetRooh_offsetFromTop = $default_offset_from_top ;
   //$tweetRooh_settings['offsetFromTop'] = $tweetRooh_offsetFromTop;

    if (!isset($tweetRooh_onRight)) $tweetRooh_onRight = get_option('tweetRooh_onRight');
    if (strlen($tweetRooh_onRight) == 0) $tweetRooh_onRight = '1';                        // 1 means default display on RIGHT, 0 means defalt display on LEFT
    //$tweetRooh_settings['onRight'] = $tweetRooh_onRight;
}

//global activeButtonIndex ;

function th_getTRSnippet()
{
    $ROOH_BLOCK_BEGIN = "<!-- RoohIt Button BEGIN -->" ;
    $ROOH_BLOCK_END   = "<!-- RoohIt Button END -->" ;

   global $TWTHL_SIG_CMNT_BGN ;
   global $TWTHL_SIG_CMNT_END ;
   global $pathToBtns ;
   global $default_Vbutton ;

   global $tweetRooh_offsetFromTop;
   global $tweetRooh_onRight;
   global $tweetRooh_buttonLook;

   global $tweetRooh_buttonStyles ;   // button style array

   $numStyles = sizeof($tweetRooh_buttonStyles) ;
   $fileSuffix = 'R' ;
   for ($activeButtonIndex=0; $activeButtonIndex < $numStyles; $activeButtonIndex++)
   {
      if ($tweetRooh_buttonStyles[$activeButtonIndex]['img'] == $tweetRooh_buttonLook)
      {
         if ($tweetRooh_onRight == '0')
         {
            $fileSuffix = 'L' ;
            /*
            $filename = $pathToBtns . $tweetRooh_buttonLook . $fileSuffix . ".png" ;
            if ( !url_validate($filename) )      // This is an extra call EACH time the button is displayed. We should not have to make this call,save a DB value abt this.
               $fileSuffix = '' ;
            */
         }
         //$filename = $pathToBtns . $tweetRooh_buttonLook . $fileSuffix . ".png" ;
         //$filenameHover = $pathToBtns . $tweetRooh_buttonLook . $fileSuffix . "_hover.png" ;
         break ;
      }
   }
   // If the value in local DB did not match any of the filenames
   if ($activeButtonIndex >= $numStyles)
   {
      $activeButtonIndex =  $default_Vbutton ;
   }
   $filename = $pathToBtns . $tweetRooh_buttonStyles[$activeButtonIndex]['img'] . $fileSuffix . ".png" ;
   $filenameHover = $pathToBtns . $tweetRooh_buttonStyles[$activeButtonIndex]['img'] . $fileSuffix . "_hover.png" ;

   echo $ROOH_BLOCK_BEGIN ;
   echo $TWTHL_SIG_CMNT_BGN ;
   echo '<style>' ;
   require_once (RHAIO_PLUGIN_DIR.'css/roohit_wpv.css') ;
   echo '</style>' ;

   if ($tweetRooh_onRight == '0') $whichClass = "<div class='vbtns_l'> " ;
   else                           $whichClass = "<div class='vbtns_r'> " ;

   echo $whichClass, "
      <div class='vbtn' onclick=\"location.href='http://go.roohit.com/'\" title='Start Highlighting (wont leave this page)'></div>
   </div>
   ";
   echo $TWTHL_SIG_CMNT_END ;
   echo $ROOH_BLOCK_END ;
}


?>
