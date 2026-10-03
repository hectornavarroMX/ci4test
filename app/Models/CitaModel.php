<?php

namespace App\Models;

use CodeIgniter\Model;

class CitaModel extends Model
{
    protected $table            = 'citas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['paciente', 'telefono', 'motivo', 'fecha'];
}