<?php
//https://www.youtube.com/watch?v=kdxDDE3OAYs&index=4&list=PLYAyQauAPx8mv6I7SG-4sNGVngclrO6WQ
 require('../fpdf/fpdf.php');
 $fpdf = new FPDF();
 $fpdf->AddPage('portrait','A4');
 $fpdf->SetFont('Arial','',12);

 $fpdf->Cell(30,5,'hola mundo');
 $fpdf->OutPut();




?>
