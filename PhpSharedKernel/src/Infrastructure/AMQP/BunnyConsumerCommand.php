<?php

declare(strict_types = 1);

namespace Sip\Psinder\SharedKernel\Infrastructure\AMQP;

use Bunny\Channel;
use Bunny\Client;
use Bunny\Message;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Sip\Psinder\SharedKernel\Infrastructure\Serializer\Serializer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class BunnyConsumerCommand extends Command
{
    /** @var Client */
    private $client;

    /** @var LoggerInterface */
    private $logger;

    /** @var ContainerInterface */
    private $container;

    /** @var array */
    private $config;

    /** @var Serializer */
    private $serializer;

    public function __construct(
        Client $client,
        LoggerInterface $logger,
        Serializer $serializer,
        array $config,
        ContainerInterface $container
    ) {
        $this->client = $client;
        $this->logger = $logger;
        $this->container = $container;
        $this->config = $config;
        $this->serializer = $serializer;

        parent::__construct();
    }

    /**
     * Configures the command
     */
    protected function configure()
    {
        $this
            ->setName('amqp:consume')
            ->addArgument(
                'queue',
                InputArgument::REQUIRED
            );
    }

    /**
     * Executes the current command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('queue');

        $this->client->connect();

        $config = $this->config[$name];

        $this->client->channel()->run(
            function (Message $message, Channel $channel, Client $client) use ($config) {
                $dto = $this->serializer->deserialize($message->content, $config['dto']);
                $this->container->get($config['service'])($dto);
                $channel->ack($message);
            },
            $name
        );
    }
}
