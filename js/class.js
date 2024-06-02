function verify(type,input) {
  var regexes = {'email':/^([\S]+)@([\S]+)\.([\S]+)$/,'phone':/^[0-9]{10}$/,'code':/^([a-zA-Z]{3})\-([0-9]{3})$/,'roll':/^([0-9]{3})\/([a-zA-z]{2})\/([0-9]{2})$/,'name':/^[a-zA-Z \']+$/,'num':/^[0-9]+$/};
  return ((input.match(regexes[type]) == null)? false:true);
}
$(document).ready(function() {
  updateClass();
  $('input[name=code],input[name=year],input[name=semester],input[name=section]').on('keyup',function() {
    $(this).parent().find('.update').html('Update');
  });
  
});
function updateClass() {
  $('.update').click(function() {
    var btn = $(this);
    var details = btn.parent();
    var d = {code:'',year:'',section:'',semester:'',class_id:''};
    d.code = details.find("input[name=code]").val();
    d.class_id = details.attr('id').replace(/_/g,'');
    d.year = details.find("input[name=year]").val();
    d.semester = details.find("input[name=semester]").val();
    d.section = details.find("input[name=section]").val();
    console.log(d);
    
    if(!verify('code',d.code)) {
      alert('¡La clave ingresada no cumple los parámetros establecidos!');
      return;
    }
    if((!verify('number',d.year)) || d.year > (new Date()).getFullYear() || d.year < 1983 ) {
      alert('¡El año ingresado no cumple los parámetros establecidos!');
      return;
    }
    if((!verify('number',d.section)) || d.section < 1 || d.section > 3) {
      alert('¡El modulo ingresado no cumple los parámetros establecidos!');
      return;
    }
    if((!verify('number',d.semester)) || d.semester < 1 || d.semester > 9) {
      alert('¡El semestre ingresado no cumple los parámetros establecidos!');
      return;
    }
    
    
    $.ajax({
      url : 'php/update_class.php',
      data : d,
      type : 'post',
      dataType : 'json',
      success : function(r) {
        console.log(r);
        switch(r.error) {
          case 'none' : 
            btn.html('<strong>¡Información actualizada con éxito!</strong>');
          break;
          case 'failure' : 
            alert("¡Se ha presentado falla técnica!, Por seguridad cierre su sesión.");
            window.location = "logout.php";
          break;     
          case 'not_found' : 
            alert("¡Se ha presentado falla técnica!, Por seguridad cierre su sesión.");
            window.location = "logout.php";
          break;
          case 'year' : 
            alert("¡El año ingresado no cumple los parámetros establecidos!");
          break;
          case 'semester' : 
            alert("¡El semestre ingresado no cumple los parámetros establecidos!");
          break;
          case 'section' : 
            alert("¡El modulo ingresado no cumple los parámetros establecidos!");
          break;
          case 'code' : 
            alert("¡La clave ingresada no cumple los parámetros establecidos!");
          break;      
        }
      }
    });
  });
}