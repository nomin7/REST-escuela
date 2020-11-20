<?php namespace App\Controllers\API;

use App\Models\GradoModel;
use CodeIgniter\RESTful\ResourceController;

class Grados extends ResourceController
{
    public function __construct()
    {
        $this->model = $this->setModel(new GradoModel());
    }
	public function index()
	{
        $grados = $this->model->findAll();
		return $this->respond($grados);
    }
    
    public function create()
    {
        try {
            $grado = $this->request->getJSON();
            if($this->model->insert($grado)) {
                $grado->id = $this->model->insertID();
               return $this->respondCreated($grado);
            }else{
                return $this->failValidationError($this->model->validation->listErrors());
            }
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
    }

    public function edit($id = null)
	{
        try {
            if ($id == null)
                return $this->failValidationError('No se ha pasado un Id valido');
            
            $grado = $this->model->find($id);
            if ($grado == null)
                return $this->failValidationError('No se ha encontrado un cliente con el '.$id);

            return $this->respond($grado);

        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
    }
    
    public function update($id = null)
	{
        try {
            if ($id == null)
                return $this->failValidationError('No se ha pasado un Id valido');
            
            $gradoVerificado = $this->model->find($id);
            if ($gradoVerificado == null)
                return $this->failValidationError('No se ha encontrado un cliente con el '.$id);


            $grado = $this->request->getJSON();
            if($this->model->update($id, $grado)) {
                $grado->id = $id;
                return $this->respondUpdated($grado);
            }else{
                return $this->failValidationError($this->model->validation->listErrors());
            }

            

        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
    }

    public function delete($id = null)
	{
		try {
            if ($id == null)
                return $this->failValidationError('No se ha pasado un Id valido');
            
            $gradoVerificado = $this->model->find($id);
            if ($gradoVerificado == null)
                return $this->failValidationError('No se ha encontrado un cliente con el '.$id);

            if($this->model->delete($id)) {
                return $this->respondDeleted($gradoVerificado);
            }else{
                return $this->failServerError('No se ha podido eliminar el registro');
            }

            

        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
	}

}
