<?php
class Database {
    private $host = 'gabriel-sempere.students-laplateforme.io';
    private $dbname = 'gabriel-sempere_Gamekeeper';
    private $username = 'gam';
    private $password = 'laplateforme.io';
    public $pdo;

    public function __construct() {
        $this->connect();
    }

    public function connect() {
        try {
            $this->pdo = new PDO(
                "mysql:host=$this->host;dbname=$this->dbname;charset=utf8",
                $this->username,
                $this->password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->pdo;
    }
}
?>