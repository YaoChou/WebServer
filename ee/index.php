<!DOCTYPE html>
<head>
<title>Yao Image Classification</title>
<link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
<meta charset=utf-8 />
</head>

<body class=white bgcolor=#ffffff>
<center>
<form action="upload_image.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />  
    Send this file: <input name="userfile" type="file" />
    <input type="submit" name="submit" value="Send File" />
</form>

</center>
</body>
</html>
