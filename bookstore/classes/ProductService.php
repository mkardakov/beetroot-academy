<?php
declare(strict_types=1);


/**
 * Class ProductService
 */
class ProductService
{

    private $isPaginationEnabled;

    /**
     * ProductService constructor.
     * @param bool $isPaginationEnabled
     */
    public function __construct(bool $isPaginationEnabled = true)
    {
        $this->isPaginationEnabled = $isPaginationEnabled;
    }

    /**
     * @param array $ids
     * @return array
     */
    public function getProductsList(array $ids = []) : array
    {
        $page = getPageNumber();
        $offset = ($page - 1) * ITEMS_PER_PAGE;
        $query = "SELECT b.id book_id, b.title, a.name author, g.name genre, b.cost FROM book b
    left join author a ON a.id = b.author_id
    left join genre g ON g.id = b.genre_id
    %s
    ORDER BY b.title
    ";
        if ($this->isPaginationEnabled) {
            $query .= " LIMIT $offset,8";
        }
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

    /**
     * @param $id
     * @return array
     */
    public function getBookById($id) : array
    {
        $query = "SELECT b.id book_id, b.title, a.name author, g.name genre, g.id genre_id, b.cost FROM book b
    left join author a ON a.id = b.author_id
    left join genre g ON g.id = b.genre_id
    where b.id = ?
    ";
        $pdo = getPDO();
        $result = $pdo->prepare($query);
        $result->execute([$id]);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        return $result->fetch();
    }

    /**
     * @param $bookId
     * @param array $data
     */
    public function update($bookId, array $data)
    {
        try {
            $pdo = getPDO();
            $pdo->beginTransaction();
            $authorId = $this->upsertAuthor($data['author']);
            $genreId = $this->getGenre($data['genre']);
            // TODO: update book
            $pdo->commit();
        } catch(Exception $e) {
            $pdo->rollBack();
        }
    }

    private function upsertAuthor($name) : int
    {

    }

    private function getGenre($name) : int
    {

    }
}