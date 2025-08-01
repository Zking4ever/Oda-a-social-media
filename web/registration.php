
<html lang='en'>
	<head>
		<title>Registration</title>
	<head>
<body>
<div class='wraper'>
		<form action="upload.php">
			<input type="file" name="photo" id="photo">
			<input type="button" onclick='send()' value="submit">
		</form>
		<img src="https://drive.google.com/uc?export=view&id=1pA_ZwHuZSNHsTLpv9CAdOUHxc8_Yr8pr" id="image" alt="image will be shown here">
		<img src="https://drive.google.com/uc?export=view&id=1a2b3c4d5e6f7g8h9" alt="My Image">

</div>
<script>
	function send(){
		if(document.getElementById('photo').value==""){
			alert("choose file first");
			return;
		}
		var file = document.getElementById('photo').files;
		var form = new FormData;
		var xml = new XMLHttpRequest;
		xml.onload = function(){
			if(xml.status==200){
				alert(xml.response);
			}
		}
		form.append('file',file[0]);
		xml.open("POST","upload.php",true);
		xml.send(form);
	}
	</script>
</body>