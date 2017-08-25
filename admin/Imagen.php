<?php
/**
 * Responsable de Modificar imagenes en el servidor.
 * @author	Marcelo Castro
 * @author 	objetivophp
 * @version 4.0.0 15/03/2009.-
 * @since 	Incopora ver propiedades
 * 			Chequeo de seguriadad en imagen.
 * 			Soporte para png, gif y jpg.
 * 			Soporte de Trasparencias para formatos gif y png.
 * 			Soporte para PHP 5 exclusivamente.-
 * @version 4.0.1 05/05/2009.- Correccion de error en servidores que no ponen .tmp a los archivos temporales.
 */
class Imagen
{	/**
 	* Ubicacion de la imagen de origen. (Se puede utilizar con $_FILES[])
 	* @var		String
 	* @access 	private
 	*/
	private $imagenOrigen;

	/**
	 * Ubicacion para la imagen una vez editada, es decir donde quedara la nueva imagen.
	 * @var 	String
	 * @access 	Private
	 */
	private $imagenDestino;

	/**
	 * Ancho en pixeles para la imagen destino.
	 * @var		Integer
	 * @access 	Private
	 */
	private $anchoDestino;

	/**
	 * Alto en pixeles para la imagen destino.
	 * @var 	Integer
	 * @access	Private
	 */
	private $altoDestino;

	/**
	 * Calcula el ancho en pixeles de la imagen de Origen.
	 * @var 	Integer
	 * @access 	Private
	 */
	private $anchoOrigen;

	/**
	 * Calcula el alto en pixeles de la imagen de Origen.
	 * @var		Integer
	 * @access 	Private
	 */
	private $altoOrigen;

	/**
	 * Especifica como respetara o no la proporcionalidad de la imagen. (Forma de Edicion).-
	 * @var 	Integer
	 * @access 	Private
	 * @since	Modos disponibles
	 * 	#0 para que respete la proporcionalidad de la imagen y tome como base el ancho
	 * 	#1 para que respete la proporcionalidad de la imagen y tome como base el alto
	 *  #2 para que respete el ancho y el alto recortando el resto de la imagen
	 *  #3 para respetar el ancho y alto indicando pero deformando la imagen
	 *  #El valor por defecto sera 0.
	 */
	private $modo				= 0;

	/**
	 * Se activa con el modo 2.
	 * La opcion cuadricula establece de cuanto sera la cuadricula para realizar el recorte y la propiedad
	 * centrado en que cuadrante se centrara para realizar el recorte.
	 * @var		array
 	 * @since  Ejemplo en una cuadricula de 3x4
 	 * 	Fila 1.[00][01][02][03]
	 *  Fila 2.[04][05][06][07]
	 *  Fila 3.[08][09][10][11]
	 */
	private $recorte			= array('filas'	=> 3, 'columnas'	=> 3, 'centrado'	=>	4);

	/**
	 * Guarda si la imagen se realizo satisfactoriamento o no en el servidor.
	 * @var 	Boolean
	 * @access 	private
	 */
	private $resultado			= false;

	/**
	 * Guarda los mensajes de errores que se pudieron ocasionar.
	 * @var 	String
	 * @access 	private
	 */
	private $mensaje;

	/**
	 * Configura si se tiene que borrar o no la imagen de origen.
	 * @var		boolean
	 * @access 	private
	 */
	private $borrarOrigen		= false;

	/**
	 * Conserva los datos iniciales.
	 * @var 	object
	 * @access 	private
	 */
	private	$jsonArgumentos;

	/**
	 * Guarda las propiedades de la imagen extraidas mediante getimagesize.
	 * @access 	private
	 * @var		array
	 */
	private $propiedadesImagen;

	/**
	 * Calidad de la imagen destino.
	 * @access 	private
	 * @var		integer
	 */
	private	$calidadImagen		= 95;

	/**
	 * Si la imagen es segura crea un puntero de imagen para utilizarlo para realizar las modificaciones.
	 * Es una imagen en Blanco.
	 * @access 	private
	 * @var 	object
	 */
	private $punteroImagen;

	/**
	 * Mantiene la extencion de la imagen.
	 * @access 	private
	 * @var 	string
	 */
	private $extencion;

	/**
	 * Configura si se generara un archivo (true) o se volcara por pantalla el resulatado.
	 * Nota:  si se vuelca por pantalla se tiene que tener la precaucion de no haber enviado
	 * ningun cabezal antes.
	 * @access 	private
	 * @var 	boolean
	 */
	private $generarArchivo		= true;

	/**
	 * Marca si la imagen se editara desde el archivo temporal creado
	 * al realizar la subida de la imagen
	 * @access 	private
	 * @var 	boolean
	 */
	private $archivoTmp			= false;
	#########################################################################
	# VARIABLES DE CONTROL													#
	#########################################################################
	/**
	 * Contiene las variables que no se podran setear por medio del metodo magico __set().
	 * @access 	private
	 * @var		array
	 */
	private $noPermitirSetVar	= array('anchoOrigen','altoOrigen','punteroImagen','extencion','resultado','mensaje','jsonArgumentos','propiedadesImagen','noPermitirSetVar','noPermitirGetVar','imageCreateFrom','msjError','tiposImagenes');

	/**
	 * Contiene las variables que no se podran ver por medio de el metodo magico __get().
	 * @access 	private
	 * @var 	array
	 */
	private $noPermitirGetVar	= array('punteroImagen','jsonArgumentos','propiedadesImagen','noPermitirSetVar','noPermitirGetVar','imageCreateFrom','tiposImagenes');

	/**
	 * Tiene los tipos de archivos de imagen permitidos y la funcion que crea la imagen editada.
	 * @access 	private
	 * @var 	array
	 */
	private $imageCreateFrom	= array(
									"JPG"	=> "jpeg",
									"GIF"	=> "gif",
									"PNG"	=> "png"
									);

	/**
	 * Contiene los tipos de errores que se pueden ocasionar.
	 * @access 	private
	 * @var		array
	 */
	private static $msjError	= array(
									"ERR_File"		=> "No existe el archivo a modificar",
									"ERR_Param"		=> "No se pudieron resolver todos los parametros.",
									"ERR_Params"	=> "Ningun parametro pudo ser resuelto.<br />Verifique que sea una imagen.",
									"ERR_Exten"		=> "El tipo de archivo y su contenido no coinciden",
									"ERR_Taman"		=> "El archivo no contiene informacion que procesar",
									"ERR_ImgNP"		=> "Tipo de imagen no permitida.",
									"ERR_ImgNC"		=> "No se puede crear una imagen tomando como origen su imagen",
									"ERR_ImgNS"		=> "La imagen no a sido verificada como segura, por favor primero utilize el metodo esImagenSegura()",
									"ERR_FIOri"		=> "No se ha configurado cual sera la imagen de origen",
									"ERR_FIDes"		=> "No se ha configurado cual sera el destino de la imagen",
									"ERR_Modo2"		=> "No se encontraron los parametros para el modo 2."
									);


	private $tiposImagenes		= array(
        							1 	=> 'GIF',
        							2	=> 'JPG',
        							3 	=> 'PNG',
        							4 	=> 'SWF',
        							5 	=> 'PSD',
        							6 	=> 'BMP',
        							7 	=> 'TIFF_II',
        							8	=> 'TIFF_MM',
        							9 	=> 'JPC',
        							10 	=> 'JP2',
        							11 	=> 'JPX',
        							12 	=> 'JB2',
        							13 	=> 'SWC',
        							14 	=> 'IFF',
        							15 	=> 'WBMP',
        							16 	=> 'XBM',
    								17	=> 'ICO');
	#########################################################################
	# METODOS PUBLICOS														#
	#########################################################################
    /**
	 * Metodo constructor.
	 * Se le pueden pasar los argumentos que deberian venir en formato JSON o
	 * tambien se pueden definir despues con los metodos SET correspondientes.
	 * FORMATO DE DATOS:
	 * '{ 	"imgOrigen"	: "direccion de origen",
 	 * 		"imgDestino": "direccion de destino",
 	 * 		"ancho"		: "ancho destino en piixeles",
 	 *		"alto"		: "alto destino",
 	 * 		"modo"		: 0,
 	 * 		"filas"		: 0,
 	 * 		"columnas"	: 0,
 	 * 		"centrado"	: 0,
 	 * 		"borrar"	: false,
 	 * 		"calidad"	: 95
 	 * }'
	 * Se pueden poner los parametros que se dese y complementarlos despues.
	 *
	 * @param	String	$argumentos	cadena tipo JSON
	 */
	public function __construct($argumentos='')
	{	// No quiero que me largue errores si suceden.
		//error_reporting(0);
		set_time_limit(0);
		$this->jsonArgumentos	= json_decode(stripslashes($argumentos));
		if(is_object($this->jsonArgumentos))
		{	// Transfiero los datos JSON a las variables Correspondientes
			// Propiedades no configuradas por defecto
			$this->imagenOrigen			= $this->jsonArgumentos->imgOrigen;
			$this->imagenDestino		= $this->jsonArgumentos->imgDestino;
			$this->anchoDestino			= (int)($this->jsonArgumentos->ancho);
			$this->altoDestino			= (int)($this->jsonArgumentos->alto);
			$this->modo					= (int)($this->jsonArgumentos->modo);
			$this->generarArchivo		= $this->jsonArgumentos->archivo;
			// Propiedades configuradas por defecto
			empty($this->jsonArgumentos->calidad)	?false:$this->calidadImagen			= (int)($this->jsonArgumentos->calidad);
			empty($this->jsonArgumentos->filas)		?false:$this->recorte["filas"]		= (int)($this->jsonArgumentos->filas);
			empty($this->jsonArgumentos->columnas)	?false:$this->recorte["columnas"]	= (int)($this->jsonArgumentos->columnas);
			empty($this->jsonArgumentos->centrado)	?false:$this->recorte["centrado"]	= (int)($this->jsonArgumentos->centrado);
			empty($this->jsonArgumentos->borrar)	?false:$this->borrarOrigen			= $this->jsonArgumentos->borrar;
			empty($this->jsonArgumentos->archivoTmp)?false:$this->archivoTmp			= $this->jsonArgumentos->archivoTmp;

		}
	}

	/**
	 * Se encarga de validar los parametros y generar una imagen para ser utilizada posteriormente.
	 * @access 	public
	 * @var 	string	$imagen	Contiene la ruta y nombre de archivo de la imagen de origen.
	 * @return 	boolean	true si se pudo generar imagen, false si no.
	 */
	public function cargarImagen($imagen)
	{	try
		{	$propiedadImagen	= getimagesize($imagen);
			if(!$propiedadImagen)
			{	throw new Exception(Imagen::$msjError["ERR_File"]);	}

			// Si Existe el Archivo Largo el codigo de Verificacion
			$extencion			= $this->extraerExtencion($imagen);
			$tamanio			= filesize($imagen);

			// Veerifico que todos los parametros tengan algo.
			if(is_array($propiedadImagen))
			{	$this->propiedadesImagen	= $propiedadImagen;
				foreach ($propiedadImagen as $valor)
				{	if(!$valor)
					{	throw new Exception(Imagen::$msjError["ERR_Param"]);	}
				}
			}
			else
			{	throw new Exception(Imagen::$msjError["ERR_Params"]);	}
			// Verifico que si el modo es 2 existan datos para ello
			if($this->modo==2)
			{	if($this->recorte['filas']<1 || $this->recorte['columnas']<1)
				{	throw new Exception(Imagen::$msjError["ERR_Modo2"]);	}
			}

			if($this->archivoTmp)
			{	$extencion	= $this->tiposImagenes[$propiedadImagen[2]];	}
			// Verifico que coincidan las extenciones fisicas y del tipo mime
			if($extencion!=$this->tiposImagenes[$propiedadImagen[2]])
			{	throw new Exception(Imagen::$msjError["ERR_Exten"]);	}

			$this->extencion	= $extencion;

			if(!$tamanio)
			{	throw new Exception(Imagen::$msjError["ERR_Taman"]);	}

			// Veo que sea un tipo permitido y que sea efectivamente de ese tipo.
			if(!array_key_exists($extencion,$this->imageCreateFrom))
			{	throw new Exception(Imagen::$msjError["ERR_ImgNP"]);	}

			switch ($extencion)
			{	case 	"JPG":
						$img = imagecreatefromjpeg($imagen);
						break;
				case 	"PNG": // Mantener Transparencias en PNG
						$img = imagecreatefrompng($imagen);
						imagealphablending($img, true); // setting alpha blending on
						imagesavealpha($img, true); // save alphablending setting (important)
						break;
				case 	"GIF": // Mantener Transparencias en GIF
						$img = imagecreatefromgif($imagen);
						break;
			}
			if(!$img)
			{	throw new Exception(Imagen::$msjError["ERR_ImgNC"]);	}
			$this->punteroImagen	= $img;
		}
		catch (Exception $e)
		{	$this->mensaje	= $e->getMessage();
			return false;
		}
		return true;
	}

	/**
	 * Muestra las propiedades de una imagen.
	 * @access 	public
	 * @return	void
	 */
	public function verPropiedades()
	{	if(!$this->punteroImagen)
		{	$this->mensaje	= Imagen::$msjError["ERR_ImgNS"];
			return false;
		}

		$propiedadesEtq		= array(	0			=> 'ancho:',
										1 			=> 'alto:',
										2			=> 'tipo:',
										3 			=> 'etiquetas img:',
										'bits'		=> 'Profundidad del color (bits):',
										'channels'	=> 'Canales:',
										'mime'		=> 'Tipo Mime:'
										);
		foreach ($this->propiedadesImagen as $clave => $valor)
		{	echo $propiedadesEtq[$clave]."  ".$valor."<br />"; 	}
		return true;
	}

	public function procesarImagen()
	{	if(!$this->punteroImagen)
		{	$estado	= $this->cargarImagen($this->imagenOrigen);
			if(!$estado)
			{	$this->__destruct();
				return ;
			}
		}
		// Controlo que los datos sean suficientes
		if($this->datosSuficientes())
		{	$this->__destruct();
			return ;
		}

		/**
		 * Nota:
		 * propiedadesImagen[0]	equivale a $anchoOrigen
		 * propiedadesImagen[1]	equivale a $altoOrigen
		 */
		switch ($this->modo)
		{	case	0:	// Respeta Proporcionalidad y toma como base el ancho.

					if($this->propiedadesImagen[0]<$this->anchoDestino) { $this->anchoDestino = $this->propiedadesImagen[0]; }
					$coeficiente	= $this->propiedadesImagen[0] / $this->anchoDestino;
					$anchoFinal 	= ceil($this->propiedadesImagen[0] / $coeficiente);
					$altoFinal 		= ceil($this->propiedadesImagen[1] / $coeficiente);
					$this->crearImagenSinRecorte($anchoFinal,$altoFinal);
					break;

			case	1:	// Respeta Proporcionalidad y toma como base el alto.
					if($this->propiedadesImagen[1]<$this->altoDestino) { $this->altoDestino = $this->propiedadesImagen[1]; }
					$coeficiente	= $this->propiedadesImagen[1] / $this->altoDestino;
					$anchoFinal 	= ceil($this->propiedadesImagen[0] / $coeficiente);
					$altoFinal 		= ceil($this->propiedadesImagen[1] / $coeficiente);
					$this->crearImagenSinRecorte($anchoFinal,$altoFinal);
					break;

			case	2:	// Respeta ancho y alto recortando el resto.
					if($this->anchoDestino>$this->propiedadesImagen[0])
					{	$this->anchoDestino	= $this->propiedadesImagen[0];	}
					if($this->altoDestino>$this->propiedadesImagen[1])
					{	$this->altoDestino	= $this->propiedadesImagen[1];	}
					$this->recortarImagen();
					break;
			case 	3:	// Respeta ancho y alto pero deforma la imagen.
					$this->crearImagenSinRecorte($this->anchoDestino,$this->altoDestino);
					break;
		}
	}

	/**
	 * Destructor.
	 * @access 	public
	 * @since 	intenta borrar el archivo de origen si se le ha pedido.
	 */
	public function __destruct()
	{	if($this->borrarOrigen)
		{	if(is_file($this->imagenOrigen))
			{	if(is_writable($this->imagenOrigen))
				{	unlink($this->imagenOrigen);	}
			}
		}
	}

	#########################################################################
	# METODOS GET Y SET 													#
	#########################################################################

	/**
	 * Metodo Magico get.
	 * Retorna el valor que tiene un atributo de la clase.
	 * @access 	public
	 * @param 	string		$propiedad	Nombre de la propiedad o Atributo que se quiere saber su valor.
	 * @return	mixed		false si no existe o el valor del atributo.
	 */
	public function get($propiedad)
	{	if(in_array($propiedad,$this->noPermitirGetVar))
		{	return 	false;	}

		if(!property_exists(__CLASS__,$propiedad))
		{	return false;	}
		else
		{	return $this->$propiedad;	 }
	}

	/**
	 * Metodo Magico set.
	 * Modifica los valores a los atributos de clase.
	 * @access 	public
	 * @var 	String		$propiedad	Nombre de la Porpiedad o Atributo que se le cambiara su valor.
	 * @var 	mixed		$valor		Valor que se le dara a la propiedad.
	 * @var 	boolean
	 */
	public function set($propiedad,$valor)
	{	if(in_array($propiedad,$this->noPermitirSetVar))
		{	return 	false;	}
		if(property_exists(__CLASS__,$propiedad))
		{	$this->$propiedad	= $valor;
			return true;
		}
		else
		{	echo "El Atributo ".$propiedad." no existe.";
			return false;
		}
	}

	#########################################################################
	# METODOS PRIVADOS														#
	#########################################################################

	/**
	 * Corrobora que tenga los datos minimos para ejecutar la rutina.
	 * En caso de no ser escenciales, los regresa al modo por defecto si no existen.
	 * @access 	private
	 * @return 	boolean		false (No se creara la imagen), true (Se puede crear la imagen)
	 */
	private function datosSuficientes()
	{	// Comprobamos el Origen y Destino de la imagen que existan
		// Con estos dos parametros solo ya funcionaria.
		if(!$this->imagenOrigen)
		{	$this->mensaje	= Imagen::$msjError["ERR_FIOri"];
			return false;
		}
		if($this->imagenDestino)
		{	$this->mensaje	= Imagen::$msjError["ERR_FIDes"];
			return false;
		}
		// Veo los parametros por defecto
		if(!$this->anchoDestino)
		{	$this->anchoDestino	= $this->propiedadesImagen[0];	}
		if(!$this->altoDestino)
		{	$this->altoDestino	= $this->propiedadesImagen[1];	}
		// Controles de Modo
		if($this->modo==2)
		{	if( (int)($this->recorte["filas"])<1 || (int)($this->recorte["columnas"])<1   )
			{	$this->recorte			= array('filas'	=> 3, 'columnas'	=> 3, 'centrado'	=>	4);	}
			else
			{	$opcionesRecorte		= $this->recorte["filas"]*$this->recorte["columnas"]-1;
				if($this->recorte["centrado"]>$opcionesRecorte)
				{	$this->recorte["centrado"]	= $opcionesRecorte;	}
			}
		}
		return true;
	}

	/**
	 * Extrae la extencion que trae el archivo basandose en su nombre solamente.
	 * @access 	private
	 * @param	string		$archivo	Ruta hacia el archivo de imagen.
	 * @return	string		Contiene la extencion del archivo en Mayusculas.
	 */
	private function extraerExtencion($archivo)
	{	$puntero	= strripos($archivo,".");
		$extencion	= strtoupper(substr($archivo,$puntero+1));

		return $extencion;
	}

	/**
	 * Metodo CrearImagenSinRecorte.
	 * Es un sub-metodo que termina creando la imagen de Destino.
	 * @access 	private
	 * @param 	int 		$anchoFinal es el ancho final de la imagen destino. Si modo es 0 coincide con el propuesto , si no podria variar.
	 * @param 	int 		$altoFinal es el alto final de la imagen destino. Si modo es 1 coincide con el propuesto , si no podria variar.
	 * @return	Archivo		Es una imagen que se almacena en la direccion establecida.
	 */
	private function crearImagenSinRecorte($anchoFinal,$altoFinal)
	{	switch ($this->extencion)
		{	case 	"JPG":
					$ImgMediana 	= imagecreatetruecolor($anchoFinal,$altoFinal);
					break;
			case	"GIF":
					$ImgMediana 		= imagecreatetruecolor($anchoFinal,$altoFinal);
					$colorTransparente 	= array('red' => 0, 'green' => 0, 'blue' => 0);
		           	$indiceTransparencia= imagecolorallocate($ImgMediana, $colorTransparente['red'], $colorTransparente['green'], $colorTransparente['blue']);
            		imagefill($ImgMediana, 0, 0, $indiceTransparencia);
             		imagecolortransparent($ImgMediana, $indiceTransparencia);
					break;
			case	"PNG":
					// Definimos propiedades de Fondo
					$fondo 				= array('red'	=> 0, 'green' => 0, 'blue'=> 0,'alfa'=>127);
					$ImgMediana 		= imagecreatetruecolor($anchoFinal,$altoFinal);
					//modo sobreescritura de pixeles anteriores activado
					imagealphablending($ImgMediana ,false);
					//color con canal alfa
					$fondo = imagecolorallocatealpha($ImgMediana , $fondo['red'], $fondo['green'], $fondo['blue'], $fondo['alfa']);
					//rellenamos (sustituimos) toda la imagen con este color
					//imagefilledrectangle ( $ImgMediana  , 0 , 0 , $anchoFinal , $altoFinal , $fondo );
					imagefill($ImgMediana,0,0,$fondo);
					//modo sobreescritura de pixeles anteriores desactivado
					imagealphablending($ImgMediana ,true);
					//salida conservando el canal alfa
					imagesavealpha($ImgMediana ,true);
					break;
		}
		// Creamos el Recorte para cualquier tipo de Imagen
		imagecopyresampled($ImgMediana,$this->punteroImagen,0,0,0,0,$anchoFinal,$altoFinal,$this->propiedadesImagen[0],$this->propiedadesImagen[1]);
		$this->crearArchivoDeImagen($ImgMediana);
		imagedestroy($ImgMediana);
	}

	/**
	 * Genera la Salida de la Imagen a un archivo, en el directorio especificado.
	 * @access 	private
	 * @var 	resource	$imgTrueColor	Es una referencia a una imagen creada con la funcion imagecreatetruecolor().
	 * @var 	String		$imgDestino		Nombre del archivo a generar. Si no se pasa se asume que es el de Imagen Destino.
	 * @return 	imagen		Archivo de Imagen
	 */
	private function crearArchivoDeImagen($imgTrueColor,$imgDestino='')
	{	if(empty($imgDestino))
		{	$imgDestino	= $this->imagenDestino;	}
		if($this->generarArchivo==false)
		{	$imgDestino	= "";
			header("Content-type: image.jpg");
		}

		if($this->calidadImagen<10) {	$this->calidadImagen = 10;	}
		switch ($this->extencion)
		{	case "JPG":	// Crea una imgen jpg
						$imgOk	= imagejpeg($imgTrueColor,$imgDestino,$this->calidadImagen);
						break;
			case "PNG":	// Crea una imagen png
						if($this->calidadImagen > 99) {
							$comprension = 9;
						} else {
							$comprension	= floor($this->calidadImagen/10);
						}
						//($this->calidadImagen>99)? $comprension = 9 : $comprension	= floor($this->calidadImagen/10);
						$imgOk	= imagepng($imgTrueColor,$imgDestino,$comprension);
						break;
			case "GIF": // Crea una imagen gif
						$imgOk	= imagegif($imgTrueColor,$imgDestino);
						break;
		}

		if($imgOk)
		{	$this->resultado	= true;
			return true;
		}
		return false;
	}

	/**
	 * Metodo RecortarImagen.
	 * Se encarga de Recortar la imagen de origen y llevarla exactamente a los valores de destino.
	 * Trata de perder la porcion minima de imagen posible.
	 */
	private function recortarImagen()
	{
		$ImgTemporal="temporal_clase_Imagen.".strtolower($this->extencion);

		$CoefAncho		= $this->propiedadesImagen[0]/$this->anchoDestino;
		$CoefAlto		= $this->propiedadesImagen[1]/$this->altoDestino;
		$Coeficiente=0;
		if ($CoefAncho>1 && $CoefAlto>1)
		{	if($CoefAncho>$CoefAlto)
			{ $Coeficiente=$CoefAlto; }
			else
			{$Coeficiente=$CoefAncho;}
		}
		else
		{	$Coeficiente = $CoefAncho; 	}

		if ($Coeficiente!=0)
		{	$anchoTmp	= ceil($this->propiedadesImagen[0]/$Coeficiente);
			$altoTmp	= ceil($this->propiedadesImagen[1]/$Coeficiente);

			$ImgMediana = imagecreatetruecolor($anchoTmp,$altoTmp);
			imagecopyresampled($ImgMediana,$this->punteroImagen,0,0,0,0,$anchoTmp,$altoTmp,$this->propiedadesImagen[0],$this->propiedadesImagen[1]);
			$this->crearArchivoDeImagen($ImgMediana,$ImgTemporal);
		}

		$fila			= floor($this->recorte['centrado']/$this->recorte['columnas']);
		$columna		= $this->recorte['centrado'] - ($fila*$this->recorte["columnas"]);

		$centroX 	= floor(($anchoTmp / $this->recorte["columnas"])/2)+$columna*floor($anchoTmp / $this->recorte["columnas"]);
		$centroY 	= floor(($altoTmp / $this->recorte["filas"])/2)+$fila*floor($altoTmp / $this->recorte["filas"]);

		$centroX	-= floor($this->anchoDestino/2);
		$centroY 	-= floor($this->altoDestino/2);

		if ($centroX<0) {$centroX = 0;}
		if ($centroY<0) {$centroY = 0;}

		if (($centroX+$this->anchoDestino)>$anchoTmp) {$centroX = $anchoTmp-$this->anchoDestino;}
		if (($centroY+$this->altoDestino)>$altoTmp) {$centroY = $altoTmp-$this->altoDestino;}

		$ImgRecortada = imagecreatetruecolor($this->anchoDestino,$this->altoDestino);
		imagecopymerge ( $ImgRecortada,$ImgMediana,0,0,$centroX, $centroY, $this->anchoDestino, $this->altoDestino,$this->calidadImagen);

		$this->crearArchivoDeImagen($ImgRecortada,$this->imagenDestino);
		imagedestroy($ImgRecortada);
		unlink($ImgTemporal);
	}
}
