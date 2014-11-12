<?php
    include "lib/Translator.php";  
    error_reporting(E_ERROR | E_PARSE);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset = "UTF-8" />
    <title>Number Translator</title>
</head>
<body>
	 <center>
	<?php
	    $translator = Translator::createTranslator();
	    if(isset($_POST["ru"]))
	    	$translator->setLanguage("ru");
	 	if(isset($_POST["ua"]))
	    	$translator->setLanguage("ua");
		if(isset($_POST["eng"]))
	    	$translator->setLanguage("eng");
	    if(isset($_POST["number"]))
	    	echo $translator->translateNumber($_POST["number"]);  
	?>

	<form  method = "post" >
		<table>
			<tr>
				<input type="text" name="number" />
			</tr>
			<tr>
				<td>
					<input type = "submit" name="ru" value = "Русский"/>
				</td>
				<td>
					<input type = "submit" name="ua" value = "Українська"/>
				</td>
				<td>
					<input type = "submit" name="eng" value = "English"/>
				</td>
			</tr>
			
		</table>
	</form>
</center>
</body>
</html>
