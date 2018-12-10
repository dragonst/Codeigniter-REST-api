<?php

if (!defined('BASEPATH')) {

    exit('No direct script access allowed');

}

class Question_model extends MY_Model
{

    protected $_table_name  = 'questions';

    protected $_foreign_key = 'product_id';


    protected $_order_by    = "id desc";

    public function __construct()
    {
        parent::__construct();
    }

    public function get_paginated($id, $start, $limit)
	  {

      $this->db->where($this->_foreign_key, $id);
      $method = 'result';
  		$this->db->limit($limit, $start);
      $this->db->order_by($this->_order_by);

      return $this->db->get($this->_table_name)->$method();
	  }

}
