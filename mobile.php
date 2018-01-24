<!DOCTYPE html>
<html>
    
	<head>
		
        <title>SMFB - Mobile</title>
		
        <!-- meta -->
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=.5, user-scalable=no">
        
        <!-- css -->
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="css/mobile.css">
		
		<!-- js -->
		<script type="text/javascript" src="js/jquery/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="js/greensock/TweenMax.min.js"></script>
		<script type="text/javascript" src="js/korvfest/mobile.js"></script>
        
    </head>
    
    <body>
        
        <div id="fb-root"></div>
        
        <script>
            
            window.fbAsyncInit = function() {
                
                // init the FB JS SDK
                FB.init({
                    appId      : '487917794605692', // App ID from the App Dashboard
                    channelUrl : '//smfb.good-morning.no/channel.html', // Channel File for x-domain communication
                    status     : true, // check the login status upon init?
                    cookie     : true, // set sessions cookies to allow your server to access the session?
                    xfbml      : true  // parse XFBML tags on this page?
                });
                
                // Additional initialization code such as adding Event Listeners goes here
                changePage("welcome");
            };
    
            // Load the SDK Asynchronously
            (function(d){
                var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
                if (d.getElementById(id)) {return;}
                js = d.createElement('script'); js.id = id; js.async = true;
                js.src = "//connect.facebook.net/en_US/all.js";
                ref.parentNode.insertBefore(js, ref);
            }(document));
            
        </script>
        
        <div id="loading" class="page">
            
            <img id="animation" src="image/mobile/loading/animation.gif" width="128" height="128" alt="" />
            
        </div>
        
        <div id="welcome" class="page">
            
            <img class="logo" src="image/mobile/common/smfb_logo.png" width="575" height="199" alt="SMFB" />
            
            <p>Welcome to the<br />Gullblyanten party!<br />Have fun!</p>
            
            <a id="play-button" class="button" href="#"><img src="image/mobile/welcome/play-button.png" width="593" height="152" alt="Play!" /></a>
            
            <a id="highscore-button" class="button" href="#"><img src="image/mobile/welcome/highscore-button.png" width="593" height="152" alt="Highscore!" /></a>
            
        </div>
        
        <div id="login" class="page">
            
            <p>You can play using your<br />Facebook account.</p>
            
            <a id="facebook-connect-button" class="button" href="#"><img src="image/mobile/login/facebook-connect-button.png" width="593" height="152" alt="Facebook connect" /></a>
            
            <p>Or you could just type in a<br />name and start playing.</p>
            
            <input id="username-input" type="text" />
            
            <a id="submit-button" class="button" href="#"><img src="image/mobile/login/submit-button.png" width="593" height="152" alt="Submit" /></a>
            
        </div>
        
        <div id="game" class="page">
            
            <div id="score">0</div>
            
            <canvas id="gameCanvas"></canvas>
        
        </div>
        
        <div id="game-over" class="page">
            
            <div id="success">
                
                <p id="score">Your total score: <span></span></p>
            
                <p id="position">Your position: <span></span></p>
            
            </div>
            
            <div id="failed">
                
                <p>You did not make the toplist.</p>
            
            </div>
            
            <a id="facebook-share-button" href="#">Share on Facebook</a>
            
            <a id="replay-button" class="button" href="#"><img src="image/mobile/game-over/replay-button.png" width="593" height="152" alt="Submit" /></a>
            
            <a id="highscore-button" class="button" href="#"><img src="image/mobile/welcome/highscore-button.png" width="593" height="152" alt="Highscore!" /></a>
            
            <a id="back-button" class="button" href="#"><img src="image/mobile/common/back-button.png" width="593" height="152" alt="Back" /></a>
            
        </div>
        
        <div id="highscore" class="page">
            
            <h2>Highscore</h2>
            
            <p>Top ten players of today</p>
            
            <img id="loading" src="image/mobile/loading/animation.gif" width="128" height="128" alt="" />
            
            <p id="fallback">No players have played today.</p>
            
            <ol>
                
                <li><img width="32" height="32" alt="" /><span class="name">Name</span><span class="score">0p</span></li>
                <li><img width="32" height="32" alt="" /><span class="name">Name</span><span class="score">0p</span></li>
                <li><img width="32" height="32" alt="" /><span class="name">Name</span><span class="score">0p</span></li>
                <li><img width="32" height="32" alt="" /><span class="name">Name</span><span class="score">0p</span></li>
                <li><img width="32" height="32" alt="" /><span class="name">Name</span><span class="score">0p</span></li>
                <li><img width="32" height="32" alt="" /><span class="name">Name</span><span class="score">0p</span></li>
                <li><img width="32" height="32" alt="" /><span class="name">Name</span><span class="score">0p</span></li>
                <li><img width="32" height="32" alt="" /><span class="name">Name</span><span class="score">0p</span></li>
                <li><img width="32" height="32" alt="" /><span class="name">Name</span><span class="score">0p</span></li>
                <li><img width="32" height="32" alt="" /><span class="name">Name</span><span class="score">0p</span></li>
            
            </ol>
            
            <a id="back-button" class="button" href="#"><img src="image/mobile/common/back-button.png" width="593" height="152" alt="Back" /></a>
            
        </div>
        
    </body>
    
</html>