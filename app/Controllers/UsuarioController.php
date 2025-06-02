<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class UsuarioController extends BaseController
{
    public function registro()
    {
        helper(['form']);
        return view('usuarios/registro');
    }

    public function registrar()
    {
        //Habilita funciones para manejar formularios y lista de errores en la vista.
        helper(['form']);
        // array que define las reglas de validación del formulario. Se usa junto con $this->validate($rules)
        /* $rules = [
            'nombre_usuario' => 'required|min_length[3]|is_unique[usuarios.nombre_usuario]',
            'email' => 'required|valid_email|is_unique[usuarios.email]',
            'password' => 'required|min_length[5]',
        ]; */
        //para que sea en español y personalizadas, sino viene en ingles predeterminado
        $rules = [
            'nombre_usuario' => [
            'label' => 'Nombre de usuario',
            'rules' => 'required|min_length[3]|is_unique[usuarios.nombre_usuario]',
            'errors' => [
                'required' => 'El {field} es obligatorio.',
                'min_length' => 'El {field} debe tener al menos 3 caracteres.',
                'is_unique' => 'El {field} ya está en uso.',
                ]
            ],
            'email' => [
                'label' => 'Correo electrónico',
                'rules' => 'required|valid_email|is_unique[usuarios.email]',
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
            return view('usuarios/registro', ['validation' => $this->validator]);
        }

        //instancia de Usuario model
        $usuarioModel = new UsuarioModel();
        //inserto en tabla
        $usuarioModel->save([
            'nombre_usuario' => $this->request->getVar('nombre_usuario'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        ]);

        return redirect()->to('/usuarios/login');
    }

    public function login()
    {
        helper(['form']);
        return view('usuarios/login');
    }

    public function ingresar()
    {
        $session = session();
        $usuarioModel = new UsuarioModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $usuario = $usuarioModel->where('email', $email)->first();

        // Verificar si el colaborador existe
            if (!$usuario) {
                return redirect()->back()->with('error', 'Email no encontrado');
            }
            // Verificar la contraseña
            if (!password_verify($password, $usuario['password'])) {
            return redirect()->back()->with('error', 'Contraseña incorrecta');
                
            }
        
        //Si usuario y contraseña validos, guardamos sus datos de sesion
       
            $session->set([
                'id' => $usuario['id'],
                'nombre_usuario' => $usuario['nombre_usuario'],
                'email' => $usuario['email'],
                'logueado' => true,
            ]);

            //Nuevo bloque: Verificamos si hoy coincide con la fecha de recordatorio de alguna tarea
                $db = \Config\Database::connect();
                $builder = $db->table('tareas');
                $builder->select('asunto, fecha_vencimiento');
                $builder->where('id_usuario', $usuario['id']);
                $builder->where('estado !=', 'Completada');
                $builder->where('fecha_recordatorio', date('Y-m-d'));

                $tareasRecordatorio = $builder->get()->getResultArray();

                if (!empty($tareasRecordatorio)) {
                    $mensaje = "<p>Estas son las tareas que tienen recordatorio para hoy:</p><ul>";
                    foreach ($tareasRecordatorio as $tarea) {
                        $diasRestantes = (new \DateTime($tarea['fecha_vencimiento']))->diff(new \DateTime())->days;
                        $mensaje .= "<li><strong>" . esc($tarea['asunto']) . "</strong> - Vence el <strong>" . esc($tarea['fecha_vencimiento']) . "</strong> (quedan <strong>" . $diasRestantes . "</strong> días)</li>";
                    }
                    $mensaje .= "</ul>";

                    $session->setFlashdata('modal_msg', [
                        'titulo' => 'Recordatorio de tareas',
                        'mensaje' => $mensaje
                    ]);
                    // 👇 GUARDAR PERSISTENTEMENTE PARA LA CAMPANA
                     $session->set('modal_msg_persistente', [
                        'titulo' => 'Recordatorio de tareas',
                        'mensaje' => $mensaje
                    ]); 
                    // Usamos para mostrar el badge(campana notificacion)
                        $session->set('tiene_recordatorios', true);
                } else {
                    //Cuando no hay recordatorios, los elimino
                        $session->remove('tiene_recordatorios');
                        $session->remove('modal_msg_persistente');
                }
                
                //fin nuevo bloque
            return redirect()->to('/tareas/listar');
        
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    public function ocultarModal()
    {
        session()->remove('mostrar_modal_vencimiento');
        return $this->response->setStatusCode(200);
    }
}