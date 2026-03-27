<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    // Указываем реальное имя таблицы из вашей схемы
    protected $table = 'Book_copies';

    // Указываем ваш первичный ключ (вместо стандартного id)
    protected $primaryKey = 'InventoryNumber';
    public $timestamps = false;
}