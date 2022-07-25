<?php

namespace App\Tasks\Task3;

interface PostalServiceInterface {
    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @param PostalParcel $parcel
     * @return int|null
     */
    public function getPriceRubles(PostalParcel $parcel): ?int;
}
