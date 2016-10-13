var app = angular.module('Votacion', ['ui.router','satellizer']);

app.config(function($stateProvider, $urlRouterProvider,$authProvider) {

$authProvider.loginUrl = 'votacion/PHP/auth.php';
$authProvider.tokenName='MiTokenGeneradoEnPHP';
$authProvider.tokenPrefix='AngularABM';
$authProvider.authHeader='data';

$stateProvider

      .state('inicio', {
                url : '/inicio',
                templateUrl : 'inicio.html'
                //controller : 'controlInicio'
            })

      .state('usuario', {
                url : '/usuario',
                abstract:true,//permite que con diferentes rutas se le pueda agregar contenidos de otros state 
                templateUrl : 'abstractoUsuario.html'
            })
      .state('usuario.registro', {
                url: '/registrarse',
                views: {
                    'contenido': {
                        templateUrl: 'registroUsuario.html',
                        controller : 'controlRegistroUser'
                    }
                }
            })
      .state('usuario.login', {
                url: '/login',
                views: {
                    'contenido': {
                        templateUrl: 'loginUsuario.html',
                        controller : 'controlLogin'
                    }
                }
            })
      .state('usuario.grilla', {
                url: '/grillauser',
                views: {
                    'contenido': {
                        templateUrl: 'grillaUsuario.html',
                        controller : 'controlUserGrilla'
                    }
                }
            })
      .state('persona', {
                url : '/persona',
                abstract:true,
                templateUrl : 'abstractaPersona.html'
            })
      .state('persona.grilla', {
                url: '/grillapersona',
                views: {
                    'contenido': {
                        templateUrl: 'grillaPersona.html',
                        controller : 'controlPersonaGrilla'
                    }
                }
            })
      .state('persona.voto', {
                url: '/voto',
                views: {
                    'contenido': {
                        templateUrl: 'votoPersona.html',
                        controller : 'controlVoto'
                    }
                }
            })
      .state('persona.modificacion', {
                url: "/modificarpersona/{id}?:dni:sexo:fechavotacion:partidopolitico:foto",
                views: {
                    'contenido': {
                        templateUrl: 'votoPersona.html',
                        controller : 'controlPersonaModificacion'
                    }
                }
            })

      $urlRouterProvider.otherwise('/inicio');
 });

app.controller('controlLogin', function($scope, $scope, $state, $http, $auth) {

    $scope.usuario={};
   

    $scope.Login= function(){
       $auth.login($scope.usuario)
          .then(function(response) {
            console.info('correcto', response);
            
            if ($auth.isAuthenticated()) {                   
                  alert("loggeado exitosamente");
                  $state.go("inicio"); 
            }     
            else {
                 alert("no se pudo loggear");
            }

            console.info($auth.getPayload());
            console.info('El token es: ',$auth.getToken()); 

          })

          .catch(function(response) {
            console.info('no volvio bien', response); 
            console.info($auth.getPayload());
            console.info('El token es: ',$auth.getToken());  
          })
        }

});

app.controller('controlRegistroUser', function($scope, $http, $state) {

  $scope.usuario={};
	/*$scope.usuario.nombreuser = "juan";
	$scope.usuario.dni = 12345;
	$scope.usuario.password = "contrasena";
	$scope.usuario.copiapassword = "contrasena";*/
  $scope.usuario.tipo = "usuario";


	$scope.Registrar=function(){
    $http.post('PHP/nexo.php', { datos: {accion :"insertarUsuario",usuario:$scope.usuario}})
    .then(function(respuesta) {       
       //aca se ejetuca si retorno sin errores        
     console.log(respuesta.data);
     $state.go("usuario.login");

  },function errorCallback(response) {        
      //aca se ejecuta cuando hay errores
      console.log( response);           
    })
  }

});

app.controller('controlUserGrilla', function($scope, $http, $state) {

  $http.get('PHP/nexo.php', { params: {accion :"traerusuarios"}})
  .then(function(respuesta) {       

         $scope.ListadoUsuario = respuesta.data.listado;
         console.info(respuesta);
         console.log(respuesta.data);

    },function errorCallback(response) {
        
        console.log( response);
    })

  $scope.Borrar=function(usuario){
  $http.post("PHP/nexo.php",{datos:{accion :"borrarUsuario",usuario:usuario}})
  .then(function(respuesta) {       
       //aca se ejetuca si retorno sin errores        
     console.log(respuesta.data);
     $state.reload();

  },function errorCallback(response) {        
      //aca se ejecuta cuando hay errores
      console.log(response);           
    })

  }

});

app.controller('controlPersonaGrilla', function($scope, $http, $state) {

  $http.get('PHP/nexo.php', { params: {accion :"traer"}})
  .then(function(respuesta) {       

         $scope.ListadoPersonas = respuesta.data.listado;
         console.info(respuesta);
         console.log(respuesta.data);

    },function errorCallback(response) {
         $scope.ListadoPersonas= [];
        console.log( response);
    })

  $scope.Borrar=function(persona){
  $http.post("PHP/nexo.php",{datos:{accion :"borrar",persona:persona}})
  .then(function(respuesta) {       
       //aca se ejetuca si retorno sin errores        
     console.log(respuesta.data);
     $state.reload();

  },function errorCallback(response) {        
      //aca se ejecuta cuando hay errores
      console.log(response);           
    })

  }

});

app.controller('controlVoto', function($scope, $http, $state) {

    $scope.persona={};

    //$scope.persona.dni= 12312312;
    //$scope.persona.sexo= "masculino" ;
    $scope.persona.fechavotacion= new Date();
    //$scope.persona.partidopolitico= "un partido";
    $scope.persona.foto="pordefecto.png";

    $scope.Registrar=function(){
    $http.post('PHP/nexo.php', { datos: {accion :"insertar",persona:$scope.persona}})
    .then(function(respuesta) {       
       //aca se ejetuca si retorno sin errores        
     console.log(respuesta.data);
     alert("Se registro tu voto !");
     $state.go("inicio");

  },function errorCallback(response) {        
      //aca se ejecuta cuando hay errores
      console.log( response);           
    })
  }

});

app.controller('controlPersonaModificacion', function($scope, $http, $state, $stateParams) {

    $scope.persona={};

    $scope.persona.id=$stateParams.id;
    $scope.persona.dni= parseInt($stateParams.dni);
    $scope.persona.sexo= $stateParams.sexo;
    $scope.persona.fechavotacion= $stateParams.fechavotacion;
    $scope.persona.partidopolitico= $stateParams.partidopolitico;
    $scope.persona.foto=$stateParams.foto;

    $scope.Registrar=function(){
    $http.post('PHP/nexo.php', { datos: {accion :"modificar",persona:$scope.persona}})
    .then(function(respuesta) {       
       //aca se ejetuca si retorno sin errores        
     console.log(respuesta.data);
     $state.go("persona.grilla");

  },function errorCallback(response) {        
      //aca se ejecuta cuando hay errores
      console.log( response);           
    })
  }

});
