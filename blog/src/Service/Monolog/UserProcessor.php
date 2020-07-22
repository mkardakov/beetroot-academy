<?php
declare(strict_types=1);


namespace App\Service\Monolog;


use App\Entity\User;

class UserProcessor
{

    public function customize(array $record)
    {
        /** @var User $user */
        $user = $record['context']['user'];
        $record['message'] = "({$user->getEmail()})" . $record['message'];
        return $record;
    }
}