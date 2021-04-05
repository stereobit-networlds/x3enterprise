var trailerCodeStart=20;

var controlsText = '\
<img id="trailerleft"  style="position:absolute;left:0px;cursor:hand;" hspace=1 src="" onClick="trailerLeft();"  width=17 height=17 alt="Left" title="Left">\
<img id="trailerstop"  style="position:absolute;left:19px;cursor:hand;" hspace=1 src="" onClick="trailerStop();"  width=17 height=17 alt="Stop/Start" title="Stop/Start">\
<img id="trailerright" style="position:absolute;left:38px;cursor:hand;" hspace=1 src="" onClick="trailerRight();" width=17 height=17 alt="Right" title="Right">\
';


var outer,inner,elementheight,controls;
var w3c=(document.getElementById)?true:false;

var controlsShown = false;
var stopPressed = false;
var direction = true; // left

var linksDone = false;






//var defaultWaitPerPicture = 2000;
var defaultWaitPerPicture = 0;
var waitPerPicture = defaultWaitPerPicture;
var waitAllowScroll = 500;
var scrollSpeed = 30; // SPEED OF SCROLL IN MILLISECONDS (1 SECOND=1000 MILLISECONDS)..
var pixelstep=1;          // PIXELS "STEPS" PER REPITITION.

//var showing = 1;	// first show picture 0 and 1
var fullLoaded = false; // when all pictures have been loaded

var tid;

//var src=[];
//var links=[];
//var specialStates=[];

function doStop()
{
	allowScrolling=false;
}

function doStart()
{
	if (stopPressed == false && allowScrolling == false)
		allowScrolling=true;
}


function showControls()
{
	controls.innerHTML = controlsText;
	var imgleft = document.getElementById('trailerleft');
	var imgright = document.getElementById('trailerright');
	var imgstop = document.getElementById('trailerstop');

	if (waitPerPicture == 0)
	{
//		imgleft.src  = '/site/images/trailer/left.gif';
//		imgright.src = '/site/images/trailer/right.gif';
		imgleft.src  = '/site/images/trailer/leftfast.gif';
		imgright.src = '/site/images/trailer/rightfast.gif';
	}
	else
	{
		imgleft.src  = '/site/images/trailer/leftfast.gif';
		imgright.src = '/site/images/trailer/rightfast.gif';
	}

	if (stopPressed)
	{
		imgstop.src = '/site/images/trailer/right.gif';
	}
	else
	{
		imgstop.src = '/site/images/trailer/stop.gif';
	}
}


function swapNoPauseTrailer()
{
	if (!fullLoaded)
		return;
	if (waitPerPicture == 0)
		waitPerPicture = defaultWaitPerPicture;
	else
		waitPerPicture = 0;
}

function trailerLeft()
{
	if (!fullLoaded)
		return;
	if (direction == false)
	{
		direction = true;	// left
		doLinks();
	}
	if (stopPressed == true)	// start playing if stopped
		trailerStop();
	swapNoPauseTrailer();
	showControls();
}

function trailerRight()
{

	if (!fullLoaded)
		return;
	if (direction == true)
	{
		direction = false;	// right
		doLinks();
	}
	if (stopPressed == true)    // start playing if stopped
		trailerStop();
	swapNoPauseTrailer();

	showControls();
}


function trailerStop()
{
	if (!fullLoaded)
		return;
	if (stopPressed == true)
	{
		stopPressed = false;
		allowScrolling = true;
	}
	else
	{
		allowScrolling = false;
		stopPressed = true;
	}
	showControls();
}

function doLinks()
{
	if (linksDone)
		return;
	for (count=0; count<(TRAILER_No_TO_SHOW+ADDITIONAL_TO_LOAD); count++)
	{
		img = document.getElementById('trimg'+count);
		img.onmouseout = doStart;
		img.onmouseover = doStop;
	}
	linksDone = true;
}

function scrollbox()
{
	doLinks();

	if (!fullLoaded)
	{

		var img;
		//var lastComplete = 0;
		var countCompleted = 0;
		var count;
		for (count=0; count<(TRAILER_No_TO_SHOW+ADDITIONAL_TO_LOAD); count++)
		{
			img = document.getElementById('trimg'+count);
			if (img.complete)
				countCompleted++;
		}
		if (countCompleted == (TRAILER_No_TO_SHOW+ADDITIONAL_TO_LOAD))
		{
			fullLoaded = true;
		}

		if (fullLoaded && !controlsShown)
		{
			showControls();
			controlsShown = true;
 		}
 		if (!controlsShown)
 		{
			if (controls.innerHTML == countCompleted+' loading .')
				controls.innerHTML = countCompleted+' loading &nbsp;';
			else
				controls.innerHTML = countCompleted+' loading .';

		}
	}

	if (fullLoaded && allowScrolling == true)	// ok, scroll one picture... now obsolete as we do not stop for every picture
	{
		doScroll();
	}
	else
		setTimeout('scrollbox()',waitAllowScroll);

}

function doScroll()
{

	if (allowScrolling == false)
	{
		setTimeout('scrollbox()',waitAllowScroll);
		return;
	}

	clearTimeout(tid);
	var theStep;
	if (direction) // left
	{

		inner.style.left=parseInt(inner.style.left)+(pixelstep * (-1))+'px';

		if ((parseInt(inner.style.left) > (-1) * ((TRAILER_No_TO_SHOW) * (SPACE_MIDDLE + singleWidth))))
		{
			setTimeout('doScroll()',scrollSpeed);
		}
		else
		{
			//alert('direction left set to 0');
			inner.style.left='0px';
			setTimeout('scrollbox()',waitPerPicture);
		}
	}
	else //right
	{
		inner.style.left=parseInt(inner.style.left)+(pixelstep * (1))+'px';

		if (parseInt(inner.style.left) < 0)
		{
			setTimeout('doScroll()',scrollSpeed);
		}
		else
		{
			inner.style.left= (-1) * (TRAILER_No_TO_SHOW) * (SPACE_MIDDLE + singleWidth) + 'px';
			setTimeout('scrollbox()',waitPerPicture);
		}
	}


}