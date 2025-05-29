<?php

namespace App\Controllers;

use App\Models\SubtareaModel;
use App\Models\TareaModel;
use App\Models\ColaboradorRegistroModel;
use CodeIgniter\Controller;

class SubtareaController extends Controller
{
    public function index($id_tarea)
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/usuarios/login');
        }
        $model = new SubtareaModel();
        $data['subtareas'] = $model->where('id_tarea', $id_tarea)->findAll();
        $data['id_tarea'] = $id_tarea;

        // Añadí estas dos para evitar error en la vista
        $data['estado'] = '';
        $data['prioridad'] = '';

        return view('subtareas/listar', $data);
    }

    //Creacion
    public function crear($id_tarea)
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/usuarios/login');
        }
        return view('subtareas/crear', ['id_tarea' => $id_tarea]);
    }

    public function guardar()
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/usuarios/login');
        }        

        $model = new SubtareaModel();
        $model->save([
            'id_tarea' => $this->request->getPost('id_tarea'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado' => 'En proceso', // Estado por defecto
            'prioridad' => $this->request->getPost('prioridad'),
            'fecha_vencimiento' => $this->request->getPost('fecha_vencimiento'),
            'comentario' => $this->request->getPost('comentario'),
            'id_responsable' => null // Responsable por defecto
        ]);

        return redirect()->to('tareas/listar');
    }

    //modificacion
    public function editar($id)
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/usuarios/login');
        }
        $model = new SubtareaModel();
        $data['subtarea'] = $model->find($id);

        if (!$data['subtarea']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Subtarea no encontrada");
        }

        return view('subtareas/editar', $data);
    }

    public function actualizar($id)
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/usuarios/login');
        }
        $model = new SubtareaModel();

        $model->update($id, [
            'descripcion' => $this->request->getPost('descripcion'),
            'estado' => $this->request->getPost('estado'),
            'prioridad' => $this->request->getPost('prioridad'),
            'fecha_vencimiento' => $this->request->getPost('fecha_vencimiento'),
            'comentario' => $this->request->getPost('comentario'),
            /* 'id_responsable' => session()->get('id'), */ // <-- dueño de la tarea
            /* 'id_responsable' => $this->request->getPost('id_responsable'), */
        ]);

        $subtarea = $model->find($id);
        $idTarea = $subtarea['id_tarea'];

        return redirect()->to('/subtareas/listar/'. $idTarea); // o al detalle de la tarea
    }

    //mostrar lista
    public function listar($idTarea)
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/usuarios/login');
        }
        $model = new SubtareaModel();

        // Obtener filtros desde GET
        $estado = $this->request->getGet('estado');
        $prioridad = $this->request->getGet('prioridad');

        // Construir la consulta con filtros
        
        $builder = $model->where('id_tarea', $idTarea);

        if ($estado) {
            $builder->where('estado', $estado);
        }

        if ($prioridad) {
            $builder->where('prioridad', $prioridad);
        }

        $subtareas = $builder->findAll();

        return view('subtareas/listar', [
            'subtareas' => $subtareas,
            'id_tarea' => $idTarea,
            'estado' => $estado ?? '',
            'prioridad' => $prioridad ?? ''
        ]);
    }

    //eliminar subtarea
    public function eliminar($id)
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/usuarios/login');
        }
        $model = new SubtareaModel();
        $subtarea = $model->find($id);

        if ($subtarea) {
            $idTarea = $subtarea['id_tarea'];
            $model->delete($id);
            return redirect()->to('/subtareas/listar/' . $idTarea);
        }

        throw new \CodeIgniter\Exceptions\PageNotFoundException('Subtarea no encontrada');
    }
    
    //cambiar estado de subtarea el colaborador 
    public function cambiarEstado()
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/usuarios/login');
        }

        $id_subtarea = $this->request->getPost('id_subtarea');
        $nuevoEstado = $this->request->getPost('estado');
        $idUsuario = session()->get('id');

        $model = new SubtareaModel();
        $subtarea = $model->find($id_subtarea);

        if ($subtarea && $subtarea['id_responsable'] == $idUsuario) {
            // Solo permite que el responsable cambie el estado
            $model->update($id_subtarea, [
                'estado' => $nuevoEstado
            ]);
        }

        return redirect()->back();
    }

    public function quitarColaborador($id_subtarea)
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/usuarios/login');
        }

        $subtareaModel = new SubtareaModel();
        $tareaModel = new TareaModel();
        $colaboradorRegistroModel = new ColaboradorRegistroModel();

         // Buscar la subtarea
        $subtarea = $subtareaModel->find($id_subtarea);
        if (!$subtarea) {
            return redirect()->back()->with('error', 'Subtarea no encontrada.');
        }

         // Buscar la tarea asociada
         $tarea = $tareaModel->find($subtarea['id_tarea']);
         if (!$tarea) {
                return redirect()->back()->with('error', 'Tarea no encontrada.');
         }

        $idUsuarioActual = session()->get('id');

        // Verifica que el usuario actual sea el creador de la tarea
        if ($tarea['id_usuario'] != $idUsuarioActual) {
            return redirect()->back()->with('error', 'No tienes permiso para realizar esta acción.');
        }

        // Obtener al colaborador actual asignado
        $idColaborador = $subtarea['id_responsable'];

        // 1. Actualizar subtarea para quitar responsable
        $subtareaModel->update($id_subtarea, ['id_responsable' => null]);

        // 2. Cambiar estado del colaborador a disponible
        if ($idColaborador) {
            $colaboradorRegistroModel
                //->where('id_usuario', $idColaborador)
                ->where('id', $idColaborador)
                ->set('estado', 'disponible')
                ->update();
        }

        return redirect()->back()->with('mensaje', 'Colaborador eliminado correctamente.');
    }

    
    

}