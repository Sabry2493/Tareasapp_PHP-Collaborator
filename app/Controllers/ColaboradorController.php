<?php

namespace App\Controllers;

use App\Models\ColaboradorRegistroModel;

class ColaboradorController extends BaseController
{
    public function login()
    {
        helper(['form']);
        return view('colaboradores/login_colaborador'); // tu vista de login colaborador
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
    
    
    public function procesarLogin()
    {
        $email = $this->request->getPost('email_colaborador');
        $password = $this->request->getPost('password');
        

        $model = new ColaboradorRegistroModel();
        $colaborador = $model->where('email_colaborador', $email)->first();

        // Verificar si el colaborador existe
        if (!$colaborador) {
            return redirect()->back()->with('error', 'Email no encontrado');
        }
        // Verificar la contraseña
        if (!password_verify($password, $colaborador['password'])) {
        return redirect()->back()->with('error', 'Contraseña incorrecta');
            
        }
   
        // Guardamos sesión del colaborador
        session()->set([
            'logueado' => true,
            'rol' => 'colaborador',
            'id_colaborador' => $colaborador['id'],
            'email_colaborador' => $colaborador['email_colaborador'],
            'nombre_colaborador' => $colaborador['nombre_colaborador']
        ]);

        return redirect()->to('/colaboradores/dashboard'); // creamos esta vista luego
    }
    
    public function solicitar()
    {
        
        //regresa la vista solicitar_colaborador 
        return view('colaboradores/solicitar_colaborador');
    }

    public function registrar()
    {
        //Habilita funciones para manejar formularios y errores.
       helper(['form']);
        // array que define las reglas de validación del formulario. Se usa junto con $this->validate($rules)
        /* $rules = [
            'nombre_colaborador' => 'required|min_length[3]|is_unique[altas_colaboradores.nombre_colaborador]',
            'email_colaborador' => 'required|valid_email|is_unique[altas_colaboradores.email_colaborador]',
            'password' => 'required|min_length[5]',
        ]; */
         //para que sea en español y personalizadas, sino viene en ingles predeterminado
        $rules = [
            'nombre_colaborador' => [
            'label' => 'Nombre de colaborador',
            'rules' => 'required|min_length[3]|is_unique[altas_colaboradores.nombre_colaborador]',
            'errors' => [
                'required' => 'El {field} es obligatorio.',
                'min_length' => 'El {field} debe tener al menos 3 caracteres.',
                'is_unique' => 'El {field} ya está en uso.',
                ]
            ],
            'email_colaborador' => [
                'label' => 'Correo electrónico',
                'rules' => 'required|valid_email|is_unique[altas_colaboradores.email_colaborador]',
                'errors' => [
                    'required' => 'El {field} es obligatorio.',
                    'valid_email' => 'El {field} no es válido.',
                    'is_unique' => 'El {field} ya está registrado.',
                ]
            ],
            'password' => [
                'label' => 'Contraseña',
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => 'La {field} es obligatoria.',
                    'min_length' => 'La {field} debe tener al menos 5 caracteres.',
                ]
            ],
            'acepta_compromiso' => [
                'label' => 'Confirmación de compromiso',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debes aceptar el compromiso para continuar.',
                ]
            ]
        ];

        //Si no se cumplen, retorna false y se entra al if
        if (!$this->validate($rules)) {
            //se vuelve a cargar la vista del formulario pasando los errores a validation:
            //$this->validator: objeto interno de CodeIgniter que contiene todos los errores después de ejecutar $this->validate().
            return view('colaboradores/solicitar_colaborador', ['validation' => $this->validator]);
        }
        

        if (!$this->request->is('post')) {
            return redirect()->to('/colaboradores/solicitar');
        }

        $nombre_colaborador = $this->request->getPost('nombre_colaborador');
        $email = $this->request->getPost('email_colaborador');
        $password = $this->request->getPost('password');

         //nueva instancia del modelo
        $model = new ColaboradorRegistroModel();
        //Insertar el nuevo colaborador
        $model->insert([
            'nombre_colaborador'=>$nombre_colaborador,
            'email_colaborador' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'fecha_alta' => date('Y-m-d H:i:s'),
            'estado' => 'disponible'
        ]);

        //regresa a login
        return redirect()->to('/colaboradores/login')->with('mensaje', 'Registro exitoso. Ya podés iniciar sesión.');
       
    }

    public function dashboard()
    {
        $id_colaborador = session()->get('id_colaborador');
        if (!$id_colaborador) {
            return redirect()->to('colaboradores/login')->with('error', 'Debes iniciar sesión.');
        }

        $db = \Config\Database::connect();

        // Obtenemos tareas donde el colaborador tiene subtareas asignadas
        // y también traemos TODAS las subtareas de esas tareas (con sus responsables)
        $builder = $db->table('subtareas')
            ->select('
                tareas.id as id_tarea,
                tareas.asunto,
                tareas.estado as estado_tarea,
                tareas.fecha_vencimiento,
                tareas.prioridad,
                tareas.color,
                subtareas.id as id_subtarea,
                subtareas.descripcion,
                subtareas.estado,
                subtareas.id_responsable,
                altas_colaboradores.email_colaborador as email_colaborador
            ')
            ->join('tareas', 'tareas.id = subtareas.id_tarea')
            ->join('altas_colaboradores', 'altas_colaboradores.id = subtareas.id_responsable', 'left')
            ->whereIn('subtareas.id_tarea', function($subquery) use ($id_colaborador) {
                $subquery->select('id_tarea')
                        ->from('subtareas')
                        ->where('id_responsable', $id_colaborador);
            })
            ->orderBy('tareas.id', 'asc');

        $result = $builder->get()->getResultArray();

        // Agrupamos las subtareas por tarea
        $tareasAgrupadas = [];

        foreach ($result as $row) {
            $tarea_id = $row['id_tarea'];
            if (!isset($tareasAgrupadas[$tarea_id])) {
                $tareasAgrupadas[$tarea_id] = [
                    'id' => $row['id_tarea'],
                    'asunto' => $row['asunto'],
                    'estado' => $row['estado_tarea'],
                    'fecha_vencimiento' => $row['fecha_vencimiento'],
                    'prioridad' => $row['prioridad'],
                    'color' => $row['color'],
                    'subtareas' => []
                ];
            }

            $tareasAgrupadas[$tarea_id]['subtareas'][] = [
                'id_subtarea' => $row['id_subtarea'],
                'descripcion' => $row['descripcion'],
                'estado' => $row['estado'],
                'id_responsable' => $row['id_responsable'],
                'email_colaborador' => $row['email_colaborador']
            ];
        }

        return view('colaboradores/dashboard', ['tareas' => $tareasAgrupadas]);
    }

    public function cambiarEstado()
    {
        $id_colaborador = session()->get('id_colaborador');
        if (!$id_colaborador) {
            return redirect()->to('colaboradores/login')->with('error', 'Debes iniciar sesión.');
        }

        $id_subtarea = $this->request->getPost('id_subtarea');
        $nuevo_estado = $this->request->getPost('estado');


        if (!in_array($nuevo_estado, ['En proceso', 'Completada'])) {
            return redirect()->back()->with('error', 'Estado inválido.');
        }

        $db = \Config\Database::connect();

        // Verificamos si la subtarea realmente le pertenece a este colaborador
        $builder = $db->table('subtareas');
        $subtarea = $builder->where('id', $id_subtarea)
                            ->where('id_responsable', $id_colaborador)
                            ->get()
                            ->getRow();

        if (!$subtarea) {
            return redirect()->back()->with('error', 'No tenés permiso para modificar esta subtarea.');
        }

        // Actualizamos el estado
        $builder->where('id', $id_subtarea)
                ->update(['estado' => $nuevo_estado]);
        //BLOQUE : actualizar estado de colaborador
        if ($nuevo_estado === 'Completada') {
            // Liberar al colaborador responsable
            $db->table('altas_colaboradores')
            ->where('id', $id_colaborador)
            ->update(['estado' => 'disponible']);
        }

        // BLOQUE: actualizar estado de la tarea asociada si las subatereas estan todas completadas
        // 1. Obtenemos el id_tarea desde la subtarea recuperada antes
        $id_tarea = $subtarea->id_tarea;

        // 2. Obtenemos todas las subtareas de esa tarea
        $subtareas = $db->table('subtareas')
            ->where('id_tarea', $id_tarea)
            ->get()
            ->getResult();

        // 3. Analizamos los estados
        $hayEnProceso = false;
        $todasCompletadas = true;

        foreach ($subtareas as $s) {
            if ($s->estado === 'En proceso') {
                $hayEnProceso = true;
            }
            if ($s->estado !== 'Completada') {
                $todasCompletadas = false;
            }
        }

        // 4. Determinamos el nuevo estado
        if ($todasCompletadas && count($subtareas) > 0) {
            $nuevoEstadoTarea = 'Completada';
        } elseif ($hayEnProceso) {
            $nuevoEstadoTarea = 'En proceso';
        } else {
            $nuevoEstadoTarea = 'Definida';
        }

        // 5. Lo actualizamos en la tabla tareas
        $db->table('tareas')
            ->where('id', $id_tarea)
            ->update(['estado' => $nuevoEstadoTarea]);
        // FIN DEL BLOQUE NUEVO

        //BLOQUE PARA MOVER A ARCHIVADAS CUANDO TAREA COMPLETADA
        if ($nuevoEstadoTarea === 'Completada') {
            // Obtener los datos de la tarea completada
            $tarea = $db->table('tareas')->where('id', $id_tarea)->get()->getRowArray();

            if ($tarea) {
                // Insertar en tabla archivadas (omitimos el id)
                $archivadaData = $tarea;
                unset($archivadaData['id']);  // evita conflictos con la clave primaria
                $archivadaData['archivada'] = 1;

                $db->table('archivadas')->insert($archivadaData);

                // Eliminar de la tabla tareas
                $db->table('tareas')->where('id', $id_tarea)->delete();
            }
        }
        //FIN BLOQUE
        return redirect()->back()->with('success', 'Estado actualizado correctamente.');
    }
    


   }