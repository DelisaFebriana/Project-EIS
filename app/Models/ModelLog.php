<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLog extends Model
{
    protected $table = 'log_activity';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kategori_id', 'satuan_id','barang_id','action', 'timestamp', 'user_name'];
}