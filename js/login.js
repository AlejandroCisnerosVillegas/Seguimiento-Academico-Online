function verify(type,input) {
  var regexes = {'email':/^([\S]+)@([\S]+)\.([\S]+)$/,'phone':/^[0-9]{10}$/,'code':/^([a-zA-Z]{3})\-([0-9]{3})$/,'roll':/^([0-9]{3})\/([a-zA-z]{2})\/([0-9]{2})$/,'name':/^[a-zA-Z \']+$/,'num':/^[0-9]+$/};
  return ((input.match(regexes[type]) == null)? false:true);
}
$(document).ready(function () {
  processLogin();
  processSignup();
});
function processLogin() {
  $("#login").submit(function() {
    var data = {};
    $("#login input").each(function(k,v) {
      if(!$(v).val().length) {
        $('.alert span').html('!Ingresa tu <strong>' + $(v).attr('name') + '</strong>!');
        $('.alert').removeClass('hidden');
        return false;
      }
      data[$(v).attr('name')] = $(v).val();
    });
    $.ajax({
      url : 'php/process_login.php',
      type : 'post',
      data : data,
      dataType : 'json',
      success : function(r) {
        console.log(r);
        switch(r.error) {
          case 'empty' : 
            $('.alert span').html('Ingresa los datos en el formulario');
            $('.alert').removeClass('hidden');
            break;
          case 'not_found' :
            $('.alert span').html('¡No se encontró registro del usuario!');
            $('.alert').removeClass('hidden');
            $("form#signup input[name=email]").val($("form#login input[name=email]").val());
            $("form#signup input[name=email]").focus();
            break;
          case 'incorrect' :
            $('.alert span').html('¡Contraseña incorrecta!');
            $('.alert').removeClass('hidden');
            $('.alert').removeClass('alert-warning');
            $('.alert').addClass('alert-danger');
            break;
          case 'none' :
            $('.alert span').html('<img src="img/loading.gif"> <Strong>Ingresando al sistema</strong>.');
            $('.alert').removeClass('hidden');
            $('.alert').removeClass('alert-warning');
            $('.alert').removeClass('alert-danger');
            $('.alert').addClass('alert-success');
            window.location="";
            break;
        }
      }    
    });
    return false;
  });
}
function processSignup() {
  $("#signup").submit(function() {
    var data = {};
    var isEmpty = 0;
    $("#signup input").each(function(k,v) {
      if(!$(v).val().length) {
        $('.alert span').html('!Ingresa tu <strong>' + $(v).attr('name') + '</strong>!');
        $('.alert').removeClass('hidden');
        isEmpty++;
        return false;
      }
      data[$(v).attr('name')] = $(v).val();
    });
    if(isEmpty) return false;
    if($("#signup input[name=password]").val() != $("#signup input[name=password2]").val()) {
      $('.alert span').html('¡La contraseña ingresada no coincide!');
      $('.alert').removeClass('hidden');
      return false;
    }
    if($("#signup input[name=password]").val().length < 6) {
      $('.alert span').html('¡La contraseña ingresada no cumple los parámetros establecidos!');
      $('.alert').removeClass('hidden');
      return false;
    }
    if(!verify('phone',data.phone)) {
      $('.alert span').html('¡El numero telefónico ingresado no cumple los parámetros establecidos!');  
      $('.alert').removeClass('hidden');
      return false;
    }
    if(!verify('email',data.email)) {
      $('.alert span').html('¡El correo electrónico ingresado no cumple los parámetros establecidos!');  
      $('.alert').removeClass('hidden');
      return false;
    }
    if(!verify('name',data.name)) {
      $('.alert span').html('¡El nombre ingresado no cumple los parámetros establecidos!');  
      $('.alert').removeClass('hidden');
      return false;
    }
    $.ajax({
      url : 'php/process_signup.php',
      type : 'post',
      data : data,
      dataType : 'json',
      success : function(r) {
        console.log(r);
        switch(r.error) {
          case 'email' :
            $('.alert span').html('¡El correo electrónico ingresado no cumple los parámetros establecidos!');  
            $('.alert').removeClass('hidden');
          break;
          case 'phone' :
            $('.alert span').html('¡El numero telefónico ingresado no cumple los parámetros establecidos!');  
            $('.alert').removeClass('hidden');
          break;
          case 'name' :
            $('.alert span').html('¡El nombre ingresado no cumple los parámetros establecidos!');  
            $('.alert').removeClass('hidden');
          break;
          case 'empty' : 
            $('.alert span').html('Ingresa todos los datos en el formulario');  
            $('.alert').removeClass('hidden');
          break;
          case 'mismatch' : 
            $('.alert span').html('¡La contraseña ingresada no coincide!');  
            $('.alert').removeClass('hidden');
          break;
          case 'small' : 
            $('.alert span').html('¡La contraseña ingresada no cumple los parámetros establecidos!');  
            $('.alert').removeClass('hidden');
          break;
          case 'exists' : 
            $('.alert span').html('Ya existe una cuenta con el correo electrónico ingresado. Intente iniciar sesión.');            
            $('.alert').removeClass('hidden');
            $("form#login input[name=email]").val($("form#signup input[name=email]").val());
            $("form#login input[name=email]").focus();
          break;
          case 'db_error' : 
            $('.alert span').html('¡Se ha presentado falla técnica!, lo resolveremos lo mas breve posible.');  
            $('.alert').removeClass('hidden');
          break;
          case 'none' : 
            $('.alert span').html('¡Tu registro se ha completado con éxito! Ahora ya puedes iniciar sesión.');  
            $("form#login input[name=email]").val($("form#signup input[name=email]").val());
            $("form#login input[name=email]").focus();
            $('.alert').removeClass('hidden');
            $('.alert').removeClass('alert-warning');
            $('.alert').addClass('alert-success');
          break;
        }
      }    
    });
    return false;
  });
}