<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Modelbarang;
use App\Models\Modelkategori;
use App\Models\Modelsatuan;
use App\Models\ModelLog;

class Barang extends BaseController
{
    public function __construct() 
    {
        $this->barang = new Modelbarang();
        $this->log = new ModelLog();
        $this->session = \Config\Services::session();
    }

    private function logAction($kodebarang, $action)
    {
        $userName = $this->session->get('name');
        $this->log->insert([
            'barang_id' => $kodebarang,
            'action' => $action,
            'user_name' => $userName
        ]);
    }

    public function index()
    {
        $data = [
            'tampildata' => $this->barang->tampildata()
        ];
        return view('barang/viewbarang', $data);
    }

    public function tambah()
    {
        $modelkategori = new Modelkategori();
        $modelsatuan = new Modelsatuan();

        $data = [
            'datakategori' => $modelkategori->findAll(),
            'datasatuan' => $modelsatuan->findAll()
        ];
        return view('barang/formtambah', $data);
    }

    public function simpandata(){
        $kodebarang = $this->request->getVar('kodebarang');
        $namabarang = $this->request->getVar('namabarang');
        $kategori = $this->request->getVar('kategori');
        $satuan = $this->request->getVar('satuan');
        $harga = $this->request->getVar('harga');
        $stok = $this->request->getVar('stok');

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'kodebarang' => [
                'rules' => 'required|is_unique[barang.brgkode]',
                'label' => 'Kode Barang',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'is_unique' => '{field} sudah ada...'
                    ]
                ],
                'namabarang' => [
                    'rules' => 'required',
                    'label' => 'Nama Barang',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'kategori' => [
                    'rules' => 'required',
                    'label' => 'Kategori',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'satuan' => [
                    'rules' => 'required',
                    'label' => 'satuan',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'harga' => [
                    'rules' => 'required|numeric',
                    'label' => 'Harga',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'numeric' => '{field} hanya dalam bentuk angka'
                    ]
                ],
                'stok' => [
                    'rules' => 'required|numeric',
                    'label' => 'Stok',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'numeric' => '{field} hanya dalam bentuk angka'
                    ]
                ],
                'gambar' => [
                    'rules' => 'mime_in[gambar,image/png,image/jpg,image/jpeg]|ext_in[gambar,png,jpg,jpeg]',
                    'label' => 'Gambar',
                ]
        ]);

        if(!$valid){
            $sess_Pesan = [
                'error' => '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                '.$validation->listErrors().'
                </div>'
            ];

            session()->setFlashdata($sess_Pesan);
            return redirect()->to('/barang/tambah');
        }else{
            $gambar = $_FILES['gambar']['name'];

            if($gambar != NULL){
                $namaFileGambar = $kodebarang;
                $fileGambar = $this->request->getFile('gambar');
                $fileGambar->move('upload',$namaFileGambar.'.'.$fileGambar->getExtension());

                $pathGambar = 'upload'.$fileGambar->getName();
            }else{
                $pathGambar = '';
            }

            $this->barang->insert([
                'brgkode' => $kodebarang,
                'brgnama' => $namabarang,
                'brgkatid' => $kategori,
                'brgsatid' => $satuan,
                'brgharga' => $harga,
                'brgstok' => $stok,
                'brggambar' => $pathGambar
            ]);

            $this->logAction($kodebarang, 'create');

            $pesan_sukses = [
                'sukses' => '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> Berhasil !</h5>
                Data Barang dengan kode <strong>'.$kodebarang.'</strong> berhasil disimpan
                </div>'
            ];

            session()->setFlashdata($pesan_sukses);
            return redirect()->to('/barang/tambah');
        }
    }

    public function edit($kode){
        $cekData = $this->barang->find($kode);

        if($cekData){

            $modelkategori = new Modelkategori();
            $modelsatuan = new Modelsatuan();

            $data = [
                'kodebarang' => $cekData['brgkode'],
                'namabarang' => $cekData['brgnama'],
                'kategori' => $cekData['brgkatid'],
                'satuan' => $cekData['brgsatid'],
                'harga' => $cekData['brgharga'],
                'stok' => $cekData['brgstok'],
                'datakategori' => $modelkategori->findAll(),
                'datasatuan' => $modelsatuan->findAll(),
                'gambar' => $cekData['brggambar']
            ];
            return view('barang/formedit', $data);

        }else{
            $pesan_error = [
                'error' => '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                Data Barang tidak ditemukan..
                </div>'
            ];

            session()->setFlashdata($pesan_error);
            return redirect()->to('/barang/index');
        }
    }

    public function updatedata(){
        $kodebarang = $this->request->getVar('kodebarang');
        $namabarang = $this->request->getVar('namabarang');
        $kategori = $this->request->getVar('kategori');
        $satuan = $this->request->getVar('satuan');
        $harga = $this->request->getVar('harga');
        $stok = $this->request->getVar('stok');

        $validation = \Config\Services::validation();

        $valid = $this->validate([
                'namabarang' => [
                    'rules' => 'required',
                    'label' => 'Nama Barang',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'kategori' => [
                    'rules' => 'required',
                    'label' => 'Kategori',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'satuan' => [
                    'rules' => 'required',
                    'label' => 'satuan',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'harga' => [
                    'rules' => 'required|numeric',
                    'label' => 'Harga',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'numeric' => '{field} hanya dalam bentuk angka'
                    ]
                ],
                'stok' => [
                    'rules' => 'required|numeric',
                    'label' => 'Stok',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'numeric' => '{field} hanya dalam bentuk angka'
                    ]
                ],
                'gambar' => [
                    'rules' => 'mime_in[gambar,image/png,image/jpg,image/jpeg]|ext_in[gambar,png,jpg,jpeg]',
                    'label' => 'Gambar',
                ]
        ]);

        if(!$valid){
            $sess_Pesan = [
                'error' => '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                '.$validation->listErrors().'
                </div>'
            ];

            session()->setFlashdata($sess_Pesan);
            return redirect()->to('/barang/tambah');
        }else{
            $cekData = $this->barang->find($kodebarang);
            $pathGambarLama = $cekData['brggambar'];

            $gambar = $_FILES['gambar']['name'];

            if($gambar != NULL){
                ($pathGambarLama == '' || $pathGambarLama==null) ? '' :unlink($pathGambarLama); 
                $namaFileGambar = $kodebarang;
                $fileGambar = $this->request->getFile('gambar');
                $fileGambar->move('upload',$namaFileGambar . '.' . $fileGambar->getExtension());

                $pathGambar = 'upload/'.$fileGambar->getName();
            }else{
                $pathGambar = $pathGambarLama;
            }

            $this->barang->update($kodebarang,[
                'brgnama' => $namabarang,
                'brgkatid' => $kategori,
                'brgsatid' => $satuan,
                'brgharga' => $harga,
                'brgstok' => $stok,
                'brggambar' => $pathGambar
            ]);

            $this->logAction($kodebarang, 'update');

            $pesan_sukses = [
                'sukses' => '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> Berhasil !</h5>
                Data Barang dengan kode <strong>'.$kodebarang.'</strong> berhasil diupdate
                </div>'
            ];

            session()->setFlashdata($pesan_sukses);
            return redirect()->to('/barang/index');
    }
}

public function hapus($kode)
{
    $cekData = $this->barang->find($kode);

    if ($cekData){

        $pathGambarLama = $cekData['brggambar'];
        if (file_exists($pathGambarLama))
        unlink($pathGambarLama);
        $this->barang->delete($kode);

        $this->logAction($kode, 'delete');

        $pesan_sukses = [
            'sukses' => '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i> Berhasil !</h5>
            Data Barang dengan kode <strong>'.$kode.'</strong> berhasil dihapus
            </div>'
        ];

        session()->setFlashdata($pesan_sukses);
        return redirect()->to('/barang/index');

    }else{
        $pesan_error = [
            'error' => '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Error!</h5>
            Data Barang tidak ditemukan..
            </div>'
        ];

            session()->setFlashdata($pesan_error);
            return redirect()->to('/barang/index');
    }
}
}