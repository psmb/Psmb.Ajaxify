<?php
namespace Psmb\Ajaxify\Fusion;

use Neos\Cache\Frontend\VariableFrontend;
use Neos\Flow\Annotations as Flow;
use Neos\Fusion\FusionObjects\AbstractFusionObject;
use Neos\Neos\View\FusionView;

/**
 * Retrieves the content node and Fusion object path given by the cache entry key
 * for re-rendering the partial.
 */
class RenderPathResolverImplementation extends AbstractFusionObject
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
    protected $pathsCache;

    /**
     * @return mixed
     * @throws \Exception
     */
    public function evaluate()
    {
        $pathKey = $this->fusionValue('pathKey');
        $partialContext = $this->pathsCache->get($pathKey);

        if (!$partialContext) {
            throw new \Exception(sprintf('The partial context could not be resolved for identifier "%s".', $pathKey), 1678108923);
        }

        return $partialContext;
    }
}
