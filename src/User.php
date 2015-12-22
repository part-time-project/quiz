<?php
namespace Model;

require_once PROJECT_PATH . 'src/AbstractModel.php';

class User extends AbstractModel
{
    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->tableName = 'users';
        $this->columns = array('fb_id', 'email', 'f_name', 'l_name', 'province', 'phone', 'profession', 'created_at');
    }
}