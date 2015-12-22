<?php
namespace Model;

require_once PROJECT_PATH . 'src/AbstractModel.php';

class UserAnswer extends AbstractModel
{
    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->tableName = 'user_answers';
        $this->columns = array('user_id', 'question_id', 'answer', 'created_at');
    }

    /**
     * get specific row
     *
     * @param integer $id
     * @param string $fetchMode
     * @return array
     */
    public function findByUserAndQuestion($userId, $questionId, $fetchMode = \PDO::FETCH_ASSOC)
    {
        $statement = $this->pdo->query('SELECT * FROM ' . $this->tableName . ' WHERE user_id = ' . $userId . ' AND question_id = ' . $questionId . ' LIMIT 1;');
        $row = $statement->fetch($fetchMode);

        return $row;
    }
}