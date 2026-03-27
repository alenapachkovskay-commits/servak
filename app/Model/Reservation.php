<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    // Указываем имя таблицы из вашей ER-диаграммы
    protected $table = 'Reservation';

    // Указываем первичный ключ (из схемы)
    protected $primaryKey = 'ReservationID';

    // Разрешаем массовое заполнение полей из вашей схемы
    protected $fillable = [
        'Status',
        'BookID',
        'userID',
        'ReservationDate',
        'ExpiryDate'
    ];

    public $timestamps = false;

    /**
     * Связь: Бронирование принадлежит книге
     */
    public function book()
    {
        return $this->belongsTo(Book::class, 'BookID', 'InventoryNumber');
    }
}
