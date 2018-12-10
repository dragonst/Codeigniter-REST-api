<?php

if (!defined('BASEPATH')) {

    exit('No direct script access allowed');

}

class Product_model extends MY_Model
{

    protected $_table_name  = 'products';

    protected $_primary_key = 'id';

    protected $_order_by    = "id desc";

    public function __construct()
    {
        parent::__construct();
    }

    public function get_paginated($start, $limit)
    {

      $method = 'result';
      $this->db->limit($limit, $start);
      $this->db->order_by($this->_order_by);

      return $this->db->get($this->_table_name)->$method();
    }
}
