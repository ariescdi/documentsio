<?php

namespace MediaBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function addConnection($user)
    {
        $dql = 'SELECT u.nbConnection FROM MediaBundle:User u WHERE u.id = :user';
        $q = $this->getEntityManager()->createQuery($dql);
        $q->setParameter(':user', $user);

        $nbConnection = $q->getSingleScalarResult();

        $nbConnection++;

        $dql = '
            UPDATE MediaBundle:User u
            SET u.nbConnection = :nbConnection
            WHERE u = :user
           '
        ;

        $q = $this->getEntityManager()->createQuery($dql);
        $q->setParameter(':nbConnection', $nbConnection);
        $q->setParameter(':user', $user);

        $q->execute();
    }

    public function findConnection()
    {
        $dql = 'SELECT u.nbConnection, u.username FROM MediaBundle:User u ';
        $q = $this->getEntityManager()->createQuery($dql);

        return $q->getResult();
    }

    public function mediaByOwner()
    {
        $dql = "SELECT u, count(u) as nbMediaByOwner FROM MediaBundle:User u JOIN u.medias m GROUP BY u.id ";
        $q = $this->getEntityManager()->createQuery($dql);

        return $q->getResult();
    }

    public function mediaPublishedByOwner()
    {
        $dql = "SELECT u,m FROM MediaBundle:User u JOIN u.medias m WHERE m.isPublished = 1 ";
        $q = $this->getEntityManager()->createQuery($dql);

        return $q->getResult();
    }
}
