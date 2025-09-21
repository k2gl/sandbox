<?php

declare(strict_types=1);

namespace App\Core\Doctrine\EventListener;

use Doctrine\ORM\Tools\Event\GenerateSchemaEventArgs;
use Doctrine\ORM\Tools\ToolEvents;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\DependencyInjection\Attribute\When;

/**
 * @psalm-api
 *
 * Фикс, чтобы доктрина не добавляла "CREATE SCHEMA public" в каждую down миграцию
 */
#[When('dev')]
#[AutoconfigureTag('doctrine.event_listener', ['event' => ToolEvents::postGenerateSchema])]
class FixPostgreSQLDefaultSchemaListener
{
    public function postGenerateSchema(GenerateSchemaEventArgs $args): void
    {
        $schemaManager = $args->getEntityManager()
            ->getConnection()
            ->createSchemaManager();

        $schema = $args->getSchema();

        foreach ($schemaManager->listSchemaNames() as $namespace) {
            if (!$schema->hasNamespace($namespace)) {
                $schema->createNamespace($namespace);
            }
        }
    }
}
