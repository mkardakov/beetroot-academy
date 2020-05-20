<?php
require 'functions.php';
$books = getBooks();
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
        <td><a href="/page.php?book_id=<?=$book['book_id'] ?>" ><?=htmlspecialchars($book['title']) ?></a></td>
        <td><?=$book['author'] ?></td>
        <td><?=$book['genre'] ?></td>
    </tr>
    
    <?php endforeach; ?>
    </table>
</div>
</body>
</html>
