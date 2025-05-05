<?php

class Model extends Db
{
    protected string $table ;
    protected array $colum;

    public function __construct()
    {
        $this->table = 'Department';
//        $this->table = get_class($this);
        $result = Db::getDbConnection()->query("DESCRIBE  $this->table");
        $this->colum = $result->fetchAll(PDO::FETCH_COLUMN);
    }

    public function findById($id):self
    {
        $data= ['id'=>$id];

        $query = "select * from $this->table where ";
        foreach ($data as $key => $value){
            $query .= "$key = :$key and";

        }

        $query = substr($query,0,-3 );
        $ent = $this->query($query, $data);

        return $ent[0];
    }

    public function findAll()
    {
        $query = "SELECT * FROM $this->table";

        return $this->query($query);
    }

    public function delete(Object $ent):bool
    {
        $data = ['id'=>$ent->id];
        $query = "Delete FROM $this->table WHERE ";

        foreach ($data as $key => $value){
            $query .= "$key = :$key and";

        }
        $query = substr($query,0,-3 );
        echo $query;
//        $ent = $this->query($query, $data);

        $this->query($query,$data);

        return true;
    }


    public function create(Object $ent)
    {
        $query = "Insert into $this->table ";

        echo $this->table;
        var_dump($this->colum);

//        return $this->query($query);

    }

    public function update()
    {

    }

}