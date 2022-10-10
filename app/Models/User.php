<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     *
     *
     * @var string
     */
    protected $guard_name = 'sanctum';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function submissions(): HasMany
    {
        $id = $this->hasRole('Patient') ? 'patient_id' : 'doctor_id';

        if ($this->hasRole('Patient')) {
            return $this->hasMany(Submission::class, 'patient_id');
        }

        return $this->hasMany(Submission::class, 'doctor_id')->orWhereNull('doctor_id');
    }

    public function doctor(): bool
    {
        return $this->hasRole('Doctor');
    }

    public function patient(): bool
    {
        return $this->hasRole('Patient');
    }
}
