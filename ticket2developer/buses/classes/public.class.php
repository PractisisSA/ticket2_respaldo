<?php
date_default_timezone_set('America/Guayaquil');
session_start();
//include("controlusuarios/seguridad.php");

class InitTicket{
	public $route;
	public $subpagePath;
	public $pages = array(
		'start' => array('path' => 'subpages/start.php','title' => ''),
		'somos' => array('path' => 'subpages/somos.php','title' => 'Configurar Productos'),
		'des_concierto' => array('path' => 'subpages/Conciertos/des_concierto.php','title' => ''),
		'des_pub' => array('path' => 'subpages/Conciertos/des_pub.php','title' => ''),
		'des_pub2' => array('path' => 'subpages/Conciertos/des_pub2.php','title' => ''),
		'comprar' => array('path' => 'subpages/Compras/comprar.php','title' => ''),
		'reservar' => array ('path' => 'subpages/Compras/reservar.php','title' => ''),
		'registrousuario' => array ('path' => 'subpages/registrousuario.php', 'title' => ''),
		'registrousuarioreserva' => array ('path' => 'subpages/registrousuarioreserva.php', 'title' => ''),
		'pagotarjeta' => array ('path' => 'subpages/Compras/pagotarjeta.php', 'title' => ''),
		'pagotarjetaCredito' => array ('path' => 'subpages/Compras/pagotarjetaCredito.php', 'title' => ''),
		'pagoPaypal' => array ('path' => 'subpages/Compras/pagoPaypal.php', 'title' => ''),
		'pago_Paypal' => array ('path' => 'subpages/Compras/pagoPaypalKiosko.php', 'title' => ''),
		'pagoPaypalok' => array ('path' => 'confirma.php', 'title' => ''),
		'pago_Paypalok' => array ('path' => 'subpages/Compras/confirma_kiosko.php', 'title' => ''),
		'pagoreserva' => array ('path' => 'subpages/Compras/pagoreserva.php', 'title' => ''),
		'updcliente' => array ('path' => 'subpages/perfilcliente.php', 'title' => ''),
		'updclientecliente' => array ('path' => 'subpages/perfilclientereserva.php', 'title' => ''),
		'pagotarjetaok' => array ('path' => 'subpages/Compras/pagotarjetaok.php', 'title' => ''),
		'pagoTarjetaCreditoOk' => array ('path' => 'subpages/Compras/pagoTarjetaCreditoOk.php', 'title' => ''),
		'pagoreservaok' => array ('path' => 'subpages/Compras/pagoreservaok.php', 'title' => ''),
		'predepositook' => array ('path' => 'subpages/Compras/predepositook.php', 'title' => ''),
		'pre_deposito_ok' => array ('path' => 'subpages/Compras/pre_deposito_ok.php', 'title' => ''),
		'pventa' => array ('path' => 'subpages/p_venta.php', 'title' => ''),
		'contactos' => array ('path' => 'subpages/contacto.php', 'title' => ''),
		'terminos' => array ('path' => 'http://ticketfacil.ec/terminosycondiciones/index.php', 'title' => ''),
		'reimprime_dist' => array ('path' => 'subpages/reimprime_dist.php', 'title' => ''),
		'ingresa_boletos_distribuidor' => array ('path' => 'subpages/ingresa_boletos_distribuidor.php', 'title' => ''),
		'anula_boletos' => array ('path' => 'distribuidor/dar_de_baja_boletos.php', 'title' => ''),
		'cambia_usu_boleto' => array ('path' => 'distribuidor/cambia_usu_boleto.php', 'title' => ''),
		'servicios' => array ('path' => 'subpages/servicios.php', 'title' => ''),
		'conciertos' => array ('path' => 'subpages/conciertos.php', 'title' => ''),
		'login' => array ('path' => 'subpages/login.php', 'title' => ''),
		'newaccount' => array ('path' => 'subpages/newaccount.php', 'title' => ''),
		'deposito' => array ('path' => 'subpages/Compras/deposito.php', 'title' => ''),
		'add_depositook' => array ('path' => 'subpages/Compras/inserts/add_depositook.php', 'title' => ''),
		'pagoReservadep' => array ('path' => 'subpages/Compras/diffReservadep.php', 'title' => ''),
		'pagotarReserva' => array ('path' => 'subpages/Compras/pagoReservas/pagotarjetaReserva.php', 'title' => ''),
		'PayDepok' => array ('path' => 'subpages/Compras/pagoReservas/payDepok.php', 'title' => ''),
		'clona' => array ('path' => 'spadmin/clona.php', 'title' => ''),
		'ingresoAdmin' => array ('path' => 'spadmin/ingresosa.php', 'title' => ''),
		'Rdepositos' => array ('path' => 'spadmin/revisardeposito.php', 'title' => ''),
		'listaConciertos' => array ('path' => 'spadmin/list_concierto.php', 'title' => ''),
		'editConcierto' => array ('path' => 'spadmin/edit_concierto.php', 'title' => ''),
		'creacionmapa' => array ('path' => 'spadmin/creacionmapa.php', 'title' => ''),
		'CreacionConciertos' => array ('path' => 'spadmin/new_concierto.php', 'title' => ''),
		'CreacionPublicaciones' => array ('path' => 'spadmin/new_publicacion.php', 'title' => ''),
		'actualiza' => array ('path' => 'spadmin/actualizaClaves.php', 'title' => ''),
		'ingresoSocio' => array ('path' => 'Estadisticas/ingresoSocio.php', 'title' => ''),
		'eventosRealizados' => array ('path' => 'Estadisticas/eventos.php', 'title' => ''),
		'reportesSocios' => array ('path' => 'Estadisticas/reportesSocios.php', 'title' => ''),
		'reportesDist' => array ('path' => 'Estadisticas/reportesFybeca.php', 'title' => ''),
		'reportesDistDet' => array ('path' => 'Estadisticas/reportesCajasDetalle.php', 'title' => ''),
		'estadisticas' => array ('path' => 'Estadisticas/estadisticas.php', 'title' => ''),
		'ingresoSP' => array ('path' => 'SP/ingresoSP.php', 'title' => ''),
		'crearUsuarios' => array ('path' => 'SP/crearusuarios.php', 'title' => ''),
		'listaUsuarios' => array ('path' => 'SP/listausuarios.php', 'title' => ''),
		'validarUsuarioA' => array ('path' => 'subpages/validarusuario.php', 'title' => ''),
		'editarUsuario' => array ('path' => 'SP/editarusuario.php', 'title' => ''),
		'listaEvento' => array ('path' => 'SP/listaeventos.php', 'title' => ''),
		'eliminarConcierto' => array ('path' => 'SP/editarconcert.php', 'title' => ''),
		'eliminarLocal' => array ('path' => 'SP/eliminarlocal.php', 'title' => ''),
		'eliminarArt' => array ('path' => 'SP/eliminarart.php', 'title' => ''),
		'ingresoAdt' => array ('path' => 'Adt/ingresoAdt.php', 'title' => ''),
		'logTributario' => array ('path' => 'Adt/logtributario.php', 'title' => ''),
		'logUsuario' => array ('path' => 'Adt/logusuario.php', 'title' => ''),
		'logAcceso' => array ('path' => 'Adt/logacceso.php', 'title' => ''),
		'listaSocio' => array ('path' => 'SP/listasocios.php', 'title' => ''),
		'crearSocio' => array ('path' => 'SP/crearsocios.php', 'title' => ''),
		'editSocio' => array ('path' => 'SP/editsocio.php', 'title' => ''),
		'Autorizaciones' => array ('path' => 'spadmin/autorizaciones.php', 'title' => ''),
		'logAutorizaciones' => array ('path' => 'Adt/logautorizaciones.php', 'title' => ''),
		'logTransaccional' => array ('path' => 'Adt/logtransaccional.php', 'title' => ''),
		'ticketFacil' => array ('path' => 'SP/datosticketfacil.php', 'title' => ''),
		'transacciones' => array ('path' => 'spadmin/transacciones.php', 'title' => ''),
		'logReimpresiones' => array ('path' => 'Adt/logreimpresiones.php', 'title' => ''),
		'imPrint' => array ('path' => 'spadmin/printdocs.php', 'title' => ''),
		'logClientes' => array ('path' => 'Adt/logclientes.php', 'title' => ''),
		'reimpresion' => array ('path' => 'spadmin/reimpresiones.php', 'title' => ''),
		'distribuidor' => array('path' => 'SP/distribuidor.php', 'title' => ''),
		'ingresoDis' => array('path' => 'distribuidor/ingresoDis.php', 'title' => ''),
		'distribuidorMod' => array('path' => 'distribuidor/distribuidorindex.php', 'title' => ''),
		'ventasDistribuidor' => array('path' => 'distribuidor/ventasistribuidor.php', 'title' => ''),
		'conciertoDis' => array('path' => 'distribuidor/eventos/conciertodistribuidor.php', 'title' => ''),
		'vederDis' => array('path' => 'distribuidor/ventas/venderdistribuidor.php', 'title' => ''),
		'pagoexitosoDis' => array('path' => 'distribuidor/ventas/pagoexitosodis.php', 'title' => ''),
		'preventaok' => array('path' => 'subpages/Compras/preventaok.php', 'title' => ''),
		'pre_Ventaok' => array('path' => 'subpages/Compras/preventaokKiosko.php', 'title' => ''),
		'reservasDistribuidor' => array('path' => 'distribuidor/cobrosdistribuidor.php', 'title' => ''),
		'cobrarDis' => array('path' => 'distribuidor/cobros/cobrardistribuidor.php', 'title' => ''),
		'cobrook' => array('path' => 'distribuidor/cobros/cobrosok.php', 'title' => ''),
		'cobroreservaok' => array('path' => 'distribuidor/cobros/cobrosreservaok.php', 'title' => ''),
		'miperfil' => array('path' => 'subpages/miperfil.php', 'title' => ''),
		'reportes' => array('path' => 'SP/reportes/index.php', 'title' => ''),
		'reportesMun' => array('path' => 'Estadisticas/reportesMun.php', 'title' => ''),
		'cuenta' => array('path' => 'SP/cuenta/index.php', 'title' => ''),
		'asignartickets' => array('path' => 'subpages/asignartickets.php', 'title' => ''));
	
	public function __construct(){
		$this -> CheckIfPageRequestIsLegal();
		}
	
	public function CheckIfPageRequestIsLegal(){
		if($_SESSION['autentica'] == 'SA456'){
			$request = isset($_REQUEST['modulo']) ? $_REQUEST['modulo'] : 'ingresoAdmin';
		}else{
			if($_SESSION['autentica'] == 'jag123'){
				$request = isset($_REQUEST['modulo']) ? $_REQUEST['modulo'] : 'ingresoSocio';
			}else{
				if($_SESSION['autentica'] == 'tFSp777'){
					$request = isset($_REQUEST['modulo']) ? $_REQUEST['modulo'] : 'ingresoSP';
				}else{
					if($_SESSION['autentica'] == 'TfAdT545'){
						$request = isset($_REQUEST['modulo']) ? $_REQUEST['modulo'] : 'ingresoAdt';
					}else{
						$request = isset($_REQUEST['modulo']) ? $_REQUEST['modulo'] : 'start';
					}
				}
			}
		}
		
		if(array_key_exists($request,$this -> pages)){
			$this -> subpagePath = $this -> pages[$request]['path'];
			}
		else{
			$this -> subpagePath = 'subpages/404.php';
			}
		}
	}
	
	include('private.db.php');
	
	$gbd = new DBConn();
	
	$estado = 'Activo';
	$hoy = date('Y-m-d');
	
	$selectDatosConciertoStart = "SELECT idConcierto, strImagen, dateFecha, strEvento, strLugar, timeHora, strDescripcion , tipo_conc , tiene_permisos , es_publi FROM Concierto WHERE  strEstado = ? AND costoenvioC = 1 ORDER BY idConcierto DESC";  //dateFecha >= ? AND
	$resultDatosConciertoStart = $gbd -> prepare($selectDatosConciertoStart);
	$resultDatosConciertoStart -> execute(array($estado));
	
	
	$selectDatosConciertoStart1 = "SELECT idConcierto, strImagen, dateFecha, strEvento, strLugar, timeHora, strDescripcion , tipo_conc , tiene_permisos , es_publi FROM Concierto WHERE  dateFecha >= ? AND strEstado = ? AND costoenvioC = 1 ORDER BY dateFecha DESC";  //
	$resultDatosConciertoStart1 = $gbd -> prepare($selectDatosConciertoStart1);
	$resultDatosConciertoStart1 -> execute(array($hoy,$estado));
	
	$selectSliderStart = "SELECT idConcierto, strImagen , es_publi FROM Concierto WHERE costoenvioC = 1 ORDER BY dateFecha DESC";
	$resultSlideStar = $gbd -> prepare($selectSliderStart);
	$resultSlideStar -> execute();
	$num_imagenes = $resultSlideStar -> rowCount();
	
	$slidertriple = "SELECT idConcierto, strImagen , es_publi FROM Concierto WHERE costoenvioC = 1 ORDER BY dateFecha DESC";
	$resulttriple = $gbd -> prepare($slidertriple);
	$resulttriple -> execute();
	
	//registrousuario
	
	$concert = $_GET['con'];
	$selectUser = "SELECT strMailU FROM Usuario";
	$resultSelectUser = $gbd -> prepare($selectUser);
	$resultSelectUser -> execute();
?>