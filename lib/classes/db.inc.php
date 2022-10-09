<?php
require_once("../lib/classes/Data.inc.php");

/**
 * This is the database class.
 *
 * It establishes the database connection and provides the CRUD functions.
 *
 * @author Mark Lösche
 * @mail nenya1337@gmail.com
 * @date: Oct 9, 2022
 */
class Database {
    /**
     * @var PDO
     */
    private $connection;

    /**
     * @var array
     */
    private $config;

    const TABLE = "crm_data";

    /**
     * @param string $dbname
     * @param string $dbUser
     * @param string $dbPass
     * @param string $dbHost
     * @return PDO
     */
    private function dbConnect(string $dbname, string $dbUser, string $dbPass, string $dbHost): PDO
    {
        return new PDO("mysql:host=".$dbHost.";dbname=".$dbname, $dbUser, $dbPass);
    }

    /**
     * @param PDO $connection
     * @return void
     */
    public function setConnection(PDO $connection):void{
        $this->connection = $connection;
    }

    /**
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    public function clearTable(){
        $stmt2 = "TRUNCATE TABLE `".self::TABLE."`";
        $sql2 = $this->getConnection()->prepare($stmt2);
        $sql2->execute();
    }

    /**
     * @param Data $data
     * @return bool
     */
    public function importData(Data $data) : bool {
        $stmt = "INSERT INTO ".self::TABLE." (`name`, `mail`, `hash`, `send_date`) VALUES (:name, :mail, :hash,  NOW())";
        $sql = $this->getConnection()->prepare($stmt);
        $name = $data->getName();
        $sql->bindParam(':name', $name, PDO::PARAM_STR);
        $mail = $data->getMail();
        $sql->bindParam(':mail', $mail, PDO::PARAM_STR);
        $hashCode = $data->getHashCode();
        $sql->bindParam(':hash', $hashCode, PDO::PARAM_STR);
        return $sql->execute();


    }

    /**
     * @param string $hash
     * @param int $value
     * @return bool
     */
    public function updatePreference(string $hash, int $value): bool
    {
        $stmt = "UPDATE `".self::TABLE."` SET `wants_delete`=:wants_delete, `response_date`= NOW() WHERE `hash`=:hash";
        $sql = $this->getConnection()->prepare($stmt);
        $sql->bindParam(':hash', $hash);
        $sql->bindParam(':wants_delete', $value, PDO::PARAM_INT);
        return $sql->execute();
    }


    /**
     * @param string $hash
     * @return mixed
     */
    public function getName(string $hash){
        $stmt = "SELECT `name` from ".self::TABLE." WHERE `hash` = :hash";
        $sql = $this->getConnection()->prepare($stmt);
        $sql->bindParam(':hash', $hash);
        $sql->execute();
        return $sql->fetch();

    }

    /**
     * @return array|false
     */
    public function exportData(){
        $stmt = "SELECT `name`, `mail`, `wants_delete`, `response_date`, `send_date`  FROM `".self::TABLE."` WHERE `wants_delete` >= 0 ORDER BY `wants_delete`, `response_date`";
        $sql = $this->getConnection()->prepare($stmt);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_NUM);
    }

    public function importDB(string $sql){
        $query = $this->getConnection()->prepare($sql);
        return $query->execute();
    }

    /**
     * constructs the class after reading the ini file.
     */
    public function __construct()
    {
        $this->config = parse_ini_file("../config/db.ini");
        $this->setConnection($this->dbConnect(
            $this->config["dbname"],
            $this->config["user"],
            $this->config["pass"],
            $this->config["host"]));
    }
}