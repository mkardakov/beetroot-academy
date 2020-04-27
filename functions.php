<?php
define('NEW_LINE', '<br />');


function helloWorld($username)
{
    global $username;
    return "<h2>Hello from $username</h2><br />";
}

$users = [
    [
        'name' => 'Bob',
        'surname' => 'Martin',
        'age' => 75,
        'gender' => 'man',
        'avatar' => 'https://i.ytimg.com/vi/sDnPs_V8M-c/hqdefault.jpg',
        'animals' => ['dog']
    ],
    [
        'name' => 'Alice',
        'surname' => 'Merton',
        'age' => 25,
        'gender' => 'woman',
        'avatar' => 'https://i.scdn.co/image/d44a5d71596b03b5dc6f5bbcc789458700038951',
        'animals' => ['dog', 'cat']
    ],
    [
        'name' => 'Jack',
        'surname' => 'Sparrow',
        'age' => 45,
        'gender' => 'man',
        'avatar' => 'https://pbs.twimg.com/profile_images/427547618600710144/wCeLVpBa_400x400.jpeg',
        'animals' => []
    ],
    [
        'name' => 'Angela',
        'surname' => 'Merkel',
        'age' => 65,
        'gender' => 'woman',
        'avatar' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b6/Besuch_Bundeskanzlerin_Angela_Merkel_im_Rathaus_K%C3%B6ln-09916.jpg/330px-Besuch_Bundeskanzlerin_Angela_Merkel_im_Rathaus_K%C3%B6ln-09916.jpg',
        'animals' => ['dog', 'parrot', 'horse']
    ]
];

if (!empty($_POST)) {
    $users[] = $_POST;
}


//Находим самого старого пользователя и выводим его имя. DONE
$ages = array_column($users, 'age');
$maxAge = max($ages);
$maxAgeId = array_search($maxAge, $ages);


$ages = array_column($users, 'age');
$maxAge = max($ages);
$maxAgeId = array_search($maxAge, $ages);
$oldestUser = $users[$maxAgeId];

$users2 = $users;
unset($users2[$maxAgeId]);

$ages = array_column($users2, 'age');
$users2 = array_values($users2);
$maxAgeId = array_search($maxAge, $ages);
if (false !== $maxAgeId) {
    $oldestUser2 = $users2[$maxAgeId];
}


//Вывести общее количество юзеров. DONE
//Если новый пользователь такого же возраста, как и самый старый. Выводим обоих

//Вывести всю информацию о пользователе с именем Jack в виде таблицы
$names = array_column($users, 'name');
define('JACK_NAME', 'Jack');
// ID of user Jack
$jackId = array_search(JACK_NAME, $names);
echo NEW_LINE;
//Вывести в таблицу случайного юзера, see rand()

$randomUserId = rand(0, count($users) - 1);
$randomUser = $users[$randomUserId];

function sortFields($userA, $userB)
{
    $order = $_GET['order'] ?? 'asc';
    $filterName = $_GET['sort'] ?? 'name';

    if ($order == 'asc') {
        return $userA[$filterName] <=> $userB[$filterName];
    }

    return $userB[$filterName] <=> $userA[$filterName];
}
//Вывести аватарки
//Вывести домашних питомцев Меркель в алфавитном порядке
if (!empty($_GET['sort'])) {
    switch ($_GET['sort']) {
        case 'id':
            if (!empty($_GET['order']) && $_GET['order'] == 'desc') {
                krsort($users);
            } else {
                ksort($users);
            }
            $users = array_values($users);
            break;
        case 'name':
        case 'surname':
        case 'age':
            usort($users, 'sortFields');
            break;
    }
}
$animals = [];
foreach ($users as $user) {
    $animals = array_merge($animals, $user['animals']);
}
$animalsFilter = array_unique($animals);

if (!empty($_GET['filter'])) {
    switch ($_GET['filter']) {
        case 'man':
            foreach ($users as $key => $user) {
                if ($user['gender'] !== 'man') {
                    unset($users[$key]);
                }
            }
            break;
        case 'woman':
            foreach ($users as $key => $user) {
                if ($user['gender'] !== 'woman') {
                    unset($users[$key]);
                }
            }
            break;
        case 'covid':
            foreach ($users as $key => $user) {
                if ($user['age'] < 60) {
                    unset($users[$key]);
                }
            }
            break;
        case 'cat':
        case 'parrot':
        case 'horse':
        case 'dog':
            foreach ($users as $key => $user) {
                $index = array_search($_GET['filter'], $user['animals']);
                if (false === $index) {
                    unset($users[$key]);
                }
            }
            break;
    }
}
