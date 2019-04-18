<?php
namespace App\Twig\Loader;

use App\Entity\Sjabloon;
use Doctrine\ORM\EntityManagerInterface;
use Twig_Error_Loader;
use Twig_LoaderInterface;
use Twig_Source;

class DatabaseLoader implements Twig_LoaderInterface
{
	protected $repo;
	
	public function __construct(EntityManagerInterface $em)
	{
		$this->repo = $em->getRepository(Sjabloon::class);
	}
	
	public function getSourceContext($name)
	{
		if (false === $sjabloon= $this->getSjabloon($name)) {
			throw new Twig_Error_Loader(sprintf('Template "%s" does not exist.', $name));
		}
		
		return new Twig_Source($sjabloon->getSource(), $name);
	}
	
	public function exists($name)
	{
		return (bool)$this->getSjabloon($name);
	}
	
	public function getCacheKey($name)
	{
		return $name;
	}
	
	public function isFresh($name, $time)
	{
		if (false === $sjabloon = $this->getSjabloon($name)) {
			return false;
		}
		
		return $sjabloon->getLastUpdated()->getTimestamp() <= $time;
	}
	
	/**
	 * @param $name
	 * @return Template|null
	 */
	protected function getSjabloon($name)
	{
		return $this->repo->findOneBy(['filename' => $name]);
	}
}