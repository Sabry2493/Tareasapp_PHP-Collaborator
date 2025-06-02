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
        
        $validation = \Config\Services::validation();

        $rules = [
            'descripcion' => [
            'label' => 'Descripcion',
            'rules' => 'required|min_length[10]',
            'errors' => [
                'required' => 'La {field} es obligatoria.',
                'min_length' => 'La {field} debe tener al menos 10 caracteres.',
                ]
            ],
            'prioridad' => [
            'label' => 'Prioridad',
            'rules' => 'required|in_list[Baja,Normal,Alta]',
            'errors' => [
                'required' => 'El {field} es obligatorio.',
                'in_list' => 'La {field} debe ser baja,normal o alta.',
                ]
            ],
            'fecha_vencimiento' => [
            'label' => 'Fecha vencimiento',
            'rules' => 'required|valid_date',
            'errors' => [
                'required' => 'La {field} es obligatoria.',
                'valid_date' => 'La {field} debe ser valida.',
                ]
            ],
            'comentario' => [
            'label' => 'Comentario',
            'rules' => 'permit_empty|min_length[10]',
            'errors' => [
                'valid_date' => 'El {field} debe tener minimo 10 caracteres.',
                ]
            ],
            
        ];

        $idTarea = $this->request->getPost('id_tarea');
        $validation->setRules($rules);

        $fechaHoy = date('Y-m-d');
        $fechaVencimiento = $this->request->getPost('fecha_vencimiento');
           
        $valid = $validation->withRequest($this->request)->run();

        // Validaciones personalizadas
        if ($fechaVencimiento < $fechaHoy) {
            $validation->setError('fecha_vencimiento', 'La fecha de vencimiento no puede ser anterior a hoy.');
            $valid = false;
        }

        if (!$valid) {
            return view('subtareas/crear', [
                'validation' => $validation,
                'id_tarea' => $idTarea
            ]);
        }


        $model = new SubtareaModel();
        $model->save([
            'id_tarea' => $idTarea,
            'descripcion' => $this->request->getPost('descripcion'),
            'estado' => 'En proceso', // Estado por defecto
            'prioridad' => $this->request->getPost('prioridad'),
            'fecha_vencimiento' => $this->request->getPost('fecha_vencimiento'),
            'comentario' => $this->request->getPost('comentario'),
            'id_responsable' => null // Responsable por defecto
        ]);


        // ✅ Flashdata para mostrar en modal
        session()->setFlashdata('modal_msg', [
            'titulo' => 'Subtarea creada',
            'mensaje' => 'La subtarea fue registrada correctamente.'
        ]);
        return redirect()->to('/subtareas/listar/'. $idTarea);
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

        $validation = \Config\Services::validation();

        $rules = [
            'descripcion' => [
            'label' => 'Descripcion',
            'rules' => 'required|min_length[10]',
            'errors' => [
                'required' => 'La {field} es obligatoria.',
                'min_length' => 'La {field} debe tener al menos 10 caracteres.',
                ]
            ],
            'prioridad' => [
            'label' => 'Prioridad',
            'rules' => 'required|in_list[Baja,Normal,Alta]',
            'errors' => [
                'required' => 'La {field} es obligatoria.',
                'in_list' => 'La {field} debe ser baja,normal o alta.',
                ]
            ],
            'fecha_vencimiento' => [
            'label' => 'Fecha vencimiento',
            'rules' => 'required|valid_date',
            'errors' => [
                'required' => 'La {field} es obligatoria.',
                'valid_date' => 'La {field} debe ser valida.',
                ]
            ],
            'comentario' => [
            'label' => 'Comentario',
            'rules' => 'permit_empty|min_length[10]',
            'errors' => [
                'valid_date' => 'El {field} debe tener minimo 10 caracteres.',
                ]
            ],
            
        ];

        $validation->setRules($rules);

        $fechaHoy = date('Y-m-d');
        $fechaVencimiento = $this->request->getPost('fecha_vencimiento'); 

        $valid = $validation->withRequest($this->request)->run();

        if ($fechaVencimiento < $fechaHoy) {
            $validation->setError('fecha_vencimiento', 'La fecha de vencimiento no puede ser anterior a hoy.');
            $valid = false;
        }

        if (!$valid) {
            $subtarea = (new \App\Models\SubtareaModel())->find($id);
            return view('subtareas/editar', [
                'validation' => $validation,
                'subtarea' => $subtarea
            ]);
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
        
        // ✅ Flashdata para mostrar en modal
        session()->setFlashdata('modal_msg', [
            'titulo' => 'Modificación exitosa de la subtarea',
            'mensaje' => 'Los cambios fueron guardados correctamente.'
        ]);

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
            // 1. Eliminar la subtarea
            $model->delete($id);

           // 2. Reanalizar estado de la tarea
            $db = \Config\Database::connect();
            $subtareasRestantes = $db->table('subtareas')
                ->where('id_tarea', $idTarea)
                ->get()
                ->getResult();

            $todasCompletadas = true;

            foreach ($subtareasRestantes as $s) {
                if ($s->estado !== 'Completada') {
                    $todasCompletadas = false;
                    break;
                }
            }

            $nuevoEstadoTarea = $todasCompletadas && count($subtareasRestantes) > 0? 'Completada': 'En proceso';

            // 3. Actualizar estado de la tarea
            $db->table('tareas')
                ->where('id', $idTarea)
                ->update(['estado' => $nuevoEstadoTarea]);

            // 4. Si está completada, mover a archivadas
            if ($nuevoEstadoTarea === 'Completada') {
                $tarea = $db->table('tareas')->where('id', $idTarea)->get()->getRowArray();

                if ($tarea) {
                    unset($tarea['id']);
                    $tarea['archivada'] = 1;

                    $db->table('archivadas')->insert($tarea);
                    $db->table('tareas')->where('id', $idTarea)->delete();
                }
            }

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