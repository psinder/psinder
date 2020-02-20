<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Read\Shelter;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Statement;
use Sip\Psinder\Adoption\Application\Query\PetDetails;
use Sip\Psinder\Adoption\Application\Query\Shelter\OfferDetails;
use Sip\Psinder\Adoption\Application\Query\Shelter\OfferDetailsRepository;
use function assert;

final class DBALOfferDetailsRepository implements OfferDetailsRepository
{
    /** @var Connection */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function find(string $id) : ?OfferDetails
    {
        $qb = $this->connection->createQueryBuilder();

        $qb->select([
            'o.id',
            'o.shelterid as shelter_id',
            'p.id as pet_id',
            'p.name as pet_name',
            'p.sex as pet_sex',
            'p.birthdate as pet_birthdate',
            'p.breed_type as pet_type',
            'p.breed_name as pet_breed',
        ])
            ->from('offer', 'o')
            ->join('o', 'pet', 'p', 'o.pet_id = p.id')
            ->where($qb->expr()->eq('o.id', ':id'))
            ->setParameter('id', $id);

        $statement = $qb->execute();

        assert($statement instanceof Statement);

        $detailsData = $statement->fetch();

        if (! $detailsData) {
            return null;
        }

        return new OfferDetails(
            $detailsData['id'],
            $detailsData['shelter_id'],
            new PetDetails(
                $detailsData['pet_id'],
                $detailsData['pet_name'],
                $detailsData['pet_sex'],
                $detailsData['pet_birthdate'],
                $detailsData['pet_type'],
                $detailsData['pet_breed']
            )
        );
    }
}
