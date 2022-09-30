<?php declare(strict_types=1);

namespace App\Events\Application\EventHandlers;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Statement;
use Somnambulist\Components\Events\AbstractEvent;
use function date;
use function floor;
use function json_encode;
use function sprintf;

class DomainEventHandler
{
    private ?Statement $statement = null;

    public function __construct(private Connection $connection)
    {
    }

    public function __invoke(AbstractEvent $event)
    {
        $this->getStatement()->executeStatement([
            'ag_root'    => $event->aggregate()->class(),
            'ag_id'      => $event->aggregate()->identity(),
            'ev_name'    => $event->type(),
            'ev_payload' => json_encode($event->payload()->toArray()),
            'ev_context' => json_encode($event->context()->toArray()),
            'date'       => $this->getDateWithMicroSeconds($event->createdAt()),
        ]);

        return true;
    }

    private function getStatement(): Statement
    {
        if (null === $this->statement) {
            $this->statement = $this->connection->prepare('
                INSERT INTO domain_events
                    (aggregate_root, aggregate_id, event_name, payload, context, created_at)
                VALUES
                    (:ag_root, :ag_id, :ev_name, :ev_payload, :ev_context, :date)
            ');
        }

        return $this->statement;
    }

    public function getDateWithMicroSeconds(float $time): string
    {
        $micro = sprintf("%06d", ($time - floor($time)) * 1e6);

        return date('Y-m-d H:i:s.', (int)$time) . $micro;
    }
}
