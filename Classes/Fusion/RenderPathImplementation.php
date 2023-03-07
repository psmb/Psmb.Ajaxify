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

		$nodeIdentifier = (string)$node->getNodeAggregateIdentifier();
		$path = $this->getPartialFusionPath();
		$partialContext = [
			'nodeIdentifier' => $nodeIdentifier,
			'renderPath' => $path,
		];
		$partialKey = sha1(implode(';', $partialContext));
		$this->pathsCache->set(
			$partialKey,
			$partialContext
		);
		return $partialKey;
	}

    /**
     * Returns the Fusion path of the wrapping partial.
     *
     * Note that this Fusion object may be nested inside a Psmb.Ajaxify:Ajaxify object.
     * It is assumed that the outer of the two objects is in turn called at the first
     * nesting depth of the wrapping partial.
     *
     * @return string
     * @see \Neos\Neos\Fusion\ContentElementWrappingImplementation::getContentElementFusionPath
     */
    protected function getPartialFusionPath()
    {
        $pos = strrpos($this->path, "<Psmb.Ajaxify:Ajaxify>");
        if ($pos === false) {
            $pos = strrpos($this->path, "<Psmb.Ajaxify:RenderPath>");
        }

        $fusionPathSegments = explode('/', substr($this->path, 0, $pos));
        $numberOfFusionPathSegments = count($fusionPathSegments);

        if (isset($fusionPathSegments[$numberOfFusionPathSegments - 3])
            && $fusionPathSegments[$numberOfFusionPathSegments - 3] === '__meta'
            && isset($fusionPathSegments[$numberOfFusionPathSegments - 2])
            && $fusionPathSegments[$numberOfFusionPathSegments - 2] === 'process') {

            // cut off the SHORT processing syntax "__meta/process/ajaxify"
            $renderPath = implode('/', array_slice($fusionPathSegments, 0, -3));
        }
        elseif (isset($fusionPathSegments[$numberOfFusionPathSegments - 4])
            && $fusionPathSegments[$numberOfFusionPathSegments - 4] === '__meta'
            && isset($fusionPathSegments[$numberOfFusionPathSegments - 3])
            && $fusionPathSegments[$numberOfFusionPathSegments - 3] === 'process') {

            // cut off the LONG processing syntax "__meta/process/ajaxify/expression"
            $renderPath = implode('/', array_slice($fusionPathSegments, 0, -4));
        } else {
            $renderPath = implode('/', array_slice($fusionPathSegments, 0, -1));
        }

        return $renderPath;
    }
}
