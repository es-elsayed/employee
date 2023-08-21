<?php

namespace App\Models;

use App\Traits\FilterableTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory, FilterableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    protected $casts = [
        'password' => 'hashed',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'manager_id');
    }
    public function fullName(): Attribute
    {
        return new Attribute(
            get: fn($value) => $this->first_name . " " . $this->last_name
        );
    }
}
