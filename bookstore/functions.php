<?php

function getPDO()
{
    $pdo = new PDO("mysql:dbname=bookstore;host=127.0.0.1;charset=utf8mb4", 'root', '',[
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    return $pdo;
}

function getBooks() : array
{
    $query = 'SELECT b.id book_id, b.title, a.name author, g.name genre FROM book b
    left join author a ON a.id = b.author_id
    left join genre g ON g.id = b.genre_id
    ';
    $pdo = getPDO();
    $result = $pdo->query($query);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    return $result->fetchAll();
}

function getBookById($bookId) : array
{
    $query = "SELECT b.id book_id, b.title, a.name author, g.name genre, g.id genre_id FROM book b
    left join author a ON a.id = b.author_id
    left join genre g ON g.id = b.genre_id
    where b.id = ?
    ";
    $pdo = getPDO();
    $result = $pdo->prepare($query);
    $result->execute([$bookId]);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    return $result->fetch();
}

function getGenres() : array
{
    $query = 'SELECT id, name FROM genre';
    $pdo = getPDO();
    $result = $pdo->query($query);
    return $result->fetchAll(PDO::FETCH_ASSOC);
}