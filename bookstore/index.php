<?php

$pdo = new PDO("mysql:dbname=bookstore;host=127.0.0.1;charset=utf8mb4", 'root', '',[
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$query = 'SELECT b.id, b.title, a.name author, g.name genre FROM book b
    left join author a ON a.id = b.author_id
    left join genre g ON g.id = b.genre_id
';

$result = $pdo->query($query);
$books = [];
foreach ($result as $row) {
    $books[] = $row;
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
<div class="container">
    <table class="table">
        <thead>
        <tr>
            <th>Книга</th>
            <th>Автор</th>
            <th>Жанр</th>
        </tr>
        </thead>
    <?php foreach ($books as $book) : ?>
    <tr>
        <td><?=$book['title'] ?></td>
        <td><?=$book['author'] ?></td>
        <td><?=$book['genre'] ?></td>
    </tr>
    
    <?php endforeach; ?>
    </table>
</div>
</body>
</html>
