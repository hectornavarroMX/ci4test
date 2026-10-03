<?php

namespace App\Controllers;

use App\Models\CitaModel;

class Citas extends BaseController
{
    protected $citaModel;

    public function __construct()
    {
        $this->citaModel = new CitaModel();
    }

    // Listar citas
    public function index()
    {
        $data['citas'] = $this->citaModel->findAll();
        return view('citas/index', $data);
    }

    // Guardar nueva cita
    public function guardar()
    {
        $this->citaModel->save([
            'paciente' => $this->request->getPost('paciente'),
            'telefono' => $this->request->getPost('telefono'),
            'motivo'   => $this->request->getPost('motivo'),
            'fecha'    => $this->request->getPost('fecha'),
        ]);

        return redirect()->to(base_url('citas'));
    }

    // Eliminar cita
    public function eliminar($id)
    {
        $this->citaModel->delete($id);
        return redirect()->to(base_url('citas'));
    }
}