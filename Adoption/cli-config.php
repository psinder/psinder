<?php

use Doctrine\DBAL\Migrations\Tools\Console\Helper\ConfigurationHelper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;

$container = require __DIR__ . '/config/container.php';

return new HelperSet([
    'em' => new EntityManagerHelper(
        $container->get('doctrine.entity_manager.orm_default')
    ),
    'question' => new QuestionHelper(),
    'configuration' => new ConfigurationHelper(
        $container->get(EntityManagerInterface::class)->getConnection(),
        $container->get('doctrine.migrations.orm_default')
    )
]);
