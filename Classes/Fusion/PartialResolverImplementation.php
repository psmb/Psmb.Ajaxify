<?php
namespace Psmb\Ajaxify\Fusion;

use Exception;
use Neos\Cache\Frontend\VariableFrontend;
use Neos\Flow\Annotations as Flow;
use Neos\Fusion\FusionObjects\AbstractFusionObject;
use Neos\Neos\View\FusionView;

/**
 * Gets the content node and the Fusion path specified by the cache entry key
 * for rendering the associated partial.
 */
class PartialResolverImplementation extends AbstractFusionObject
{
    /**
     * @Flow\Inject
     * @var FusionView
     */
    protected $view;

    /**
     * @Flow\Inject
     * @var VariableFrontend
     */
    protected $partialCache;

    /**
     * @return mixed
     * @throws Exception
     */
    public function evaluate()
    {
        $partialKey = $this->fusionValue('partialKey');

        $partialContext = $this->partialCache->get($partialKey);

        if (!$partialContext) {
            throw new Exception(
                sprintf('The partial context could not be resolved for identifier "%s".', $partialKey),
                1678108923
            );
        }

        return $partialContext;
    }
}
