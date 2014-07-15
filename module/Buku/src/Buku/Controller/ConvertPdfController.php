<?php
	
namespace Buku\Controller;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DOMPDFModule\View\Model\PdfModel;

Class ConvertPdfController extends AbstractActionController
{
	public function convertAction()
	{
		$this->AuthPlugin()->checkAuth();
		$objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$headerAdap = $objectManager->getRepository('Buku\Model\Entity\Hjual');
		$headers = $headerAdap->findAll();
		
		$detailAdap = $objectManager->getRepository('Buku\Model\Entity\Djual');
		$details = $detailAdap->findAll();
		
		$bukuAdap = $objectManager->getRepository('Buku\Model\Entity\Buku');
		$buku = $bukuAdap->findAll();
		
		$kasirAdap = $objectManager->getRepository('Buku\Model\Entity\Kasir');
		$kasir = $kasirAdap->findAll();
		
		/*
		// Create a new DOMPDF object
		$dompdf = new \DOMPDF();
		// Set the paper size to A4
		$dompdf->set_paper('A4');
		// Load the HTML
		$dompdf->load_html($html);
		// Render the PDF
		$dompdf->render();
		// Set the PDF Author
		$dompdf->add_info('Author', 'I am the Author');
		// Set the PDF Title
		$dompdf->add_info('Title', 'My PDF Title');
		*/
		
		$pdf = new PdfModel();
		$pdf->setVariables(array(
	      'title' => 'History Transaksi',
	      'headers' => $headers,
	      'details' => $details,
	      'books' => $buku,
	      'kasirs' => $kasir,
	    ));
		$pdf->setOption("paperSize", "a4"); //Defaults to 8x11
		//$pdf->setOption("basePath", realpath(APPLICATION_PATH . '/path/to/css/'));
    	//$pdf->setOption("paperOrientation", "landscape"); //Defaults to portrai
    	$pdf->setOption("filename", "laporan-penjualan");
    	return $pdf;
	}
}	
?>