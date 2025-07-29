
<html lang='en'>
	<head>
		<title>Registration</title>
    	<link rel="stylesheet" href="assets/styles/regsteration.css">
	<head>
<body>
<div class='wraper'>
		<div class="container">
			<h1>Incredible Future</h1>
			<p>Rigsteration</p>
                <form action="main.php" class='box' id="form" method="GET">
							Username<br>
							<input type='text' name='username' placeholder =" Username" required>
                            Password<br>
                            <input type='password' name="password" id="password" placeholder=' Password' required>
                            Confirm password<br>
                            <input type='password' name='password2' id="password2" placeholder=' Confirm Password'>

                        <div id="passStrength">
                           <div class="criteria"><input type="checkbox" disabled> <div class="des"> Must be at least of 8 characters</div></div> 
                           <div class="criteria"><input type="checkbox" disabled> <div class="des"> Passwords must match </div></div> 
                           <div class="criteria"><input type="checkbox" disabled> <div class="des"> Contains Uppercase Letters</div> </div>                       
                           <div class="criteria"><input type="checkbox" disabled> <div class="des"> Contains Lowercase Letters</div></div>                       
                           <div class="criteria"><input type="checkbox" disabled> <div class="des"> Contains Special characters</div></div>                  
                           <div class="criteria"><input type="checkbox" disabled> <div class="des"> Contains Numbers</div></div>              
                        </div><br>

						<input type="Submit" id="btn">
                 </form>
		</div>
		<div class="back"><div class="circle"></div></div>
</div>
</body>
<script src="assets/scripts/registration.js"></script>