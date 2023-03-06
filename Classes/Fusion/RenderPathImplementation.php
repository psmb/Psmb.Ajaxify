<?php
namespace Psmb\Ajaxify\Fusion;

use Neos\ContentRepository\Domain\Model\Node;
use Neos\Flow\Annotations as Flow;
use Neos\Fusion\FusionObjects\AbstractFusionObject;

/**
 * Returns the path to the parent Fusion object
 */
class RenderPathImplementation extends AbstractFusionObject {

	/**
	 * @Flow\Inject
	 * @var \Neos\Cache\Frontend\VariableFrontend
	 */
	protected $pathsCache;

	/**
	 * @return mixed|string
	 * @throws \Neos\Cache\Exception
	 */
	public function evaluate() {
		/** @var $node Node */
		$node = $this->fusionValue('node');

		// TODO: Find this ugly? Know how to do better? Submit a PR!
		$pathExploded = explode('/', $this->path);
		$key = explode('<', $pathExploded[sizeof($pathExploded) - 5])[0];
		$path = dirname($this->path, 7);
		$nodeIdentifier = (string)$node->getNodeAggregateIdentifier();
		$partialContext = [
			'nodeIdentifier' => $nodeIdentifier,
			'renderPath' => $path,
		];
		$this->pathsCache->set(
			$key,
			$partialContext
		);
		return $key;
	}

}
