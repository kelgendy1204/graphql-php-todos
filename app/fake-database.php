<?php

class FakeDatabase
{

    public static $database;

    public static function getDatabase()
    {
        $faker = Faker\Factory::create();
        $faker->addProvider(new Faker\Provider\Lorem($faker));
        $faker->addProvider(new Faker\Provider\Base($faker));

        if(isset(self::$database) && !empty(self::$database)) {
            return self::$database;
        }

        $users = array();
        $tasks = array();
        $folders = array();

        for ($i=1; $i <= 10; $i++) {
            $users[$i] = [
                'id'   => $i,
                'name' => $faker->name
            ];
        }

        for ($i=1; $i <= 5; $i++) {
            $folders[$i] = [
                'id'   => $i,
                'name' => "Folder " . $i
            ];
        }

        for ($i=1; $i <= 1000; $i++) {
            $tasks[$i] = [
                'id'       => $i,
                'userId'   => mt_rand(1, 10),
                'folderId' => mt_rand(1, 5),
                'text'     => $faker->sentence($nbWords = 10, $variableNbWords = true)
            ];
        }

        self::$database = [
            'users'   => $users,
            'tasks'   => $tasks,
            'folders' => $folders
        ];

        return self::$database;
    }
}
