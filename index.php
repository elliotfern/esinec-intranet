<?php
$url_server = "https://gestion.esinec.com/";

session_start();
if(!isset($_SESSION['user'])){
    header('Location: '.$url_server. 'login.php');
    exit;
} else {  
    class Route {

        private function simpleRoute($file, $route){
    
            
            //replacing first and last forward slashes
            //$_REQUEST['uri'] will be empty if req uri is /
    
            if(!empty($_REQUEST['uri'])){
                $route = preg_replace("/(^\/)|(\/$)/","",$route);
                $reqUri =  preg_replace("/(^\/)|(\/$)/","",$_REQUEST['uri']);
            }else{
                $reqUri = "/";
            }
    
            if($reqUri == $route){
                $params = [];
                include($file);
                exit();
    
            }
    
        }
    
        function add($route,$file){
    
            //will store all the parameters value in this array
            $params = [];
    
            //will store all the parameters names in this array
            $paramKey = [];
    
            //finding if there is any {?} parameter in $route
            preg_match_all("/(?<={).+?(?=})/", $route, $paramMatches);
    
            //if the route does not contain any param call simpleRoute();
            if(empty($paramMatches[0])){
                $this->simpleRoute($file,$route);
                return;
            }
    
            //setting parameters names
            foreach($paramMatches[0] as $key){
                $paramKey[] = $key;
            }
    
           
            //replacing first and last forward slashes
            //$_REQUEST['uri'] will be empty if req uri is /
    
            if(!empty($_REQUEST['uri'])){
                $route = preg_replace("/(^\/)|(\/$)/","",$route);
                $reqUri =  preg_replace("/(^\/)|(\/$)/","",$_REQUEST['uri']);
            }else{
                $reqUri = "/";
            }
    
            //exploding route address
            $uri = explode("/", $route);
    
            //will store index number where {?} parameter is required in the $route 
            $indexNum = []; 
    
            //storing index number, where {?} parameter is required with the help of regex
            foreach($uri as $index => $param){
                if(preg_match("/{.*}/", $param)){
                    $indexNum[] = $index;
                }
            }
    
            //exploding request uri string to array to get
            //the exact index number value of parameter from $_REQUEST['uri']
            $reqUri = explode("/", $reqUri);
    
            //running for each loop to set the exact index number with reg expression
            //this will help in matching route
            foreach($indexNum as $key => $index){
    
                 //in case if req uri with param index is empty then return
                //because url is not valid for this route
                if(empty($reqUri[$index])){
                    return;
                }
    
                //setting params with params names
                $params[$paramKey[$key]] = $reqUri[$index];
    
                //this is to create a regex for comparing route address
                $reqUri[$index] = "{.*}";
            }
    
            //converting array to sting
            $reqUri = implode("/",$reqUri);
    
            //replace all / with \/ for reg expression
            //regex to match route is ready !
            $reqUri = str_replace("/", '\\/', $reqUri);
    
            //now matching route with regex
            if(preg_match("/$reqUri/", $route))
            {
                include($file);
                exit();
    
            }
        }
    
        function notFound($file){
            include($file);
            exit();
        }
    }
    
    // constants
    require_once('./inc/variables.php');
    $url = 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    
    $route = new Route();
            
    if (strpos($url,'update') OR (strpos($url,'delete')) OR (strpos($url,'new')) OR (strpos($url,'info')) !== false ) {

        $rootDirectory = $_SERVER['DOCUMENT_ROOT'];
        $substring = "/public_html/gestion";
        $result = str_replace($substring, "", $rootDirectory);
        $path = $result . "/pass/connection.php";
        require_once($path);

        //links
        $route->add("/links/update","php-forms/links/links-update-link.php");
        $route->add("/links/process/update","php-process/links/update-link.php");

        $route->add("/links/new","php-forms/links/links-add-new.php");
        $route->add("/links/process/new","php-process/links/add-new-link.php");


    } else {
        require_once('./inc/header.php');
        // homepage
        $route->add("/","admin.php");
        $route->add("/admin","admin.php");

        $route->add("/login","login.php");
        $route->add("/logout","logout.php");

        // clientes
        $route->add("/clientes/alta","public/clientes/cliente-alta-woocommerce.php");
        $route->add("/clientes/{id}","public/clientes/cliente-info.php");
        $route->add("/clientes/{id}/facturacion","public/clientes/cliente-facturacion.php");
        $route->add("/clientes","public/clientes/index.php");
        $route->add("/clientes/todos","public/clientes/todos.php");

        // facturacion
        $route->add("/facturacion/todos","public/facturacion/todos.php");
        $route->add("/facturacion/meses","public/facturacion/todos-mensuales.php");
        $route->add("/facturacion/pagos-programados","public/facturacion/pagos-programados.php");
        $route->add("/facturacion/pagos-programados/mensuales","public/facturacion/pagos-programados-mensuales.php");
        $route->add("/facturacion/{id}","public/facturacion/factura-detalle.php");
        $route->add("/facturacion/intranet/{id}","public/facturacion/factura-detalle-intranet.php");

        $route->add("/facturacion","public/facturacion/index.php");

        // cursos
        $route->add("/cursos","public/cursos/index.php");
        $route->add("/cursos/{id}","public/cursos/inscritos-curso.php");

        // comerciales
        $route->add("/comerciales/listado","public/comerciales/listado-comerciales.php");
        $route->add("/comerciales/pagos/mensuales","public/comerciales/pagos-mensuales-comerciales.php");
        $route->add("/comerciales/pagos/mensuales/{year}/{month}","public/comerciales/pagos-mensuales-comerciales-mes.php");
        $route->add("/comerciales/reclutadores","public/comerciales/listado-reclutadores.php");
        $route->add("/comerciales/{id}","public/comerciales/comercial-info.php");

        // Ayuda
        $route->add("/ayuda","public/ayuda/index.php");
        $route->add("/ayuda/factura","public/ayuda/crear-factura.php");
    
        $route->notFound("404.php");

    }
}

?>
