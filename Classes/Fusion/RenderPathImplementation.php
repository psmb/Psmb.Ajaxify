<?php
namespace Psmb\Ajaxify\Fusion;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Log\SystemLoggerInterface;
use Neos\Fusion\FusionObjects\AbstractFusionObject;
use Neos\Neos\Exception as NeosException;

/**
 * Returns the path to the parent Fusion object
 */
class RenderPathImplementation extends AbstractFusionObject {

	/**
	 * @Flow\Inject
	 * @var \Neos\Cache\Frontend\VariableFrontend
	 */
	protected $pathsCache;

	public function evaluate() {
		// TODO: Find this ugly? Know how to do better? Submit a PR!
		$pathExploded = explode('/', $this->path);
		$key = explode('<', $pathExploded[sizeof($pathExploded) - 5])[0];
		$path = dirname($this->path, 7);
		$this->pathsCache->set(
			$key,
			$path
		);
		return $key;
	}

}
