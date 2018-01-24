<?php
//put sha1() encrypted password here - example is 'hello'
$password = '991aaf561b8563e3cf8a8477efdda8d980811932';

session_start();
if (!isset($_SESSION['loggedIn'])) {
    $_SESSION['loggedIn'] = false;
}

if (isset($_POST['password'])) {
    if (sha1($_POST['password']) == $password) {
        $_SESSION['loggedIn'] = true;
    } else {
        die ('Incorrect password');
    }
} 

if (!$_SESSION['loggedIn']): ?>

<!DOCTYPE html>
<html>
    
	<head>
		
        <title>Korvfest - Desktop</title>
		
        <!-- meta -->
		<meta charset="utf-8">
        
        <!-- css -->
        <style>
        
            form {
                position: absolute;
                display: block;
                width: 500px;
                top: 50%;
                left: 50%;
                margin-top: -100px;
                margin-left: -250px;
                text-align: center;
                font-size: 50px;
            }
            
            form input {
                display: block;
                width: 100%;
                height: 100px;
                text-align: center;
                font-size: 30pt;
                margin-top: 20px;
            }
        
        </style>
		
    </head>
    
    <body>
        
        <form method="post">
            Password
            <input type="password" name="password">
        </form>
        
    </body>
    
</html>

<?php
exit();
endif;
?>