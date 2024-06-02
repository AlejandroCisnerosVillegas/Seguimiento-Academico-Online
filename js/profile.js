function verify(type,input) {
  var regexes = {'email':/^([\S]+)@([\S]+)\.([\S]+)$/,'phone':/^[0-9]{10}$/,'code':/^([a-zA-Z]{3})\-([0-9]{3})$/,'roll':/^([0-9]{3})\/([a-zA-z]{2})\/([0-9]{2})$/,'name':/^[a-zA-Z \']+$/,'num':/^[0-9]+$/};
  return ((input.match(regexes[type]) == null)? false:true);
}
$(document).ready(function() {
  $('.update-profile').hide();
  $('.update-profile').click(function() {
    updateProfile($(this));
  });
  $('input[name=name],input[name=phone],input[name=email]').on('keyup',function() {
    $('.update-profile').slideDown('fast');
  });
});
function updateProfile(a) {
  var name = $('input[name=name]').val() == null?'':$('input[name=name]').val();
  var phone = $('input[name=phone]').val() == null?'':$('input[name=phone]').val();
  var email = $('input[name=email]').val() == null?'':$('input[name=email]').val();
  
  if(!verify('name',name)) {
    alert("El nombre ingresado no cumple los parámetros establecidos");
    return;
  }
  if(!verify('phone',phone)) {
    alert("El numero telefónico ingresado no cumple los parámetros establecidos");
    return;
  }
  if(!verify('email',email)) {
    alert("El correo electrónico ingresado no cumple los parámetros establecidos");
    return;
  }
  $.ajax({
    url : 'php/update_profile.php',
    type : 'post',
    data : {name:name,phone:phone,email:email},
    dataType : 'json',
    success : function(r) {
      switch(r.error) {
        case 'phone' : alert("¡El numero telefónico ingresado no cumple los parámetros establecidos!"); break;
        case 'email' : alert("¡El correo electrónico ingresado no cumple los parámetros establecidos!"); break;
        case 'name' : alert("¡El nombre ingresado no cumple los parámetros establecidos!"); break;
        case 'exists' : alert("El correo electrónico que ingresaste ya esta registrado."); break;
        case 'none' : a.html('¡Información actualizada con éxito!'); setTimeout(function() { window.location = ""; },500); break;
        case 'not_found' : case 'failure' : 
        alert("¡Se ha presentado falla técnica!, Por seguridad cierre su sesión.");
        window.location = "logout.php";
      }
    }  
  });
}