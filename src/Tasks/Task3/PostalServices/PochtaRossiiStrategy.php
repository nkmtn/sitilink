<?php

namespace App\Tasks\Task3\PostalServices;

use App\Tasks\Task3\PostalParcel;
use App\Tasks\Task3\PostalServiceInterface;

/**
 * Стратегия расчета стоимости Почты России
 */

class PochtaRossiiStrategy implements PostalServiceInterface {

    const BRANCH = 10;

    const PRICE_UNDER_BRANCH_RUBLES = 100;

    const PRICE_OVER_BRANCH_RUBLES = 1000;

    public function getTitle(): string {
        return "Почта России";
    }

    public function getPriceRubles(PostalParcel $parcel): ?int {
        if (is_null($parcel->getWeight())) {
            return null;
        }
        return $parcel->getWeight() < self::BRANCH ? self::PRICE_UNDER_BRANCH_RUBLES : self::PRICE_OVER_BRANCH_RUBLES;
    }
}
