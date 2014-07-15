<?php
	
namespace Buku\Controller;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use PHPExcel;

Class ConvertExcelController extends AbstractActionController
{
	public function convertAction()
	{
		$this->AuthPlugin()->checkAuth();
		$objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$headerAdap = $objectManager->getRepository('Buku\Model\Entity\Hjual');
		$headers = $headerAdap->findAll();
		
		$detailAdap = $objectManager->getRepository('Buku\Model\Entity\Djual');
		$details = $detailAdap->findAll();
		
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		
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
		            ->setCellValue('A1', 'No. Transaksi')
					->setCellValue('B1', 'Tanggal')
					->setCellValue('C1', 'Kasir')
					->setCellValue('D1', 'Customer')
		            ->setCellValue('E1', 'Nama Buku')
		            ->setCellValue('F1', 'Qty')
		            ->setCellValue('G1', 'Harga')
					->setCellValue('H1', 'Subtotal');
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		
		// Miscellaneous glyphs, UTF-8
		$idxBaris = 2;
		$lastIdx = 0;
		foreach ($headers as $header) {
			foreach ($details as $detail) {
				if ($detail->getId() == $header->getId()) {
					$objPHPExcel->setActiveSheetIndex(0)
				            ->setCellValue('A'.$idxBaris, $header->getId())
							->setCellValue('B'.$idxBaris, $header->getTgl())
				            ->setCellValue('C'.$idxBaris, $this->getNamaKasir($header->getKasir()))
							->setCellValue('D'.$idxBaris, $header->getCustomer())
							->setCellValue('E'.$idxBaris, $this->getNamaBuku($detail->getBuku()))
							->setCellValue('F'.$idxBaris, $detail->getQty())
							->setCellValue('G'.$idxBaris, $detail->getHarga())
							->setCellValue('H'.$idxBaris, $detail->getSubtotal());
					$lastIdx = $idxBaris;
					$idxBaris++;	
				}
			}
		}
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('E'.($lastIdx+2), 'Total Item Terjual')
					->setCellValue('F'.($lastIdx+2), '=SUM(F2:F' . $lastIdx . ')')
					->setCellValue('E'.($lastIdx+3), 'Total Penjualan')
					->setCellValue('H'.($lastIdx+3), '=SUM(H2:H' . $lastIdx . ')');
		
		
		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('Book Sales Report');
		
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		
		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="01simple.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
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