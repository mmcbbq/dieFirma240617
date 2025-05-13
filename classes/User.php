<?php

class User implements ICrud
{

    private int $id;
    private string $vorname;
    private string $nachname;
    private DateTime $bday;
    private Department $department;

    /**
     * @param string $bday
     * @param int $id
     * @param string $nachname
     * @param string $vorname
     */
    public function __construct(string $bday, int $id, string $nachname, string $vorname, int $departmentId)
    {
        $this->bday = new DateTime($bday);
        $this->id = $id;
        $this->nachname = $nachname;
        $this->vorname = $vorname;
        $this->departmentId = $departmentId;
    }

    public function getBday(): DateTime
    {
        return $this->bday;
    }

    public function setBday(DateTime $bday): void
    {
        $this->bday = $bday;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNachname(): string
    {
        return $this->nachname;
    }

    public function setNachname(string $nachname): void
    {
        $this->nachname = $nachname;
    }

    public function getVorname(): string
    {
        return $this->vorname;
    }

    public function setVorname(string $vorname): void
    {
        $this->vorname = $vorname;
    }

    public function getAlter():int
    {
        return (int)(new DateTime())->diff($this->bday,true)->format('%Y');
    }


public function getDepartmentId():int 
{
    return $this->departmentId;
}

public function getDepartment(): string
    {
        $id = $this->getDepartmentId();
        $dbcon = Db::getDbconnection();

        $stmnt = "SELECT name FROM department where id = :id";
        $select_stm = $dbcon->prepare($stmnt);
        $select_stm->bindParam(":id", $id, PDO::PARAM_INT);
        $select_stm->execute();
        $dpName = $select_stm->fetch(PDO::FETCH_ASSOC);
        return $dpName['name'];
    }


    /**
     * Hallo das erstellt uns unsere User
     * @return User[]
     * @throws Exception
     */
    static function getAllAsObjects(): array
    {
        $dbcon = Db::getDbConnection();
        $stmnt = "SELECT * FROM user";
        $select_stm = $dbcon->prepare($stmnt);
        $select_stm->execute();

        $userarray = $select_stm->fetchAll(PDO::FETCH_ASSOC);
        $userObjects = [];
        foreach ($userarray as $item) {
            $user =new User($item['bday'],$item['id'],$item['nachname'],$item['vorname'], $item['department_id']);
            $userObjects[] = $user;
        }
        return $userObjects;
    }

    function delete(): bool
    {
        try {
            $id = $this->getId();
            // Datensatz löschen
            $dbcon = Db::getDbConnection();
            $stmnt = "DELETE FROM user WHERE id=:id";
            $request = $dbcon->prepare($stmnt);
            $request->bindParam(":id", $id, PDO::PARAM_INT);
            $request->execute();
            if ($request->rowCount() === 0) {
                throw new Exception("DELETE mit nicht vorhandener id.");
            };
            return true;
        } catch (PDOException $e) {
//            echo '<pre>';
//            print_r($e);
//            echo '</pre>';
            var_dump($e->getCode());
            if ($e->getCode() === 23000) {
                throw new Exception('Solange es Mitarbeiter in der Abteilung gibt, kann die Abteilung nicht gelöscht werden', 23000);
            } else{
                throw new Exception($e->getMessage());
            }
        }
    }

    static function getObjectById(int $id): ?object
    {
        try {
            $dbcon = Db::getDbConnection();
            $stmnt = "SELECT * FROM user WHERE id=:id";
            $request = $dbcon->prepare($stmnt);
            $request->bindParam(":id", $id, PDO::PARAM_INT);
            $request->execute();
            if ($request->rowCount() === 0) {
                throw new Exception("die id $id existiert nicht in der Tabelle department.");
            };
            $userarray = $request->fetch( PDO::FETCH_ASSOC);
            return new User($userarray['bday'],$userarray['id'],$userarray['nachname'],$userarray['vorname']);
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function update(): bool
    {
        // TODO: Implement update() method.
    }

    static function createObject(): ?User
    {
        $vorname = $_POST['vorname'];
        $nachname = $_POST['nachname'];
        $bday = $_POST['bday'];
        $dbcon = Db::getDbConnection();
        $stmnt = "INSERT INTO user (vorname, nachname, bday) 
                  VALUES (:vorname, :nachname,:bday)";
        $request = $dbcon->prepare($stmnt);
        $request->bindParam(":vorname", $vorname, PDO::PARAM_STR);
        $request->bindParam(":nachname", $nachname, PDO::PARAM_STR);
        $request->bindParam(":bday", $bday, PDO::PARAM_STR);
        $request->execute();
        //$dbcon->lastInsertId(); // ist PK
        return new User($bday,$dbcon->lastInsertId(),$nachname,$vorname );
    }
}