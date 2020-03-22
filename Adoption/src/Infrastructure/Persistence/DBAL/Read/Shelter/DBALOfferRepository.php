<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Read\Shelter;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Statement;
use Sip\Psinder\Adoption\Application\Query\Offer\OfferApplication;
use Sip\Psinder\Adoption\Application\Query\Offer\OfferDetails;
use Sip\Psinder\Adoption\Application\Query\Offer\OfferRepository;
use Sip\Psinder\Adoption\Application\Query\PetDetails;
use function assert;
use function Functional\map;

final class DBALOfferRepository implements OfferRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findDetails(string $id) : ?OfferDetails
    {
        $qb = $this->connection->createQueryBuilder();

        $qb->select([
            'o.id',
            'o.shelter_id as shelter_id',
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

        $detailsData = $statement->fetchAll()[0] ?? null;

        if ($detailsData === null) {
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

    /** @return OfferApplication[] */
    public function getApplications(string $id) : array
    {
        $qb = $this->connection->createQueryBuilder();

        $qb->select([
            'o.id as offer_id',
            's.id as shelter_id',
            's.name as shelter_name',
            'a.id as adopter_id',
            'a.name as adopter_name',
        ])
            ->from('offer', 'o')
            ->where($qb->expr()->eq('o.id', ':id'))
            ->join('o', 'shelter', 's', 'o.shelter_id = s.id')
            ->join('o', 'offer_application', 'oa', 'oa.offer_id = o.id')
            ->join('oa', 'adopter', 'a', 'oa.adopter_id = a.id')
            ->groupBy('s.id, o.id, a.id')
            ->setParameter('id', $id);

        $statement = $qb->execute();

        assert($statement instanceof Statement);

        $offers = $statement->fetchAll();

        return map($offers, fn(array $item) => new OfferApplication(
            $item['offer_id'],
            $item['shelter_id'],
            $item['shelter_name'],
            $item['adopter_id'],
            $item['adopter_name'],
        ));
    }
}
