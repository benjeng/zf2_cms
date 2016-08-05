<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Cms_core\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;
use Zend\Form\ElementInterface;
use Zend\Form\Exception;

class filemanagerHelper extends AbstractHelper
{
    /**
     * Invoke helper as functor
     *
     * Proxies to {@link render()}.
     *
     * @param  ElementInterface|null $element
     * @return string|FormTextarea
     */
    public function __invoke(ElementInterface $element = null)
    {
        if (!$element) {
            return $this;
        }

        return $this->render($element);
    }

    /**
     * Render a form <textarea> element from the provided $element
     *
     * @param  ElementInterface $element
     * @throws Exception\DomainException
     * @return string
     */
    public function render(ElementInterface $element)
    {
        $name   = $element->getName();
        if (empty($name) && $name !== 0) {
            throw new Exception\DomainException(sprintf(
                '%s requires that the element has an assigned name; none discovered',
                __METHOD__
            ));
        }

        $attributes         = $element->getAttributes();
        $attributes['name'] = $name;
        $content            = (string) $element->getValue();
        $escapeHtml         = $this->getEscapeHtmlHelper();

        return sprintf(
            '<div class="filemanager_element"><input type="hidden" %s value="%s" name="%s">
                <a href="javascript:;" class="filemanager-unset">Unset</a>
                <a href="javascript:;" class="filemanager-preview">Preview</a>
                <a href="javascript:;" class="filemanager-open">Pick File</a>
                <span>%s</span></div>'.
            "<div id='dlg_preview' class='easyui-dialog' title='&nbsp;Preview' data-options='iconCls:\"icon-help\"' style='width:350px;height:300px;padding:10px;'>
</div>",
            $this->createAttributesString($attributes),
            $escapeHtml($content),
            $name,
            $escapeHtml($content)
        );
    }
}
