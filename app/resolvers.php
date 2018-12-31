<?php

$fakeDatabase = FakeDatabase::getDatabase();

return [
    'Query' => array(
        'users' => function($parent, $args) use ($fakeDatabase) {
            $search = $args['search'];
            $users = $fakeDatabase['users'];

            if(isset($search) && !empty($search)) {
                $users = array_filter($fakeDatabase['users'], function($user) use ($search) {
                    $name = $user['name'];
                    if(strpos($name, $search) === false) {
                        return false;
                    }
                    return true;
                });
            }

            return array_map(function ($user) {
                return array(
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'tasks' => $user['tasks']
                );
            }, $users);
        }
    ),
    'Mutation' => null,
    'User' => array(
        'tasks' => function($parent) use ($fakeDatabase) {
            $taskIds = array_values($parent['tasks']);
            return array_map(function($taskId) use ($fakeDatabase) {
                return $fakeDatabase['tasks'][$taskId];
            }, $taskIds);
        }
    )
];

// users(search: String): [User]
// tasks(folderName: String, userName: String): [Task]
// folders: [Folder]
