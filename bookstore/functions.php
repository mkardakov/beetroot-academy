<?php

define('ITEMS_PER_PAGE', 8);
define('PUB_KEY', 'sandbox_i96445077653');
define('PRIVATE_KEY', 'sandbox_th2Vhc533WCmoAWPnlpcblegCT9JWX9UG3tbFUXe');

function getPDO()
{
    $pdo = new PDO("mysql:dbname=bookstore;host=127.0.0.1;charset=utf8mb4", 'root', '',[
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    return $pdo;
}

function getBooks(array $ids = []) : array
{
    $page = getPageNumber();
    $offset = ($page - 1) * ITEMS_PER_PAGE;
    $query = "SELECT b.id book_id, b.title, a.name author, g.name genre, b.cost FROM book b
    left join author a ON a.id = b.author_id
    left join genre g ON g.id = b.genre_id
    %s
    ORDER BY b.title LIMIT $offset,8
    ";
//    SELECT b.id book_id, b.title, a.name author, g.name genre FROM book b
//    left join author a ON a.id = b.author_id
//    left join genre g ON g.id = b.genre_id
//    WHERE b.id IN (2,3,4,5,7)
//    ORDER BY b.title LIMIT $offset,8
    $where = '';
    if (!empty($ids)) {
        $where = sprintf('WHERE b.id IN (%s)', implode(',',$ids));
    }
    $query = sprintf($query, $where);
    $pdo = getPDO();
    $result = $pdo->query($query);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    return $result->fetchAll();
}

function getBookById($bookId) : array
{
    $query = "SELECT b.id book_id, b.title, a.name author, g.name genre, g.id genre_id, b.cost FROM book b
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

function getComments($bookId) : array
{
    $query = 'SELECT * FROM comment WHERE book_id = ?';
    $pdo = getPDO();
    $result = $pdo->prepare($query);
    $result->execute([$bookId]);
    return $result->fetchAll(PDO::FETCH_ASSOC);
}

function getStars(int $rating = 3)
{
    $stars = '';
    for ($i = 1; $i <= 5; $i++) {
        $stars .= ($i <= $rating) ? '&#9733;' : '&#9734;';
    }
    $html = "<span class=\"text-warning\">$stars</span> $rating.0 star";
    if ($rating > 1) {
        $html .= 's';
    }
    return $html;
}


function addComment($comment, $bookId)
{
    $sql = "INSERT INTO `comment` (message, book_id) VALUES (:comment, :book)";
    $pdo = getPDO();
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'comment' => $comment,
        'book'    => $bookId
    ]);
}

function formatCommentDate(string $date) : string
{
    $time = strtotime($date);
    return date('n/j/y', $time);
}

function getPageNumber() : int
{
    $page = $_GET['page'] ?? 1;
    $total = getTotal();
    if ($page < 1) {
        $page = 1;
    } elseif ($page > $total) {
        $page = $total;
    }

    return $page;
}

function paginate()
{
    $page = getPageNumber();
    $pageCount = getTotal();
    $buttons = "";
    $startPos = getPageNumber();
    for ($i = 0; $i < 2; $i++) {
        if ($startPos === 1) {
            break;
        }
        $startPos--;
    }
    $endPos = $page;
    for ($i = 0; $i < 2; $i++) {
        if ($endPos === $pageCount) {
            break;
        }
        $endPos++;
    }
    for ($i = $startPos; $i <= $endPos; $i++) {
        $active = $page === $i ? 'active' : '';
        $buttons .= "<li class=\"page-item $active \"><a class=\"page-link\" href=\"?page=$i\">$i</a></li>";
    }
    return <<<PAGE
<nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" href="?page=1" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            $buttons
            <li class="page-item">
                <a class="page-link" href="?page=$pageCount" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </nav>
PAGE;
}

function getTotal() : int
{
    static $count;
    if ($count === null) {
        $sql = 'SELECT COUNT(1) FROM book';
        $pdo = getPDO();
        $stmt = $pdo->query($sql);
        $total = $stmt->fetch(PDO::FETCH_COLUMN);
        $count = ceil($total / ITEMS_PER_PAGE);
        return $count;
    }
    return $count;
}

function addToCart($bookId, int $count = 1)
{
    $cart = [];
    if (isset($_COOKIE['cart'])) {
        $cart = json_decode($_COOKIE['cart'], true);
    }
    if (!isset($cart[$bookId])) {
        $cart[$bookId] = 0;
    }
    //$cart[$bookId] = $cart[$bookId] + $count;
    $cart[$bookId] += $count;
    setcookie('cart', json_encode($cart), time() + 60 * 60 * 24 * 365);
}

function getItemsCount() : int
{
    $total = 0;
    if (!empty($_COOKIE['cart'])) {
        $cart = json_decode($_COOKIE['cart'], true);
        foreach ($cart as $count) {
            $total += $count;
        }
        //$total = array_sum($cart);
    }
    return $total;
}
// order_id INT | added_at | status ENUM

function getCartItems() : array
{
    $cart = json_decode($_COOKIE['cart'], true);
    // [book_id => count]
    $ids = array_keys($cart);
    $books = getBooks($ids);
    foreach ($books as &$book) {
        $book['count'] = $cart[  $book['book_id']    ];
    }
    return $books;
}

/**
 * Create order with books
 *
 * @return int
 */
function createOrder() : int
{
    $items = getCartItems();
    $sql = 'INSERT INTO `order` VALUES()';
    $pdo = getPDO();
    $pdo->query($sql);
    $orderId = $pdo->lastInsertId();
    $sql = 'INSERT INTO order_book (order_id, book_id, `count`) VALUES (?, ?, ?)';
    $stmt = $pdo->prepare($sql);
    foreach ($items as $item) {
        $stmt->execute([
            $orderId,
            $item['book_id'],
            $item['count']
        ]);
    }
    return $orderId;
}

/**
 * Get total cost of current order
 *
 * @return float
 */
function getOrderTotal() : float
{
    $total = 0.0;
    $items = getCartItems();
    foreach ($items as $item) {
        $total += $item['cost'] * $item['count'];
    }
    return $total;
}

/**
 * @param $orderId
 *
 * @return string
 */
function getData($orderId)
{
    $data = sprintf(
        '{"public_key":"%s","version":"3","action":"pay","amount":"%.2f","currency":"UAH","description":"Покупка на сайте книг","order_id":"%s"}',
        PUB_KEY,
        getOrderTotal(),
        $orderId
    );

    return base64_encode($data);
}

/**
 * @param $orderId
 *
 * @return string
 */
function getSignature($orderId)
{
    return base64_encode( sha1(PRIVATE_KEY . getData($orderId) . PRIVATE_KEY, true) );
}