jQuery(document).ready(function(jQuery) {

    var status_form_evento = 0;

    jQuery.validator.addMethod("rut", function(value, element) {
      return this.optional(element) || jQuery.Rut.validar(value);
    });

    jQuery('#rut').Rut({
      //on_error: function(){ alert('Rut incorrecto'); },
      format_on: 'keyup'
    });    

    jQuery.validator.addMethod("lettersonly", function(value, element){
      return this.optional(element) || /^[a-zñáéíóú A-Z]+$/i.test(value);
    });    

    jQuery("#form-eventos").validate({
        ignore :[],
        rules : {
          'nombre'      : { required:true },
          'rut'         : { required:true, rut:true },
          'email'       : { required:true, email:true },
          'telefono'    : { required:true },
          'becado'      : { required:true },
          'procedencia' : { required:true }
        },     
        errorPlacement: function(error,element) {
          element.addClass('error');
        },
        unhighlight: function(element) {
          jQuery(element).removeClass("error");
        },
        submitHandler:function() {

            //jQuery("input").prop('disabled', true);
            jQuery(".btn-enviar").css("opacity",".2");
            jQuery(".btn-enviar").css("cursor","default");

            if( status_form_evento==0 ) {

                status_form_evento = 1;            
                
                jQuery.post(ajax.url,jQuery("#form-eventos").serialize(),function(data) {
                    if( data==1 ) {
                    	//alert("inscrito con éxito");
                        jQuery(".caja-asistir").hide();
                        jQuery("#gracias-inscrito").fadeIn();
                        jQuery("#form-eventos")[0].reset();
                        jQuery(".btn-enviar").css("opacity","1");
                        jQuery(".btn-enviar").css("cursor","pointer");                
                        //jQuery("input").prop('disabled', false);
                    }else if( data==2 ) {
                        alert("ya está inscrito en el evento");
                        //jQuery("#form-eventos").hide();
                        //jQuery("#gracias-inscrito").hide();
                        //jQuery("#gracias-ya-inscrito").fadeIn();                    
                    }
                });                

            }
            
        }

    });

    jQuery(".btn-enviar").click(function() {
    	jQuery("#form-eventos").submit();
    });

    jQuery("#form-encuesta").validate({
        ignore :[],
        rules : {
          'respuesta_1' : { required:true },
          'respuesta_2' : { required:true },
          'respuesta_3' : { required:true },
          'respuesta_4' : { required:true }
        },     
        errorPlacement: function(error,element) {
          element.addClass('error');
        },
        unhighlight: function(element) {
          jQuery(element).removeClass("error");
        },
        submitHandler:function() {

            jQuery.post(ajax.url,jQuery("#form-encuesta").serialize(),function(data) {
                if( data==0 ) {
                    //alert("error al guardar la encuesta");
                    //jQuery("#gracias-encuesta").show();
                }else if( data==1 ) {
                    //alert("Encuesta guardada con exito");
                    jQuery("#gracias-encuesta").show();
                    jQuery("#encuesta-content").hide();
                }              
            }); 

        }
    });

    jQuery("#send-button").click(function() {
        jQuery("#form-encuesta").submit();
        return false;
    });

    jQuery('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        fade: true,
        asNavFor: '.slider-nav'
    });
    jQuery('.slider-nav').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        dots: false,
        centerMode: false,
        focusOnSelect: true
    });    

});  	

