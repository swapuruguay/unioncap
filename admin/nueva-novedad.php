
<section class="container padding5">
  <div class="row">
    <div class="col-sm-12 col-md-7 col-md-offset-1">
      <h1>Ingresar novedad</h1>
    </div>
    <div class="col-sm-12">
      <p>&nbsp;</p>

    </div>
  </div>
  <div class="row">
    <form class="form-horizontal" id="formulario">
      <div class="form-group">
        <label for="titulo" class="col-sm-12 col-md-offset-1">Título</label>
        <div class="col-sm-12 col-md-7 col-md-offset-1">
          <input type="text" id="titulo" name="titulo" class="form-control">
        </div>
      </div>
      <p></p>
      <div class="form-group">
        <label for="titulo" class="col-sm-12 col-md-offset-1">Cuerpo</label>
        <div class="col-md-7 col-md-offset-1">
          <textarea name="cuerpo" id="cuerpo" class="form-control" rows="10"></textarea>

        </div>

      </div>
      <div class="form-group">
        <label for="foto" class="col-sm-12 col-md-offset-1">Cargar Imagen</label>
        <div class="col-sm-12 col-md-7 col-md-offset-1">
          <input type="file" id="foto" name="foto" class="form-control">
        </div>
      </div>
        <div class="col-md-2 col-md-offset-1">
          <input type="submit" id="btn" class="btn btn-primary" value="Guardar">

        </div>
        <div id="resultado">

        </div>
    </form>
  </div>
</section>


<script>
$(document).ready( function() {
  $("#cuerpo").cleditor()
 })
  let form = document.getElementById('formulario')
  form.addEventListener('submit', evt => {
    evt.preventDefault()
    let data = new FormData();
    jQuery.each($('input[type=file]')[0].files, function(i, file) {
      data.append('file-'+i, file);
    })
    let other_data = $('form').serializeArray()
    $.each(other_data,function(key,input){
      data.append(input.name,input.value);
    })
    jQuery.ajax({
        url: 'carga.php',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data){
          $('#resultado').html(data)
          form.reset()
            //console.log(data)
        }
    })
  })
</script>
