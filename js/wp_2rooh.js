var domain = "roohit.com" ;
var baseDomain = "http://" + domain + "/site/4wp" ;

// Call Check Site Visit so we can validate users visit status
//function afterPageLoad() {checkSiteVisit();}
//window.onload=afterPageLoad;

var xmlHttpObject;
//var cookieName = "roohitNotification";
var cookieName = "roohInstHLerNotif";
var cookieTargetValue = "Y";
var cookieExpNoOfDays = 30;

function getCookieValue(c_name) {
	if (document.cookie.length>0) {
		c_start=document.cookie.indexOf(c_name + "=");
		if (c_start!=-1) {
			c_start=c_start + c_name.length+1;
			c_end=document.cookie.indexOf(";",c_start);
			if (c_end==-1) c_end=document.cookie.length;
				return unescape(document.cookie.substring(c_start,c_end));
		}
	}
	return "";
}

function setCookie(c_name,value,expiredays) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expiredays);
	//document.cookie=c_name+ "=" +escape(value) + ((expiredays==null) ? "" : ";expires="+exdate.toUTCString());
	// Notice domain has "." explicitly prepended in the next line, and path is hard coded to root
	document.cookie=c_name+ "=" +escape(value) + ((expiredays==null) ? "" : ";domain=." + domain + "; path=/;expires="+exdate.toUTCString());
}
/*
 * Added new function showNotificationContent2 to specify
 * blanket area & popup div tag names.
 * This way users can re-use this same code with different div ids.
 * 
 * Modified the existing showNotificationContent method to call the
 * new showNotificationContent2 method for backward compatible
 * so users with old plug-in can still call this and this will send existing div ids.
 */
function showNotificationContent(blanketGrayoutMilliSecs, popUpDisplayMilliSecs) {
	showNotificationContent2('blanket', blanketGrayoutMilliSecs, 'cust_notification', popUpDisplayMilliSecs);
}

function showNotificationContent2(blanketAreaId, blanketGrayoutMilliSecs, popUpId, popUpDisplayMilliSecs) {
	document.getElementById(popUpId).style.left = (viewportWidth - 275) + 'px';
	document.getElementById(popUpId).style.top = (viewportHeight - 165) + 'px';

	//alert('left: ' + document.getElementById(popUpId).style.left);
	//alert('top: ' + document.getElementById(popUpId).style.top);

	if (blanketGrayoutMilliSecs > 1) {
		/* 5/3/2011 - Commented out by RC
		setPopupDIVStatus(blanketAreaId, 'block');
		setTimeout("setPopupDIVStatus('" + blanketAreaId + "', 'none');", blanketGrayoutMilliSecs);
		*/
	}
	if (popUpDisplayMilliSecs < 0) {
		popUpDisplayMilliSecs = 7000;
	}
	setPopupDIVStatus(popUpId, 'block');
	setTimeout("setPopupDIVStatus('" + popUpId + "', 'none');", popUpDisplayMilliSecs);
}

function hideNotificationContent() {
	setPopupDIVStatus('blanket', 'none');
	setPopupDIVStatus('cust_notification', 'none');
}


function setPopupDIVStatus(popupDIVId, status) {
	var popupHandler = document.getElementById(popupDIVId);
	popupHandler.style.display = status;
}

function togglePopup(popupDIVId) {
	var popupHandler = document.getElementById(popupDIVId);
	if ( popupHandler.style.display == 'none' ) {
		popupHandler.style.display = 'block';
	} else {
		popupHandler.style.display = 'none';
	}
}

var viewportWidth;
var viewportHeight;
// the more standards compliant browsers (mozilla/netscape/opera/IE7) use window.innerWidth and window.innerHeight
if (typeof window.innerWidth != 'undefined') {
	viewportWidth = window.innerWidth,
	viewportHeight = window.innerHeight
}
//IE6 in standards compliant mode (i.e. with a valid doctype as the first line in the document)
else if (typeof document.documentElement != 'undefined'
    && typeof document.documentElement.clientWidth !=
    'undefined' && document.documentElement.clientWidth != 0) {
	viewportWidth = document.documentElement.clientWidth,
	viewportHeight = document.documentElement.clientHeight
}
// older versions of IE
else {
	viewportWidth = document.getElementsByTagName('body')[0].clientWidth,
	viewportHeight = document.getElementsByTagName('body')[0].clientHeight
}
//alert('<p>Your viewport width is '+ viewportWidth +'x'+viewportHeight+'</p>');
