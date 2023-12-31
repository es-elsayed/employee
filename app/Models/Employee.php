<?php

namespace App\Models;

use App\Traits\FilterableTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Authenticatable
{
    use HasFactory, FilterableTrait, HasRoles;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'salary',
        'image',
        'department_id',
        'manager_id',
    ];

    const PATH = "employees";
    protected $guard = 'employee';

    protected $casts = [
        'password' => 'hashed',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function fullName(): Attribute
    {
        return new Attribute(
            get: fn($value) => $this->first_name . " " . $this->last_name
        );
    }
}
