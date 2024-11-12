<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Choice;
use App\Models\Result;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->can('viewAdmin', User::class);
    }
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function isAdmin() {
        return $this->role === self::ROLE_ADMIN;
    }

    const ROLE_ADMIN = 'ADMIN';

    const ROLE_EDITOR = 'EDITOR';

    const ROLE_USER = 'USER';

    const ROLE_DEFAULT = self::ROLE_USER;

    const ROLES = [
        self:: ROLE_ADMIN => 'Admin',
        self:: ROLE_USER => 'User'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function quizzes() {
        $this->hasMany(Quiz::class);
    }

    public function createdQuizzes() {
        return Quiz::where('user_id', auth()->user()->id)->take('*')->get();
    }

    public function rightAnswers() {
        return $this->hasMany(Question::class);
    }

    public function choices() {
        return $this->hasMany(Choice::class);
    }

    public function results() {
        return $this->hasMany(Result::class);
    }

    public function answered($question_id) {
        $choices = Choice::where('user_id', auth()->user()->id)->take('*')->get();
        foreach($choices as $choice) {
            if ($choice->question_id === $question_id) {
                return true;
            } else {
                return false;
            }
        }
    }
}
