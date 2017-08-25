
<section class="container padding5">
  <a class="btn btn-default" href="index.php?mod=nn"><i class="fa fa-plus-circle" aria-hidden="true"></i> Añadir Novedad</a>
  <p>&nbsp;</p>
  <div id="resultado">

  </div>
</section>

<script>
$(document).ready( () => {
  listar()
})

function listar() {
  let result = $('#resultado')

  jQuery.ajax({
    url: 'listar-novedades.php',
    cache: false,
    type: 'POST',
    dataType: 'json',
    success: function(data){
      let texto = `<table class="table table-bordered table-striped table-responsive table-condensed">
      <tr><th>Título</th><th></th></tr>
      `
      data.forEach(fila => {
        texto+=`<tr><td>${fila.titulo}</td><td><a class="elimina" id="${fila.id_novedad}" href="#">Eliminar</a></td></tr>`
      })
      texto+='</table>'
      result.html(texto)

      //console.log(data)
    }
  })

}

$('#resultado').on('click', '.elimina', (evt) => {
  let id = evt.currentTarget.id
  let data = `id=${id}`
  jQuery.ajax({
    url: 'eliminar-novedad.php',
    cache: false,
    type: 'POST',
    data: data,
    success: function(data){
      listar()
    }
  })
})


</script>
