<?php
namespace Cms_core\View\Helper;
 
use Zend\Http\Request;
use Zend\View\Helper\AbstractHelper;

use Zend\Form\View\Helper\Form as zf_form;
 
class formHelper extends AbstractHelper
{
    protected $request;
 
    public function __construct()
    {
    }
 
    public function __invoke()
    {
        return $this;
    }
    
    public function renderEditForm($form, $parent)
    {
        $result = "";
        $form->prepare();
        $formGroups = $form->groups();
        $result .= $parent->form()->openTag($form);
        foreach($formGroups as $group_name => $_group){
            $_tmp = explode("@@@", $group_name);//[0]Name [1]Legend
            $result .= "<fieldset id='{$_tmp[0]}'><legend>{$_tmp[1]}</legend>";
            foreach($_group as $_fieldName){
                $element = $form->get($_fieldName);
                if($_tmp[0] != '_control') $result .= "<div>";
            //    echo $this->formRow($element);
                $label = ($element->getAttribute('type')!='hidden')?$parent->formLabel($element):"";
                switch($element->getAttribute('type')){
                    default:
                    case "text":$result .= $label.$parent->formInput($element);break;
                    case "select":$result .= $label.$parent->formSelect($element);break;
                    case "radio":$result .= $label.$parent->formRadio($element);break;
                    case "textarea":$result .= $label.$parent->formTextarea($element);break;
                    case "htmleditor":$result .= $label.$parent->formTextarea($element);break;
                    case "checkbox":$result .= $label.$parent->formCheckbox($element);break;
                    case "multi_checkbox":$result .= $label.$parent->formMultiCheckbox($element);break;
                    case "date":$result .= $label.$parent->formDate($element);break;
                    case "filemanager":$result .= $label.$parent->formFilemanager($element);break;
                    case "button":$result .= $parent->formButton($element);break;
                    case "submit":$result .= $parent->formSubmit($element);break;
                }
                $result .= $parent->formElementErrors($element);
                if($_tmp[0] != '_control'){
                    $result .= "<p class='hint'>".$element->getAttribute('description')."</p>";
                    $result .= "</div>\n";
                }
            }
            $result .= "</fieldset>";
        }
        $result .= $parent->form()->closeTag();
        return $result;
    }
    
    public function renderAddForm($form, $parent)
    {
        $form->prepare();
        $formGroups = $form->groups();

        $result = $parent->form()->openTag($form);
        foreach($formGroups as $group_name => $_group){
            $_tmp = explode("@@@", $group_name);//[0]Name [1]Legend
            $result .= "<fieldset><legend>{$_tmp[1]}</legend>";
            foreach($_group as $_fieldName){
                $element = $form->get($_fieldName);
                if($_tmp[0] != '_control') $result .= "<div>";
            //    $result .= $this->formRow($element);
                $label = ($element->getAttribute('type')!='hidden')?$parent->formLabel($element):"";
                switch($element->getAttribute('type')){
                    default:
                    case "text":$result .= $label.$parent->formInput($element);break;
                    case "select":$result .= $label.$parent->formSelect($element);break;
                    case "radio":$result .= $label.$parent->formRadio($element);break;
                    case "textarea":$result .= $label.$parent->formTextarea($element);break;
                    case "htmleditor":$result .= $label.$parent->formTextarea($element);break;
                    case "checkbox":$result .= $label.$parent->formCheckbox($element);break;
                    case "multi_checkbox":$result .= $label.$parent->formMultiCheckbox($element);break;
                    case "button":$result .= $parent->formButton($element);break;
                    case "submit":$result .= $parent->formSubmit($element);break;
                }
                $result .= $parent->formElementErrors($element);
                if($_tmp[0] != '_control'){
                    $result .= "<p class='hint'>".$element->getAttribute('description')."</p>";
                    $result .= "</div>\n";
                }
            }
            $result .= "</fieldset>";
        }
        $result .= $parent->form()->closeTag();
        return $result;
    }
}