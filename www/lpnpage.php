  <?php

	$nospam_pagetype = array("html", "website");

	if (isset($_GET["pagetype"])
	    && in_array($_GET["pagetype"], $nospam_pagetype))
	{
		$pagetype = $_GET["pagetype"];
	}
	else {
		$pagetype = "website";
	}

	$nospam_pageid = array("bibtex_french", "bibtex", "contact", "errata", "french", "handheld", "implementations", "index", "links", "lpnpage", "lpnpage", "manuals", "navbar", "online", "teaching", "thanks", "toc", "top", "lpn-html");

	if (isset($_GET["pageid"])
            && (in_array($_GET["pageid"], $nospam_pageid)
	        ||
                preg_match("/^lpn-html(ch|se|li)\d*$/", $_GET["pageid"])))
	{
		$pageid = $_GET["pageid"];
	}
	else {
		$pageid = "top";
		$pagetype = "website";
	}

?>


<!-- HEADER -->
<html lang="en">
  <head>

  <title>Learn Prolog Now!</title>
  <link href="https://lpn.swi-prolog.org/jquery-ui.min.css" rel="stylesheet">
    <script src="https://lpn.swi-prolog.org/jquery.min.js"></script>
    <script src="https://lpn.swi-prolog.org/jquery-ui.min.js"></script>
    <script src="https://lpn.swi-prolog.org/lpn.js?<?=time() ?>"></script>
  <link href="lpn_reds2.css" rel="stylesheet" type="text/css">
  <link href="https://lpn.swi-prolog.org/lpn.css" rel="stylesheet" type="text/css">

  </head>

  <body>

  <!-- table is needed because IE doesn't recognize min-width. -->
  <table width="100%">
  <tr><td><div style="width:500pt;"></div></td></tr>
  <tr><td>

  <div class="coloredbar">


  <div class="swish-disclaimer">
This version of Learn Prolog Now! embeds <a href="https://swish.swi-prolog.org">
<span style="color:darkblue">SWI</span><span style="color:maroon">SH</span></a>,
<a href="https://www.swi-prolog.org">SWI-Prolog</a> for SHaring.
The current version rewrites the Learn Prolog Now! HTML on the fly, recognising
source code and example queries.  It is not yet good at recognising the relations
between source code fragments and queries.  Also Learn Prolog Now! needs some
updating to be more compatible with SWI-Prolog.  All sources are on GitHub:

<div class="github">
<span>LearnPrologNow</span>

<iframe class="github-btn" src="https://ghbtns.com/github-btn.html?user=LearnPrologNow&amp;repo=lpn&amp;type=fork&amp;count=true" width="102" height="20" title="Fork on GitHub"></iframe>

<span>LPN SWISH Proxy</span>

<iframe class="github-btn" src="https://ghbtns.com/github-btn.html?user=LearnPrologNow&amp;repo=lpn-swish-proxy&amp;type=fork&amp;count=true" width="102" height="20" title="Fork on GitHub"></iframe>

<span>SWISH</span>

<iframe class="github-btn" src="https://ghbtns.com/github-btn.html?user=SWI-Prolog&amp;repo=swish&amp;type=fork&amp;count=true" width="102" height="20" title="Fork on GitHub"></iframe>
</div>
</div>


  </div>
  <div class="lpnheader">
  <a href="index.php">Learn Prolog Now!</a>
  </div>


  <div class="authorbar">
  by <a href="http://www.loria.fr/~blackbur/">Patrick Blackburn</a>,
     <a href="http://www.let.rug.nl/bos/">Johan Bos</a>, and
     <a href="http://cs.union.edu/~striegnk/">Kristina Striegnitz</a>
  </div>

<!-- NAVIGATION BAR -->
  <div class="navbar">
  <?php

	include "navbar.php";

	make_navmenu($pageid);
  ?>
  </div>


<!-- MAIN CONTENT -->
  <div class="content">

  <?php
	if ($pagetype == "website")
	    include $pageid.".php";
	else
  	    include "html/".$pageid.".html";
  ?>

  </div>


<!-- FOOTER -->
  <div class="foot">
<div class="tracker">
<div id="eXTReMe"><a href="http://extremetracking.com/open?login=lpntwo">
<img src="http://t1.extreme-dm.com/i.gif" style="border: 0;"
height="38" width="41" id="EXim" alt="eXTReMe Tracker" /></a>
<script type="text/javascript"><!--
var EXlogin='lpntwo' // Login
var EXvsrv='s11' // VServer
EXs=screen;EXw=EXs.width;navigator.appName!="Netscape"?
EXb=EXs.colorDepth:EXb=EXs.pixelDepth;
navigator.javaEnabled()==1?EXjv="y":EXjv="n";
EXd=document;EXw?"":EXw="na";EXb?"":EXb="na";
EXd.write("<img src=http://e2.extreme-dm.com",
"/"+EXvsrv+".g?login="+EXlogin+"&amp;",
"jv="+EXjv+"&amp;j=y&amp;srw="+EXw+"&amp;srb="+EXb+"&amp;",
"l="+escape(EXd.referrer)+" height=1 width=1>");//-->
</script><noscript><div id="neXTReMe"><img height="1" width="1" alt=""
src="http://e2.extreme-dm.com/s11.g?login=lpntwo&amp;j=n&amp;jv=n" />
</div></noscript></div>
</div>
  &copy 2006-2012 <a href="http://www.patrickblackburn.org/">Patrick Blackburn</a>, <a href="http://www.let.rug.nl/bos/">Johan Bos</a>, <a href="http://cs.union.edu/~striegnk/">Kristina Striegnitz</a>
  </div>

  </td></tr></table>

<script>

$(function() {
  $(".swish").LPN({ swish:"https://swish.swi-prolog.org/" });
});

</script>

  </body>

</html>
