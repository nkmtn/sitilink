<?php

namespace App\Tasks\Task3;
/**
 * Клас описания посылки
 */

class PostalParcel {
    private int $weight;

    public function __construct(int $weight) {
        $this->weight = $weight;
    }

    /**
     * @return int
     */
    public function getWeight() : int {
        return $this->weight;
    }
}
