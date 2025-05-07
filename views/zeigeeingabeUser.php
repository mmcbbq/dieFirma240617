<!doctype html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport'
          content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Document</title>
</head>
<body>

<form method='POST' action='index.php'>
    <input type="hidden" name="area" value="user">
    <input type="hidden" name="action" value="create">
    <input type='text' name='vorname'>
    <input type='text' name='nachname'>
    <input type='date' name='bday'>
    <input type='submit'>


</form>


</body>
</html>
<?php
