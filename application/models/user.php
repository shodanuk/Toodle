<?php defined('SYSPATH') OR die('No direct access allowed.');

class User_Model extends ORM {
  protected $has_many = array('todo');
} // End ToDo Model

