<?php

declare(strict_types = 1);

namespace Sip\Psinder\SharedKernel\Infrastructure\AMQP;

use Bunny\AbstractClient;
use Bunny\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class BunnyDeclareCommand extends Command
{
    /** @var Client */
    private $client;

    /** @var LoggerInterface */
    private $logger;

    /** @var array */
    private $config;

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
    protected function configure()
    {
        $this
            ->setName('amqp:declare');
    }

    /**
     * Executes the current command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->client->connect();
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
