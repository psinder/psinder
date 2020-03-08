<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\AMQP;

use Bunny\Channel;
use Bunny\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function sprintf;

final class BunnyDeclareCommand extends Command
{
    private Client $client;
    private LoggerInterface $logger;
    /** @var mixed[] */
    private array $config;

    /**
     * @param mixed[] $config
     */
    public function __construct(
        Client $client,
        LoggerInterface $logger,
        array $config
    ) {
        $this->client = $client;
        $this->logger = $logger;
        $this->config = $config;

        parent::__construct();
    }

    /**
     * Configures the command
     */
    protected function configure() : void
    {
        $this
            ->setName('amqp:declare');
    }

    /**
     * Executes the current command
     */
    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $this->client->connect();
        /** @var Channel $channel */
        $channel = $this->client->channel();

        foreach ($this->config['exchanges'] ?? [] as $exchange) {
            $channel->exchangeDeclare($exchange['name'], $exchange['type'] ?? 'direct');
            $this->logger->info('Declared exchange ' . $exchange['name']);
        }

        foreach ($this->config['queues'] ?? [] as $queue) {
            $channel->queueDeclare($queue['name']);
            $this->logger->info('Declared queue ' . $queue['name']);
            $channel->queueBind(
                $queue['name'],
                $queue['exchange'],
                $queue['routingKey'] ?? ''
            );

            $this->logger->info(sprintf(
                'Bound exchange %s to queue %s with routing key %s',
                $queue['exchange'],
                $queue['name'],
                $queue['routingKey'] ?? ''
            ));
        }

        $this->client->disconnect();

        return 0;
    }
}
