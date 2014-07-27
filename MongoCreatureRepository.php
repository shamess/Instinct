<?php

class MongoCreatureRepository
{
    /**
     * @var \MongoCollection
     */
    private $creatures;

    public function __construct(\MongoCollection $collection)
    {
        $this->creatures = $collection;
    }

    public function findOneById($id)
    {
        $flatCreature = $this->creatures->findOne(array('_id' => $id));

        $creature = $this->flatToCreature($flatCreature);

        return $creature;
    }

    public function find()
    {
        $flatCreatures = $this->creatures->find();

        $creatures = array();
        foreach ($flatCreatures as $creature) {
            $creatures[] = $this->flatToCreature($creature);
        }

        return $creatures;
    }

    private function flatToCreature(array $flatCreature)
    {
        $color = new ColorChromosome($flatCreature['chromosomes']['color']);

        $creature = new Creature($flatCreature['x'], $flatCreature['y']);
        $creature->setId($flatCreature['_id']);
        $creature->addToGenome($color);

        return $creature;
    }

    public function save(Creature $creature)
    {
        if (!$creature->getId()) {
            throw new \Exception("Creature doesn't have an ID, so can't be saved. Use CreationRepostiory.");
        }

        $flatCreature = array(
            'x' => $creature->getX(),
            'y' => $creature->getY(),
            'chromosomes' => array(),
        );

        foreach ($creature->getChromosomePairs() as $pair) {
            $flatCreature['chromosomes'][$pair->getName()] = $pair->getGenesAsString();
        }

        $this->creatures->update(
            array('_id' => $creature->getId()), array('$set' => $flatCreature),
            array('upsert' => true)
        );
    }
}
