<?php
/**
 * 
 ************************************************************************************** 
 * 28/04/2010
 * INCRUSTA REPRODUCTOR YOUTUBE  con las dimensiones y el video que se indica
 * Ej: http://www.youtube.com/watch?v=zVt9kQWNp3I&feature=player_embedded 
 * youtube('zVt9kQWNp3I',800,600)
 * donde ancho = 800px
 *       alto = 600px
 *       codigo del video en youtube = zVt9kQWNp3I 
 ************************************************************************************** 
 * 
 */
function youtube($codigo=null,$ancho=480,$alto=385){ 

	return '<object width="'.$ancho.'" height="'.$alto.'">
				<param name="movie" value="http://www.youtube.com/v/'.$codigo.'"></param>
				<param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param>
				<embed src="http://www.youtube.com/v/'.$codigo.'" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="'.$ancho.'" height="'.$alto.'></embed>
			</object>';

}
?>

