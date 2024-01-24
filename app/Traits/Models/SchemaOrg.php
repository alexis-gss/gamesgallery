<?php

namespace App\Traits\Models;

use Spatie\SchemaOrg\Schema;

trait SchemaOrg
{
    /**
     * Return the schema of person (conceptor).
     *
     * @return \Spatie\SchemaOrg\Person
     */
    public function toPersonSchema(): \Spatie\SchemaOrg\Person
    {
        return Schema::Person()
            ->givenName(explode(" ", config('app.conceptor'))[0])
            ->familyName(explode(" ", config('app.conceptor'))[1]);
    }
}
