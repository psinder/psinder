<?php

declare(strict_types=1);

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
    private Client $client;
    private LoggerInterface $logger;
    private ContainerInterface $container;
    /**
     * @phpstan-var array<string, array>
     *
     * @var array[]
     */
    private array $config;
    private Serializer $serializer;

    /**
     * @param mixed[] $config
     */
    public function __construct(
        Client $client,
        LoggerInterface $logger,
        Serializer $serializer,
        array $config,
        ContainerInterface $container
    ) {
        $this->client     = $client;
        $this->logger     = $logger;
        $this->container  = $container;
        $this->config     = $config;
        $this->serializer = $serializer;

        parent::__construct();
    }

    /**
     * Configures the command
     */
    protected function configure() : void
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
    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        /** @var string $name */
        $name = $input->getArgument('queue');

        $this->client->connect();

        $config = $this->config[$name];

        /** @var Channel $channel */
        $channel = $this->client->channel();
        $channel->run(
            function (Message $message, Channel $channel) use ($config) : void {
                $dto = $this->serializer->deserialize($message->content, $config['dto']);
                $this->container->get($config['service'])($dto);
                $channel->ack($message);
            },
            $name
        );

        return 0;
    }
}
