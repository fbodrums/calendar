<?php

use DataTables\Database;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

function getSidebar()
{
    return config('sidebar');
}


function getConnectionDataTable(): Database
{
    return new Database([
        "type" => "Mysql",
        "pdo" => DB::connection('sqlite')->getPdo(),
    ]);
}


function getUserId()
{
    return Auth::user()->id;
}
