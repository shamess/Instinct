<?php

namespace Instinct\Plant;

class MongoPlantRepository
{
    private $plants;

    public function __construct(\MongoCollection $plants)
    {
        $this->plants = $plants;
    }

    public function find()
    {
        $flatPlants = $this->plants->find();
        $plants = array();

        foreach ($flatPlants as $plant) {
            $newPlant = new Plant($plant['x'], $plant['y']);
            $newPlant->setId($plant['_id']);

            $plants[] = $newPlant;
        }

        return $plants;
    }
}
