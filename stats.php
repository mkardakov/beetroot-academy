<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

require './functions.php';
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
<h1>Статистика <?=helloWorld('From Top of the page') ?></h1>
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
            <th><a href="?sort=name&order=<?=!empty($_GET['order']) && $_GET['order'] == 'desc'? 'asc': 'desc' ?>">Name</a></th>
            <th><a href="?sort=surname&order=<?=!empty($_GET['order']) && $_GET['order'] == 'desc'? 'asc': 'desc' ?>">Surname</a></th>
            <th><a href="?sort=age&order=<?=!empty($_GET['order']) && $_GET['order'] == 'desc'? 'asc': 'desc' ?>">Age</a></th>
            <th><a href="?sort=avatar&order=<?=!empty($_GET['order']) && $_GET['order'] == 'desc'? 'asc': 'desc' ?>">Picture</a></th>
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
    <?=helloWorld('End of page') ?>
</div>
</body>
</html>

