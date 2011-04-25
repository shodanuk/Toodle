<?php defined('SYSPATH') OR die('No direct access allowed.');

$lang = array(

  // Add / edit todo item form errors

  'description' => array (
    'required' => 'Please enter a description.',
    'default'  => 'Invalid Input.',
  ),
  'due_date' => array (
    'required' => 'Please enter a due date.',
    'default'  => 'Invalid Input.',
  ),

  // Login form errors

  'login_username' => array (
    'required'  => 'Please enter your username.',
    'not_found' => 'The username you have entered does not exist.',
    'default'   => 'Invalid Input.',
  ),
  'login_password' => array (
    'required'            => 'Please enter your password.',
    'incorrect_password'  => 'The password you have entered is incorrect.',
    'default'             => 'Invalid Input.',
  ),

  // Registration form errors

  'register_username' => array (
    'required'        => 'Please enter a username.',
    'already_exists'  => 'The username you have entered is taken. Please choose another.',
    'default'         => 'Invalid Input.',
  ),
  'register_email' => array (
    'required'  => 'Please enter your email.',
    'email'     => 'Please enter a valid email.',
    'default'   => 'Invalid Input.',
  ),
  'register_password' => array (
    'required' => 'Please enter a password.',
    'default'  => 'Invalid Input.',
  ),
  'register_confirm' => array (
    'required' => 'Please confirm your password.',
    'matches' => 'Passwords do not match.',
    'default'  => 'Invalid Input.',
  ),

);
?>