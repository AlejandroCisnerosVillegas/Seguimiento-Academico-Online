function verify(type,input) {
  var regexes = {'email':/^([\S]+)@([\S]+)\.([\S]+)$/,'phone':/^[0-9]{10}$/,'code':/^([a-zA-Z]{3})\-([0-9]{3})$/,'roll':/^([0-9]{3})\/([a-zA-z]{2})\/([0-9]{2})$/,'name':/^[a-zA-Z \']+$/,'num':/^[0-9]+$/};
  return ((input.match(regexes[type]) == null)? false:true);
}
$(document).ready(function() {
  $('#cancel').click(function() {
    $('.modal').modal('hide');
  });
 $('#add').click(function() {
    addTheClass();
  });
  $('.delete-class-warning').click(function() {
    deleteWarning($(this).parent());
  });
  $('.delete-class-code').click(function() {
    deleteClass($(this).parent());
  });
});
function deleteWarning(handle) {
  code = handle.find('.code').text();
  section = handle.find('.section').text();
  year = handle.find('.year').text();
  $('.warning-class').html('<span class="warning-code">'+code+'</span> ( <span class="warning-section">'+section+'</span> ) '+' , <span class="warning-year">'+year+'</span>');
}
function deleteClass(handle) {
  code = handle.find('.warning-code').text();
  section = handle.find('.warning-section').text();
  year = handle.find('.warning-year').text();
  $.ajax({
    url : 'php/delete_class.php',
    type : 'post',
    data : {code:code,year:year,section:section},
    dataType : 'json',
    success : function(r) {
      switch(r.error) {
        case 'not_found' :
          alert('¡No se encontró registro de esta asignatura!, Por seguridad cierre su sesión.');
          window.location = "logout.php";
        break;
        case 'illegal' :
          alert('¡No has tomado esta asignatura aun!, Por seguridad cierre su sesión.');
          window.location = "logout.php";
        break;
        case 'failure' :
          alert('¡Se ha presentado falla técnica!, Por seguridad cierre su sesión.');
          window.location = "logout.php";
        break;
        case 'none' :
          $('.delete-warning').modal('hide');
            $('.class').each(function(k,v) {
              if($(this).find('.code').text() == code && 
                 $(this).find('.year').text() == year && 
                 $(this).find('.section').text() == section) {
                  $(this).hide('slow',function() {
                    $(this).remove();
                  });
              return;
              }
          });
        break;
        
      }
    }
  });
}
function addTheClass() {
  var fields = $('#add_class_form input,#add_class_form select');
  var data = {};
  for(i = 0;i < fields.length;i++) {
   data[jQuery(fields[i]).attr('name')] = jQuery(fields[i]).val();
  }
  console.log(data);
  
  if(!verify('code',data.code)) {
        alert('¡La clave ingresada no cumple los parámetros establecidos!');
        $('input[name=code]').val('');
        return;
      }
  if(!verify('number',data.year)) {
    alert('¡El año ingresado no cumple los parámetros establecidos!');
    $('input[name=year]').val('');
    return;
  }
  if(!verify('number',data.section)) {
    alert('¡El modulo ingresado no cumple los parámetros establecidos!');
    $('input[name=section]').val('');
    return;
  }
  if(!verify('number',data.semester)) {
    alert('¡El semestre ingresado no cumple los parámetros establecidos!');
    $('input[name=semester]').val('');
    return;
  }
  if(!verify('roll',data.start)) {
    alert('¡La matricula académica inicial ingresada no cumple los parámetros establecidos!');
    $('input[name=end],input[name=start]').val('');
    return;
  }
  if(!verify('roll',data.end)) {
    alert('¡La matricula académica final ingresada no cumple los parámetros establecidos!');
    $('input[name=end],input[name=start]').val('');
    return;
  }

  $.ajax({ 
    url : 'php/add_class.php',
    type : 'post',
    data : data,
    dataType : 'json',
    success : function (r) {
      if(r.error == 'code') {
        alert('¡La clave ingresada no cumple los parámetros establecidos!');
        $('input[name=code]').val('');
        return;
      }
      if(r.error == 'year') {
        alert('¡El año ingresado no cumple los parámetros establecidos!');
        $('input[name=year]').val('');
        return;
      }
      if(r.error == 'section') {
        alert('¡El modulo ingresado no cumple los parámetros establecidos!');
        $('input[name=section]').val('');
        return;
      }
      if(r.error == 'semester') {
        alert('¡El semestre ingresado no cumple los parámetros establecidos!');
        $('input[name=semester]').val('');
        return;
      }
      if(r.error == 'roll') {
        alert('¡La matricula académica ingresada no cumple los parámetros establecidos!');
        $('input[name=end],input[name=start]').val('');
        return;
      }
      if(r.error == 'exists') {
        alert('¡Esta asignatura ya ha sido registrada!');
        $('input[name=code]').val('');
        return;
      }
      $('.wrapper').prepend('<div class="class"> <a class="no-decoration" href="take.php?cN='+r.class_id+'"> <div><strong>Código</strong>: <span class="code">'+r.code+'</span></div> <div><strong>Bloque</strong>: <span class="section">'+r.section+'</span></div> <div><strong>Año</strong>: <span class="year">'+r.year+'</span> </div> <div><strong>Clases</strong>: 0</div> </div></a>');
      $('.wrapper .class').first().hide();
      $('.wrapper .class').first().show('slow');
      $('.modal').modal('hide');
      $('.no-classes').remove();
    }, 
    error : function (err) {
      console.log(err);
    }   
  });
}