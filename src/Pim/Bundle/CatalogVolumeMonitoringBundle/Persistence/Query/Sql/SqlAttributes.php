<?php

declare(strict_types=1);

namespace Pim\Bundle\CatalogVolumeMonitoringBundle\Persistence\Query\Sql;

use Doctrine\DBAL\Connection;
use Pim\Component\CatalogVolumeMonitoring\Volume\Query\CountQuery;
use Pim\Component\CatalogVolumeMonitoring\Volume\ReadModel\CountVolume;

/**
 * @author    Elodie Raposo <elodie.raposo@akeneo.com>
 * @copyright 2018 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class SqlAttributes implements CountQuery
{
    private const VOLUME_NAME = 'attributes';

    /** @var Connection */
    private $connection;

    /** @var int */
    private $limit;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection, int $limit)
    {
        $this->connection = $connection;
        $this->limit = $limit;
    }

    /**
     * {@inheritdoc}
     */
    public function fetch(): CountVolume
    {
        $sql = <<<SQL
            SELECT COUNT(*) as count
            FROM pim_catalog_attribute;
SQL;
        $result = $this->connection->query($sql)->fetch();
        $volume = new CountVolume((int) $result['count'], $this->limit, self::VOLUME_NAME);

        return $volume;
    }
}
