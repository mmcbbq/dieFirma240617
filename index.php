<?php
include 'config.php';

// lädt fehlende Klassen automatisch nach, statt dem user Fehlermeldungen anzuzeigen
spl_autoload_register(function ($className) {
    include 'classes/' . $className . '.php';
});

// Variablenempfang
$firstName = $_POST['firstName'] ?? '';
$lastName = $_POST['lastName'] ?? '';
$dateOfBirth = $_POST['dateOfBirth'] ?? '';
$departmentId = (int)($_POST['departmentId'] ?? 0);
$action = $_REQUEST['action'] ?? 'showList';
$id = (int)($_REQUEST['id'] ?? 0);
$area = $_REQUEST['area'] ?? 'department';
$name = $_POST['name'] ?? '';
//$view = $action; // Standardwert
echo '<pre>';
print_r($_REQUEST);
echo '</pre>';

try {
    if ($action == 'showList' and $area === 'department') {
        $departments = (new Department())->getAllAsObjects();
        $departments = HtmlHelper::addDeleteAndUpdate($departments, $area);
        $view = 'showList';

    } elseif ($action === 'delete' and $area == 'department') {
        (new Department())->deleteObjectById($id);
        $view = 'showList';
        $departments = (new Department())->getAllAsObjects();
        $departments = HtmlHelper::addDeleteAndUpdate($departments, $area);

    } elseif ($action === 'update' and $area === 'department') {
        (new Department())->updateById($id,['name'=>$name]);
        $view = 'showList';
        $departments = (new Department())->getAllAsObjects();
        $departments = HtmlHelper::addDeleteAndUpdate($departments, $area);

    } elseif ($action === 'aendern' and $area === 'department') {
            $department = (new Department())->getObjectById($id);
        $view = 'zeigeeingabe';
    } elseif ($action === "zeigeeingabe" and $area === 'department'){
        $view = 'zeigeeingabe';
    }elseif ($action === "eingabe" and $area === 'department'){
        $departments = (new Department())->getAllAsObjects();
        $departments = HtmlHelper::addDeleteAndUpdate($departments, $area);
        $view = 'showList';


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