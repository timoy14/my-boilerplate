<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use App\Model\Purchase;
use App\User;

class FirebaseRealtimeDatabase
{
    protected $auth;
    protected $realtimeDatabase;

    public function __construct()
    {
        $factory = (new Factory)
        ->withServiceAccount(env('FIREBASE_CREDENTIALS'))
        ->withDatabaseUri(env('FIREBASE_DB_URI'));

        $this->auth = $factory->createAuth();
        $this->realtimeDatabase = $factory->createDatabase();
    }

    public function insert_data($id,$table) {

       
    }


    public function clean_data($table) {

        if ($firebaseRealtimeDatabase = $this->realtimeDatabase->getReference($table)->getValue()) {
            foreach ($firebaseRealtimeDatabase as $key => $value) {
                if ($value["status"] != "payment") {
                    $id = $table."/".$key;
                    $firebaseRealtimeDatabase = $this->realtimeDatabase->getReference($id)->remove();
                }
            }            
        }
    }


}