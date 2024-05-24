<?php

namespace Azcend\Core;

use PDO;

class Model {
    protected $table;
    protected $primaryKey = 'id';
    protected $attributes = [];
    protected $dirtyAttributes = [];

    protected $connection;

    public function __construct($table = null, $primaryKey = 'id', $id = null) {

        if (empty($table)){
            $path = explode('\\', get_class($this));
            $this->table = strtolower(array_pop($path) . 's');
        }

        $this->primaryKey = $primaryKey;
        $this->connection = (new \Azcend\Core\Database())->getConn();

        if ($id !== null) {
            $this->find($id);
        }
    }

    public function __set($name, $value) {
        $this->attributes[$name] = $value;
        $this->dirtyAttributes[$name] = $value;
    }

    public function __get($name) {
        return $this->attributes[$name] ?? null;
    }

    public function save() {
        if (isset($this->attributes[$this->primaryKey])) {
            $this->update();
        } else {
            $this->insert();
        }
    }

    protected function insert() {
        $columns = implode(", ", array_keys($this->dirtyAttributes));
        $placeholders = implode(", ", array_fill(0, count($this->dirtyAttributes), '?'));
        $values = array_values($this->dirtyAttributes);

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($values);

        $this->attributes[$this->primaryKey] = $this->getConnection()->lastInsertId();
        $this->dirtyAttributes = [];
    }

    protected function update() {
        $setClause = [];
        $values = [];
        foreach ($this->dirtyAttributes as $column => $value) {
            $setClause[] = "$column = ?";
            $values[] = $value;
        }
        $values[] = $this->attributes[$this->primaryKey];

        $setClause = implode(", ", $setClause);
        $sql = "UPDATE {$this->table} SET $setClause WHERE {$this->primaryKey} = ?";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($values);

        $this->dirtyAttributes = [];
    }

    protected function find($id) {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([$id]);

        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($record) {
            $this->attributes = $record;
            $this->dirtyAttributes = [];
        }
    }

    protected function getConnection() {
        return $this->connection;
    }

    public function isDirty() {
        return !empty($this->dirtyAttributes);
    }
}
