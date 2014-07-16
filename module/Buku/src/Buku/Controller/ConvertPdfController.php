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
		$this->authPlugin()->checkAuth();
		$objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$headerAdap = $objectManager->getRepository('Buku\Model\Entity\HeaderJual');
		$headers = $headerAdap->findAll();
		
		$detailAdap = $objectManager->getRepository('Buku\Model\Entity\DetailJual');
		$details = $detailAdap->findAll();
		
		$bukuAdap = $objectManager->getRepository('Buku\Model\Entity\Buku');
		$buku = $bukuAdap->findAll();
		
		$kasirAdap = $objectManager->getRepository('Buku\Model\Entity\Kasir');
		$kasir = $kasirAdap->findAll();
		
		$pdf = new PdfModel();
		$pdf->setVariables(array(
	      'title' => 'History Transaksi',
	      'headers' => $headers,
	      'details' => $details,
	      'books' => $buku,
	      'kasirs' => $kasir,
	    ));
		$pdf->setOption("paperSize", "a4"); 
    	$pdf->setOption("filename", "laporan-penjualan");
    	return $pdf;
	}
}	
?>