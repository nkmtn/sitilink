<?php

namespace App\Tasks\Task3\PostalServices;

use App\Tasks\Task3\PostalParcel;
use App\Tasks\Task3\PostalServiceInterface;

/**
 * Стратегия расчета стоимости DHL
 */

class DHLStrategy implements PostalServiceInterface {

    const PRICE_PER_KILO_RUBLES = 100;

    /**
     * @inheritDoc
     */
    public function getTitle(): string {
        return 'DHL';
    }

    /**
     * @inheritDoc
     */
    public function getPriceRubles(PostalParcel $parcel): ?int {
        return $parcel->getWeight() ? $parcel->getWeight() * self::PRICE_PER_KILO_RUBLES : null;
    }
}
