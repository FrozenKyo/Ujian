<?php
	
namespace Buku\Controller;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use PHPExcel;

Class ConvertChartController extends AbstractActionController
{
	public function convertAction()
	{
		$this->authPlugin()->checkAuth();
		
		$objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$headerAdap = $objectManager->getRepository('Buku\Model\Entity\HeaderJual');
		$headers = $headerAdap->findAll();
		
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		$objWorksheet = $objPHPExcel->getActiveSheet();
		
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Shinigami")
									 ->setLastModifiedBy("Shinigami")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");
		
		
		// Add some data
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Tanggal')
					->setCellValue('B1', 'Total');
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		
		$tgl="";
		$idxBaris = 1;
		$total = 0;
		$lastIdx = 0;
		foreach ($headers as $header) {
			if ($tgl <> $header->getTgl()) {
				if ($idxBaris > 1) {
					$objPHPExcel->setActiveSheetIndex(0)
				            	->setCellValue('A'.$idxBaris, $tgl)
								->setCellValue('B'.$idxBaris, $total);
				}
				$tgl = $header->getTgl();
				$lastIdx = $idxBaris;
				$idxBaris++;
				$total = 0;
			}
			$total += $header->getTotal();
		}
		$lastIdx++;
		$objPHPExcel->setActiveSheetIndex(0)
	            	->setCellValue('A'.$lastIdx, $tgl)
					->setCellValue('B'.$lastIdx, $total);
					
		/*
		$idxBaris = 2;
				
				foreach ($headers as $header) {
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('A'.$idxBaris, $header->getTgl())
								->setCellValue('B'.$idxBaris, $header->getTotal());
					$lastIdx = $idxBaris;
					$idxBaris++;	
				}*/
		
		/*
		$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A'.($lastIdx+2), 'Total Item Terjual')
							->setCellValue('F'.($lastIdx+2), '=SUM(F2:F' . $lastIdx . ')')
							->setCellValue('E'.($lastIdx+3), 'Total Penjualan')
							->setCellValue('H'.($lastIdx+3), '=SUM(H2:H' . $lastIdx . ')');*/
		
		
		/*
		$objWorksheet->fromArray(
					array(
						array('',	2010,	2011,	2012),
						array('Q1',   12,   15,		21),
						array('Q2',   56,   73,		86),
						array('Q3',   52,   61,		69),
						array('Q4',   30,   32,		0),
					)
				);*/
		
		
		//	Set the Labels for each data series we want to plot
		//		Datatype
		//		Cell reference for data
		//		Format Code
		//		Number of datapoints in series
		//		Data values
		//		Data Marker
		$dataseriesLabels = array();
		for ($i=2;$i<=$lastIdx;$i++) {
			array_push($dataseriesLabels, new \PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$' . $i , NULL, 1));
		}
		
		/*
		$dataseriesLabels = array(
					new \PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$2', NULL, 1),
					new \PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$3', NULL, 1),
					//new \PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$1', NULL, 1),	//	2011
					//new \PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$D$1', NULL, 1),	//	2012
				);*/
		
		//	Set the X-Axis Labels
		//		Datatype
		//		Cell reference for data
		//		Format Code
		//		Number of datapoints in series
		//		Data values
		//		Data Marker
		$xAxisTickValues = array(
			//new \PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$2', NULL, 1),
			//new \PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$3', NULL, 1)
			new \PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$2:$B$' . $lastIdx, NULL, $lastIdx-1),	//	Q1 to Q4
		);
		
		//	Set the Data values for each data series we want to plot
		//		Datatype
		//		Cell reference for data
		//		Format Code
		//		Number of datapoints in series
		//		Data values
		//		Data Marker
		$dataSeriesValues = array(
			//new \PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$B$2', NULL, 1),
			//new \PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$B$3', NULL, 1),
			//new \PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$B$2:$B$' . $lastIdx, NULL, $lastIdx),
			//new \PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$C$2:$C$5', NULL, 4),
			//new \PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$2:$D$5', NULL, 4),
		);
		
		for ($i=2;$i<=$lastIdx;$i++) {
			array_push($dataSeriesValues, new \PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$B$' . $i, NULL, $lastIdx-1));
		}
		
		//	Build the dataseries
		$series = new \PHPExcel_Chart_DataSeries(
			\PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
			\PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,	// plotGrouping
			range(0, count($dataSeriesValues)-1),			// plotOrder
			$dataseriesLabels,								// plotLabel
			$xAxisTickValues,								// plotCategory
			$dataSeriesValues								// plotValues
		);
		//	Set additional dataseries parameters
		//		Make it a horizontal bar rather than a vertical column graph
		$series->setPlotDirection(\PHPExcel_Chart_DataSeries::DIRECTION_BAR);
		
		//	Set the series in the plot area
		$plotarea = new \PHPExcel_Chart_PlotArea(NULL, array($series));
		//	Set the chart legend
		$legend = new \PHPExcel_Chart_Legend(\PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
		
		$title = new \PHPExcel_Chart_Title('Chart Penjualan Harian');
		$yAxisLabel = new \PHPExcel_Chart_Title('Nilai Penjualan (Rp)');
		
		
		//	Create the chart
		$chart = new \PHPExcel_Chart(
			'chart1',		// name
			$title,			// title
			$legend,		// legend
			$plotarea,		// plotArea
			true,			// plotVisibleOnly
			0,				// displayBlanksAs
			NULL,			// xAxisLabel
			$yAxisLabel		// yAxisLabel
		);
		
		//	Set the position where the chart should appear in the worksheet
		$chart->setTopLeftPosition('G1');
		$chart->setBottomRightPosition('Q20');
		
		//	Add the chart to the worksheet
		$objWorksheet->addChart($chart);
		
		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="chart.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		
		// Save Excel 2007 file
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		//$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
		$objWriter->save('php://output');
	}

	private function getNamaBuku($id){
		$omBook = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$bukuAdap = $omBook->getRepository('Buku\Model\Entity\Buku');
		$buku = $bukuAdap->findBy(array('id' => $id));
		return $buku[0]->getNama();
	}
	
	private function getNamaKasir($id){
		$omKasir = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$kasirAdap = $omKasir->getRepository('Buku\Model\Entity\Kasir');
		$kasir = $kasirAdap->findBy(array('id' => $id));
		return $kasir[0]->getNama();
	}
}	
?>