<?php
// api/src/Controller/CreateBookPublication.php

namespace App\Controller;

use App\Entity\Bericht;

class BerichtController
{ 
	public function __invoke(Bericht $data): Bericht
	{
		//$this->bookPublishingHandler->handle($data);
		
		return $data;
	}
}