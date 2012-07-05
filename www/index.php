<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Featherweights | Tweeow</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
	
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-31068095-1']);
	  _gaq.push(['_trackPageview']);

	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">Featherweights</a>
          <div class="nav-collapse">
            <ul class="nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="about">About</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1>Featherweights:</h1>
        <p>An interactive, social toy. It's controlled by two cats, Suki and Verb. Follow them on Twitter, and wait for a chance to play.</p>
        <p><a class="btn btn-primary btn-large" href="about">Meet the cats &raquo;</a></p>
      </div>
	  
      <div class="row">
        <div class="span6">
          <img class="thumbnail" src="/img/usecase.png" alt="">
        </div>
        <div class="span4">
          <script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
          <script>
          new TWTR.Widget({
            version: 2,
            type: 'profile',
            rpp: 4,
            interval: 30000,
            width: 500,
            height: 453,
            theme: {
              shell: {
                background: '#333333',
                color: '#ffffff'
              },
              tweets: {
                background: '#000000',
                color: '#ffffff',
                links: '#4aed05'
              }
            },
            features: {
              scrollbar: false,
              loop: false,
              live: true,
              behavior: 'all'
            }
          }).render().setUser('fthrwghts').start();
          </script>
        </div>
      </div>

      <hr>

      <footer>
        <p>
          Featherweights &copy 2012 by <a href="http://benjamindsnow.info">Benjamin Snow</a> | 
          Graphics and photography by <a href="http://andajean.com/">Anda J. Cross</a>
        </p>
        <p>
          <a href="https://twitter.com/fthrwghts" class="twitter-follow-button" data-show-count="false">Follow @fthrwghts</a>
          <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        </p>
      </footer>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

  </body>
</html>
