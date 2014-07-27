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
        $creature = $this->creatures->findOne(array('_id' => $id));

        $color = new ColorChromosome($creature['chromosomes']['color']);

        $creature = new Creature($id, $creature['x'], $creature['y']);
        $creature->addToGenome($color);

        return $creature;
    }
}
