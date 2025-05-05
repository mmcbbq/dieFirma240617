<?php
include 'config.php';

// lädt fehlende Klassen automatisch nach, statt dem user Fehlermeldungen anzuzeigen
spl_autoload_register(function ($className) {
    include 'classes/' . $className . '.php';
});


$class = new Model();
$department = new Department();
$department->setName('mvc');
$department = $class->create($department);
var_dump($department);



// Variablenempfang
$firstName = $_POST['firstName'] ?? '';
$lastName = $_POST['lastName'] ?? '';
$dateOfBirth = $_POST['dateOfBirth'] ?? '';
$departmentId = (int)($_POST['departmentId'] ?? 0);
$action = $_REQUEST['action'] ?? 'showList';
$id = (int)($_REQUEST['id'] ?? 0);
$area = $_REQUEST['area'] ?? 'department';
$name = $_POST['name'] ?? '';
$err = "";
//$view = $action; // Standardwert
echo '<pre>';
print_r($_REQUEST);
echo '</pre>';

try {

    if ($action === 'show' and $area === "department"){
        $department = Department::getObjectById($id);
        $view = 'show';
    }

    elseif ($action == 'showList' and $area === 'department') {
        $departments = Department::getAllAsObjects();
        $departments = HtmlHelper::addDeleteAndUpdate($departments, $area);
        $view = 'showList';

    } elseif ($action === 'delete' and $area === 'department') {
        $department = Department::getObjectById($id);
        $department->delete();
        $view = 'showList';
        $departments = Department::getAllAsObjects();
        $departments = HtmlHelper::addDeleteAndUpdate($departments, $area);

    } elseif ($action === 'update' and $area === 'department') {
        $department = Department::getObjectById($id);
        $department->update();
        $view = 'showList';
        $departments = Department::getAllAsObjects();
        $departments = HtmlHelper::addDeleteAndUpdate($departments, $area);

    } elseif ($action === 'aendern' and $area === 'department') {
            $department = Department::getObjectById($id);
        $view = 'zeigeeingabe';
//
    } elseif ($action === "create" and $area === 'department'){
        if ($_SERVER['REQUEST_METHOD'] === 'POST' and Department::validateName($name)){
            Department::createObject();
            $departments = Department::getAllAsObjects();
            $departments = HtmlHelper::addDeleteAndUpdate($departments, $area);
            $view = 'showList';
        } else{
            if (!Department::validateName($name)  and isset($_POST['name'])){
                $err = "Name ist zu kurz";
            }
            $view = 'zeigeeingabe';
        }
//        ;
//
//    } elseif ($action === "eingabe" and $area === 'department'){
//



    }
} catch (Exception $e) {
    // zum Auslesen, was in der Exception alles drinsteht
    echo $e->getCode(); // abhängig von getCode() === 23000 department showList anzeigen
    // andernfalls Fehler in log.txt schreiben
    // Fehlermeldung in log-Datei mit Datum ausgeben (aktuelle Meldung oben)
    $dtStr = (new DateTime())->format('D, d M Y H:i:s');
    file_put_contents(LOG_FILE_PATH, $dtStr . ' ' . $e->getMessage() . "\n" . file_get_contents(LOG_FILE_PATH));
    $view = 'fehler';
}
include 'views/' . $view . '.php';