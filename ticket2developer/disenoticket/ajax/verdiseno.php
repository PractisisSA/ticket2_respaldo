<?php
    require_once('private.db.php');
    $gbd = new DBConn();

	$disenoweb = $_REQUEST['disenoweb'];
	$idCon = $_REQUEST['idCon'];
    $idLoc = $_REQUEST['idLoc'];
    $idDes = $_REQUEST['idDes'];

    $data = file_get_contents("http://ticketfacil.ec/apiTicketFacil2.php?id=18&idCon=$idCon");
    $products = json_decode($data, true);

    foreach ($products as $product) {
        foreach ($product['concierto'] as $product1) {
            $ruc_cliente = $product1['ruc_cliente'];
            $lleva_cota = $product1['lleva_cota'];
            $matriz_clie = $product1['matriz_clie'];
            $suc_cliente = $product1['suc_cliente'];
            $aut_mun_cli = $product1['aut_mun_cli'];
            $aut_sri_cli = $product1['aut_sri_cli'];
            $Desde = $product1['Desde'];
            $fechaA = $product1['fechaA'];
            $FechaC = $product1['FechaC'];
            $docu = $product1['docu'];
            $tipo_negocio = $product1['tipo_negocio'];
        }
    }

    $data1 = file_get_contents("http://ticketfacil.ec/apiTicketFacil2.php?id=17&idCon=$idCon");
    $products1 = json_decode($data1, true);

    foreach ($products1 as $product1) {
        foreach ($product1['concierto'] as $product11) {
            $Nombre = $product11['Nombre'];
            $aut_sri_pro = $product11['aut_sri_pro'];
            $aut_mun_pro = $product11['aut_mun_pro'];
            $Ruc = $product11['Ruc'];
            $TipoCont = $product11['TipoCont'];
        }
    }

    $data2 = file_get_contents("http://ticketfacil.ec/apiTicketFacil2.php?id=27&idCon=$idCon&idLoc=$idLoc&idDes=$idDes");
    $products2 = json_decode($data2, true);

    foreach ($products2 as $product2) {
        foreach ($product2['entradas'] as $product22) {
            $imp = $product22['imp'];
            $id = $product22['id'];
            $Car = $product22['Car'];
            $boleto = $product22['boleto'];
            $bloque = $product22['bloque'];
            $puerta = $product22['puerta'];
            $asientos = $product22['asientos'];
            $codigo = $product22['codigo'];
            $Valor = $product22['Valor'];
            $localidad = $product22['localidad'];
            $abr = $product22['abr'];
            $valor_normal = $product22['valor_normal'];
            $valor_descuento = $product22['valor_descuento'];
            $valor_nominal = $product22['valor_nominal'];
            $impuesto = $product22['impuesto'];
            $nom = $product22['nom'];
            $total = $product22['total'];
        }
    }

    $quitar0 = 'id="camp';
    $quitar1 = 'verModal(this);'; 

    $poner0 = 'id="';
    $poner1 = '';

    //$disenowebmod = str_ireplace('[ruc_cliente]',$ruc_cliente,$disenoweb);
    $healthy = array("[ruc_cliente]","[lleva_cota]","[matriz_clie]","[suc_cliente]","[aut_mun_cli]",
                     "[aut_sri_cli]","[Desde]","[fechaA]","[FechaC]","[docu]","[tipo_negocio]",
                     "[Nombre]","[aut_sri_pro]","[aut_mun_pro]","[Ruc]","[TipoCont]","|@|",$quitar0,$quitar1,
                     "[imp]","[Car]","[boleto]","[bloque]","[puerta]","[asientos]","[codigo]","[Valor]","[localidad]",
                     "[abr]","[valor_normal]","[valor_descuento]","[valor_nominal]","[impuesto]","[nom]","[total]");
    $yummy   = array($ruc_cliente,$lleva_cota,$matriz_clie,$suc_cliente,$aut_mun_cli,
                     $aut_sri_cli,$Desde,$fechaA,$FechaC,$docu,$tipo_negocio,
                     $Nombre,$aut_sri_pro,$aut_mun_pro,$Ruc,$TipoCont,"",$poner0,$poner1,
                     $imp,$Car,$boleto,$bloque,$puerta,$asientos,$codigo,$Valor,$localidad,
                     $abr,$valor_normal,$valor_descuento,$valor_nominal,$impuesto,$nom,$total);

    $disenowebmod = str_replace($healthy, $yummy, $disenoweb);

    echo $disenowebmod;

	/*try{
		$update = "UPDATE disenoticket SET disenoweb = ?, disenoimp = ? WHERE id = ?";
		$sql = $gbd -> prepare($update);
		$sql -> execute(array($disenoweb,$disenoimp,$id));
	}catch(PDOException $e){
		print_r($e);
	}*/
?>