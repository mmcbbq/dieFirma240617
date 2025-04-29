<?php
// beim Ändern existiert $user, bei Eingabe eines neuen users nicht, deshalb Leerstrings als Vorbelegung
//if (!isset($department)) {
//    $department = ['id' => '', 'name' => ''];
//}
//$departments = readDepartments();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mitarbeiter</title>
</head>
<body>
<?php

include 'views/nav.php';
?>
<form method="post" action="index.php">
    <input type="hidden" name="area" value="<?php echo $area; ?>">
    <input type="hidden" name="action" value="<?php if (!isset($department)) {
        echo 'create';
    } else {
        echo 'update';
    } ?>">
    <input type="hidden" name="id" value="<?php if (isset($department)){ echo $department->getId();} else {echo '';} ?>">
    <table>
        <tr>
            <td><label for="name">Name:</label></td>
            <td><input type="text" id="name" name="name" value="<?php if (isset($department)){ echo $department->getName();} else {echo $name;} ?>"></td>
            <td><?php echo $err ?></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="OK"><input type="reset"></td>
        </tr>
    </table>
</form>
</body>
</html>
