<?php 
//echo date("Y-m-d H:i:s");
$fecha=date("Y-m-d");
$hora=date("H:i:s");
//echo "<br>";

include("recursos/config.php");

include("recursos/control_ip.php");
	
$ip=miip();

session_start();

$_SESSION["dir_ip"]=miip();

$usu=filtra($_POST["usuario"]);
$pass=filtra($_POST["pass"]);

$md5=filtra($_POST["md5"]);
//echo "md5".$md5."<br>";
//extra
$num=filtra($_POST["num"]);	
$_SESSION["cusu"]=$usu;

$_SESSION["mo"]=0;
	
	$num++;
	//if((strcmp($contrase_md5,$exi_usuario[3]))!=0){
	ins_ip();
	
	//echo "numero de intentos ".$num."<br>";
				
	$_SESSION["veces"]=$num;
	
	/*if($num>3 && $_SESSION["bloqueada_ip"]=="0"){
		$cont_inc=sql_ins("'','$ip','$usu','7','$menu','$fecha','$hora',''","login_bitacora");
		$ingresa=sql_u("idsta=2","ip='$ip'","login_ips");
		header("location:http://187.188.173.10/igsi/index.php?error=4");
		//echo "bloqueo de ip<br>";
	}
	
	if($_SESSION["bloqueada_ip"]=="1"){
		$cont_inc=sql_ins("'','$ip','$usu','8','$menu','$fecha','$hora',''","login_bitacora");
		header("location:http://187.188.173.10/igsi/index.php?error=4");
		//echo "ip bloqueada<br>";
	}else{*/
		$contrase_md5=md5($md5);
$exi_usuario=sql_qfr("SELECT * FROM  login_usuarios WHERE usuario like '$usu'");		
//echo "SELECT * FROM  login_usuarios WHERE usuario like '$usu'";
if(!$exi_usuario)
{
	$exi_usuario=sql_qfr("SELECT * FROM  login_alumnos WHERE usuario like '$usu'");
	$usalu=1;
}
		
if($exi_usuario[10]>1)	
{
	//echo "ENTRO";
	if($usalu!=1)
	{
		$priv_usuario=sql_qfr("SELECT * FROM  login_perm_modulo WHERE id_usuario like '".$exi_usuario[0]."' AND idsta=1");
		//echo $priv_usuario[2];
		$con_priv_usuario=sql_qfr("SELECT COUNT(*) FROM  login_perm_modulo WHERE id_usuario like '".$exi_usuario[0]."' AND idsta=1");
	}
	else			
		$priv_usuario=sql_qfr("SELECT * FROM  login_alu_perm_modulo WHERE id_usuario like '".$exi_usuario[0]."' AND idsta=1");
}else{
	//echo "ENTRO";
	$priv_usuario=sql_qfr("SELECT * FROM  login_perm_modulo WHERE id_usuario like '".$exi_usuario[0]."' AND idsta=1");
	//echo "SELECT * FROM  login_perm_modulo WHERE id_usuario like '".$exi_usuario[0]."' AND idsta=1";
	$con_priv_usuario=sql_qfr("SELECT COUNT(*) FROM  login_perm_modulo WHERE id_usuario like '".$exi_usuario[0]."' AND idsta=1");
}

$menu=$priv_usuario[2];
$campus=$priv_usuario[3];
	
if(!$priv_usuario)
{						
	$cont_inc=sql_ins("'','$ip','$usu','3','$menu','$fecha','$hora',''","login_bitacora");
	$ingresa=sql_u("id_verificador='',idsta='3'","id_usuario='".$dato_usuario[0]."'","login_usuarios");
	header("location:http://187.188.173.10/fundacion/usfundacion/index.php?error=5");					
	//echo "$modu - Sin privilegios<br>";
}else{
		
		if(!$exi_usuario){
			$cont_inc=sql_ins("'','$ip','$usu','2','$menu','$fecha','$hora',''","login_bitacora");
			header("location:http://187.188.173.10/fundacion/usfundacion/index.php?error=1");
			//echo "No existe<br>";
		}else{
			if($exi_usuario[7]==2){
				$cont_inc=sql_ins("'','$ip','$usu','6','$menu','$fecha','$hora',''","login_bitacora");
				header("location:http://187.188.173.10/fundacion/usfundacion/index.php?error=3");
				//echo "cuenta bloqueada<br>";
			}else if($exi_usuario[7]==4){
				$cont_inc=sql_ins("'','$ip','$usu','13','$menu','$fecha','$hora',''","login_bitacora");
				header("location:http://187.188.173.10/fundacion/usfundacion/index.php?error=9");
				//echo "cuenta deshabilitada<br>";
			}else{

				$dato_usuario=sql_qfr("SELECT * FROM  login_usuarios WHERE usuario like '$usu' and pass like '$contrase_md5'");

				echo "SELECT * FROM  login_usuarios WHERE usuario like '$usu' and pass like '$contrase_md5'";

				if(!$dato_usuario)
					$dato_usuario=sql_qfr("SELECT * FROM  login_alumnos WHERE usuario like '$usu' and pass like '$contrase_md5'");
				
				if($dato_usuario)
				{
					if(!$num)
						$num=$dato_usuario[8];
					else{
						$ingresa=sql_u("intentos='".$num."'","id_usuario='".$dato_usuario[0]."'","login_usuarios");
					}
					
					$act_usuario=sql_qfr("SELECT * FROM  login_usuarios WHERE usuario like '$usu' and idsta='1'");
					
					if($act_usuario){
						$cont_inc=sql_ins("'','$ip','$usu','11','$menu','$fecha','$hora',''","login_bitacora");
						header("location:http://187.188.173.10/fundacion/usfundacion/index.php?error=6");	
						//echo "sesion iniciada<br>";
					}else{
						
						if($usu==$pass)
							header("location:http://187.188.173.10/igsi/admin/pass_usuario.php");
						else
						{
							$_SESSION["activo"]=1;
							$_SESSION["veces"]=0;
							$_SESSION["us"]=$usu;
							$_SESSION["rol"]=$exi_usuario[1];
							$_SESSION["iduser"]=$exi_usuario[9];
							$_SESSION["privusr"]=$exi_usuario[10];
							$_SESSION["plan"]=$campus;
							$_SESSION["cpass"]=$pass;
							$_SESSION["lopass"]=$md5;
							$_SESSION["tipmen"]=$menu;
							//echo $con_priv_usuario[0];
							//if($con_priv_usuario[0]>1){
									if($menu==32)
										$ingresa=sql_u("id_verificador='$pin',idsta='1'","id_usuario='".$dato_usuario[0]."'","login_usuarios");
										
									header("location:http://187.188.173.10/appus/inicio.html");
							/*else{
								//echo "user = ".$usu." pass = ".$pass."<br>";
									
								$nommenu=sql_qfr("SELECT linkmodu FROM  login_modulos WHERE idmodu=$menu ORDER BY modulo");
			
								$cont_inc=sql_ins("'','$ip','$usu','9','$menu','$fecha','$hora',''","login_bitacora");
								$pin=sha1(microtime());
								
								if($menu==32){
									header("location:index2.php");
								}else{
									$ingresa=sql_u("id_verificador='$pin',idsta='1'","id_usuario='".$dato_usuario[0]."'","login_usuarios");
									$_SESSION["mo"]=$menu;
									header("location:http://igsikiosko.universidaddelsur.edu.mx/menu.php");
								}
									
								//echo "$modu - inicio de sesion ok<br>";
							}*/
						}
					}
					
				}else{		
					if($num<3){
						$ingresa=sql_u("intentos='".$num."'","id_usuario='".$exi_usuario[0]."'","login_usuarios");
					
							$cont_inc=sql_ins("'','$ip','$usu','1','$menu','$fecha','$hora',''","login_bitacora");
							header("location:http://187.188.173.10/fundacion/usfundacion/index.php?error=2&num=".$num);	
							//echo $num." cuenta activa por bloquearse<br>";
					}else{
						if($num==3){
								$cont_inc=sql_ins("'','$ip','$usu','5','$menu','$fecha','$hora',''","login_bitacora");
								$ingresa=sql_u("idsta=2","id_usuario=$exi_usuario[0]","login_usuarios");
								$ingresa=sql_u("intentos=$num","id_usuario=$exi_usuario[0]","login_usuarios");
								header("location:http://187.188.173.10/fundacion/usfundacion/index.php?error=3");		
								//echo "bloqueo de cuenta<br>";
						}
					}	
				}	
			}	
		//}
	}
}
?>