
<section class="container padding5">

  <div class="row paddingtop">

    <h1 class="border-bottom" >GALERÍA</h1>

    <div class="imagenes-sucursales paddingtop margin">
      <a class="btn btn-default" href="index.php?mod=ng"><i class="fa fa-plus-circle" aria-hidden="true"></i> Añadir Foto</a>
      <p>&nbsp;</p>
      <div id="resultado"></div>
    </div>
  </div>
</section>

<script>
$(document).ready( () => {
  listar()
})

function listar() {
  let result = $('#resultado')

  jQuery.ajax({
    url: 'listar-galeria.php',
    cache: false,
    type: 'POST',
    dataType: 'json',
    success: function(data){
      let texto = ''


      data.forEach(fila => {
        texto+=`<div class="envoltorio" style="display:inline; position: relative;"><img class="foto"
        src="../upload/galeria/${fila.ruta}" width="200" height="auto"
        style="padding: 5px;" /><a href="#" style=""><i class="fa fa-trash"
        id="${fila.id_galeria}" style="box-shadow: 5px 5px 5px #888888; position: absolute; z-index: 101;
        left: 10px; font-size: 2em; top:-50px; color:#FFF;"></i></a></div>`
      })

      result.html(texto)

      //console.log(data)
    }
  })

}

$('#resultado').on('click', '.elimina', (evt) => {
  evt.preventDefault()
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

$('#resultado').on('click', '.fa-trash', (evt) => {
  evt.preventDefault()
  let id = evt.currentTarget.id
  let data = `id=${id}`
  jQuery.ajax({
    url: 'eliminar-foto.php',
    cache: false,
    type: 'POST',
    data: data,
    success: function(data){
      listar()
    }
  })
})


</script>
