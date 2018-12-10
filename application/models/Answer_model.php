<?php

if (!defined('BASEPATH')) {

    exit('No direct script access allowed');

}

class Answer_model extends MY_Model
{

    protected $_table_name  = 'answers';

    protected $_foreign_key = 'question_id';


    protected $_order_by    = "id asc";

    public function __construct()
    {
        parent::__construct();
    }


}
