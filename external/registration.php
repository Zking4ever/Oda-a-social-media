<Doctype html>
<html>
<head>
	<title>Registration</title>
  <style>
	*{
		padding:0;
	}
	.back{
		height:100vh;
		width:100%;

		position:absolute;
		z-index:-2;
	}
	.circle{
		width:200px;
		aspect-ratio:1;
		border-radius:50%;
		background-color:#9073de;
		position:absolute;
		left:27%;
		top:20%;
	}
	.circle::before{
		content:'';
		width:200px;
		aspect-ratio:1;
		display:block;
		background-color:orange;
		position:absolute;
		left:180%;
		top:120%;
		border-radius:35px;
		}
	.circle::after{
		content:'';
		width:160px;
		aspect-ratio:1;
		display:block;
		background-color:#9073de;
		position:absolute;
		left:190%;
		top:-20%;
		}
	.wraper{
		height:100vh;
		display:flex;
		align-items:center;
		justify-content:center;
		position:relative;
	}
	.container{
		text-align:center;
		width:350px;
		min-height:390px;
		border-radius:30px;
		border:solid thin lightgray;
		padding:10px;
		background-color:#c9e4ff5e;
		backdrop-filter:blur(10px);
	}
	.box{
		text-align:left;
		font-size:26px;

		display:grid;
	}
	.box input{
		height:30px;
		width:90%;
		margin:auto;
		border:solid thin;
		border-radius:10px;
	}
	#passStrength{
            font-size: 14px;
            display: grid;
            grid-template-columns: 50% 50%;
            background-color: rgb(217, 227, 234);
            min-height: 5px;
            width: 90%;
            margin: 5px auto;
            padding: 5px;
            border-radius: 5px;
        }
        .criteria{
            display: flex;
            align-items: center;
        }
        .des{
            color: red;
	    padding-left:5px;
        }
        .criteria input:checked ~ .des{
            color: green;
        }
        #passStrength input{
            width: 12px;
        }
  </style>
</head>
<body>
<div class='wraper'>
		<div class="container">
			<h1>Incredible Future</h1>
			<p>Rigsteration</p>
                <form action="check.php" class='box' id="form" method="GET">
							Username<br>
							<input type='text' name='username' placeholder =" Usernames">
                            Password<br>
                            <input type='password' name="password" id="password2" placeholder=' Password' required>
                            Confirm password<br>
                            <input type='password' name='password2' placeholder=' Confirm Password'>

                        <div id="passStrength">
                           <div class="criteria"><input type="checkbox" disabled> <div class="des"> Must be at least of 8 characters</div></div> 
                           <div class="criteria"><input type="checkbox" disabled> <div class="des"> Contains Uppercase Letters</div> </div>                       
                           <div class="criteria"><input type="checkbox" disabled> <div class="des"> Contains Lowercase Letters</div></div>                       
                           <div class="criteria"><input type="checkbox" disabled> <div class="des"> Contains Special characters</div></div>                  
                           <div class="criteria"><input type="checkbox" disabled> <div class="des"> Contains Numbers</div></div>              
                        </div><br>

						<input type="Submit">
                 </form>
		</div>
		<div class="back"><div class="circle"></div></div>
</div>

<center> by <a href='https://github.com/zking4ever'>Astawus Amsalu</a> </center>	
</body>
</html>