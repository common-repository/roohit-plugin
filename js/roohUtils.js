<script type="text/javascript">

function HideFrame(frName) {
  var fr = document.getElementById (frName);
if(fr.style.display=="none") {
   fr.style.display="inline";
}
else {
   fr.style.display="none";
  }
}

function toggleText(someid)
{
	var theElem = someid ;
	switch(theElem.innerHTML)
	{
		case 'See your Ticker Id': 				theElem.innerHTML='Your Ticker Id is shown below' ;
			break ;
		case 'Your Ticker Id is shown below': 	theElem.innerHTML='See your Ticker Id' ;
			break ;
		case 'What should the width be?': 		theElem.innerHTML='Actual width of widget is' ;
			break ;
		case 'Actual width of widget is' : 		theElem.innerHTML='What should the width be?' ;
			break ;
		case 'What should the height be?': 		theElem.innerHTML='Actual height of widget is' ;
			break ;
		case 'Actual height of widget is': 		theElem.innerHTML='What should the height be?' ;
			break ;
	}
}
</script>
