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
                'id'                                                   => $i,
                'name'                                                 => $faker->name,
                'tasks'                                                => array_unique(array_map(function($item) use ($faker) {
                    return $faker->unique(true)->numberBetween(1, 1000);
                }, array_fill(0, mt_rand(1, 20), null)))
            ];
        }

        for ($i=1; $i <= 5; $i++) {
            $folders[$i] = [
                'id'                                                   => $i,
                'name'                                                 => $faker->word,
                'tasks'                                                => array_unique(array_map(function($item) use ($faker) {
                    return $faker->unique(true)->numberBetween(1, 1000);
                }, array_fill(0, mt_rand(1, 100), null)))
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
