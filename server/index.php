<?php

use Siler\Graphql;
use Siler\Http\Request;
use Siler\Http\Response;

require 'vendor/autoload.php';

// Enable CORS
Response\header('Access-Control-Allow-Origin', '*');
Response\header('Access-Control-Allow-Headers', 'content-type');

// Respond only for POST requests
if (Request\method_is('post')) {
    // Retrive the Schema
    $schema = include __DIR__.'/app/schema.php';

    // Give it to siler
    Graphql\init($schema);
} else {
    Response\header('Content-type', 'application/json');

    $fakeDatabase = FakeDatabase::getDatabase();

    echo json_encode($fakeDatabase, JSON_FORCE_OBJECT);
}
