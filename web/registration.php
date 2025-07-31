
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