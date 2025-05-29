<?php

namespace App\Models;

use CodeIgniter\Model;

class ColaboradorRegistroModel extends Model
{
    protected $table = 'altas_colaboradores';
    protected $primaryKey = 'id';
   
    protected $allowedFields = ['nombre_colaborador','email_colaborador','password','fecha_postulacion','estado'];
}