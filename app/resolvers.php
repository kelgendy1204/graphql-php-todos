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
                    'name' => $user['name']
                );
            }, $users);
        },
        'tasks' => function($parent, $args) use ($fakeDatabase) {
            $folderId = $args['folderId'];
            $userId = $args['userId'];
            $tasks = $fakeDatabase['tasks'];

            return array_map(function ($task) {
                return array(
                    'id' => $task['id'],
                    'text' => $task['text'],
                    'user' => $task['userId'],
                    'folder' => $task['folderId']
                );
            }, $tasks);
        },
        'folders' => function($parent, $args) use ($fakeDatabase) {
            $folders = $fakeDatabase['folders'];

            return array_map(function ($folder) {
                return array(
                    'id' => $folder['id'],
                    'name' => $folder['name']
                );
            }, $folders);
        },
    ),

    'Mutation' => null,

    'User' => array(
        'tasks' => function($parent) use ($fakeDatabase) {
            $tasks = array_filter($fakeDatabase['tasks'], function($task) use ($parent) {
                if($task['userId'] === $parent['id']) {
                    return true;
                }
                return false;
            });
            return array_map(function($task) use ($fakeDatabase) {
                return array(
                    'id' => $task['id'],
                    'text' => $task['text'],
                    'user' => $task['userId'],
                    'folder' => $task['folderId']
                );
            }, $tasks);
        }
    ),
    'Folder' => array(
        'tasks' => function($parent) use ($fakeDatabase) {
            $tasks = array_filter($fakeDatabase['tasks'], function($task) use ($parent) {
                if($task['folderId'] === $parent['id']) {
                    return true;
                }
                return false;
            });
            return array_map(function($task) use ($fakeDatabase) {
                return array(
                    'id' => $task['id'],
                    'text' => $task['text'],
                    'user' => $task['userId'],
                    'folder' => $task['folderId']
                );
            }, $tasks);
        }
    ),
    'Task' => array(
        'user' => function($parent) use ($fakeDatabase) {
            $user = $fakeDatabase['users'][$parent['user']];

            return array(
                'id' => $user['id'],
                'name' => $user['name']
            );
        },

        'folder' => function($parent) use ($fakeDatabase) {
            $folder = $fakeDatabase['folders'][$parent['folder']];

            return array(
                'id' => $folder['id'],
                'name' => $folder['name']
            );
        }
    )
];
