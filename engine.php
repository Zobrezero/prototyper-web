<?php 
	function getStringBetween($str, $start, $end = null)
	{
		$str = ' ' . $str;
		$ini = strpos($str, $start);
		if ($ini == 0) return '';
		$ini += strlen($start);
		if ($end)
		{
			$len = strpos($str, $end, $ini) - $ini;
			return substr($str, $ini, $len);
		}
		return substr($str, $ini);
	}
	$templatePath = 'templates/';
	$pagesPath    = './pages/';

	$allDirs = scandir($pagesPath);
	$dirs = [];
	foreach ($allDirs as $d)
	{
		if (is_file($pagesPath.$d) && strpos($d, '.html'))
			$dirs[] = $d;
	}

	//$requestedPageName  = split('engine.php/', $_SERVER['REQUEST_URI'])[1];
	$requestedPageName  = getStringBetween($_SERVER['REQUEST_URI'], 'engine.php/');

	if ($requestedPageName)
	{
		$templatePage  = file_get_contents($templatePath.'base.html', FILE_USE_INCLUDE_PATH);
		$pageContent   = file_get_contents($pagesPath.$requestedPageName, FILE_USE_INCLUDE_PATH);

		$titlePage     = getStringBetween($pageContent, '[title]', '[/title]');
		$bodyPage      = getStringBetween($pageContent, '[body]', '[/body]');

		$renderedPage  = $templatePage;
		$renderedPage  = str_replace('[title]', $titlePage, $renderedPage);
		$renderedPage  = str_replace('[body]', $bodyPage, $renderedPage);
		echo $renderedPage;
	}
	else
	{
 ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Prototyper Web</title>
	</head>
	<body>
		<h1>Bienvenido a Prototyper Web</h1>
		<br>
		<?php
			if ($dirs)
			{
		?>
			<p>
				Actualmente usted dispone de las siguientes páginas para navegar.
				<br>
				<br>
				Presione una de la lista para comenzar con la navegación.
			</p>
			<ul>
		<?php
			foreach ($dirs as $key => $value)
			{
				?>

				<li><a href="engine.php/<?php echo $value ?>"><?php echo $value?></a></li>
				<?php
			}
		} ?>
			</ul>
	</body>
</html>

<?php } ?>