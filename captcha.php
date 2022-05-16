<?php
	session_start();
	header("Content-Type: image/png");


	//Captcha :
		//Alphanumérique
		//Long doit être aléatoire entre 6 et 9 caractères
		//On utilise qu'une seule fois un caractère
		//On alimente la variable $captcha

	$charAuthorized = "abcdefghijklmnopqrstuvwxyz0123456789";
	$captcha = str_shuffle($charAuthorized);
	$captcha = substr($captcha, 0, rand(6,9));

	$_SESSION["captcha"] = $captcha;


	$image = imagecreate(400, 200);

	

	//imagestring($image, 5, 20, 150, $captcha, $black);

	//Un fond aléatoire
	$back = imagecolorallocate($image, rand(150, 250),  rand(150, 250),  rand(150, 250));

	//Une police aléatoire par caractère, les polices se trouveront dans un dossier font

	$listOfFonts = glob("fonts/*.ttf");


	$x = 20;

	for($i=0; $i < strlen($captcha); $i++){
		//Angle aléatoire par caractère
		//Couleur aléatoire par caractère
		//Taille aléatoire par caractère
		//Position aléatoire par caractère
		//Forme géométriques aléatoire avec un nombre aléatoire utilisant les mêmes couleurs que les caractères.
		//ATTENTION: Doit toujours être lisible

		$colorFont[] = imagecolorallocate($image, rand(0, 100),  rand(0, 100),  rand(0, 100));

		imagettftext(
						$image, 
						rand(40,45), 
						rand(-30, 30), 
						$x, 
						rand(100, 150), 
						$colorFont[$i], 
						__DIR__."/".$listOfFonts[array_rand($listOfFonts)], 
						$captcha[$i]);


		$x += rand(42, 45);


	}


	//intégration des formes géo
	$nbForm = rand(8, 16);
	for( $i=0 ; $i<$nbForm ; $i++){
		$form = rand(1, 3);

		switch ($form) {
			case 1:
				imagerectangle($image, rand(0,400), rand(0,200), rand(0,400),  rand(0,200), $colorFont[array_rand($colorFont)]);
				break;
			case 2:
				imageline($image, rand(0,400), rand(0,200), rand(0,400),  rand(0,200), $colorFont[array_rand($colorFont)]);
				break;
			default:
				imageellipse($image, rand(0,400), rand(0,200), rand(0,400),  rand(0,200), $colorFont[array_rand($colorFont)]);
				break;
		}

	}

	







	imagepng($image);



