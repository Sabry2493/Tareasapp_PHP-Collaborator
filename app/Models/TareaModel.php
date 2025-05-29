<?php

namespace App\Models;

use CodeIgniter\Model;

class TareaModel extends Model
{
    protected $table = 'tareas';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id_usuario',
        'asunto',
        'descripcion',
        'prioridad',
        'estado',
        'fecha_vencimiento',
        'fecha_recordatorio',
        'color',
        'archivada'
    ];
}