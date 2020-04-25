<?php
define('NEW_LINE', '<br />');
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

// foreach()
// for
// while/ do while

//foreach ($users as $key => &$user) {
//    echo "Key is: $key" . " " . strtoupper($user['name']) . '<br />';
//    $user['name'] = strtoupper($user['name']);
//}

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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<br/>
<h1>Статистика</h1>
<div class="container">
    <ul>
        <li>Самый старый
            пользователь: <?= $oldestUser['name'] . " " . $oldestUser['surname'] . ", age:" . $oldestUser['age']; ?></li>
        <?php if (!empty($oldestUser2)) : ?>
            <li>Самый старый пользователь
                (2): <?= $oldestUser2['name'] . " " . $oldestUser2['surname'] . ", age:" . $oldestUser2['age']; ?></li>
        <?php endif ?>
        <li>Общее количество юзеров: <?= count($users) ?></li>
        <li>Питомцы Меркель: <?php
            $animals = $users[3]['animals'];
            sort($animals);
            echo "<ul><li>" . implode('</li><li>', $animals) . "</li></ul>"
            ?></li>
    </ul>
    <table class="table">
        <thead>
        <tr>
            <th><a href="?sort=id&order=<?=!empty($_GET['order']) && $_GET['order'] == 'desc'? 'asc': 'desc' ?>">#</a></th>
            <th><a href="?sort=name&order=asc">Name</a></th>
            <th><a href="?sort=surname">Surname</a></th>
            <th><a href="?sort=age">Age</a></th>
            <th><a href="?sort=avatar">Picture</a></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $key => $user) : ?>
            <?php $id = (!empty($_GET['sort']) && $_GET['sort'] == 'id' && $_GET['order'] == 'desc') ? count($users) - $key : $key + 1; ?>
            <tr style="background-color: <?=($key%2 ===0) ? '#aaa': '#fff' ?>">
                <td><?=$id ?></td>
                <td><?=$user['name'] ?></td>
                <td><?=$user['surname'] ?></td>
                <td><?=$user['age'] ?></td>
                <td><img src="<?=$user['avatar'] ?>" style="width:60px"/></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <form method="get">
    <select name="filter">
        <option value="man">Только мужчины</option>
        <option value="woman">Только женщины</option>
        <option value="covid">Риск COVID age > 60</option>
        <?php foreach ($animalsFilter as $animal) :?>
            <option value="<?=$animal ?>"><?=$animal ?></option>
        <?php endforeach; ?>
    </select>
    <input type="submit">
    </form>
    <a href="user.php">На страницу регистрации</a>
</div>
</body>
</html>

