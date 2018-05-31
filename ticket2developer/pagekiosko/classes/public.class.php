<?php
date_default_timezone_set('America/Guayaquil');
session_start();
include("controlusuarios/seguridad.php");

class InitTicket{
	public $route;
	public $subpagePath;
	public $pages = array(
		'start' => array('path' => 'subpages/start.php','title' => ''),
		'somos' => array('path' => 'subpages/somos.php','title' => 'Configurar Productos'),
		'des_concierto' => array('path' => 'subpages/Conciertos/des_concierto.php','title' => ''),
		'comprar' => array('path' => 'subpages/Compras/comprar.php','title' => ''),
		'reservar' => array ('path' => 'subpages/Compras/reservar.php','title' => ''),
		'registrousuario' => array ('path' => 'subpages/registrousuario.php', 'title' => ''),
		'registrousuarioreserva' => array ('path' => 'subpages/registrousuarioreserva.php', 'title' => ''),
		'pagotarjeta' => array ('path' => 'subpages/Compras/pagotarjeta.php', 'title' => ''),
		'pagoPaypal' => array ('path' => 'subpages/Compras/pagoPaypal.php', 'title' => ''),
		'pagoPaypalok' => array ('path' => 'confirma.php', 'title' => ''),
		'pagoreserva' => array ('path' => 'subpages/Compras/pagoreserva.php', 'title' => ''),
		'updcliente' => array ('path' => 'subpages/perfilcliente.php', 'title' => ''),
		'updclientecliente' => array ('path' => 'subpages/perfilclientereserva.php', 'title' => ''),
		'pagotarjetaok' => array ('path' => 'subpages/Compras/pagotarjetaok.php', 'title' => ''),
		'pagoreservaok' => array ('path' => 'subpages/Compras/pagoreservaok.php', 'title' => ''),
		'predepositook' => array ('path' => 'subpages/Compras/predepositook.php', 'title' => ''),
		'pventa' => array ('path' => 'subpages/p_venta.php', 'title' => ''),
		'contactos' => array ('path' => 'subpages/contacto.php', 'title' => ''),
		'conciertos' => array ('path' => 'subpages/conciertos.php', 'title' => ''),
		'login' => array ('path' => 'subpages/login.php', 'title' => ''),
		'newaccount' => array ('path' => 'subpages/newaccount.php', 'title' => ''),
		'deposito' => array ('path' => 'subpages/Compras/deposito.php', 'title' => ''),
		'add_depositook' => array ('path' => 'subpages/Compras/inserts/add_depositook.php', 'title' => ''),
		'pagoReservadep' => array ('path' => 'subpages/Compras/diffReservadep.php', 'title' => ''),
		'pagotarReserva' => array ('path' => 'subpages/Compras/pagoReservas/pagotarjetaReserva.php', 'title' => ''),
		'PayDepok' => array ('path' => 'subpages/Compras/pagoReservas/payDepok.php', 'title' => ''),
		'ingresoAdmin' => array ('path' => 'spadmin/ingresosa.php', 'title' => ''),
		'Rdepositos' => array ('path' => 'spadmin/revisardeposito.php', 'title' => ''),
		'listaConciertos' => array ('path' => 'spadmin/list_concierto.php', 'title' => ''),
		'editConcierto' => array ('path' => 'spadmin/edit_concierto.php', 'title' => ''),
		'creacionmapa' => array ('path' => 'spadmin/creacionmapa.php', 'title' => ''),
		'CreacionConciertos' => array ('path' => 'spadmin/new_concierto.php', 'title' => ''),
		'ingresoSocio' => array ('path' => 'Estadisticas/ingresoSocio.php', 'title' => ''),
		'eventosRealizados' => array ('path' => 'Estadisticas/eventos.php', 'title' => ''),
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
		'ingresoKio' => array('path' => 'kiosko/ingresoKio.php', 'title' => ''),
		'distribuidorMod' => array('path' => 'distribuidor/distribuidorindex.php', 'title' => ''),
		'moduloKiosko' => array('path' => 'kiosko/indexKiosko.php', 'title' => ''),
		'ventasDistribuidor' => array('path' => 'distribuidor/ventasistribuidor.php', 'title' => ''),
		'ventasKiosko' => array('path' => 'kiosco/ventasKiosko.php', 'title' => ''),
		'conciertoDis' => array('path' => 'distribuidor/eventos/conciertodistribuidor.php', 'title' => ''),
		'vederDis' => array('path' => 'distribuidor/ventas/venderdistribuidor.php', 'title' => ''),
		'pagoexitosoDis' => array('path' => 'distribuidor/ventas/pagoexitosodis.php', 'title' => ''),
		'preventaok' => array('path' => 'subpages/Compras/preventaok.php', 'title' => ''),
		'reservasDistribuidor' => array('path' => 'distribuidor/cobrosdistribuidor.php', 'title' => ''),
		'reservasKiosko' => array('path' => 'kiosco/cobrosKiosko.php', 'title' => ''),
		'cobrarDis' => array('path' => 'distribuidor/cobros/cobrardistribuidor.php', 'title' => ''),
		'cobrook' => array('path' => 'distribuidor/cobros/cobrosok.php', 'title' => ''),
		'cobroreservaok' => array('path' => 'distribuidor/cobros/cobrosreservaok.php', 'title' => ''),
		'miperfil' => array('path' => 'subpages/miperfil.php', 'title' => ''),
		'kiosco' => array('path' => 'subpages/somos.php','title' => ''),
		'reportes' => array('path' => 'SP/reportes/index.php', 'title' => '')
		);
	
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
	
	$selectDatosConciertoStart = "SELECT idConcierto, strImagen, dateFecha, strEvento, strLugar, timeHora, strDescripcion , tiene_permisos FROM Concierto WHERE dateFecha >= ? AND strEstado = ? ORDER BY dateFecha ASC";
	$resultDatosConciertoStart = $gbd -> prepare($selectDatosConciertoStart);
	$resultDatosConciertoStart -> execute(array($hoy,$estado));
	
	$selectSliderStart = "SELECT idConcierto, strImagen FROM Concierto WHERE dateFecha >= ? AND strEstado = ? ORDER BY dateFecha ASC";
	$resultSlideStar = $gbd -> prepare($selectSliderStart);
	$resultSlideStar -> execute(array($hoy,$estado));
	$num_imagenes = $resultSlideStar -> rowCount();
	
	$slidertriple = "SELECT idConcierto, strImagen FROM Concierto WHERE dateFecha >= ? AND strEstado = ? ORDER BY dateFecha ASC";
	$resulttriple = $gbd -> prepare($slidertriple);
	$resulttriple -> execute(array($hoy,$estado));
	
	//registrousuario
	
	$concert = $_GET['con'];
	$selectUser = "SELECT strMailU FROM Usuario";
	$resultSelectUser = $gbd -> prepare($selectUser);
	$resultSelectUser -> execute();
?>