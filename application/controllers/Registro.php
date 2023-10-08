<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registro extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Registro_model");
        $this->load->model("Ubigeo_model");
        $this->load->helper('captcha');
        $this->session->set_flashdata("flag", "0");
    }   

	public function add()
	{
        $config = array(
            'img_path'      => 'captcha_images/',
            'img_url'       => base_url().'captcha_images/',
            'img_width'     => '180',
            'img_height'    => 40,
            'expiration'    => 7200,
            'word_length'   => 5,
            'font_path'     => base_url().'captcha_images/fonts/OldStandardTT-Regular.ttf',
            'font_size'     => 24,
            'img_id'        => 'Imageid',
            'pool'          => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'colors'        => array(
                            'background' => array(255, 255, 255),
                            'border' => array(255, 255, 255),
                            'text' => array(0, 0, 0),
                            'grid' => array(200, 200, 200)
                            )            
        );
        
        $cap = create_captcha($config);        

        $data = array(
            'departamentos' => $this->Ubigeo_model->getDepartamentos(),
            'nacionalidades' => $this->Registro_model->getNacionalidades(),
            'especs' => $this->Registro_model->getEspecialidades(),
            'captcha' => $cap['image']

        );

        //$this->session->set_flashdata("flag", "1");

        $this->session->unset_userdata('captchaCode'); 
        $this->session->set_userdata('captchaCode',$cap['word']); 

        $this->load->view('registro', $data);
    }



    public function refresh_captcha(){ 

        $config = array(
            'img_path'      => 'captcha_images/',
            'img_url'       => base_url().'captcha_images/',
            'img_width'     => '180',
            'img_height'    => 40,
            'expiration'    => 7200,
            'word_length'   => 5,
            'font_path'     => base_url().'captcha_images/fonts/OldStandardTT-Regular.ttf',
            'font_size'     => 24,
            'img_id'        => 'Imageid',
            'pool'          => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'colors'        => array(
                            'background' => array(255, 255, 255),
                            'border' => array(255, 255, 255),
                            'text' => array(0, 0, 0),
                            'grid' => array(200, 200, 200)
                            )            
        );
        
        $cap = create_captcha($config);        
        
        $this->session->unset_userdata('captchaCode'); 
        $this->session->set_userdata('captchaCode',$cap['word']); 
        
        echo $cap['image'];
    } 

    public function insert()
    {   
        // Si se envía el formulario captcha 
        $inputCaptcha = $this->input->post('captcha'); 
        $sessCaptcha = $this->session->userdata('captchaCode');

        if($inputCaptcha === $sessCaptcha){ 
            $this->load->library('utilitarios');
            $util = new Utilitarios();
            $clave = $util->generar_clave(3);
    
            $data =  array(
                'dni' => $this->input->post("dni"),
                'ruc' => $this->input->post("ruc"),
                'genero' => $this->input->post("genero"),
                'nacionalidad' => $this->input->post("nacionalidad"),
                'paterno' => $this->input->post("paterno"),
                'materno' => $this->input->post("materno"),
                'nombres' => $this->input->post("nombres"),
                'email' => $this->input->post("email"),
                'fijo' => $this->input->post("fijo"),
                'movil' => $this->input->post("movil"),
                'fnacim' => $this->input->post("fnacim"),
                'lugar_nacim' => $this->input->post("lugar_nacim"),
                'iddist1' => $this->input->post("iddist1"),
                'direccion' => $this->input->post("direccion"),
                'barrio' => $this->input->post("barrio"),
                'iddist2' => $this->input->post("iddist2"),
                'claboral' => $this->input->post("claboral"),
                'iddist3' => $this->input->post("iddist3"),
                'ref_urgencia' => $this->input->post("ref_urgencia"),
                'dir_urgencia' => $this->input->post("dir_urgencia"),
                'telefono_urgencia' => $this->input->post("telefono_urgencia"),
                'iduniv1' => $this->input->post("iduniv1"),
                'semestre_ingreso' => $this->input->post("semestre_ingreso"),
                'semestre_egreso' => $this->input->post("semestre_egreso"),
                'iduniv2' => $this->input->post("iduniv2"),
                'num_resolucion' => $this->input->post("num_resolucion"),
                'fecha_titulo' => $this->input->post("fecha_titulo"),
                'num_titulo' => $this->input->post("num_titulo"),
                'conyugue_dni' => $this->input->post("conyugue_dni"),
                'conyugue_paterno' => $this->input->post("conyugue_paterno"),
                'conyugue_materno' => $this->input->post("conyugue_materno"),
                'conyugue_nombres' => $this->input->post("conyugue_nombres"),
                'clave' => $clave
            );
            
            $dnis = $this->input->post("dnis");
            $paternos = $this->input->post("paternos");
            $maternos = $this->input->post("maternos");
            $nombress = $this->input->post("nombress");
            $fechas = $this->input->post("fechas");

            $especs = $this->input->post("espec2");

            $id = $this->Registro_model->insert($data);

            $this->insert_hijos($id,$dnis,$paternos,$maternos,$nombress,$fechas);
            $this->insert_especs($id,$especs);

            $url = base_url()."registro/ficha/".$clave.$id;
            redirect($url);

        }else{ 
            
            $this->session->set_flashdata("flag", "1");
            $this->add();
            
            //redirect(base_url()."registro");
        } 
    }

    public function insert_hijos($id, $dnis, $paternos, $maternos, $nombress, $fechas){
        for ($i=0; $i < count($dnis) ; $i++) { 
            $data = array(
                'idregistro' => $id,
                'dni' => $dnis[$i],
                'paterno' => $paternos[$i],
                'materno' => $maternos[$i],
                'nombres' => $nombress[$i],
                'fecha' => $fechas[$i]
            );

            $this->Registro_model->insert_hijos($data);
        }
    }    

    public function insert_especs($id, $especs){
        for ($i=0; $i < count($especs) ; $i++) { 
            $data = array(
                'idregistro' => $id,
                'idespec' => $especs[$i]
            );

            $this->Registro_model->insert_especs($data);
        }
    }    

    public function provincias(){
        
        $codigo = $this->input->post("cod");
        echo $this->Ubigeo_model->getProvincias($codigo);
    }

    public function distritos(){
        
        $codigo = $this->input->post("cod");
        echo $this->Ubigeo_model->getDistritos($codigo);
    }

    public function getuniversidades(){
        $valor = $this->input->post("valor");
        $registros = $this->Registro_model->getUniversidades($valor);
        echo json_encode($registros);
    }


    public function ficha($id){
        $data = array(
            'flag_registro' => $this->Registro_model->getID($id),
            'registro' => $id
        );
        
        $this->load->view('ficha',$data);
    }

    public function imprimir_ficha($id)
    {
        date_default_timezone_set('America/LIma');
        $this->load->library('tcpdf_masterA4');
        
        $idreg = substr($id,3);
        $clave = substr($id,0,3);

        $ficha = array(
            'registro' => $this->Registro_model->getFicha($idreg, $clave),
            'hijos' => $this->Registro_model->getHijos($idreg),
            'especs' => $this->Registro_model->getEspecs($idreg)
        );

        $id = $ficha['registro'][0]->idregistro;
        $dni = $ficha['registro'][0]->dni;
        $ruc = $ficha['registro'][0]->ruc;
        $paterno = $ficha['registro'][0]->paterno;
        $materno = $ficha['registro'][0]->materno;
        $nombres = $ficha['registro'][0]->nombres;
        $genero = $ficha['registro'][0]->genero;
        $desnacional = ($genero=="Masculino"?$ficha['registro'][0]->desnacional1:$ficha['registro'][0]->desnacional2);
        $email = $ficha['registro'][0]->email;
        $fijo = $ficha['registro'][0]->fijo;
        $movil = $ficha['registro'][0]->movil;
        $fecha_nacimiento = $ficha['registro'][0]->fecha_nacimiento;
        $lugar_nacim = $ficha['registro'][0]->lugar_nacim;
        $direccion = $ficha['registro'][0]->direccion;
        $barrio = $ficha['registro'][0]->barrio;
        $claboral = $ficha['registro'][0]->claboral;
        $ref_urgencia = $ficha['registro'][0]->ref_urgencia;
        $dir_urgencia = $ficha['registro'][0]->dir_urgencia;
        $telefono_urgencia = $ficha['registro'][0]->telefono_urgencia;
        $semestre_ingreso = $ficha['registro'][0]->semestre_ingreso;
        $semestre_egreso = $ficha['registro'][0]->semestre_egreso;
        $num_resolucion = $ficha['registro'][0]->num_resolucion;
        $fecha_titulo = $ficha['registro'][0]->fecha_titulo;
        $num_titulo = $ficha['registro'][0]->num_titulo;

        $conyugue_dni = $ficha['registro'][0]->conyugue_dni;
        $conyugue_paterno = $ficha['registro'][0]->conyugue_paterno;
        $conyugue_materno = $ficha['registro'][0]->conyugue_materno;
        $conyugue_nombres = $ficha['registro'][0]->conyugue_nombres;

        $fecha_hora = $ficha['registro'][0]->hora;

        $uni1 = $ficha['registro'][0]->uni1;
        $uni2 = $ficha['registro'][0]->uni2;

        $ubigeo1 = $ficha['registro'][0]->dist1."/".$ficha['registro'][0]->prov1."/".$ficha['registro'][0]->dep1;
        $ubigeo2 = $ficha['registro'][0]->dist2."/".$ficha['registro'][0]->prov2."/".$ficha['registro'][0]->dep2;
        $ubigeo3 = $ficha['registro'][0]->dist3."/".$ficha['registro'][0]->prov3."/".$ficha['registro'][0]->dep3;
  

        //if(isset($data['registro'][0]->dni)){





        $datetime = new DateTime(); 
        $hora_impresion = $datetime->format('Y/m/d');
        
       
        // set document information
        $this->tcpdf->SetCreator(PDF_CREATOR);
        $this->tcpdf->SetAuthor('Grupo NET++');
        $this->tcpdf->SetTitle('Ficha Matricula');

        // set margins
        $this->tcpdf->SetMargins(20, 20, 20);

        $this->tcpdf->setY(40);
        $this->tcpdf->SetFont('helvetica', 'B', 16, '', true);
        $this->tcpdf->Cell(0,0, 'FICHA DE MATRÍCULA', '0', '1', 'C');
        
        $this->tcpdf->Ln(1);

        $this->tcpdf->SetFont('helvetica', 'B', 10, '', true);
        $this->tcpdf->Cell(180,5, 'DATOS PERSONALES', '1', '1', 'L');

        $this->tcpdf->SetFont('helvetica', 'B', 9, '', true);
        $this->tcpdf->Cell(60,5, 'ID Registro', '1', '0', 'C');
        $this->tcpdf->Cell(60,5, 'Fecha y Hora', '1', '0', 'C');
        $this->tcpdf->Cell(60,5, 'DNI', '1', '1', 'C');
        
        $this->tcpdf->SetFont('helvetica', '', 10, '', true);
        $this->tcpdf->Cell(60,5, $id, '1', '0', 'C');
        $this->tcpdf->Cell(60,5, $fecha_hora, '1', '0', 'C');
        $this->tcpdf->Cell(60,5, $dni, '1', '1', 'C');

        $this->tcpdf->SetFont('helvetica', 'B', 9, '', true);
        $this->tcpdf->Cell(60,5, 'RUC', '1', '0', 'C');
        $this->tcpdf->Cell(60,5, 'Género', '1', '0', 'C');
        $this->tcpdf->Cell(60,5, 'Nacionalidad', '1', '1', 'C');
        
        $this->tcpdf->SetFont('helvetica', '', 10, '', true);
        $this->tcpdf->Cell(60,5, $ruc, '1', '0', 'C');
        $this->tcpdf->Cell(60,5, $genero, '1', '0', 'L');
        $this->tcpdf->Cell(60,5, $desnacional, '1', '1', 'L');
        
        $this->tcpdf->SetFont('helvetica', 'B', 9, '', true);
        $this->tcpdf->Cell(60,5, 'Apellido Paterno', '1', '0', 'C');
        $this->tcpdf->Cell(60,5, 'Apellido Materno', '1', '0', 'C');
        $this->tcpdf->Cell(60,5, 'Apellido Nombres', '1', '1', 'C');
       
        $this->tcpdf->SetFont('helvetica', '', 9, '', true);
        $this->tcpdf->Cell(60,5, $paterno, '1', '0', 'L');
        $this->tcpdf->Cell(60,5, $materno, '1', '0', 'L');
        $this->tcpdf->Cell(60,5, $nombres, '1', '1', 'L');

        $this->tcpdf->SetFont('helvetica', 'B', 9, '', true);
        $this->tcpdf->Cell(60,5, 'Email', '1', '0', 'C');
        $this->tcpdf->Cell(60,5, 'Teléfono Fijo', '1', '0', 'C');
        $this->tcpdf->Cell(60,5, 'Teléfono Móvil', '1', '1', 'C');
        
        $this->tcpdf->SetFont('helvetica', '', 10, '', true);
        $this->tcpdf->Cell(60,5, $email, '1', '0', 'L');
        $this->tcpdf->Cell(60,5, $fijo, '1', '0', 'L');
        $this->tcpdf->Cell(60,5, $movil, '1', '1', 'L');

        $this->tcpdf->SetFont('helvetica', 'B', 9, '', true);
        $this->tcpdf->Cell(60,5, 'Fecha Nacimiento', '1', '0', 'C');
        $this->tcpdf->Cell(60,5, 'Lugar', '1', '0', 'C');
        $this->tcpdf->Cell(60,5, 'Distrito / Provincia / Departamento', '1', '1', 'C');
       
        $this->tcpdf->SetFont('helvetica', '', 10, '', true);
        $this->tcpdf->Cell(60,5, $fecha_nacimiento, '1', '0', 'C');
        $this->tcpdf->Cell(60,5, $lugar_nacim, '1', '0', 'L');
        $this->tcpdf->Cell(60,5, $ubigeo1, '1', '1', 'L');

        $this->tcpdf->SetFont('helvetica', 'B', 9, '', true);
        $this->tcpdf->Cell(60,5, 'Dirección actual', '1', '0', 'C');
        $this->tcpdf->Cell(60,5, 'Barrio / Urbanización', '1', '0', 'C');
        $this->tcpdf->Cell(60,5, 'Distrito / Provincia / Departamento', '1', '1', 'C');
        
        $this->tcpdf->SetFont('helvetica', '', 10, '', true);
        $this->tcpdf->Cell(60,5, $direccion, '1', '0', 'L');
        $this->tcpdf->Cell(60,5, $barrio, '1', '0', 'L');
        $this->tcpdf->Cell(60,5, $ubigeo2, '1', '1', 'L');

        $this->tcpdf->SetFont('helvetica', 'B', 9, '', true);
        $this->tcpdf->Cell(90,5, 'Centro Laboral', '1', '0', 'C');
        $this->tcpdf->Cell(90,5, 'Distrito / Provincia / Departamento', '1', '1', 'C');
        
        $this->tcpdf->SetFont('helvetica', '', 10, '', true);
        $this->tcpdf->Cell(90,5, $claboral, '1', '0', 'L');
        $this->tcpdf->Cell(90,5, $ubigeo3, '1', '1', 'L');

        $this->tcpdf->SetFont('helvetica', 'B', 9, '', true);
        $this->tcpdf->Cell(60,5, 'Referencia en caso de urgencia', '1', '0', 'C');
        $this->tcpdf->Cell(60,5, 'Dirección', '1', '0', 'C');
        $this->tcpdf->Cell(60,5, 'Teléfono', '1', '1', 'C');
        
        $this->tcpdf->SetFont('helvetica', '', 10, '', true);
        $this->tcpdf->Cell(60,5, $ref_urgencia, '1', '0', 'L');
        $this->tcpdf->Cell(60,5, $dir_urgencia, '1', '0', 'L');
        $this->tcpdf->Cell(60,5, $telefono_urgencia, '1', '1', 'L');

        $this->tcpdf->Ln(2);

        $this->tcpdf->SetFont('helvetica', 'B', 10, '', true);
        $this->tcpdf->Cell(180,5, 'DATOS FAMILIARES', '1', '1', 'C');

        $this->tcpdf->SetFont('helvetica', 'B', 9, '', true);
        $this->tcpdf->Cell(180,5, 'Datos del (la) Cónyugue', '1', '1', 'C');
        $this->tcpdf->Cell(20,5, 'DNI', '1', '0', 'C');
        $this->tcpdf->Cell(50,5, 'Apellido Paterno', '1', '0', 'C');
        $this->tcpdf->Cell(50,5, 'Apellido Materno', '1', '0', 'C');
        $this->tcpdf->Cell(60,5, 'Apellido Nombres', '1', '1', 'C');
       
        $this->tcpdf->SetFont('helvetica', '', 9, '', true);
        $this->tcpdf->Cell(20,5, $conyugue_dni, '1', '0', 'L');
        $this->tcpdf->Cell(50,5, $conyugue_paterno, '1', '0', 'L');
        $this->tcpdf->Cell(50,5, $conyugue_materno, '1', '0', 'L');
        $this->tcpdf->Cell(60,5, $conyugue_nombres, '1', '1', 'L');

        $this->tcpdf->SetFont('helvetica', 'B', 9, '', true);
        $this->tcpdf->Cell(180,5, 'Datos del los Hijos', '1', '1', 'C');
        $this->tcpdf->Cell(20,5, 'DNI', '1', '0', 'C');
        $this->tcpdf->Cell(40,5, 'Apellido Paterno', '1', '0', 'C');
        $this->tcpdf->Cell(40,5, 'Apellido Materno', '1', '0', 'C');
        $this->tcpdf->Cell(50,5, 'Apellido Nombres', '1', '0', 'C');
        $this->tcpdf->Cell(30,5, 'Fecha Nacim.', '1', '1', 'C');
       
        $this->tcpdf->SetFont('helvetica', '', 8, '', true);
        foreach( $ficha['hijos'] as $hijo){
            $this->tcpdf->Cell(20,5, $hijo->dni, '1', '0', 'C');
            $this->tcpdf->Cell(40,5, $hijo->paterno, '1', '0', 'L');
            $this->tcpdf->Cell(40,5, $hijo->materno, '1', '0', 'L');
            $this->tcpdf->Cell(50,5, $hijo->nombres, '1', '0', 'L');
            $this->tcpdf->Cell(30,5, $hijo->fecha_nacimiento, '1', '1', 'C');

        }

        $this->tcpdf->Ln(2);

        $this->tcpdf->SetFont('helvetica', 'B', 10, '', true);
        $this->tcpdf->Cell(180,5, 'DATOS PROFESIONALES', '1', '1', 'C');

        $this->tcpdf->SetFont('helvetica', '', 9, '', true);
        $this->tcpdf->Cell(140,5, 'Universidad de estudio', '1', '0', 'C');
        $this->tcpdf->Cell(20,5, 'Ingreso', '1', '0', 'C');
        $this->tcpdf->Cell(20,5, 'Egreso', '1', '1', 'C');

        $this->tcpdf->SetFont('helvetica', '', 10, '', true);
        $this->tcpdf->Cell(140,5, $uni1, '1', '0', 'L');
        $this->tcpdf->Cell(20,5, $semestre_ingreso, '1', '0', 'C');
        $this->tcpdf->Cell(20,5, $semestre_egreso, '1', '1', 'C');

        $this->tcpdf->SetFont('helvetica', 'B', 9, '', true);
        $this->tcpdf->Cell(180,5, 'Universidad que otorgó título', '1', '1', 'C');
        
        $this->tcpdf->SetFont('helvetica', '', 10, '', true);
        $this->tcpdf->Cell(180,5, $uni2, '1', '1', 'L');

        $this->tcpdf->SetFont('helvetica', 'B', 9, '', true);
        $this->tcpdf->Cell(80,5, 'Resoluación Rectoral', '1', '0', 'C');
        $this->tcpdf->Cell(40,5, 'Fecha', '1', '0', 'C');
        $this->tcpdf->Cell(60,5, 'Nº Título', '1', '1', 'C');
        
        $this->tcpdf->SetFont('helvetica', '', 10, '', true);
        $this->tcpdf->Cell(80,5, $num_resolucion, '1', '0', 'L');
        $this->tcpdf->Cell(40,5, $fecha_titulo, '1', '0', 'C');
        $this->tcpdf->Cell(60,5, $num_titulo, '1', '1', 'L');

        $this->tcpdf->Ln(2);

        $this->tcpdf->SetFont('helvetica', 'B', 10, '', true);
        $this->tcpdf->Cell(180,5, 'ESTUDIOS DE ESPECIALIZACIÓN', '1', '1', 'C');
        
        $especialidad = "";
        foreach( $ficha['especs'] as $espec){
            $especialidad .= $espec->desespec . "; ";
        }
        

        $this->tcpdf->SetFont('helvetica', '', 10, '', true);
        $this->tcpdf->Cell(180,5, $especialidad, '1', '1', 'L');


        $this->tcpdf->SetFont('helvetica', '', 9, '', true);
        $this->tcpdf->Cell(0,5,"Fecha y Hora de impresión: ".date('d-m-Y h:i:s A'), '0', '0', 'L');

        $this->tcpdf->Ln(8);
        //$txt="Puno, ".$util->fecha_letras($fecha_hora).".";
        //$this->tcpdf->MultiCell(0,6,$txt,0,'L');








        
        $this->tcpdf->SetFont('helvetica', '', 7, '', true);
        $style = array('width' => 0.1, 'cap' => 'round', 'join' => 'round', 'solid' => '2,5', 'color' => array(0, 0, 0));
        $this->tcpdf->Line(40, 254, 100, 254);
        $this->tcpdf->Text(65, 257, 'FIRMA');

        $this->tcpdf->SetFont('helvetica', 'B', 8, '', true);
        $this->tcpdf->Text(50, 265, 'Importante: Esta hoja Firmar, escanear en formato PDF y adjuntar al trámite vitual.');

        $this->tcpdf->Output('net.pdf', 'I');




/*
        #Establecemos los márgenes izquierda, arriba y derecha:
        $this->fpdf->SetMargins(20, 20 , 20, 20);

        $this->fpdf->setY(35);
        $this->fpdf->SetFont('Arial','BU',16); 
        $this->fpdf->Cell(0,0, utf8_decode('FICHA DE PRE-INSCRIPCIÓN'), '0', '1', 'C');

        $this->fpdf->Ln(8);

        $this->fpdf->SetFont('Arial','B',14); 
        $this->fpdf->Cell(180,7, 'DATOS PERSONALES', '1', '1', 'C');

        $this->fpdf->SetFont('Arial','B',9);
        $this->fpdf->Cell(60,5, 'ID Registro', '1', '0', 'C');
        $this->fpdf->Cell(60,5, 'Fecha y Hora', '1', '0', 'C');
        $this->fpdf->Cell(60,5, 'DNI', '1', '1', 'C');
        
        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->Cell(60,6, $id, '1', '0', 'C');
        $this->fpdf->Cell(60,6, $fecha_hora, '1', '0', 'C');
        $this->fpdf->Cell(60,6, $dni, '1', '1', 'C');

        $this->fpdf->Ln(2);
        $this->fpdf->SetFont('Arial','B',9);
        $this->fpdf->Cell(60,5, 'RUC', '1', '0', 'C');
        $this->fpdf->Cell(60,5, utf8_decode('Género'), '1', '0', 'C');
        $this->fpdf->Cell(60,5, 'Nacionalidad', '1', '1', 'C');
        
        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->Cell(60,6, $ruc, '1', '0', 'C');
        $this->fpdf->Cell(60,6, $genero, '1', '0', 'L');
        $this->fpdf->Cell(60,6, $desnacional, '1', '1', 'L');
        
        $this->fpdf->Ln(2);
        $this->fpdf->SetFont('Arial','B',9);
        $this->fpdf->Cell(60,5, 'Apellido Paterno', '1', '0', 'C');
        $this->fpdf->Cell(60,5, 'Apellido Materno', '1', '0', 'C');
        $this->fpdf->Cell(60,5, 'Apellido Nombres', '1', '1', 'C');
       
        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->Cell(60,6, $paterno, '1', '0', 'L');
        $this->fpdf->Cell(60,6, $materno, '1', '0', 'L');
        $this->fpdf->Cell(60,6, $nombres, '1', '1', 'L');

        $this->fpdf->Ln(2);
        $this->fpdf->SetFont('Arial','B',9);
        $this->fpdf->Cell(60,5, 'Email', '1', '0', 'C');
        $this->fpdf->Cell(60,5, utf8_decode('Teléfono Fijo'), '1', '0', 'C');
        $this->fpdf->Cell(60,5, utf8_decode('Teléfono Móvil'), '1', '1', 'C');
       
        $this->fpdf->SetFont('Arial','',9);
        $this->fpdf->Cell(60,6, $email, '1', '0', 'L');
        $this->fpdf->Cell(60,6, $fijo, '1', '0', 'L');
        $this->fpdf->Cell(60,6, $movil, '1', '1', 'L');

        $this->fpdf->Ln(2);
        $this->fpdf->SetFont('Arial','B',9);
        $this->fpdf->Cell(60,5, 'Fecha Nacimiento', '1', '0', 'C');
        $this->fpdf->Cell(60,5, 'Lugar', '1', '0', 'C');
        $this->fpdf->Cell(60,5, 'Distrito / Provincia / Departamento', '1', '1', 'C');
       
        $this->fpdf->SetFont('Arial','',9);
        $this->fpdf->Cell(60,6, $fecha_nacimiento, '1', '0', 'C');
        $this->fpdf->Cell(60,6, $lugar_nacim, '1', '0', 'L');
        $this->fpdf->Cell(60,6, $ubigeo1, '1', '1', 'L');

        $this->fpdf->Ln(2);
        $this->fpdf->SetFont('Arial','B',9);
        $this->fpdf->Cell(60,5, utf8_decode('Dirección actual'), '1', '0', 'C');
        $this->fpdf->Cell(60,5, utf8_decode('Barrio / Urbanización'), '1', '0', 'C');
        $this->fpdf->Cell(60,5, 'Distrito / Provincia / Departamento', '1', '1', 'C');
       
        $this->fpdf->SetFont('Arial','',9);
        $this->fpdf->Cell(60,6, $direccion, '1', '0', 'L');
        $this->fpdf->Cell(60,6, $barrio, '1', '0', 'L');
        $this->fpdf->Cell(60,6, $ubigeo2, '1', '1', 'L');

        $this->fpdf->Ln(2);
        $this->fpdf->SetFont('Arial','B',9);
        $this->fpdf->Cell(90,5, 'Centro Laboral', '1', '0', 'C');
        $this->fpdf->Cell(90,5, 'Distrito / Provincia / Departamento', '1', '1', 'C');
       
        $this->fpdf->SetFont('Arial','',9);
        $this->fpdf->Cell(90,6, $claboral, '1', '0', 'L');
        $this->fpdf->Cell(90,6, $ubigeo3, '1', '1', 'L');

        $this->fpdf->Ln(2);
        $this->fpdf->SetFont('Arial','B',9);
        $this->fpdf->Cell(60,5, 'Referencia en caso de urgencia', '1', '0', 'C');
        $this->fpdf->Cell(60,5, utf8_decode('Dirección'), '1', '0', 'C');
        $this->fpdf->Cell(60,5, utf8_decode('Teléfono'), '1', '1', 'C');
       
        $this->fpdf->SetFont('Arial','',9);
        $this->fpdf->Cell(60,6, $ref_urgencia, '1', '0', 'L');
        $this->fpdf->Cell(60,6, $dir_urgencia, '1', '0', 'L');
        $this->fpdf->Cell(60,6, $telefono_urgencia, '1', '1', 'L');

        $this->fpdf->Ln(4);

        $this->fpdf->SetFont('Arial','B',14); 
        $this->fpdf->Cell(180,7, 'DATOS PROFESIONALES', '1', '1', 'C');

        $this->fpdf->SetFont('Arial','B',9);
        $this->fpdf->Cell(180,5, 'Universidad de estudio', '1', '1', 'C');

        $this->fpdf->SetFont('Arial','',9);
        $this->fpdf->Cell(180,6, $uni1, '1', '1', 'L');

        $this->fpdf->SetFont('Arial','B',9);
        $this->fpdf->Cell(60,5, 'Egreso', '1', '0', 'C');
        $this->fpdf->Cell(120,5, utf8_decode('Nombre promoción'), '1', '1', 'C');
        
        $this->fpdf->SetFont('Arial','',9);
        $this->fpdf->Cell(60,6, $semestre_egreso, '1', '0', 'C');
        $this->fpdf->Cell(120,6, $nom_promo, '1', '1', 'L');

        $this->fpdf->Ln(2);
        $this->fpdf->SetFont('Arial','B',9);
        $this->fpdf->Cell(180,5, utf8_decode('Universidad que otorgó título'), '1', '1', 'C');
        
        $this->fpdf->SetFont('Arial','',9);
        $this->fpdf->Cell(180,6, $uni2, '1', '1', 'L');

        $this->fpdf->SetFont('Arial','B',9);
        $this->fpdf->Cell(60,5, utf8_decode('Resoluación Rectoral'), '1', '0', 'C');
        $this->fpdf->Cell(60,5, 'Fecha', '1', '0', 'C');
        $this->fpdf->Cell(60,5, utf8_decode('Nº Título'), '1', '1', 'C');
        
        $this->fpdf->SetFont('Arial','',9);
        $this->fpdf->Cell(60,6, $num_resolucion, '1', '0', 'L');
        $this->fpdf->Cell(60,6, $fecha_titulo, '1', '0', 'C');
        $this->fpdf->Cell(60,6, $num_titulo, '1', '1', 'L');

        $this->fpdf->Cell(0,5,utf8_decode("Fecha y Hora de impresión: ").date('Y-m-d h:i:s A'), '0', '0', 'L');

        $this->fpdf->Ln(8);
        $this->fpdf->SetFont('Arial','',10); 
        $txt="Puno, ".$util->fecha_letras($fecha_hora).".";
        $this->fpdf->MultiCell(0,6,utf8_decode($txt),0,'L');


        $this->fpdf->Ln(30);

        $this->fpdf->SetFont('Arial','',8);
        $this->fpdf->Cell(100,5, '________________________________________________', '0', '1', 'C');
        $this->fpdf->SetFont('Arial','B',8);        
        $this->fpdf->Cell(100,5, $nombres.' '. $paterno.' '.$materno, '0', '1', 'C');
        $this->fpdf->Cell(100,5, 'DNI: '.$dni, '0', '0', 'C');


        $this->fpdf->Code39(130,230,$id,1.5,15);
       


        $this->fpdf->output();

        */

        

    }



    public function imprimir_solicitud($id)
    {
        date_default_timezone_set('America/LIma');
        $dias = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");  
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");  

        $idreg = substr($id,3);
        $clave = substr($id,0,3);

        $ficha = array(
            'registro' => $this->Registro_model->getSolicitud($idreg, $clave)
        );

        $dni = $ficha['registro'][0]->dni;
        $ruc = $ficha['registro'][0]->ruc;
        $genero = $ficha['registro'][0]->genero;
        $direccion = $ficha['registro'][0]->direccion;

        $nombre = $ficha['registro'][0]->nombres . " " . $ficha['registro'][0]->paterno . " " . $ficha['registro'][0]->materno;
        $desnacional = ($genero=="Masculino"?$ficha['registro'][0]->desnacional1:$ficha['registro'][0]->desnacional2);

        $fecha_hora = $ficha['registro'][0]->hora_insert;
        $ahora = strtotime($fecha_hora);  
        $fecha_letras = date("j", $ahora) . " de " . $meses[date("n", $ahora)-1] . " de " . date("Y", $ahora);

        $uni = $ficha['registro'][0]->uni;
        $ubigeo = $ficha['registro'][0]->lugar;


        //if(isset($data['registro'][0]->dni)){
            $this->load->library('tcpdf_masterA4');

            $this->tcpdf->SetTitle('Constancia');


            $datetime = new DateTime(); 
            $hora_impresion = $datetime->format('Y/m/d');
            
           
            // set document information
            $this->tcpdf->SetCreator(PDF_CREATOR);
            $this->tcpdf->SetAuthor('Grupo NET++');
            $this->tcpdf->SetTitle('Solicitud');

            // set margins
            $this->tcpdf->SetMargins(25, 20, 20);
            
            $this->tcpdf->SetFont('helvetica', '', 7, '', true);
            $style = array('width' => 0.1, 'cap' => 'round', 'join' => 'round', 'solid' => '2,5', 'color' => array(0, 0, 0));
            $this->tcpdf->Rect(40, 190, 80, 40, 'D', array('all' => $style));
            $this->tcpdf->Text(65, 231, 'FIRMA DEL SOLICITANTE');
            $this->tcpdf->Rect(140, 190, 35, 40, 'D', array('all' => $style));
            $this->tcpdf->Text(147, 231, 'INDICE DERECHO');

            $this->tcpdf->SetFont('helvetica', 'B', 8, '', true);
            $this->tcpdf->Text(37, 238, 'Importante: Esta hoja Firmar, poner Huella Dactilar, escanear en formato PDF y adjuntar al trámite vitual.');

            $this->tcpdf->SetFont('helvetica', 'B', 8, '', true);
            $this->tcpdf->Text(26, 252, 'VISTO LA SOLICITUD QUE ANTECEDE, PASE A LA COMISIÓN DE ADMISIÓN PARA SU REVISIÓN (para uso del Colegio)');
            $this->tcpdf->SetFont('helvetica', '', 8, '', true);
            $this->tcpdf->Text(26, 264, 'Puno, ______ de __________________ del 20_____');


            $this->tcpdf->setY(42);
            $this->tcpdf->SetFont('helvetica', '', 9, '', true);

            $html = '<table border="0" width="680">';
            $html .='<tr>
                        <td width="470" align="center"><h1>SOLICITUD DE INGRESO</h1></td>
                    </tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr><td style="font-size:13px; text-align: justify; font-weight:bold;">SEÑOR DECANO DEL COLEGIO DE CONTADORES PÚBLICOS DE PUNO</td></tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr><td style="font-size:13px; text-align: justify;">Yo, '.$nombre.' de nacionalidad '.$desnacional.', identificado con DNI Nº'.$dni.' y con domicilio en el '.$direccion.' - '.$ubigeo.'.</td></tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr><td style="font-size:12px;">A Usted digo:</td></tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr><td style="font-size:12px; text-align: justify;">Que, habiendo optado el Título Profesional de Contador Público en la <strong>'.$uni.'</strong> conforme acredito, adjuntando al presente trámite el archivo escaneado en formato PDF y al mismo tiempo me comprometo a hacer alcance de manera física en las instalaciones del Colegio antes de los 10 días después de terminada la juramentación.</td></tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr><td style="font-size:12px; text-align: justify;">Que, así mismo de coformidad con el estatuto del Colegio y dispositivos legales pertinentes, acompaño todos los requisitos establecidos para ser admitido como miembro de la Orden.</td></tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr><td style="font-size:12px; text-align: justify;">POR LO TANTO</td></tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr><td style="font-size:12px; text-align: justify;">De conformidad con lo dispuesto por la Ley Nº13253 y Ley Nº28951 D.S. Nº28 del 26-08-1960 del 26 de agosto de 1960 SOLICITO a Ud. Señor Decano autorizar el trámite a quien corresponda y disponer mi incorporación como miembro del Colegio de Contadores Públicos de Puno.</td></tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr><td style="font-size:12px; text-align: justify;">Puno, '.$fecha_letras.'.</td></tr>
                    <tr><td>&nbsp;</td></tr>
                    </table>';

            $this->tcpdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


        //echo $html;
        //return;

        // Print text using writeHTMLCell()
        //$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        
        //$pdf->SetXY(15, 200);
        //$pdf->writeHTMLCell(0, 0, '', '', $pie, 0, 1, 0, true, '', true);


        // ---------------------------------------------------------

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $this->tcpdf->Output('net.pdf', 'I');


    }

    public function imprimir_ficha1($id)
    {
        date_default_timezone_set('America/LIma');
        $dias = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");  
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");  

      
        $ficha = array(
            'registro' => $this->Registro_model->getFicha($id)
        );

        $dni = $ficha['registro'][0]->dni;
        $ruc = $ficha['registro'][0]->ruc;
        $genero = $ficha['registro'][0]->genero;
        $direccion = $ficha['registro'][0]->direccion;

        $nombre = utf8_decode($ficha['registro'][0]->nombres) . " " . utf8_decode($ficha['registro'][0]->paterno) . " " . utf8_decode($ficha['registro'][0]->materno);
        $desnacional = ($genero=="Masculino"?utf8_decode($ficha['registro'][0]->desnacional1):utf8_decode($ficha['registro'][0]->desnacional2));

        $fecha_hora = $ficha['registro'][0]->hora_insert;
        $ahora = strtotime($fecha_hora);  
        $fecha_letras = date("j", $ahora) . " de " . $meses[date("n", $ahora)-1] . " de " . date("Y", $ahora);

        $uni = utf8_decode($ficha['registro'][0]->uni2);

        $ubigeo = utf8_decode($ficha['registro'][0]->dist2)."/".utf8_decode($ficha['registro'][0]->prov2)."/".utf8_decode($ficha['registro'][0]->dep2);


        //if(isset($data['registro'][0]->dni)){
            $this->load->library('tcpdf_masterA4');

            $this->tcpdf->SetTitle('Constancia');


           /*$numero = $data['registro'][0]->id;
            $fecha = $data['registro'][0]->fecha_hora;
            $matricula = $data['registro'][0]->dni;
            $nombre = $data['registro'][0]->nombres . ' ' . $data['registro'][0]->paterno . ' ' . $data['registro'][0]->materno;*/


            $var_anio = "";
            $global_ruc = "";
            $global_rsocial = "";
            $global_direccion = "";

            $datetime = new DateTime(); 
            $hora_impresion = $datetime->format('Y/m/d');
            
           
            // set document information
            $this->tcpdf->SetCreator(PDF_CREATOR);
            $this->tcpdf->SetAuthor('Grupo NET++');
            $this->tcpdf->SetTitle('Solicitud');

            // set margins
            $this->tcpdf->SetMargins(25, 20, 20);
            
            $this->tcpdf->SetFont('helvetica', '', 7, '', true);
            $style = array('width' => 0.1, 'cap' => 'round', 'join' => 'round', 'solid' => '2,5', 'color' => array(0, 0, 0));
            $this->tcpdf->Rect(40, 190, 80, 40, 'D', array('all' => $style));
            $this->tcpdf->Text(65, 231, 'FIRMA DEL SOLICITANTE');
            $this->tcpdf->Rect(140, 190, 35, 40, 'D', array('all' => $style));
            $this->tcpdf->Text(147, 231, 'INDICE DERECHO');

            $this->tcpdf->SetFont('helvetica', 'B', 8, '', true);
            $this->tcpdf->Text(37, 238, 'Importante: Esta hoja Firmar, poner Huella dactilar, escanear en formato PDF y adjuntar al trámite vitual.');

            $this->tcpdf->SetFont('helvetica', 'B', 8, '', true);
            $this->tcpdf->Text(26, 252, 'VISTO LA SOLICITUD QUE ANTECEDE, PASE A LA COMISIÓN DE ADMISIÓN PARA SU REVISIÓN (para uso del Colegio)');
            $this->tcpdf->SetFont('helvetica', '', 8, '', true);
            $this->tcpdf->Text(26, 264, 'Puno, ______ de __________________ del 20_____');


            $this->tcpdf->setY(42);
            $this->tcpdf->SetFont('helvetica', '', 9, '', true);

            $html = '<table border="0" width="680">';
            $html .='<tr>
                        <td width="470" align="center"><h1>FICHA DE MATRICULA</h1></td>
                    </tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr><td style="font-size:13px; text-align: justify;">Yo, '.$nombre.' de nacionalidad '.$desnacional.', identificado con DNI Nº '.$dni.' y con domicilio en el '.$direccion.' - '.$ubigeo.'.</td></tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr><td style="font-size:12px;">A Usted digo:</td></tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr><td>&nbsp;</td></tr>
                    </table>';

            $this->tcpdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


        //echo $html;
        //return;

        // Print text using writeHTMLCell()
        //$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        
        //$pdf->SetXY(15, 200);
        //$pdf->writeHTMLCell(0, 0, '', '', $pie, 0, 1, 0, true, '', true);


        // ---------------------------------------------------------

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $this->tcpdf->Output('net.pdf', 'I');


    }




}
