<?php


class GPdf
{


	var $engine=null;

	var $buffer=null;

	var $name=null;

	var $title=null;

	var $margin_left=null;

	var $margin_right=null;

	var $margin_top=null;

	var $margin_bottom=null;

	var $margin_header=null;

	var $margin_footer=null;

	var $header_logo=null;

	var $orientation=null;

	var $paper=null;

	var $unit=null;

	var $header=null;
	
	var $generator=null;
	
	var $description=null;
	
	var $subject=null;
	
	var $metadata=null;
	



	function __construct($options=array())
	{
		global $option;
		if (!defined('RELATIVE_PATH')) define('RELATIVE_PATH',JPATH_ROOT.DS."administrator".DS."components".DS.$option.DS."libraries".DS."gobingoo".DS."html2pdf".DS);
		if (!defined('FPDF_FONTPATH')) define('FPDF_FONTPATH',RELATIVE_PATH.DS.'font'.DS);
		
		define('F_PATH_CACHE',JPATH_CACHE);

		$this->margin_left=isset($options['margin_left'])?$options['margin_left']:15;

		$this->margin_right=isset($options['margin_right'])?$options['margin_right']:15;

		$this->margin_top=isset($options['margin_top'])?$options['margin_top']:10;

		$this->margin_bottom=isset($options['margin_bottom'])?$options['margin_bottom']:15;

		$this->margin_header=isset($options['margin_header'])?$options['margin_header']:15;

		$this->margin_footer=isset($options['margin_footer'])?$options['margin_footer']:15;

		$this->orientation=isset($options['orientation'])?$options['orientation']:"P";

		$this->paper=isset($options['paper'])?$options['paper']:'A4';

		$this->unit=isset($options['unit'])?$options['unit']:'mm';

		$this->image_scale=isset($options['image_scale'])?$options['image_scale']:4;



		require_once (RELATIVE_PATH."html2fpdf.php");
		$this->engine=new HTML2FPDF($this->orientation,$this->unit,$this->paper);
		$this->engine->SetMargins($this->margin_left,$this->margin_top,$this->margin_right);
		$this->engine->SetAutoPageBreak(true,$this->margin_bottom);

	}

	
	function setGenerator($text="")
	{
		$this->generator=$text;
	}
	
	function getGenerator()
	{
		return $this->generator;
	}
	
	function setDescription($text="")
	{
		$this->description=$text;
	}
	
	function getDescription()
	{
		return $this->description;
	}

	function setName($name="gobingoo")
	{
		$this->name=$name;
	}

	function getName()
	{
		return $this->name;
	}

	function setTitle($title="gobingoo")
	{
		$this->title=$title;
	}

	function getTitle()
	{
		return $this->title;

	}

	
	function setSubject($text="")
	{
		$this->subject=$text;
		
	}
	
	function getSubject()
	{
		
		return $this->subject;
	}
	
	function setMetaData($text="")
	{
		$this->metadata=$text;
		
	}
	
	function getMetaData()
	{
		
		return $this->metadata;
	}
	
	
	function setBuffer($buffer="")
	{
		$this->buffer=$buffer;
	}
	
	function getBuffer()
	{
		return $this->buffer;
	}
	
	function setHeader($text="")
	{
		$this->header=$text;
	}

	function getHeader()
	{
		return $this->header;
	}

	function render( $cache = false, $params = array())
	{
		$pdf = &$this->engine;

		// Set PDF Metadata
		$pdf->SetCreator($this->getGenerator());
		$pdf->SetTitle($this->getTitle());
		$pdf->SetSubject($this->getDescription());
		$pdf->SetKeywords($this->getMetaData('keywords'));
		$pdf->AddPage();
		$pdf->WriteHTML($this->getBuffer());
		$data = $pdf->Output($this->getName().".pdf", 'D');



		JResponse::setHeader('Content-disposition', 'inline; filename="'.$this->getName().'.pdf"', true);

		//Close and output PDF document
		return $data;
	}
}
?>