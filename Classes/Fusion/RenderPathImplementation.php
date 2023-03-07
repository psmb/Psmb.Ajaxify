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
		$pathKey = $this->fusionValue('pathKey');

		$nodeIdentifier = (string)$node->getNodeAggregateIdentifier();
		list($pathKeyFallback, $path) = $this->getPathKeyAndFusionPath();
		$pathKey = $pathKey ?: $pathKeyFallback;
		$partialContext = [
			'nodeIdentifier' => $nodeIdentifier,
			'renderPath' => $path,
		];
		$this->pathsCache->set(
			$pathKey,
			$partialContext
		);
		return $pathKey;
	}

    /**
     * Returns the property name that this Fusion object or the wrapping Psmb.Ajaxify:Ajaxify
     * Fusion object is associated with - as a potential cache key, and the Fusion path of the
     * wrapping partial.
     *
     * @return array
     * @see \Neos\Neos\Fusion\ContentElementWrappingImplementation::getContentElementFusionPath
     */
    protected function getPathKeyAndFusionPath()
    {
        $pos = strrpos($this->path, "<Psmb.Ajaxify:Ajaxify>");
        if ($pos === false) {
            $pos = strrpos($this->path, "<Psmb.Ajaxify:RenderPath>");
        }

        $fusionPathSegments = explode('/', substr($this->path, 0, $pos));
        $numberOfFusionPathSegments = count($fusionPathSegments);

        $pathKey = $fusionPathSegments[$numberOfFusionPathSegments - 1];
        if (isset($fusionPathSegments[$numberOfFusionPathSegments - 3])
            && $fusionPathSegments[$numberOfFusionPathSegments - 3] === '__meta'
            && isset($fusionPathSegments[$numberOfFusionPathSegments - 2])
            && $fusionPathSegments[$numberOfFusionPathSegments - 2] === 'process') {

            // cut off the SHORT processing syntax "__meta/process/contentElementWrapping<Neos.Neos:ContentElementWrapping>"
            $renderPath = implode('/', array_slice($fusionPathSegments, 0, -3));
        }
        elseif (isset($fusionPathSegments[$numberOfFusionPathSegments - 4])
            && $fusionPathSegments[$numberOfFusionPathSegments - 4] === '__meta'
            && isset($fusionPathSegments[$numberOfFusionPathSegments - 3])
            && $fusionPathSegments[$numberOfFusionPathSegments - 3] === 'process') {

            // cut off the LONG processing syntax "__meta/process/contentElementWrapping/expression<Neos.Neos:ContentElementWrapping>"
            $renderPath = implode('/', array_slice($fusionPathSegments, 0, -4));
        } else {
            $renderPath = implode('/', array_slice($fusionPathSegments, 0, -1));
        }

        return [
            $pathKey,
            $renderPath,
        ];
    }
}
