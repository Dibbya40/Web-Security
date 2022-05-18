<?php
	// Connects to the Database 
	include('connect.php');
        connect();
	$mysqli = new mysqli("127.0.0.1","cs6324spring22","3Q9Y5Asg8as8p5m4","cs6324spring22");

	//if the login form is submitted 
	if (isset($_POST['submit'])) {
		
		$_POST['username'] = trim($_POST['username']);
		if(!$_POST['username'] | !$_POST['password']) {
			die('<p>You did not fill in a required field.
			Please go back and try again!</p>');
		}
		
		$passwordHash = hash('sha256', $_POST['password']);
		$post_uname = $_POST['username'];
		
		$mysqli->multi_query("SELECT * FROM users WHERE username = '".$post_uname."'") or die(mysql_error());

		if( $mysqli->store_result()->fetch_row()){
			$hour = time() + 3600; 
			setcookie(hackme, $_POST['username'], $hour); 
			setcookie(hackme_pass, $passwordHash, $hour);
			header("Location: members.php");
		}else{
			die("<p>Sorry, user name does not exisits.</p>");
		}

	}
		?>  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>hackme</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
<?php
	include('header.php');
?>
<div class="post">
	<div class="post-bgtop">
		<div class="post-bgbtm">
        <h2 class = "title">hackme bulletin board</h2>
        	<?php
            if(!isset($_COOKIE['hackme'])){
				 die('Why are you not logged in?!');
			}else
			{
				print("<p>Logged in as <a>$_COOKIE[hackme]</a></p>");
			}
			?>
        </div>
    </div>
</div>

<?php
	$threads = mysql_query("SELECT * FROM threads ORDER BY date DESC")or die(mysql_error());
	while($thisthread = mysql_fetch_array( $threads )){
?>
	<div class="post">
	<div class="post-bgtop">
	<div class="post-bgbtm">
		<h2 class="title"><a href="show.php?pid=<?php echo $thisthread['id'] ?>"><?php echo htmlspecialchars($thisthread[title],ENT_QUOTES);?></a></h2>
							<p class="meta"><span class="date"> <?php echo date('l, d F, Y',$thisthread[date]) ?> - Posted by <a href="#"><?php echo htmlspecialchars($thisthread[username],ENT_QUOTES); ?> </a></p>

	</div>
	</div>
	</div> 

<?php
}
	include('footer.php');
?>
</body>
</html>

