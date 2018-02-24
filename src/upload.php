<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Загрузка файлов на сервер</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<!-- Custom styles for this template -->
    <link href="cover.css" rel="stylesheet">
</head>
<body class="text-center">
    <div class="cover-container d-flex h-100 p-3 mx-auto flex-column">
      <header class="masthead mb-auto">
        <div class="inner">
          <h3 class="masthead-brand">Paper BACKUPER</h3>
          <nav class="nav nav-masthead justify-content-center">
            <a class="nav-link" href="index.html">Главная</a>
            <a class="nav-link active" href="upload.php">Результат</a>
          </nav>
        </div>
      </header>

      <main role="main" class="inner cover">
        <h1 class="cover-heading">Вы заботитесь о природе?</h1>
		<p class="lead">
<?php
$hashcode = md5(time());
$uploaddir = './uploads/'  .  $hashcode;
if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );
if(  is_uploaded_file($_FILES["filename"]["tmp_name"])  )
    {
        move_uploaded_file
        (
            $_FILES["filename"]["tmp_name"],
            $uploaddir .  DIRECTORY_SEPARATOR  .  $_FILES["filename"]["name"]
        );
		$file = $_FILES["filename"]["name"];
		$filetxt = $_FILES["filename"]["name"]  .  ".txt";
		$upload = file_get_contents($file);
		file_put_contents($uploaddir .  DIRECTORY_SEPARATOR  .  $filetxt, bin2hex($upload));
		require('fpdf/fpdf.php');
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(0,8,'Make with PaperBackuper v0.1');
		$pdf->MultiCell(0,8,'Original filename: '  .  $_FILES["filename"]["name"]);
		$pdf->MultiCell(0,8,bin2hex($upload));
		$pdf->Output($uploaddir  .  DIRECTORY_SEPARATOR  .  'output.pdf', 'F');
		echo "<p><a href = '$uploaddir"  .  DIRECTORY_SEPARATOR  .  "$filetxt'>Скачать TXT</a></p>";
		echo "<p><a href = '$uploaddir"  .  DIRECTORY_SEPARATOR  .  "output.pdf'>Скачать PDF</a></p>";
    } else {
        echo("Ошибка загрузки файла.");
    }
?>
		</p>
      </main>
      <footer class="mastfoot mt-auto">
        <div class="inner">
          <p>Cover template for <a href="https://getbootstrap.com/">Bootstrap</a>, by <a href="https://twitter.com/mdo">@mdo</a>.</p>
        </div>
      </footer>
    </div>
</body>
</html>