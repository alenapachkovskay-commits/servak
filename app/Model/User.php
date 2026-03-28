<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class User extends Model implements IdentityInterface
{
    use HasFactory;
    protected $table = 'user';

    // 2. Указываем первичный ключ (проверь, чтобы в БД он был именно userID)
    protected $primaryKey = 'userID';
    public $timestamps = false;
    protected $fillable = [
        'Name',
        'Surname',
        'Email',
        'login',
        'password',
        'role',
        'RegestrationDate'
    ];



    protected static function booted()
    {
        static::creating(function ($user) {
            $user->password = md5($user->password);
            $user->RegestrationDate = date('Y-m-d');
            $user->role = 2; // По умолчанию 'reader'
        });
    }

    //Выборка пользователя по первичному ключу
    public function findIdentity(int $id)
    {
        return self::where('userID', $id)->first();
    }

    //Возврат первичного ключа
    public function getId(): int
    {
        return $this->userID;
    }

    //Возврат аутентифицированного пользователя
    public function attemptIdentity(array $credentials)
    {
        return self::where([
            'login' => $credentials['login'],
            'password' => md5($credentials['password'])
        ])->first();
    }
}
