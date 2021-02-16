<?php declare(strict_types=1);

namespace App\Events\Application\EventHandlers;

use Doctrine\DBAL\Connection;
use Somnambulist\Components\Domain\Events\AbstractEvent;

/**
 * Class DomainEventHandler
 *
 * @package    App\Events\Domain\Services\EventHandlers
 * @subpackage App\Events\Application\EventHandlers\DomainEventHandler
 */
class DomainEventHandler
{

    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function __invoke(AbstractEvent $event)
    {
        $date = $this->getDateWithMicroSeconds($event->getTime());

        $qb = $this->connection->createQueryBuilder();
        $qb
            ->insert('domain_events')
            ->values([
                'aggregate_root' => ':ag_root',
                'aggregate_id'   => ':ag_id',
                'event_name'     => ':ev_name',
                'payload'        => ':ev_payload',
                'context'        => ':ev_context',
                'created_at'     => ':date',
            ])
            ->setParameters([
                ':ag_root'    => $event->getAggregate()->class(),
                ':ag_id'      => $event->getAggregate()->identity(),
                ':ev_name'    => $event->getType(),
                ':ev_payload' => json_encode($event->payload()->toArray()),
                ':ev_context' => json_encode($event->context()->toArray()),
                ':date'       => $date,
            ])
        ;

        $qb->execute();

        return true;
    }

    public function getDateWithMicroSeconds(float $time): string
    {
        $micro = sprintf("%06d", ($time - floor($time)) * 1e6);

        return date('Y-m-d H:i:s.', (int)$time) . $micro;
    }
}
