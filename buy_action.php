<?php

    require ("conexion.php");
    session_start();
    $idusuario = $_SESSION['logueado'];

    $sql = "SELECT * FROM inventarios WHERE idusuario = ".$idusuario;
    $result = mysqli_query($conexion, $sql);
    $inventario = mysqli_fetch_assoc($result);

    $idproducto = $_POST['producto'];
    $sql = "SELECT * FROM productos WHERE idproducto = ".$idproducto;

    $result = mysqli_query($conexion, $sql);
    $producto = mysqli_fetch_assoc($result);

    if(intval($producto['precio'])>intval($inventario['moneda'])){
        echo "NO TIENE SUFICIENTE MONEDAS.";
    }else{
        $compraexito = 1;
        switch(intval($producto['idcategoria'])){
            case 1:
                if(!isset($inventario['logo1'])){
                    $sql = "UPDATE inventarios SET logo1 = '".$producto['imagen']."' WHERE idusuario = ".$idusuario;
                    $result = mysqli_query($conexion, $sql);                                
                }else if(!isset($inventario['logo2'])){
                    $sql = "UPDATE inventarios SET logo2 = '".$producto['imagen']."' WHERE idusuario = ".$idusuario;
                    $result = mysqli_query($conexion, $sql);                                
                }else if(!isset($inventario['logo2'])){
                    $sql = "UPDATE inventarios SET logo3 = '".$producto['imagen']."' WHERE idusuario = ".$idusuario;
                    $result = mysqli_query($conexion, $sql);                                
                }else{
                    echo "El inventario esta lleno.";
                    $compraexito = 0;
                }
                break;
            case 2:
                if(!isset($inventario['imagen1'])){
                    $sql = "UPDATE inventarios SET imagen1 = '".$producto['imagen']."' WHERE idusuario = ".$idusuario;
                    $result = mysqli_query($conexion, $sql);                                
                }else if(!isset($inventario['imagen2'])){
                    $sql = "UPDATE inventarios SET imagen2 = '".$producto['imagen']."' WHERE idusuario = ".$idusuario;
                    $result = mysqli_query($conexion, $sql);                                
                }else if(!isset($inventario['imagen2'])){
                    $sql = "UPDATE inventarios SET imagen3 = '".$producto['imagen']."' WHERE idusuario = ".$idusuario;
                    $result = mysqli_query($conexion, $sql);                                
                }else{
                    echo "El inventario esta lleno.";
                    $compraexito = 0;
                }
                break;
            case 3:
                if(!isset($inventario['banner1'])){
                    $sql = "UPDATE inventarios SET banner1 = '".$producto['imagen']."' WHERE idusuario = ".$idusuario;
                    $result = mysqli_query($conexion, $sql);                                
                }else if(!isset($inventario['banner2'])){
                    $sql = "UPDATE inventarios SET banner2 = '".$producto['imagen']."' WHERE idusuario = ".$idusuario;
                    $result = mysqli_query($conexion, $sql);                                
                }else if(!isset($inventario['banner3'])){
                    $sql = "UPDATE inventarios SET banner3 = '".$producto['imagen']."' WHERE idusuario = ".$idusuario;
                    $result = mysqli_query($conexion, $sql);                                
                }else{
                    echo "El inventario esta lleno.";
                    $compraexito = 0;
                }
                break;
        }
        if($compraexito == 1){
            $monedas = intval($inventario['moneda']) - intval($producto['precio']);
            $sql = "UPDATE inventarios SET moneda = ".$monedas." WHERE idusuario = ".$idusuario;
            $result = mysqli_query($conexion, $sql);                                
        }

        header ("location: perfil.php");
    }
?>