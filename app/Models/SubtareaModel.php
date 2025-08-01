<?php

namespace App\Models;

use CodeIgniter\Model;

class SubtareaModel extends Model
{
    protected $table = 'subtareas';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_tarea',
        'descripcion',
        'estado',
        'prioridad',
        'fecha_vencimiento',
        'comentario',
        'id_responsable'
    ];
}