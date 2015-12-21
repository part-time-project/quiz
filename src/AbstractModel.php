<?php
namespace Model;

abstract class AbstractModel
{
    /**
     * @var \PDO
     */
    protected $pdo = null;

    /**
     * @var string
     */
    protected $tableName = '';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $columns = array();

    /**
     * @var int
     */
    private $lastInsertId;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->pdo = new \PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    }

    /**
     * @return \PDO
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @param string $tableName
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * get all rows
     *
     * @param string $fetchMode
     * @return array|object[]
     */
    public function fetchAll($fetchMode = \PDO::FETCH_ASSOC)
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . $this->tableName);
        $statement->execute();

        return $statement->fetchAll($fetchMode);
    }

    /**
     * get specific row
     *
     * @param integer $id
     * @param string $fetchMode
     * @return array
     */
    public function find($id, $fetchMode = \PDO::FETCH_ASSOC)
    {
        $statement = $this->pdo->query("SELECT * FROM " . $this->tableName . ' WHERE ' . $this->primaryKey . ' = ' . $id . ' LIMIT 1;');
        $row = $statement->fetch($fetchMode);

        return $row;
    }


    /**
     * get specific row
     *
     * @param string $field
     * @param string $value
     * @param int $fetchMode
     * @return array
     */
    public function findBy($field, $value, $fetchMode = \PDO::FETCH_ASSOC)
    {
        $statement = $this->pdo->query(sprintf("SELECT * FROM %s WHERE %s = '%s';",
            $this->tableName, $field, $value
        ));

        $row = $statement->fetch($fetchMode);

        return $row;
    }

    /**
     * get specific row
     *
     * @param string $field
     * @param string $value
     * @param string $orderBy
     * @param int $fetchMode
     * @return array
     */
    public function findAllBy($field, $value, $orderBy = '', $fetchMode = \PDO::FETCH_ASSOC)
    {
        $orderByStr = '';
        if (is_string($orderBy) && !empty($orderBy)) {
            $orderByStr = 'ORDER BY ' . $orderBy;
        }

        $statement = $this->pdo->query(sprintf("SELECT * FROM %s WHERE %s = '%s' %s;",
            $this->tableName, $field, $value, $orderByStr
        ));

        $row = $statement->fetchAll($fetchMode);

        return $row;
    }

    /**
     * insert new row
     *
     * @param array $data
     * @return bool
     */
    public function save($data)
    {
        if ($key = array_search('created_at', $this->columns)) {
            $data['created_at'] = date("Y-m-d H:i:s");
        }
        $data = $this->reArrange($data);

        $statement = $this->pdo->prepare(sprintf("INSERT INTO %s (%s) VALUES (:%s);",
            $this->tableName, implode(',', array_keys($data)), implode(',:', array_keys($data))
        ));

        foreach ($data as $key => &$value) {
            $statement->bindParam(':' . $key, $value, \PDO::PARAM_STR);
        }
        $result = $statement->execute();

        $this->lastInsertId = $this->pdo->lastInsertId();

        return $result;
    }

    /**
     * update existing row
     *
     * @param array $newData
     * @param int $primaryKey
     * @return bool
     */
    public function update($newData, $primaryKey)
    {
        $sql = array();

        foreach ($this->reArrange($newData) as $column => $value) {
            $sql[] = sprintf("%s='%s'", $column, (string)$value);
        }

        $statement = $this->pdo->prepare(sprintf("UPDATE %s SET %s WHERE %s='%s';",
            $this->tableName, implode(',', $sql), $this->primaryKey, $primaryKey
        ));

        $result = $statement->execute();

        return $result;
    }

    /**
     * delete row by PK
     *
     * @param integer $id
     * @return bool
     */
    public function delete($id)
    {
        $primaryKey = (is_string($id)) ? sprintf("'%s'", $id) : $id;
        $statement = $this->pdo->query("DELETE FROM " . $this->tableName . ' WHERE ' . $this->primaryKey . ' = ' . $primaryKey . ' LIMIT 1;');
        $result = $statement->execute();

        return $result;
    }

    /**
     * @param string $field
     * @param string /int $value
     * @return bool
     */
    public function deleteBy($field, $value)
    {
        $value = (is_string($value)) ? sprintf("'%s'", $value) : $value;
        $statement = $this->pdo->query("DELETE FROM " . $this->tableName . ' WHERE ' . $field . ' = ' . $value . ';');
        $result = $statement->execute();

        return $result;
    }

    /**
     *
     * @param array $data
     * @return array
     */
    protected function reArrange($data)
    {
        $arrangedData = array();

        foreach ($this->columns as $column) {
            if (isset($data[$column])) {
                $arrangedData[$column] = $data[$column];
            }
        }

        return $arrangedData;
    }

    /**
     * @return int
     */
    public function getLastInsertId()
    {
        return $this->lastInsertId;
    }

    /**
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }
}

