<?php
declare(strict_types=1);


/**
 * Class OrderService
 */
class OrderService
{

    /**
     * @return array
     */
    public function getOrdersList() : array
    {
        $sql = 'SELECT o.order_id, group_concat(b.title SEPARATOR "</li><li>") items, o.amount,
            o.added_at, o.status from `order` o
            join order_book ob ON ob.order_id = o.order_id
            join book b ON b.id = ob.book_id
            group by o.order_id
            order by o.added_at desc
        ';
        $stmt = getPDO()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}