<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelSatuan;
use App\Models\ModelLog;

class Satuan extends BaseController
{
    public function __construct()
    {
        $this->satuan = new Modelsatuan();
        $this->log = new ModelLog();
        $this->session = \Config\Services::session();
    }

    private function logAction($satuanId, $action)
    {
        $userName = $this->session->get('name');
        $this->log->insert([
            'satuan_id' => $satuanId,
            'action' => $action,
            'user_name' => $userName
        ]);
    }
    
    public function index()
    {
        $tombolcari = $this->request->getPost('tombolcari');

        if(isset($tombolcari)){
            $cari = $this->request->getPost('cari');
            session()->set('cari_satuan', $cari);
            redirect()->to('/satuan/index');
        }else{
            $cari = session()->get('cari_satuan');
        }

        $dataSatuan = $cari ? $this->satuan->cariData($cari)->paginate(5, 'satuan') : $this->satuan->paginate(5, 'satuan');

        $nohalaman = $this->request->getVar('page_satuan') ? $this->request->getVar('page_satuan') : 1;
        $data = [
            'tampildata' => $dataSatuan,
            'pager' => $this->satuan->pager,
            'nohalaman' => $nohalaman,
            'cari' => $cari
        ];
        return view('satuan/viewsatuan', $data);
    }

    public function formtambah()
    {
        return view('satuan/formtambah');
    }

    public function simpandata(){
        $namasatuan = $this->request->getVar('namasatuan');

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'namasatuan' =>[
                'rules' => 'required',
                'label' => 'Nama Satuan',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ]
        ]);

        if(!$valid){
            $pesan=[
                'errorNamaSatuan' => '<br><div class="alert alert-danger">' . $validation-> getError() . '</div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('/satuan/formtambah');
        }else{
            $this->satuan->insert([
                'satnama' => $namasatuan
            ]);

            $this->logAction($this->satuan->getInsertID(), 'create');

            $pesan=[
                'sukses' => '<br><div class="alert alert-success">Data satuan berhasil di tambahkan...</div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('/satuan/index');
        }
    }

    public function formedit($id)
    {
        $rowData = $this->satuan->find($id);

        if($rowData){

            $data = [
                'id' => $id,
                'nama' => $rowData['satnama']
            ];

            return view('satuan/formedit', $data);
        }else{
            exit('Data tidak ditemukan');
        }
    }

    public function updatedata(){
        $idsatuan = $this->request->getVar('idsatuan');
        $namasatuan = $this->request->getVar('namasatuan');

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'namasatuan' =>[
                'rules' => 'required',
                'label' => 'Nama Satuan',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ]
        ]);

        if(!$valid){
            $pesan=[
                'errorNamaSatuan' => '<br><div class="alert alert-danger">' . $validation-> getError() . '</div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('/satuan/formedit/' .$idsatuan);
        }else{
            $this->satuan->update($idsatuan, [
                'satnama' => $namasatuan
            ]);

            $this->logAction($idsatuan, 'update');

            $pesan=[
                'sukses' => '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> Berhasil !</h5>
                Data satuan berhasil diupdate
                </div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('/satuan/index');
        }
    }

    public function hapus($id){
        $rowData = $this->satuan->find($id);

        if($rowData){

            $this->satuan->delete($id);

            $this->logAction($id, 'delete');

            $pesan=[
                'sukses' => '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> Berhasil !</h5>
                Data satuan berhasil dihapus...
                </div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('/satuan/index');

        }else{
            exit('Data tidak ditemukan');
        }
    }
}
