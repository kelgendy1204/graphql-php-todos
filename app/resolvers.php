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

            if($folderId) {
                $tasks = array_filter($tasks, function($task) use ($folderId) {
                    $taskFolderId = $task['folderId'];
                    if($taskFolderId === $folderId) {
                        return true;
                    }
                    return false;
                });
            }

            if($userId) {
                $tasks = array_filter($tasks, function($task) use ($userId) {
                    $taskUserId = $task['userId'];
                    if($taskUserId === $userId) {
                        return true;
                    }
                    return false;
                });
            }

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

    'Mutation' => array(
        'createTask' => function($parent, $args) use ($fakeDatabase) {
            $folderId = $args['folderId'];
            $userId = $args['userId'];
            $text = $args['text'];

            $tasks = $fakeDatabase['tasks'];

            $tasksIds = array_map(function($task) {
                return $task['id'];
            }, $tasks);

            $newId = max($tasksIds) + 1;

            $newTask = array(
                'id'       => $newId,
                'text'     => $text,
                'folder' => $folderId,
                'user'   => $userId,
            );

            $fakeDatabase['tasks'][] = $newTask;

            FakeDatabase::setDatabase($fakeDatabase);

            return $newTask;
        },
        'createUser' => function($parent, $args) use ($fakeDatabase) {
            $name = $args['name'];

            $users = $fakeDatabase['users'];
            $usersIds = array_map(function($user) {
                return $user['id'];
            }, $users);

            $newId = max($usersIds) + 1;

            $newUser = array(
                'id'   => $newId,
                'name' => $name
            );

            $fakeDatabase['users'][] = $newUser;

            FakeDatabase::setDatabase($fakeDatabase);

            return $newUser;
        },
        'createFolder' => function($parent, $args) use ($fakeDatabase) {
            $name = $args['name'];

            $folders = $fakeDatabase['folders'];
            $foldersIds = array_map(function($folder) {
                return $folder['id'];
            }, $folders);

            $newId = max($foldersIds) + 1;

            $newFolder = array(
                'id'   => $newId,
                'name' => $name
            );

            $fakeDatabase['folders'][] = $newFolder;

            FakeDatabase::setDatabase($fakeDatabase);

            return $newFolder;
        }
    ),

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
