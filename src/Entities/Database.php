<?php
class Database {

    use SingletonTrait;

    public PDO $db;

    private function __construct() {
        $this->db = new PDO('mysql:host=db_todo_pdo_server;dbname=todo', 'root', 'root');
    }

}