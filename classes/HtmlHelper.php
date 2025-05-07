<?php

class HtmlHelper
{
    public static function buildHTMLFromArrays(array $twoDimArray, $area = null): string
    {
        $htmlTable = '<table>';
        // TableHead erstellen
        $htmlTable .= '<tr>';
        if ($area === 'user') {
            $tableHeads = USER_TABLE_HEAD_NAMES;
        } elseif ($area === 'department') {
            $tableHeads = DEPARTMENT_TABLE_HEAD_NAMES;
        }

        foreach ($tableHeads as $headName) {
            $htmlTable .= '<th>' . $headName . '</th>';
        }
        $htmlTable .= '</tr>';

        // TableBody erstellen
        if ($area === 'department') {
            foreach ($twoDimArray as $department) {
                $htmlTable .= '<tr>';

                $htmlTable .= '<td>' . $department->getId() . '</td>';
                $htmlTable .= '<td>' . $department->linkToSelf . '</td>';
                $htmlTable .= '<td>' . $department->delete . '</td>';
                $htmlTable .= '<td>' . $department->zeigeeingabe . '</td>';
                $htmlTable .= '</tr>';
            }
        } elseif ($area === 'user') {
            foreach ($twoDimArray as $userObject) {

                $htmlTable .= '<tr>';
                $htmlTable .= "<td>" . $userObject->getId() . "</td>";
                $htmlTable .= "<td>" . $userObject->getVorname() . "</td>";
                $htmlTable .= "<td>" . $userObject->getNachname() . "</td>";
                $htmlTable .= "<td>" . $userObject->getAlter() . "</td>";
                $htmlTable .= "<td>" . 'TODO' . "</td>";
                $htmlTable .= "<td>" . $userObject->delete . "</td>";
                $htmlTable .= "<td>" . $userObject->zeigeeingabe . "</td>";
                $htmlTable .= '</tr>';
            }
        }

        $htmlTable .= '</table>';
        return $htmlTable;
    }

    public static function addDeleteAndUpdate(array $users, string $area): array
    {
        foreach ($users as $user) {
            if ($area === 'user') {
                $name = $user->getVorname() . ' ' . $user->getNachname();
            } elseif ($area === 'department') {
                $name = $user->getName();
            }
            // füe jedem Element von $users eine index 'delete' zu,
            // damit erstelle ich den Löschknopf
            $user->delete = '<a href="index.php?action=delete&id=' . $user->getId() . '&area=' . $area . '"><button>LÖSCHEN</button></a>';
            $user->zeigeeingabe = '<a href="index.php?action=aendern&id=' . $user->getId() . '&area=' . $area . '"><button>ändern</button></a>';
            $user->linkToSelf = '<a href="index.php?action=show&id=' . $user->getId() . '&area=' . $area . '">' . $name . '</a>';
        }

        return $users;
    }


    public static function departmentView(Department $department): string
    {
        $html = '<div>';
        $html .= "<div>" . $department->getId();
        $html .= '</div>';
        $html .= "<div>" . $department->getName();
        $html .= '</div>';
        $html .= "<div> Mitarbeiter";
        $html .= '</div>';

        $html .= '</div>';

        return $html;
    }



}
