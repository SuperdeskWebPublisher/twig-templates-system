<?php

namespace SWP\TemplatesSystem\Twig\Extension;

use SWP\TemplatesSystem\Twig\TokenParser\GimmeTokenParser;
use SWP\TemplatesSystem\Twig\TokenParser\GimmeListTokenParser;

class GimmeExtension extends \Twig_Extension
{
    protected $loader;

    protected $context;

    public function __construct($context, $loader)
    {
        $this->context = $context;
        $this->loader = $loader;
    }

    public function getLoader()
    {
        return $this->loader;
    }

    public function getContext()
    {
        return $this->context;
    }

    public function getTokenParsers()
    {
        return [
            new GimmeTokenParser(),
            new GimmeListTokenParser(),
        ];
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('start', function($context, $node, $value) {
                $node['_collection_type_filters']['start'] = $value;

                return $node;
            }, array('needs_context' => true)),
            new \Twig_SimpleFilter('limit', function($context, $node, $value) {
                $node['_collection_type_filters']['limit'] = $value;

                return $node;
            }, array('needs_context' => true)),
            new \Twig_SimpleFilter('order', function($context, $node, $value1, $value2) {
                $node['_collection_type_filters']['order'] = [$value1, $value2];

                return $node;
            }, array('needs_context' => true)),
        ];
    }

    public function getGlobals()
    {
        return ['gimme' => $this->context];
    }

    public function getName()
    {
        return 'swp_gimme';
    }
}
