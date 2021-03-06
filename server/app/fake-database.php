<?php

class FakeDatabase
{

    private static $database;

    private static function dumpDatabaseToJson()
    {
        $fp = fopen(__Dir__ . '/data.json', 'w');

        fwrite($fp, json_encode(self::$database));

        fclose($fp);
    }

    private static function getDatabaseFromJson()
    {
        $str = file_get_contents(__Dir__ . '/data.json');

        self::$database = json_decode($str, true);
    }

    public static function setDatabase($newDatabase)
    {
        self::$database = $newDatabase;

        self::dumpDatabaseToJson();
    }

    public static function getDatabase($reset = false)
    {
        self::getDatabaseFromJson();

        if(isset(self::$database) && !empty(self::$database) && !$reset) {
            return self::$database;
        }

        $faker = Faker\Factory::create();
        $faker->addProvider(new Faker\Provider\Lorem($faker));
        $faker->addProvider(new Faker\Provider\Base($faker));

        $users = array();
        $tasks = array();
        $folders = array();

        for ($i=1; $i <= 20; $i++) {
            $users[$i] = [
                'id'   => $i,
                'name' => $faker->name
            ];
        }

        $foldersNames = ['Requested', 'Development', 'Testing', 'Code review', 'Production'];

        for ($i=1; $i <= 5; $i++) {
            $folders[$i] = [
                'id'   => $i,
                'name' => $foldersNames[$i - 1]
            ];
        }

        for ($i=1; $i <= 50; $i++) {
            $tasks[$i] = [
                'id'       => $i,
                'userId'   => mt_rand(1, 20),
                'folderId' => mt_rand(1, 5),
                'text'     => $faker->sentence($nbWords = 10, $variableNbWords = true)
            ];
        }

        self::$database = [
            'users'   => $users,
            'tasks'   => $tasks,
            'folders' => $folders
        ];

        self::dumpDatabaseToJson();

        return self::$database;
    }
}
