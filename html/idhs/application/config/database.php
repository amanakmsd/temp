<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;
$active_record = TRUE;//ci version 2.x


$db['default'] = array(
    'dsn'=> '',
    'hostname' => '43.205.162.157',
    'username' => 'postgres',
    'password' => 'PdkrjWbF14sHteh',
    'database' => 'idhs_database',
    'dbdriver' => 'postgre',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt'  => FALSE,
    'compress' => FALSE,
    'autoinit' => TRUE,//ci version 2.x
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE,
    'port' => 5432,
);
 
