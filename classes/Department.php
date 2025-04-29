<?php

class Department implements ICrud
{
    private int $id;
    private string $name;


    function __construct(int $id_paltzhalter = null, string $name_platzhalter = null)
    {
        if (isset($id)) {
            $this->id = $id_paltzhalter;
            $this->name = $name_platzhalter;
        }
    }


    public function setName(string $name): void
    {
        $this->name = $name;
    }
    //public string $delete;

    //public string $zeigeeingabe;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    // erstellt Department-Objekt, Name von user-Eingabe, id von der Datenbank
    public static function createObject() :Department
    {
        $name = $_POST['name'];
        $dbcon = Db::getDbConnection();
        $stmnt = "INSERT INTO department (name) 
                  VALUES (:name)";
        $request = $dbcon->prepare($stmnt);
        $request->bindParam(":name", $name, PDO::PARAM_STR);
        $request->execute();
        //$dbcon->lastInsertId(); // ist PK
        return new Department($dbcon->lastInsertId(), $name);
    }

    /**
     * @return Department[]
     * @throws Exception
     */
    static public function getAllAsObjects(): array
    {
        $dbcon = Db::getDbConnection();
        $stmnt = "SELECT * FROM department";
        $select_stm = $dbcon->prepare($stmnt);
        $select_stm->execute();

        return $select_stm->fetchAll(PDO::FETCH_CLASS, 'Department');
    }
    public function delete(): bool
    {
        try {
            $id = $this->getId();
            // Datensatz löschen
            $dbcon = Db::getDbConnection();
            $stmnt = "DELETE FROM department WHERE id=:id";
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

    public static function getObjectById(int $id): ?object
    {
        try {
            $dbcon = Db::getDbConnection();
            $stmnt = "SELECT * FROM department WHERE id=:id";
            $request = $dbcon->prepare($stmnt);
            $request->bindParam(":id", $id, PDO::PARAM_INT);
            $request->execute();
            if ($request->rowCount() === 0) {
                throw new Exception("die id $id existiert nicht in der Tabelle department.");
            };
            return $request->fetchObject( 'Department');
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }


    function update(): bool
    {
        $id = $this->getId();
        $dbcon = Db::getDbConnection();
        $stmnt = "Update department set name= :name where id = :id";
        $request = $dbcon->prepare($stmnt);
        $request->bindParam(':name',$_POST['name'],PDO::PARAM_STR);
        $request->bindParam(':id',$id,PDO::PARAM_INT);
        $request->execute();
        return true;
    }


    static function validateName(string $name): bool
    {
        if (strlen($name) >= 2){
            return true;
        }
        return false;
    }




}