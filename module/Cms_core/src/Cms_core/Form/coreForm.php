<?php

namespace Cms_core\Form;
 
use Zend\Form\Form;
use Zend\Form\Element;

//Core Form Loader, load dynamice template
class coreForm extends Form
{
    private $_groups;//array
    
    public function __construct($_name)
    {
        // we want to ignore the name passed
        parent::__construct($_name);
    }
    
    //add with group
    public function add($elementOrFieldset, array $flags = array())
    {
        parent::add($elementOrFieldset, $flags);
        $groupName = isset($elementOrFieldset['group'])?$elementOrFieldset['group']:"default@@@Main Content";
        $this->_groups[$groupName][] = $elementOrFieldset['name'];
    }
    
    public function groups()
    {
        return $this->_groups;
    }
    
    public function loadTemplate($customizeFields=array(), $dbAdapter=null)
    {
        /* Structure Sample
        $customizeFields = array(
            array(
                "field_name" => "test2",
                "type" => "text",
                "label" => "Hello",
                "description" => "Desc here",
                "required" => false,
                "placeholder" => "hello",
                "default" => "1234",
            ),
        );
         * 
         */
        
        //Redner customized fields in form
        foreach($customizeFields as $_item){
            if(!is_array($_item)) continue;
            switch($_item['type']){
                case "text":
                    $this->add(array(
                        'name' => $_item['field_name'],
                        'type'  => 'Zend\Form\Element\Text',
                        'attributes' => array(
                            'placeholder' => @$_item['placeholder'],
                            'required' => @$_item['required'],
                            'class' => @$_item['class'],
                            'description' => @$_item['description'],
                            'id' => $_item['field_name'],
                            'value' => @$_item['default'],
                        ),
                        'options' => array(
                            'label' => $_item['label'],
                        ),
                    ));
                    break;
                case "select":
                    $this->add(array(
                        'name' => $_item['field_name'],
                        'type' => 'Zend\Form\Element\Select',
                        'attributes' => array(
                            'value' => @$_item['default'],
                            'required' => @$_item['required'],
                            'class' => @$_item['class'],
                            'description' => @$_item['description'],
                        ),
                        'options' => array(
                            'label' => $_item['label'],
                            'value_options' => $_item['options'],
                        ),
                    ));
                    break;
                case "select_by_ref":
                    //retrieve ref-data
                    $arrDataKeys = explode(":", $_item['options_ref']);//[0]TableRef [1]key field [2]display field
                    $sql = "select {$arrDataKeys[1]}, {$arrDataKeys[2]} from {$arrDataKeys[0]}";
                    $statement = $dbAdapter->query($sql);
                    $result = $statement->execute();
                    $arrDatas = array("" => "(Not selected)");
                    foreach ($result as $res) {
                        $arrDatas[$res[$arrDataKeys[1]]] = $res[$arrDataKeys[2]];
                    }
                    $arrRefData = $arrDatas;
                    //retrieve ref-data(END)
                    $this->add(array(
                        'name' => $_item['field_name'],
                        'type' => 'Zend\Form\Element\Select',
                        'attributes' => array(
                            'value' => @$_item['default'],
                            'required' => @$_item['required'],
                            'class' => @$_item['class'],
                            'description' => @$_item['description'],
                        ),
                        'options' => array(
                            'label' => $_item['label'],
                            'value_options' => $arrRefData,
                        ),
                    ));
                    break;
                case "radio":
                    $this->add(array(
                        'name' => $_item['field_name'],
                        'type' => 'Zend\Form\Element\Radio',
                        'attributes' => array(
                            'value' => @$_item['default'],
                            'required' => @$_item['required'],
                            'class' => @$_item['class'],
                            'description' => @$_item['description'],
                        ),
                        'options' => array(
                            'label' => $_item['label'],
                            'value_options' => $_item['options'],
                        ),
                    ));
                    break;
                case "checkbox":
                    $this->add(array(
                        'name' => $_item['field_name'],
                        'type' => 'Zend\Form\Element\Checkbox',
                        'attributes' => array(
                            'value' => @$_item['default'],
                            'required' => @$_item['required'],
                            'class' => @$_item['class'],
                            'description' => @$_item['description'],
                        ),
                        'options' => array(
                            'label' => $_item['label'],
                            'use_hidden_element' => true,
                            'checked_value' => '1',
                            'unchecked_value' => '0'
                        )
                    ));
                    break;
                case "multicheckbox":
                    $this->add(array(
                        'name' => $_item['field_name'],
                        'type' => 'Zend\Form\Element\MultiCheckbox',
                        'attributes' => array(
                            'value' => @$_item['default'],
                            'required' => @$_item['required'],
                            'class' => @$_item['class'],
                            'description' => @$_item['description'],
                        ),
                        'options' => array(
                            'label' => $_item['label'],
                            'value_options' => $_item['options'],
                        )
                    ));
                    break;
                case "textarea":
                    $this->add(array(
                        'name' => $_item['field_name'],
                        'type'=>'textarea',
                        'attributes'=>array(
                            'value' => @$_item['default'],
                            'required' => @$_item['required'],
                            'class' => @$_item['class'],
                            'description' => @$_item['description'],
                        ),
                        'options' => array(
                            'label' => $_item['label'],
                        ),
                    ));
                    if(isset($_item['dimension'])){
                        $_tmp = explode("x", $_item['dimension']);
                        $this->get($_item['field_name'])->setAttribute('cols', $_tmp[0]);
                        $this->get($_item['field_name'])->setAttribute('rows', $_tmp[1]);
                    }
                    break;
                case "htmleditor":
                    $this->add(array(
                        'name' => $_item['field_name'],
                        'type'=>'textarea',
                        'attributes'=>array(
                            'value' => @$_item['default'],
                            'required' => @$_item['required'],
                            'class' => "redactor",
                            'description' => @$_item['description'],
                        ),
                        'options' => array(
                            'label' => $_item['label'],
                        ),
                    ));
                    if(isset($_item['dimension'])){
                        $_tmp = explode("x", $_item['dimension']);
                        $this->get($_item['field_name'])->setAttribute('cols', $_tmp[0]);
                        $this->get($_item['field_name'])->setAttribute('rows', $_tmp[1]);
                    }
                    break;
                case "date":
                    $this->add(array(
                        'name' => $_item['field_name'],
                        'type' => 'Zend\Form\Element\Date',
                        'attributes' => array(
                            'value' => @$_item['default'],
                            'required' => @$_item['required'],
                            'class' => @$_item['class'],
                            'description' => @$_item['description'],
                        ),
                        'options' => array(
                            'label' => $_item['label'],
                        ),
                    ));
                    break;
                case "filemanager":
                    $long_desc = $_item['description'];
                    if($_item['dimension']) $long_desc .= " ({$_item['dimension']})";//Cat additional text
                    $this->add(array(
                        'name' => $_item['field_name'],
                        'type' => 'Cms_core\Form\Element\Filemanager',
                        'attributes' => array(
                            'value' => @$_item['default'],
                            'required' => @$_item['required'],
                            'class' => "filemanager_element ".@$_item['class'],
                            'description' => @$long_desc,
                        ),
                        'options' => array(
                            'label' => $_item['label'],
                        ),
                    ));
                    break;
                case "hidden":
                    $this->add(array(
                        'name' => $_item['field_name'],
                        'type'  => 'hidden',
                        'attributes' => array(
                            'value' => @$_item['default'],
                        ),
                    ));
                    break;
            }
        }
        //Redner customized fields in form(END)
        
        return $this;
    }
}