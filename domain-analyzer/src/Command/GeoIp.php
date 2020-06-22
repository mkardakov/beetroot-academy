<?php
declare(strict_types=1);


namespace App\Command;


/**
 * Class GeoIp
 * @package App\Command
 */
class GeoIp extends Command
{

    /**
     * @param string $domain
     * @return array
     */
    public function run(string $domain): array
    {
        return $this->execute("/usr/bin/geoiplookup $domain");
    }
}