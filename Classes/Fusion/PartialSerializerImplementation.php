<?php
namespace Psmb\Ajaxify\Fusion;

use Neos\Cache\Exception;
use Neos\Cache\Frontend\VariableFrontend;
use Neos\ContentRepository\Domain\Model\Node;
use Neos\Flow\Annotations as Flow;
use Neos\Fusion\FusionObjects\AbstractFusionObject;

/**
 * Stores the content node and the Fusion path of the current partial
 * in the cache and returns the associated cache entry key.
 */
class PartialSerializerImplementation extends AbstractFusionObject
{
    /**
     * @Flow\Inject
     * @var VariableFrontend
     */
    protected $partialCache;

    /**
     * @return mixed|string
     * @throws Exception
     */
    public function evaluate()
    {
        /** @var $node Node */
        $node = $this->fusionValue('node');

        $nodeIdentifier = (string)$node->getNodeAggregateIdentifier();
        $fusionPath = $this->getPartialFusionPath();
        $partialContext = [
            'nodeIdentifier' => $nodeIdentifier,
            'fusionPath' => $fusionPath,
        ];
        $partialKey = sha1(implode(';', $partialContext));
        $this->partialCache->set(
            $partialKey,
            $partialContext
        );
        return $partialKey;
    }

    /**
     * Returns the Fusion path of the wrapping partial.
     *
     * Note that this Psmb.Ajaxify:PartialSerializer object may be nested inside a
     * Psmb.Ajaxify:Ajaxify object. It is assumed that the outer of the two
     * objects is in turn called at the first nesting depth of the wrapping
     * partial.
     *
     * @return string
     * @see \Neos\Neos\Fusion\ContentElementWrappingImplementation::getContentElementFusionPath
     */
    protected function getPartialFusionPath()
    {
        $pos = strrpos($this->path, "<Psmb.Ajaxify:Ajaxify>");
        if ($pos === false) {
            $pos = strrpos($this->path, "<Psmb.Ajaxify:PartialSerializer>");
        }

        $fusionPathSegments = explode('/', substr($this->path, 0, $pos));
        $numberOfFusionPathSegments = count($fusionPathSegments);
        if (isset($fusionPathSegments[$numberOfFusionPathSegments - 3])
            && $fusionPathSegments[$numberOfFusionPathSegments - 3] === '__meta'
            && isset($fusionPathSegments[$numberOfFusionPathSegments - 2])
            && $fusionPathSegments[$numberOfFusionPathSegments - 2] === 'process') {

            // cut off the SHORT processing syntax "__meta/process/ajaxify"
            return implode('/', array_slice($fusionPathSegments, 0, -3));
        }
        elseif (isset($fusionPathSegments[$numberOfFusionPathSegments - 4])
            && $fusionPathSegments[$numberOfFusionPathSegments - 4] === '__meta'
            && isset($fusionPathSegments[$numberOfFusionPathSegments - 3])
            && $fusionPathSegments[$numberOfFusionPathSegments - 3] === 'process') {

            // cut off the LONG processing syntax "__meta/process/ajaxify/expression"
            return implode('/', array_slice($fusionPathSegments, 0, -4));
        }
        return implode('/', array_slice($fusionPathSegments, 0, -1));
    }
}
