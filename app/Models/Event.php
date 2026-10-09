<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Override;

#[Fillable(['title', 'slug', 'description', 'max_capacity', 'allowed_domains'])]
class Event extends Model
{
    #[Override]
    protected function casts(): array
    {
        return [
            'allowed_domains' => 'array'
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'registrations')
        ->withPivot('ticket_code')
        ->withTimestamps();
    }
}
