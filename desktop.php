<?php
include "config.php";
// include "access.php";
?>
<!DOCTYPE html>
<html>
    
	<head>
		
        <title>SMFB - Desktop</title>
		
        <!-- meta -->
		<meta charset="utf-8">
        
        <!-- css -->
        <link rel="stylesheet" href="css/reset.css"> 
        <link rel="stylesheet" href="css/desktop.css"> 
		
		<!-- js -->
		<script type="text/javascript" src="js/jquery/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="js/swfobject/swfobject.js"></script>
		<script type="text/javascript">
            
            $(document).ready(function() {
			
				var flashvars = {};
                    flashvars.target = "<?php echo $path; ?>service/target.php";
                    flashvars.highscore = "<?php echo $path; ?>service/highscore.php";
				
				var params = {};
				    params.menu = "false";
				    params.allowfullscreen = "true";
				    params.allowscriptaccess = "always";
					
				var attributes = {};
				    attributes.id = "swf";
				    attributes.name = "swf";
					
				swfobject.embedSWF("swf/target.swf", "swf", "100%", "100%", "10.1", "swf/playerProductInstall.swf", flashvars, params, attributes);
			});
            
        </script>
		
    </head>
    
    <body>
        
        <div id="swf"></div>
        
    </body>
    
</html>