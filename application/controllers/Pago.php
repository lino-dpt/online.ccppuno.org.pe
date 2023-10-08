<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pago extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('captcha');
        $this->load->model("Habilidad_model");
        $this->load->model("Agremiado_model");
        $this->load->model("Pago_model");
    }

	public function index()
	{
        $id = $this->session->userdata("id");

        $data = array(
            'registro' => $this->Agremiado_model->getRegistro($id),
            'ultimo' => $this->Habilidad_model->getUltimopago($id),
            'anios' => $this->Pago_model->getAnios()
        );

        $this->load->view('layouts/header');
        $this->load->view('pago',$data);
        $this->load->view('layouts/footer');
        

	
    }

    public function gethabil()
    {
        $codigo = $this->input->post("codigo");
        
        $registros = $this->Habilidad_model->getHabil($codigo);
        echo json_encode($registros);
    }


/*    public function inicio()
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
            'captcha' => $cap['image']
        );

        $this->session->unset_userdata('captchaCode'); 
        $this->session->set_userdata('captchaCode',$cap['word']); 

        $this->load->view('login', $data);
    
    }*/


   /* public function login()
    {
        
        if(!$this->session->userdata('login')){
            $inputCaptcha = $this->input->post('captcha'); 
            $sessCaptcha = $this->session->userdata('captchaCode');

            if($inputCaptcha === $sessCaptcha){
                $codigo = $this->input->post("matricula");
                $fecha = $this->input->post("fnacimiento");
                
                $resp = $this->Habilidad_model->validarRegistro($codigo, $fecha);


                if (!$resp['flag']) {
                    $this->session->set_flashdata("error", "Los datos ingresados son incorrectos.");
                    redirect(base_url()."pago/inicio");
                }else{
                    $id = $resp['registro']->id;
                    $data = array(
                        'id' => $id,
                        'login' => true
                    );

                    $this->session->set_userdata($data);
            
                    $data = array(
                        'registro' => $this->Habilidad_model->getRegistro($id),
                        'anios' => $this->Pago_model->getAnios()
                    );

                    $this->load->view('pago',$data);
                }

            }else{
                $this->session->set_flashdata("error", "El texto ingresado NO coinside con el de la IMAGEN.");
                redirect(base_url()."pago/inicio");
            } 
        }else{

            $data = array(
                'registro' => $this->Habilidad_model->getRegistro($this->session->userdata('id')),
                'anios' => $this->Pago_model->getAnios()
            );

            $this->load->view('pago',$data);
        }

    }*/

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url());
    }

    public function pagar()
    {

        $id = $this->session->userdata("id");

        $data = array(
            'registro' => $this->Agremiado_model->getRegistro($id),
            'ultimo' => $this->Habilidad_model->getUltimopago($id),
            'conceptos' => $this->Pago_model->getConceptos(),
            'anios' => $this->Pago_model->getAnios(),
            'meses' => $this->Pago_model->getMeses()
        );

        $this->load->view('layouts/header');
        $this->load->view('pagar',$data);
        $this->load->view('layouts/footer');

    
    }

    public function attach($id)
    {

        $idcliente = $this->session->userdata("id");

        $data = array(
            'idpago' => $id
        );

        $this->load->view('layouts/header');
        $this->load->view('pagar-attach',$data);
        $this->load->view('layouts/footer');

    
    }

    public function upload(){

        $idpago = $this->input->post('idpago');

        $extension = pathinfo($_FILES['upfile_0']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES['upfile_0']['tmp_name'], "files/pagos/".$idpago.".".$extension);

        /*$requisitos = $this->Tramite_model->getRequisitos($idtupa);
        foreach($requisitos as $req){

            $extension = pathinfo($_FILES['upfile_'.$req->idrequisito]['name'], PATHINFO_EXTENSION);
    
            $data =  array(
                'id' => $id,
                'idrequisito' => $req->idrequisito,
                'tipo' => $req->tipo,
                'voucher' => $this->input->post("voucher_upfile_".$req->idrequisito),
                'fecha' => $this->input->post("fecha_upfile_".$req->idrequisito),
                'importe' => $this->input->post("importe_upfile_".$req->idrequisito),
                'extension' => $extension
            );

            $this->Tramite_model->insert_requisito($data);

            if(!move_uploaded_file($_FILES['upfile_'.$req->idrequisito]['tmp_name'], "files/registro/".$id."_".$req->idrequisito.".".$extension)){
                echo "Errror.";
            }
        }*/
        
        redirect(base_url()."pago");

    }

    public function cargoo(){

        //$token = $this->input->post('token'); 
        $idcliente = $this->input->post('idcliente');
        $email = $this->input->post('email');

        $idproductos = json_decode($this->input->post("idprod"));
        $precios = json_decode($this->input->post("prec"));
        $cantidades = json_decode($this->input->post("cant"));
        $cuotas = json_decode($this->input->post("cuot"));

        $importe = (int)($this->input->post('total')*100);

        $data = array(
            'total' => $importe,
            'email' => $email,
            'idcliente' => $idcliente
        );

        $idventa = $this->Pago_model->insert($data);
        $this->insert_detalle($idventa, $idproductos, $precios, $cantidades, $cuotas);

        echo "OK";
                
    }

    public function insert_detalle($idventa, $idproductos, $precios, $cantidades, $cuotas){
        for($i=0; $i < count($idproductos) ; $i++) { 
            $data = array(
                'idventa' => $idventa,
                'idproducto' => $idproductos[$i],
                'precio' => $precios[$i],
                'cantidad' => $cantidades[$i],
                'cuota' => $cuotas[$i]

            );

            $this->Pago_model->insert_detalle($data);
        }
    }



    public function cargo_deposito(){
        $idcliente = $this->input->post('idcliente');
        $idproductos = json_decode($this->input->post("idprod"));
        $precios = json_decode($this->input->post("prec"));
        $cantidades = json_decode($this->input->post("cant"));
        $cuotas = json_decode($this->input->post("cuot"));

        $importe = $this->input->post('total');

        $data = array(
            'total' => $importe,
            'idcliente' => $idcliente
        );

        $idventa = $this->Pago_model->insert_deposito($data);
        $this->insert_detalle_deposito($idventa, $idproductos, $precios, $cantidades, $cuotas);

        echo $idventa;

    }

    public function insert_detalle_deposito($idventa, $idproductos, $precios, $cantidades, $cuotas){
        for($i=0; $i < count($idproductos) ; $i++) { 
            $data = array(
                'idventa' => $idventa,
                'idproducto' => $idproductos[$i],
                'precio' => $precios[$i],
                'cantidad' => $cantidades[$i],
                'cuota' => $cuotas[$i]

            );

            $this->Pago_model->insert_detalle_deposito($data);
        }
    }




    public function cargo(){

        $token = $this->input->post('token'); 
        $idcliente = $this->input->post('idcliente');
        $email = $this->input->post('email');

        $idproductos = json_decode($this->input->post("idprod"));
        $precios = json_decode($this->input->post("prec"));
        $cantidades = json_decode($this->input->post("cant"));
        $cuotas = json_decode($this->input->post("cuot"));

        /*$dni = $this->input->post('dni');
        $matricula = $this->input->post('matricula');*/

        $importe = (int)($this->input->post('total')*100);

        include_once APPPATH.'third_party/culqi/Requests/library/Requests.php';
        Requests::register_autoloader();

        include_once APPPATH.'third_party/culqi/lib/culqi.php';
        
        try {
          // Usando Composer (o puedes incluir las dependencias manualmente)
          //require '../vendor/autoload.php';
            include_once APPPATH.'third_party/culqi/lib/culqi.php';

            // Configurar tu API Key y autenticación
            $SECRET_KEY = "sk_test_Wn7omznscSDEORAQ";
            $culqi = new Culqi\Culqi(array('api_key' => $SECRET_KEY));

            // Creando Cargo a una tarjeta
            $charge = $culqi->Charges->create(
              array(
                "amount" => $importe,
                "capture" => true,
                "currency_code" => "PEN",
                "description" => "Culqi",
                "installments" => 0,
                "email" => $email,
                "source_id" => $token
              )
            );

            //"metadata" => array("dni"=>$dni,"matricula"=>$matricula),
            
            $id_cargo = $charge->id;
            $total = $charge->current_amount;
            $moneda = $charge->currency_code;
            $total_comision = $charge->total_fee;
            $total_impuesto = $charge->total_fee_taxes;
            $total_deposito = $charge->transfer_amount;
            $mensaje_tipo = $charge->outcome->type; 

            $data = array(
                'id_cargo' => $id_cargo,
                'id_token' => $token,
                'total' => $total,
                'moneda' => $moneda,
                'email' => $email,
                'total_comision' => $total_comision,
                'total_impuesto' => $total_impuesto,
                'total_deposito' => $total_deposito,
                'mensaje_tipo' => $mensaje_tipo,
                'idcliente' => $idcliente
            );
            

            if($charge->object == 'charge'){
                
                $idculqi = $this->Pago_model->insertCulqi($data);

                $data = array(
                    'total' => $importe,
                    'email' => $email,
                    'idcliente' => $idcliente,
                    'idculqi' => $idculqi
                );

                $idventa = $this->Pago_model->insert($data);
                $this->insert_detalle($idventa, $idproductos, $precios, $cantidades, $cuotas);
                
                //redirect(base_url()."pago");            

            }else{

            
            }

            // Respuesta
            echo json_encode($charge);

        } catch (Exception $e) {
          echo json_encode($e->getMessage());
        }
    }
    

  /* public function insert()
    {
        $data =  array(
            'idcliente' => $this->input->post("idcliente"),
            'glosa' => "Pago por Internet con Culqi",
            'total' => $this->input->post("total")
        );

        $idproductos = $this->input->post("idprod");
        $precios = $this->input->post("prec");
        $cantidades = $this->input->post("cant");
        $cuotas = $this->input->post("cuota");

        if($this->Venta_model->insert($data)){
            $idventa = $this->Venta_model->ultimoID();
            $this->insert_detalle($idventa, $idproductos, $precios, $cantidades, $cuotas);

            redirect(base_url()."app/venta/inicio/0");            
        }else{
            
            $this->session->set_flashdata("error", "No se pudo guardar");
            redirect(base_url()."venta/add");

        }

    }*/

    public function insert_detalle_1($idventa, $idproductos, $precios, $cantidades){
        for($i=0; $i < count($idproductos) ; $i++) { 
            $data = array(
                'idventa' => $idventa,
                'idproducto' => $idproductos[$i],
                'precio' => $precios[$i],
                'cantidad' => $cantidades[$i]
            );

            $this->Pago_model->insert_detalle($data);
        }
    }







/*

    $token_id   =  trim($this->input->post("token_id")); 
    $email_culqi   =  trim($this->input->post("email_culqi")); 
    $nu_monto   =  trim($this->input->post("nu_monto"));       
    // Configurar tu API Key y autenticación
    $SECRET_KEY = "sk_test_XXX";
    $culqi = new Culqi\Culqi(array('api_key' => $SECRET_KEY));
    
    $charge = $culqi->Charges->create(
     array(
         "amount" => $nu_monto,
         "currency_code" => "PEN",
         "email" => $email_culqi,
         "description" => 'Academia ',
         "source_id" => $token_id
       )
    );      

    if($charge->object == 'charge'){
        
        $datos['id_alumno']            =  trim($this->input->post("id_alumno_m"));       
        $datos['id_padre']             =  trim($this->input->post("id_padre_m"));      
       
        $datos['fe_registro'] = $datos['fe_pago'] = date('Y-m-d H:i:s');       
        $datos['tx_operacion']=  $charge->outcome->merchant_message; 
        $datos['nu_monto']=  $nu_monto/100;
        $datos['nu_fases']=  $nu_monto/15000;
        $datos['tx_orden_culqi']=  $token_id;
        $datos['tx_tipo']=  'Culqi Pago Tarjeta' ;
        $datos['tx_estatus']=  'Pagado' ;           
            
        
        $this->load->model('Matriculacion_model');      
        $filas_afectadas = $this->Matriculacion_model->guardar($datos) ;
        $usuario = $this->session->userdata('usuario'); 
        $this->load->library('Libnotificaciones');
        $param_padre['nombre'] = $usuario->name;
        $param_padre['correo'] =  $email_culqi;  
        $param_padre['fe_pago'] =  $datos['fe_pago'];  
        $param_padre['tx_operacion'] = $charge->outcome->merchant_message; 
        $param_padre['nu_monto'] = $nu_monto/100;
        $this->libnotificaciones->envio_pago_padre($param_padre); 
    }else{
        $datos['id_alumno']            =  trim($this->input->post("id_alumno_m"));       
        $datos['id_padre']             =  trim($this->input->post("id_padre_m"));      
       
        $datos['fe_registro'] = $datos['fe_pago'] = date('Y-m-d H:i:s');       
        $datos['tx_operacion']=  $charge->merchant_message; 
        $datos['nu_monto']=  0;
        $datos['nu_fases']=  0;
        $datos['tx_orden_culqi']=  0;
        $datos['tx_tipo']=  'Culqi Pago Tarjeta' ;
        $datos['tx_estatus']=  'Fallido' ;
            
        
        $this->load->model('Matriculacion_model');      
        $filas_afectadas = $this->Matriculacion_model->guardar($datos) ;
        $usuario = $this->session->userdata('usuario'); 
        $this->load->library('Libnotificaciones');
        $param_padre['nombre'] = $usuario->name;
        $param_padre['correo'] =  $email_culqi;  
        $param_padre['fe_pago'] =  $datos['fe_pago'];  
        $param_padre['tx_operacion'] = $charge->merchant_message; 
        $param_padre['nu_monto'] =  0;
         $this->libnotificaciones->envio_pago_padre($param_padre); 
    }     
  
  // Respuesta
    echo json_encode($charge);*/

    









/*    public function constancia()
    {   
        $data = array(
            'registro' => $this->Habilidad_model->getRegistro($id),
            'detalle' => $this->Habilidad_model->getDetalle($id)
        );

        $this->load->view('constancia',$data);
    }*/



    public function getpendiente()
    {
        $id = $this->input->post("id");
        $data = $this->Pago_model->getPendiente($id);

        echo json_encode($data);        

    }

    public function getdetalle()
    {
        $id = $this->input->post("id");
        $anio = $this->input->post("anio");
        $tipo = $this->input->post("tipo");
        $data = $this->Pago_model->getDetalle($id, $anio, $tipo);

        echo json_encode($data);        

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

   /* public function buscar()
    {
        $codigo = is_null($this->input->post("codigo")) ? '' : $this->input->post("codigo");
    
        $buscar =  array(
            'codigo' => $codigo
        );
    
        $data = array(
            'datos' => $this->Habilidad_model->getRegistros($buscar)
        );
        
        $this->load->view('habilidad', $data);
        
    }*/



    /*public function validar($clave)
    {

        $data = array(
            'datos' => $this->Habilidad_model->getConstancia($clave)
        );
        
        if(isset($data['datos'][0]->matricula))
            $data['habil'] = $this->Habilidad_model->getHabil($data['datos'][0]->matricula);
        else
            $data['habil'] = "";

        $this->load->view('validar', $data);
        
    }*/
    
    public function consulta()
    {
        $codigo = is_null($this->input->post("codigo")) ? '' : $this->input->post("codigo");
        
        if($codigo!=''){
            $data = array(
                'datos' => $this->Habilidad_model->getConsulta($codigo)
            );

            //$data['habil'] = $this->Habilidad_model->getHabil($data['datos'][0]->matricula);
            if(isset($data['datos'][0]->matricula)){
                $data['habil'] = "NO";
                $data['flag'] = "SI";
                if($this->Habilidad_model->getHabil($data['datos'][0]->matricula) != '')
                    $data['habil'] = "SI";
            }
            else{
                $data['flag'] = "NO";
                $data['habil'] = "NO";
            }

            
        }else{
            $data = array(
                'datos' => ""
            );

            $data['flag'] = "NO";
            $data['habil'] = "NO";
        }

        $this->load->view('consulta', $data);

        
    }




   /* public function validadregistro()
    {
        $codigo = $this->input->post("matricula_false");
        $fecha = $this->input->post("fnacimiento");
        
        $resp = $this->Habilidad_model->validarRegistro($codigo, $fecha);

        return $resp;
    }*/



    public function imprimir_a5($id, $clave="")
    {
        date_default_timezone_set('America/Lima');

        $this->load->library('utilitarios');
        $util = new Utilitarios();


        $mes = array("ENE","FEB","MAR","ABR","MAY","JUN","JUL","AGO","SET","OCT","NOV","DIC");  


        $venta = array(
            'registro' => $this->Venta_model->getVenta($id),
            'detalle' => $this->Venta_model->getVentadetalle($id)
        );

        $serie = $venta['registro'][0]->idserie;
        $numero = $venta['registro'][0]->numero;
        $total1 = $venta['registro'][0]->total1;
        $total2 = $venta['registro'][0]->total2;
        $obs = utf8_decode($venta['registro'][0]->obs);
        $fecha = $venta['registro'][0]->fecha;
        $numdoc = $venta['registro'][0]->nummat;
        $key = $venta['registro'][0]->clave;
        $nombre = $venta['registro'][0]->nombres . ' ' . $venta['registro'][0]->paterno . ' ' . $venta['registro'][0]->materno;
        
        $this->load->library('fpdf_masterA5');
        $this->load->library('Letras');

        #Establecemos los márgenes izquierda, arriba y derecha:
        $this->fpdf->SetMargins(30, 8 , 12);

        //$this->fpdf->setY(-50);

        $this->fpdf->setY(40);

        $this->fpdf->SetFont('Arial','B',20); 
        $this->fpdf->Cell(100,5,'RECIBO', '0', '1', 'C');

        $this->fpdf->Ln(5);
        $this->fpdf->SetTextColor(255,0,0);
        $this->fpdf->SetFont('Arial','B',18); 
        $this->fpdf->Cell(105,5,utf8_decode('Nº').$numero, '0', '1', 'R');

        $this->fpdf->SetTextColor(0,0,0);

        $this->fpdf->Ln(10);

        $this->fpdf->SetFont('Arial','',12); 
        $this->fpdf->setX(14);
        $this->fpdf->Cell(100,5,utf8_decode('Colegiatura : ' . $numdoc), '0', '1', 'L');
        $this->fpdf->Ln(3);
        $this->fpdf->setX(14);
        $this->fpdf->SetFont('Arial','',11); 
        $this->fpdf->Cell(100,5,utf8_decode('Recibí de      : ' . $nombre), '0', '1', 'L');

        $this->fpdf->Ln(4);

        $this->fpdf->SetFont('Arial','B',8); 
        $this->fpdf->setX(14);
        $this->fpdf->line(14,$this->fpdf->getY(),135,$this->fpdf->getY());
        $this->fpdf->setX(14);
        $this->fpdf->Cell(10,5,'Cant.', '0', '0', 'C');
        $this->fpdf->Cell(76,5,utf8_decode('Denominación'), '0', '0', 'C');
        $this->fpdf->Cell(15,5,'P/U', '0', '0', 'C');
        $this->fpdf->Cell(15,5,'Importe', '0', '1', 'C');
        $this->fpdf->setX(14);
        $this->fpdf->line(14,$this->fpdf->getY(),135,$this->fpdf->getY());
        
        $total =0;
        
        $this->fpdf->SetFont('Arial','',9); 
        foreach($venta['detalle'] as $reg){
            $texto = "";
            $cadena = utf8_decode($reg->obs);

            if(strlen($cadena) > 0){

                if($reg->idconcepto <= 2){
                    $var_anual = explode("*", $cadena);

                    if(count($var_anual) > 1){
                        $anio1 = substr($var_anual[0],0,4);
                        $meses1 = substr($var_anual[0],5);

                        $anio2 = substr($var_anual[1],0,4);
                        $meses2 = substr($var_anual[1],5);

                        $texto = $mes[intval(substr($meses1,0,2))-1] . (strlen($meses1) > 2?"-".$mes[intval(substr($meses1,-2))-1]:"")." " . $anio1;

                        $texto .= ", ".$mes[intval(substr($meses2,0,2))-1] . (strlen($meses2) > 2?"-".$mes[intval(substr($meses2,-2))-1]:"")." " . $anio2;

                    }else{
                        $anio = substr($reg->obs,0,4);
                        $meses = substr($reg->obs,5);
                        $texto = $mes[intval(substr($meses,0,2))-1] . (strlen($meses) > 2?"-".$mes[intval(substr($meses,-2))-1]:"")." " . $anio;
                    }



                }else{
                    $texto = $cadena;
                }






            }
            
            $this->fpdf->setX(14);
            $this->fpdf->Cell(10,5, $reg->cantidad, '0', '0', 'C');
            $this->fpdf->SetFont('Arial','',7); 
            $this->fpdf->Cell(82,5, utf8_decode($reg->nombre.' '.$texto), '0', '0', 'L');
            $this->fpdf->SetFont('Arial','',9); 
            $this->fpdf->Cell(15,5,  number_format($reg->precio,2,".",",") , 0, 0, 'R');
            $this->fpdf->Cell(15,5,  number_format($reg->cantidad*$reg->precio,2,".",",") , 0, 1, 'R');
            $total += $reg->cantidad*$reg->precio;
        }
        $this->fpdf->line(14,$this->fpdf->getY(),135,$this->fpdf->getY());

        $this->fpdf->Ln(1);

        $letras=new Letras();
        $importeletras = strtoupper($letras->ValorEnLetras($total,""));
        $this->fpdf->setX(14);

        $this->fpdf->Ln(1);
        $this->fpdf->SetFont('Arial','B',18); 
        $this->fpdf->Cell(0,5,"Total S/ ".number_format($total,2,".",","), '0', '0', 'R');

        $this->fpdf->setX(14);
        $this->fpdf->SetFont('Arial','B',9); 
        $this->fpdf->Cell(0,5,'SON: '.$importeletras, '0', '0', 'L');

        $this->fpdf->Ln(5);

        $this->fpdf->setX(14);
        $this->fpdf->SetFont('Arial','',9); 
        $this->fpdf->Cell(0,5,$obs, '0', '0', 'L');
        $this->fpdf->Ln(1);

        $this->fpdf->Ln(5);
        $this->fpdf->SetFont('Arial','',9); 
        $fecha_letras = $util->fecha_letras($fecha);

        $this->fpdf->setX(14);
        $this->fpdf->Cell(0,5,'Puno, '.$fecha_letras, '0', '0', 'R');
        $this->fpdf->Ln(10);

               
        $this->fpdf->setX(14);
        $this->fpdf->Cell(0,5,utf8_decode("Impresión: ").date('Y-m-d h:i:s A'), '0', '0', 'L');
        $this->fpdf->Ln(3);

        $this->fpdf->Code39(20,160,$serie.$numero,1,10);
        $this->fpdf->Ln(4);

        $this->fpdf->SetFont('Arial','',8); 
        $this->fpdf->Text(32,175,$serie.'-'.$numero." (Key: ".$key.")", '0', '1', 'L');
        
        $this->fpdf->output();

        
    }

    public function imprimir($id, $clave="")//ticket
    {

        date_default_timezone_set('America/LIma');

        $this->load->library('utilitarios');
        $this->load->library('Letras');

        $util = new Utilitarios();

        $venta = array(
            'registro' => $this->Pago_model->getVenta($id),
            'detalle' => $this->Pago_model->getVentadetalle($id)
        );

        $serie = $venta['registro'][0]->idserie;
        $numero = $venta['registro'][0]->numero;
        $hora_insert = $venta['registro'][0]->hora_insert;
        $fecha = $venta['registro'][0]->fecha;
        $nummat = $venta['registro'][0]->nummat;
        $dni = $venta['registro'][0]->dni;
        $direccion = $venta['registro'][0]->direccion;
        $key = $venta['registro'][0]->clave;
        $nombre = $venta['registro'][0]->nombres . ' ' . $venta['registro'][0]->paterno . ' ' . $venta['registro'][0]->materno;
        
        $this->load->library('ticket_master');
        
        $this->fpdf->Image(base_url().'/resources/img/logo.png', 18, 5, 40, 40, 'PNG', '', 'L', false, 150, '', false, false, 0, false, false, false);

        $this->fpdf->SetFont('Arial','B',8);    //Letra Arial, negrita (Bold), tam. 20
        $this->fpdf->setX(0);


        $this->fpdf->setY(50);
        $this->fpdf->SetFont('Arial','B',18); 
        $this->fpdf->setX(3);
        $this->fpdf->Cell(0,5, utf8_decode('Nº ') . $serie.'-'.$numero, '0', '1', 'C');
        $this->fpdf->Ln(4);

        $this->fpdf->SetFont('Arial','B',12); 
        $this->fpdf->setX(3);
        $this->fpdf->Cell(0,5, 'Fecha: ' . $fecha, '0', '1', 'C');
        
        $this->fpdf->Ln(4);

       
        $this->fpdf->SetFont('Arial','',8); 
        $this->fpdf->setX(3);
        $this->fpdf->Cell(12,5,'DNI', '0', '0', 'L');

        $this->fpdf->SetFont('Arial','B',9); 
        $this->fpdf->Cell(20,5,$dni, '0', '0', 'L');

        $this->fpdf->SetFont('Arial','',8); 
        $this->fpdf->Cell(15,5,utf8_decode('Matrícula'), '0', '0', 'L');

        $this->fpdf->SetFont('Arial','B',9); 
        $this->fpdf->Cell(20,5,$nummat, '0', '1', 'L');

        
        $this->fpdf->setX(3);
        $this->fpdf->SetFont('Arial','',8); 
        $this->fpdf->Cell(12,5,'Nombre', '0', '0', 'L');
        $this->fpdf->SetFont('Arial','B',8); 
        $this->fpdf->Cell(55,5,$nombre, '0', '1', 'L');
        $this->fpdf->setX(3);
        $this->fpdf->SetFont('Arial','',7); 
        $this->fpdf->Cell(12,5,utf8_decode('Dirección'), '0', '0', 'L');
        $this->fpdf->Cell(55,5,$direccion, '0', '1', 'L');
        
        $this->fpdf->Ln(2);

        $this->fpdf->SetFont('Arial','',7); 
        $this->fpdf->setX(5);
        $this->fpdf->Cell(70,2,'---------------------------------------------------------------------------------------------', '0', '1', 'C');
        $this->fpdf->setX(3);
        $this->fpdf->Cell(8,5,'CANT.', '0', '0', 'C');
        $this->fpdf->Cell(44,5,'DENOMINACION', '0', '0', 'C');
        $this->fpdf->Cell(8,5,'P/U', '0', '0', 'C');
        $this->fpdf->Cell(10,5,'IMPORTE', '0', '1', 'C');
        $this->fpdf->setX(5);
        $this->fpdf->Cell(70,2,'---------------------------------------------------------------------------------------------', '0', '1', 'C');

        
        $total =0;
        
        $meses = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre"];

        foreach($venta['detalle'] as $pro){
            $detalle = "";
            if($pro->idconcepto == "0"){
                $cadena = $pro->cuotas;
                $anio = substr($cadena, 0, 4);
                
                $selectedMes = explode(',',$cadena);
                $num = count($selectedMes);

                $detalle = ($num > 1 ? $meses[0]."-".$meses[$num-1]." de ".$anio."." : $meses[0]." de ".$anio.".");
            }

            $this->fpdf->setX(3);
            $this->fpdf->Cell(8, 5, $pro->cantidad, '0', '0', 'C');
            $this->fpdf->Cell(44,5, utf8_decode(substr($pro->nombre, 0,35)), '0', '0', 'L');
            $this->fpdf->Cell(8,5,  number_format($pro->precio,2,".",",") , 0, 0, 'R');
            $this->fpdf->Cell(10,5,  number_format($pro->cantidad*$pro->precio,2,".",",") , 0, 1, 'R');

            if($pro->idconcepto == "0"){
                $this->fpdf->setX(3);
                $this->fpdf->Cell(8, 5, "", '0', '0', 'C');
                $this->fpdf->Cell(44,5, $detalle, '0', '0', 'L');
                $this->fpdf->Cell(8,5,  "", 0, 0, 'R');
                $this->fpdf->Cell(10,5, "", 0, 1, 'R');
            }

            $total += $pro->cantidad*$pro->precio;
        }

        $this->fpdf->setX(5);
        $this->fpdf->Cell(70,2,'---------------------------------------------------------------------------------------------', '0', '1', 'C');

        $this->fpdf->SetFont('Arial','B',10); 
        $this->fpdf->Cell(50,5,"TOTAL S/ :", '0', '0', 'R');
        $this->fpdf->Cell(10,5,number_format($total,2,".",","), '0', '1', 'C');

        $this->fpdf->Ln(2);       
        $this->fpdf->SetFont('Arial','',7); 
        $this->fpdf->setX(2);
        $letras=new Letras();
        $importeletras = strtoupper($letras->ValorEnLetras($total,""));

        $this->fpdf->Cell(0,5,"SON: ".$importeletras, '0', '1', 'L');

        $this->fpdf->Ln(5);
        $this->fpdf->SetFont('Arial','',7);
        $this->fpdf->setX(2);

        $this->fpdf->setX(2);
        $this->fpdf->Cell(15,2,"Clave", '0', '0', 'L');
        $this->fpdf->Cell(40,2,$key, '0', '0', 'L');
        $this->fpdf->Ln(4);
        $this->fpdf->setX(2);
        $this->fpdf->Cell(15,2,utf8_decode("Elaboración"), '0', '0', 'L');
        $this->fpdf->Cell(40,2,$hora_insert, '0', '0', 'L');
        $this->fpdf->Ln(4);
        $this->fpdf->setX(2);
        $this->fpdf->Cell(15,2,utf8_decode("Impresión"), '0', '0', 'L');
        $this->fpdf->Cell(40,2,date("d/m/Y H:i:s"), '0', '0', 'L');

        

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial','',8); 
        $this->fpdf->setX(2);
        $this->fpdf->Cell(0,5,"GESTION MODERNA Y TRANSPARENTE...!!!!", '0', '1', 'C');
        $this->fpdf->Ln(12);
        $this->fpdf->Cell(0,5,".:.", '0', '1', 'C');

        $this->fpdf->output();

    }


    public function enviar_email(){
      $destinatario = "elvis.aliagan@gmail.com";
      $asunto = "Recibo de Pagp";
      $cuerpo = "Como estas?";
      mail($destinatario,$asunto,$cuerpo);
  }


    public function declinarpago(){
        $id = $this->input->post("id");
        $this->Pago_model->declinarpago($id);
    }


}
