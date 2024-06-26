<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modelkategori;
use App\Models\ModelLog;

class Kategori extends BaseController
{
    public function __construct()
    {
        $this->kategori = new Modelkategori();
        $this->log = new ModelLog();
        $this->session = \Config\Services::session();
    }

    private function logAction($kategoriId, $action)
    {
        $userName = $this->session->get('name');
        $this->log->insert([
            'kategori_id' => $kategoriId,
            'action' => $action,
            'user_name' => $userName
        ]);
    }

    public function index()
    {
        $tombolcari = $this->request->getPost('tombolcari');

        if(isset($tombolcari)){
            $cari = $this->request->getPost('cari');
            session()->set('cari_kategori', $cari);
            redirect()->to('/kategori');
        }else{
            $cari = session()->get('cari_kategori');
        }

        $dataKategori = $cari ? $this->kategori->cariData($cari)->paginate(5, 'kategori') : $this->kategori->paginate(5, 'kategori');

        $nohalaman = $this->request->getVar('page_kategori') ? $this->request->getVar('page_kategori') : 1;
        $data = [
            'tampildata' => $dataKategori,
            'pager' => $this->kategori->pager,
            'nohalaman' => $nohalaman,
            'cari' => $cari
        ];
        return view('kategori/viewkategori', $data);
    }

    public function formtambah()
    {
        return view('kategori/formtambah');
    }

    public function simpandata(){
        $namakategori = $this->request->getVar('namakategori');

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'namakategori' =>[
                'rules' => 'required',
                'label' => 'Nama Kategori',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ]
        ]);

        if(!$valid){
            $pesan=[
                'errorNamaKategori' => '<br><div class="alert alert-danger">' . $validation-> getError() . '</div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('/kategori/formtambah');
        }else{
            $this->kategori->insert([
                'katnama' => $namakategori
            ]);

            $this->logAction($this->kategori->getInsertID(), 'create');

            $pesan=[
                'sukses' => '<br><div class="alert alert-success">Data kategori berhasil di tambahkan...</div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('/kategori');
        }
    }

    public function formedit($id)
    {
        $rowData = $this->kategori->find($id);

        if($rowData){

            $data = [
                'id' => $id,
                'nama' => $rowData['katnama']
            ];

            return view('kategori/formedit', $data);
        }else{
            exit('Data tidak ditemukan');
        }
    }

    public function updatedata(){
        $idkategori = $this->request->getVar('idkategori');
        $namakategori = $this->request->getVar('namakategori');

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'namakategori' =>[
                'rules' => 'required',
                'label' => 'Nama Kategori',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ]
        ]);

        if(!$valid){
            $pesan=[
                'errorNamaKategori' => '<br><div class="alert alert-danger">' . $validation-> getError() . '</div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('/kategori/formedit/' .$idkategori);
        }else{
            $this->kategori->update($idkategori, [
                'katnama' => $namakategori
            ]);

            $this->logAction($idkategori, 'update');

            $pesan=[
                'sukses' => '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> Berhasil !</h5>
                Data kategori berhasil diupdate
                </div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('/kategori');
        }
    }

    public function hapus($id){
        $rowData = $this->kategori->find($id);

        if($rowData){

            $this->kategori->delete($id);

            $this->logAction($id, 'delete');

            $pesan=[
                'sukses' => '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> Berhasil !</h5>
                Data kategori berhasil dihapus...
                </div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('/kategori');

        }else{
            exit('Data tidak ditemukan');
        }
    }
}