<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//codeplaners 
class DumpController extends Controller
{
  function generate() {
    \Spatie\DbDumper\Databases\MySql::create()
    ->setDbName(env('DB_DATABASE'))
    ->setUserName(env('DB_USERNAME'))
    ->setPassword(env('DB_PASSWORD'))
    ->dumpToFile('bemo.sql');
  }
}
