<?php

namespace App\Controllers;

use App\Models\TareaModel;
use App\Models\UsuarioModel;
use App\Models\SubtareaModel;
use App\Models\ColaboradorRegistroModel;
use CodeIgniter\Controller;


class TareaController extends Controller
{
    public function index()
    {
         //Validación de sesión, ponerlo en cada metodo donde quiera que este logueado para accder
        if (!session()->get('logueado')) {
            return redirect()->to('/usuarios/login');
        }
        $model = new TareaModel();
        $data['tareas'] = $model->where('archivada', false)->findAll();

        return view('/tareas/listar', $data);
    }

    //Creacion
    public function crear()
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/usuarios/login');
        }
        return view('/tareas/crear');
    }

    public function guardar()
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/usuarios/login');
        }

        $validation = \Config\Services::validation();

        $rules = [
            'asunto' => [
            'label' => 'Asunto',
            'rules' => 'required|min_length[3]',
            'errors' => [
                'required' => 'El {field} es obligatorio.',
                'min_length' => 'El {field} debe tener al menos 3 caracteres.',
                ]
            ],
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
            'rules' => 'required',
            'errors' => [
                'required' => 'La {field} es obligatoria.',
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
            'fecha_recordatorio' => [
            'label' => 'Fecha recordatorio',
            'rules' => 'permit_empty|valid_date',
            'errors' => [
                'valid_date' => 'La {field} debe ser valida.',
                ]
            ],
            'color' => [
            'label' => 'Color',
            'rules' => 'required',
            'errors' => [
                'required' => 'El {field} es obligatorio.',
                ]
            ],
            
        ];

            $validation->setRules($rules);

            $fechaHoy = date('Y-m-d');
            $fechaVencimiento = $this->request->getPost('fecha_vencimiento');
            $fechaRecordatorio = $this->request->getPost('fecha_recordatorio');
            $color = strtolower($this->request->getPost('color'));

            if (!$validation->withRequest($this->request)->run()) {
                return view('tareas/crear', ['validation' => $validation]);
            }

            // Validaciones adicionales personalizadas
            if ($fechaVencimiento < $fechaHoy) {
                $validation->setError('fecha_vencimiento', 'La fecha de vencimiento no puede ser anterior a hoy.');
            }

            if (!empty($fechaRecordatorio) && $fechaRecordatorio > $fechaVencimiento) {
                $validation->setError('fecha_recordatorio', 'La fecha de recordatorio no puede ser posterior a la fecha de vencimiento.');
            }

            if ($color === '#ffffff' || $color === '#000000') {
                $validation->setError('color', 'No se permite el color blanco ni negro.');
            }

            // Si hay errores personalizados, reenviamos la vista
            if ($validation->getErrors()) {
                return view('tareas/crear', ['validation' => $validation]);
            }

        $model = new TareaModel();
        $model->save([
            'id_usuario' => 1, // En pruebas, usar ID fijo
            'asunto' => $this->request->getPost('asunto'),
            'descripcion' => $this->request->getPost('descripcion'),
            'prioridad' => $this->request->getPost('prioridad'),
            'estado' => 'Definida', // Estado por defecto
            'fecha_vencimiento' => $this->request->getPost('fecha_vencimiento'),
            'fecha_recordatorio' => $this->request->getPost('fecha_recordatorio'),
            'color' => $this->request->getPost('color'),
        ]);
        // ✅ Flashdata para mostrar en modal
        session()->setFlashdata('modal_msg', [
            'titulo' => 'Tarea creada',
            'mensaje' => 'La tarea fue creada exitosamente.'
        ]);

        return redirect()->to('/tareas/listar');
    }
    //modificar
    public function editar($id)
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/usuarios/login');
        }
        $model = new TareaModel();
        $tarea = $model->find($id);

        return view('tareas/editar', ['tarea' => $tarea]);
    }

    public function actualizar($id)
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/usuarios/login');
        }
         $model = new TareaModel();
         $tarea = $model->find($id);

        $validation = \Config\Services::validation();

        $rules = [
            'asunto' => [
            'label' => 'Asunto',
            'rules' => 'required|min_length[3]',
            'errors' => [
                'required' => 'El {field} es obligatorio.',
                'min_length' => 'El {field} debe tener al menos 3 caracteres.',
                ]
            ],
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
            'rules' => 'required',
            'errors' => [
                'required' => 'La {field} es obligatoria.',
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
            'fecha_recordatorio' => [
            'label' => 'Fecha recordatorio',
            'rules' => 'permit_empty|valid_date',
            'errors' => [
                'valid_date' => 'La {field} debe ser valida.',
                ]
            ],
            'color' => [
            'label' => 'Color',
            'rules' => 'required',
            'errors' => [
                'required' => 'El {field} es obligatorio.',
                ]
            ],
            
        ];

            $validation->setRules($rules);

            $fechaHoy = date('Y-m-d');
            $fechaVencimiento = $this->request->getPost('fecha_vencimiento');
            $fechaRecordatorio = $this->request->getPost('fecha_recordatorio');
            $color = strtolower($this->request->getPost('color'));
        // Validación principal
            if (!$validation->withRequest($this->request)->run()) {
                return view('tareas/editar', [
                    'validation' => $validation,
                    'tarea' => $tarea // 👈 ESTA línea es la clave
                ]);
            }

            // Validaciones adicionales personalizadas
            if ($fechaVencimiento < $fechaHoy) {
                $validation->setError('fecha_vencimiento', 'La fecha de vencimiento no puede ser anterior a hoy.');
            }

            if (!empty($fechaRecordatorio) && $fechaRecordatorio > $fechaVencimiento) {
                $validation->setError('fecha_recordatorio', 'La fecha de recordatorio no puede ser posterior a la fecha de vencimiento.');
            }

            if ($color === '#ffffff' || $color === '#000000') {
                $validation->setError('color', 'No se permite el color blanco ni negro.');
            }

            // Si hay errores personalizados, reenviamos la vista
            if ($validation->getErrors()) {
                return view('tareas/editar', ['validation' => $validation, 'tarea' => $tarea]);
            }

        $model->update($id, [
            'asunto' => $this->request->getPost('asunto'),
            'descripcion' => $this->request->getPost('descripcion'),
            'prioridad' => $this->request->getPost('prioridad'),
            'estado' => $this->request->getPost('estado'),
            'fecha_vencimiento' => $this->request->getPost('fecha_vencimiento'),
            'fecha_recordatorio' => $this->request->getPost('fecha_recordatorio'),
            'color' => $this->request->getPost('color'),
        ]);

        // Si la tarea fue marcada como completada, moverla a archivadas
        if ($this->request->getPost('estado') === 'Completada') {
            $db = \Config\Database::connect();
            $tareaData = $db->table('tareas')->where('id', $id)->get()->getRowArray();

            if ($tareaData) {
                unset($tareaData['id']);
                $tareaData['archivada'] = 1;

                $db->table('archivadas')->insert($tareaData);
                $db->table('tareas')->where('id', $id)->delete();
            }
        }


        // ✅ Flashdata para mostrar en modal
        session()->setFlashdata('modal_msg', [
            'titulo' => 'Modificación exitosa de la tarea',
            'mensaje' => 'Los cambios fueron guardados correctamente.'
        ]);

        return redirect()->to(base_url('tareas/listar'));
    }

    public function eliminar($id)
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/usuarios/login');
        }
        $model = new TareaModel();
        $model->delete($id);

        return redirect()->to(base_url('tareas/listar'));
    }

    //listar tareas en una tabla
    public function listar()
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/usuarios/login');
        }

        $model = new TareaModel();
        $subtareaModel = new SubtareaModel();
        $usuarioModel = new UsuarioModel();
        $colaboradorRegistroModel = new ColaboradorRegistroModel(); // tabla altas_colaboradores

        $estado = $this->request->getGet('estado');
        $prioridad = $this->request->getGet('prioridad');
        $filtroColaboracion = $this->request->getGet('filtro_colaboracion');
        $ordenFecha = $this->request->getGet('orden_fecha');
        $asunto = $this->request->getGet('asunto'); // Nuevo filtro

        $usuarioId= session()->get('id');
        $builder = $model->where('archivada', false) // no mostrar tareas archivadas
                         ->where('id_usuario', $usuarioId); // solo tareas propias
        if ($estado) {
            $builder = $builder->where('estado', $estado);
        }

        if ($prioridad) {
            $builder = $builder->where('prioridad', $prioridad);
        }

        

        // Obtener tareas
        $tareas = $builder->findAll();
        // Obtener lista de asuntos únicos del usuario para el select
        $asuntosDisponibles = array_unique(array_map(fn($t) => $t['asunto'], $tareas));
        
        if ($asunto) {
            $tareas = array_filter($tareas, fn($t) => $t['asunto'] == $asunto);
        }
        
       

         // Agregar colaboradores a cada tarea
         foreach ($tareas as &$tarea) {
            // Subtareas asignadas a otros (colaboradores)
            $subtareasAsignadas = $subtareaModel
                ->where('id_tarea', $tarea['id'])
                //->where('id_responsable !=', $tarea['id_usuario']) // distinto al creador
                ->where('id_responsable !=', null) // distinto a null
                ->findAll();

            $emailsColaboradores = [];

            foreach ($subtareasAsignadas as $sub) {
                
               // Buscar en la tabla de altas_colaboradores por ID de responsable
                $registro = $colaboradorRegistroModel
                    //->where('id_usuario', $sub['id_responsable'])
                    ->where('id', $sub['id_responsable'])
                    ->first();

                if ($registro) {
                    $emailFinal = $registro['email_colaborador'];

                    if (!in_array($emailFinal, $emailsColaboradores)) {
                        $emailsColaboradores[] = $emailFinal;
                    }
                }
            }

            $tarea['colaboradores'] = $emailsColaboradores;
        }
        

        // Filtrar tareas compartidas (solo si el filtro está activo)
        if ($filtroColaboracion == 'compartidas') {
            $tareas = array_filter($tareas, function ($t) {
                return !empty($t['colaboradores']);
            });
        }

        // Ordenar tareas por fecha de vencimiento
        if ($ordenFecha == 'asc') {
            usort($tareas, fn($a, $b) => strtotime($a['fecha_vencimiento']) <=> strtotime($b['fecha_vencimiento']));
        } elseif ($ordenFecha == 'desc') {
            usort($tareas, fn($a, $b) => strtotime($b['fecha_vencimiento']) <=> strtotime($a['fecha_vencimiento']));
        }

        return view('tareas/listar', [
            'tareas' => $tareas,
            'estado' => $estado ?? '',
            'prioridad' => $prioridad ?? '',
            'filtro' => $filtroColaboracion ?? '',
            'orden' => $ordenFecha ?? '',
            'asunto' => $asunto ?? '',
            'asuntosDisponibles' => $asuntosDisponibles
        ]);

        
    }

    //colaboradores
    //muestra el formualario para compartir una subtarea
    public function mostrarCompartir($id_tarea)
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/usuarios/login');
        }
       
         // Instanciar modelos necesarios
        $subtareaModel = new SubtareaModel();
        $colaboradorRegistroModel = new ColaboradorRegistroModel();
        $usuarioModel = new UsuarioModel(); 
        $tareaModel = new TareaModel();

        //pasar el id_usuario (creador de la tarea) a la vista
        $tarea = $tareaModel->find($id_tarea);
        $idCreadorTarea = $tarea['id_usuario'];

        // Obtener colaboradores disponibles desde altas_colaboradores
        $usuariosDisponibles = $colaboradorRegistroModel
            ->where('estado', 'disponible')
            ->findAll(); // ya tienen el email_colaborador, no hace falta join
        

        // Obtener subtareas de la tarea que todavía tienen como responsable al creador
        $subtareasDisponibles = $subtareaModel
            ->where('id_tarea', $id_tarea)
            ->where('id_responsable', null)
            ->findAll();

        //obtener subtareas asignadas para mostrar los usuarios asignados a esa tarea
        $subtareasAsignadas = $subtareaModel
            ->where('id_tarea', $id_tarea)
            //->where('id_responsable !=', session()->get('id')) // distinto al creador
            ->where('id_responsable !=', null) // distinto a null
            ->findAll();
        
        
        // Formamos el array enriquecido para la vista
        $subtareasAsignadasInfo = [];

        foreach ($subtareasAsignadas as $sub) {
            $registro = $colaboradorRegistroModel
                //->where('id_usuario', $sub['id_responsable'])
                ->where('id', $sub['id_responsable'])
                ->first();

            if ($registro) {
                $subtareasAsignadasInfo[] = [
                    'id_subtarea' => $sub['id'],
                    'descripcion' => $sub['descripcion'],
                    'estado' => $sub['estado'],
                    'id_responsable' => $sub['id_responsable'],
                    'email_colaborador' => $registro['email_colaborador'],
                    
                ];
            }
        }

        return view('tareas/compartir', [
            'id_tarea' => $id_tarea,
            'usuarios' => $usuariosDisponibles,
            'subtareas_disponibles' => $subtareasDisponibles,
            'subtareas_asignadas' => $subtareasAsignadasInfo,
            'id_usuario_creador_tarea' => $idCreadorTarea
            
        ]);
        

        
    }


    //procesa la asignacion
    public function asignar_subtarea($id_tarea)
    {
        // Verificar sesión
        if (!session()->get('logueado')) {
            return redirect()->to('/usuarios/login');
        }

        // Recolectar datos del formulario
        $email = $this->request->getPost('email_colaborador');
        $id_subtarea = $this->request->getPost('id_subtarea');

        // Modelos necesarios
        $colaboradorRegistroModel = new ColaboradorRegistroModel();
        $subtareaModel = new SubtareaModel();
        $tareaModel = new TareaModel(); // Asegurate de tenerlo
        

        // Buscar el colaborador por su email (de la tabla altas_colaboradores)
        $colaborador = $colaboradorRegistroModel
            ->where('email_colaborador', $email)
            ->first();

        if ($colaborador) {
            // Obtener subtarea y tarea asociada
            $subtarea = $subtareaModel->find($id_subtarea);
            
            // Actualizar la subtarea: asignar colaborador como nuevo responsable
            $subtareaModel->update($id_subtarea, [
                'id_responsable' => $colaborador['id'],
                'estado' => 'En proceso'
            ]);
            // Marcar al colaborador como no disponible
            $colaboradorRegistroModel->update($colaborador['id'], [
                'estado' => 'no disponible'
            ]);
        }
         //  NUEVO BLOQUE: actualizar estado de la tarea relacionada
            $subtarea = $subtareaModel->find($id_subtarea);
            $id_tarea = $subtarea['id_tarea'];

            // Obtener todas las subtareas de esa tarea
            $subtareas = $subtareaModel->where('id_tarea', $id_tarea)->findAll();

            $hayEnProceso = false;
            $todasCompletadas = true;

            foreach ($subtareas as $s) {
                if ($s['estado'] === 'En proceso') {
                    $hayEnProceso = true;
                }
                if ($s['estado'] !== 'Completada') {
                    $todasCompletadas = false;
                }
            }

            // Determinar el nuevo estado
            if ($todasCompletadas && count($subtareas) > 0) {
                $nuevoEstadoTarea = 'Completada';
            } elseif ($hayEnProceso) {
                $nuevoEstadoTarea = 'En proceso';
            } else {
                $nuevoEstadoTarea = 'Definida';
            }

            // Actualizar la tarea
            $tareaModel->update($id_tarea, ['estado' => $nuevoEstadoTarea]);
            //  FIN BLOQUE

        
            // ✅ Flashdata para mostrar en modal
            session()->setFlashdata('modal_msg', [
                'titulo' => 'Subtarea asignada',
                'mensaje' => 'Se asignó la subtarea <strong>' . esc($subtarea['descripcion']) . '</strong> al colaborador <strong>' . esc($colaborador['email_colaborador']) . '</strong>.'
            ]);
        
        return redirect()->to('/tareas/mostrarCompartir/' . $id_tarea); 
    }

    //ARCHIVADAS
    public function verArchivadas()
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/usuarios/login');
        }

       /*  $id_usuario = session()->get('id_usuario'); */
        $id_usuario = session()->get('id');

        $db = \Config\Database::connect();
        $archivadas = $db->table('archivadas')
            ->where('id_usuario', $id_usuario)
            ->get()
            ->getResult();

        return view('tareas/archivadas', ['archivadas' => $archivadas]);
    }

    // Restaurar una tarea desde "archivadas" a "tareas"
    public function restaurar($id)
    {
        $db = \Config\Database::connect();
        $tarea = $db->table('archivadas')->where('id', $id)->get()->getRowArray();

        if ($tarea) {
            unset($tarea['id']); // Evita conflicto de PK
            $tarea['archivada'] = 0;
            $tarea['estado'] = 'Definida';

            $db->table('tareas')->insert($tarea);

            //Eliminar tarea archivada
            $db->table('archivadas')->where('id', $id)->delete();
            // ✅ Flashdata para mostrar en modal
            session()->setFlashdata('modal_msg', [
                'titulo' => 'Restauración exitosa de la tarea',
                'mensaje' => 'La tarea fue restaurada correctamente.'
            ]);
            return redirect()->to(base_url('tareas/archivadas'));
        }else {

        return redirect()->to(base_url('/tareas/archivadas'));
        }
    }

    // Eliminar definitivamente
    public function eliminarArchivada($id)
    {
        $db = \Config\Database::connect();
        $db->table('archivadas')->where('id', $id)->delete();

        return redirect()->to(base_url('/tareas/archivadas'))->with('success', 'Tarea archivada eliminada.');
    }

    
}