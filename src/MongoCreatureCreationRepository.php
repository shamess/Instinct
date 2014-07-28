<?php

namespace Instinct;

use Instinct\MongoCreatureRepository;

class MongoCreatureCreationRepository
{
    private $sequenceStorage, $creatures;

    public function __construct(MongoCreatureRepository $creatures, \MongoCollection $sequenceStorage)
    {
        $this->sequenceStorage = $sequenceStorage;
        $this->creatures = $creatures;
    }

    public function save(Creature $creature)
    {
        if ($creature->getId()) {
            throw new \Exception("Can't create a new creature - this one already exists with an ID: [" . $creature->getId() . "]");
        }

        $id = $this->getNextId();

        $creature->setId($id);
        $this->creatures->save($creature);
    }

    private function getNextId()
    {
        $updatedRecord = $this->sequenceStorage->findAndModify(
            array('_id' => 'creature_id'),
            array('$inc' => array('current_id' => 1)),
            array('current_id' => true),
            array('new' => true)
        );

        return $updatedRecord['current_id'];
    }
}
