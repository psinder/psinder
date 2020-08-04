<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Persistence\ORM;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Logging\SQLLogger;
use Psr\Log\LoggerInterface;
use Sip\Psinder\SharedKernel\Infrastructure\Logging\LoggerFactory;
use function microtime;
use function Safe\json_encode;

class PSR3LoggingSQLLogger implements SQLLogger
{
    /**
     * Executed SQL queries.
     *
     * @var array<string, mixed>
     */
    public array $currentQuery = [];
    public ?float $start       = null;
    private LoggerInterface $logger;
    private Connection $connection;

    public function __construct(LoggerFactory $loggerFactory, Connection $connection)
    {
        $this->logger     = $loggerFactory('query');
        $this->connection = $connection;
    }

    /**
     * @param string       $sql
     * @param mixed[]|null $params
     * @param mixed[]|null $types
     */
    public function startQuery($sql, ?array $params = null, ?array $types = null) : void
    {
        $this->start = microtime(true);
        $queryParams = [];

        if ($params !== null && $types !== null) {
            $queryParams = json_encode($this->connection->resolveParams($params, $types));
        }

        $this->currentQuery = ['query' => $sql, 'queryParams' => $queryParams];
    }


    public function stopQuery() : void
    {
        $this->currentQuery['executionMS'] = microtime(true) - (float) $this->start;
        $this->logger->debug('Executed Doctrine query', $this->currentQuery);
        $this->currentQuery = [];
    }
}
