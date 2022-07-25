<?php

namespace App\Tasks\Task3;

class ParcelPriceCalculationFactory {

    private iterable $services;

    public function __construct(iterable $services) {
        $this->services = $services;
    }

    /**
     * @param PostalParcel $parcel
     * @return array
     */
    public function getAllPrices(PostalParcel $parcel) : array {
        $result = [];
        foreach ($this->services as $service) {
            $result[$service->getTitle()] = $service->getPriceRubles($parcel);
        }
        return $result;
    }

    public function decorateAnswer(array $answer) : string {
        $result = '';
        foreach ($answer as $name => $price) {
            $result .= $name . ": " . $price . "\n";
        }
        return $result;
    }
}
