<?php

namespace SWP\TemplatesSystem\Twig\Node;

/**
 * Gimme twig node.
 */
class GimmeNode extends \Twig_Node
{
    private static $count = 1;

    /**
     * @param \Twig_Node_Expression $annotation
     * @param \Twig_Node_Expression $parameters
     * @param \Twig_NodeInterface   $body
     * @param integer               $lineno
     * @param string                $tag
     */
    public function __construct(\Twig_Node $annotation, \Twig_Node_Expression $parameters = null, \Twig_NodeInterface $body, $lineno, $tag = null)
    {
        parent::__construct(array('parameters' => $parameters, 'body' => $body, 'annotation' => $annotation), array(), $lineno, $tag);
    }

    /**
     * {@inheritDoc}
     */
    public function compile(\Twig_Compiler $compiler)
    {
        $i = self::$count++;

        $compiler
            ->addDebugInfo($this)
            ->write("\$swpMetaLoader".$i." = \$this->getEnvironment()->getExtension('swp_gimme')->getLoader();\n")
            ->write("")->subcompile($this->getNode('annotation'))->raw(" = \$swpMetaLoader".$i."->load(\"")->raw($this->getNode('annotation')->getNode(0)->getAttribute('name'))->raw("\", ");
                if (!is_null($this->getNode('parameters'))) {
                    $compiler->subcompile($this->getNode('parameters'));
                } else {
                    $compiler->raw("null");
                }
                $compiler->raw(");\n")
            ->write("if (")->subcompile($this->getNode('annotation'))->raw(" !== false) {\n")
            ->indent()
                ->subcompile($this->getNode('body'))
            ->outdent()
            ->write("}\n")
            ->write("unset(")->subcompile($this->getNode('annotation'))->raw(');')
        ;
    }
}
