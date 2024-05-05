<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Modelbarang;
use App\Models\Modelkategori;
use App\Models\Modelsatuan;

class Barang extends BaseController
{
    public function __construct() 
    {
        $this->barang = new Modelbarang();
    }

    public function index()
    {
        $data = [
            'tanpildata' => $this->barang->tampildata()
        ];
        return view('barang/viewbarang', $data);
    }
}
