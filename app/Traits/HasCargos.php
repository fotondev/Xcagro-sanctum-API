<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Cargo;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasCargos
{
    public function cargos(): HasMany
    {
        return $this->hasMany(Cargo::class);
    }

    public function assignOrder(Cargo $cargo)
    {
        $this->cargos()->associate($cargo);
        $this->save();
    }
}
