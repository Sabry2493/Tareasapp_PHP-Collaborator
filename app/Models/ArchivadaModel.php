<?php
namespace App\Models;
use CodeIgniter\Model;

class ArchivadaModel extends Model
{
    protected $table = 'archivadas';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_usuario', 'asunto', 'descripcion', 'prioridad', 'estado',
        'fecha_vencimiento', 'fecha_recordatorio', 'color', 'archivada'
    ];
}