<?php

require_once("basemodel.php");

class Pager extends Base {

	private $totalrecords;    
	private $pagesize;
	private $currentpage;
	private $totalpages;
	private $startpage;
	private $endpage;
	private $pages;
	
	function __construct( $totalrecords, $currentpage, $pagesize) 
	{

	   $this->totalrecords = $totalrecords;
	   $this->currentpage = $currentpage;
	   $this->pagesize =  $pagesize;
	}
	

	public function setPager(){
		
		$this->totalpages = ceil($this->totalrecords / $this->pagesize) ;
		$this->startpage = $this->currentpage > 5 && $this->totalpages > 10 ? $this->currentpage - 5 : 1;
		$this->endpage = $this->currentpage < 5 ? 10 : $this->currentpage + 5;

		if($this->endpage > $this->totalpages)
		{
			$this->endpage = $this->totalpages;
		}


		for($i = $this->startpage; $i <= $this->endpage; $i++)
		{
			$this->pages[] = array( "pageno" => $i, "iscurrent" => $this->currentpage == $i );
		}


	}

	public function getPager(){

		$pager["totalrecords"] = $this->totalrecords;
		$pager["totalpages"] = $this->totalpages;
		$pager["startpage"] = $this->startpage;
		$pager["endpage"] = $this->endpage;
		$pager["pages"] = $this->pages;
		
		return $pager;
	}

	public function getPages(){
		return $this->pages;
	}

	public function getTotalPages(){
		return $this->totalpages;
	}

	public function getStartPage(){
		return $this->startpage;
	}

	public function getEndPage(){
		return $this->endpage;
	}


}


?>