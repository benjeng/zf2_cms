<?php

namespace Cms_core\Form\Element;

use Zend\Form\Element;
use Zend\InputFilter\InputProviderInterface;
use Zend\Validator\Regex as RegexValidator;

class Filemanager extends Element implements InputProviderInterface
{
    protected $attributes = array(
        'type' => 'filemanager',
    );
    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
    * Get a validator if none has been set.
    *
    * @return ValidatorInterface
    */
    public function getValidator()
    {
        if (null === $this->validator) {
//            $validator = new RegexValidator('/^\+?\d{11,12}$/');
            $validator = new RegexValidator('/^[.]*$/');
            $validator->setMessage('Please enter string!',
                                    RegexValidator::NOT_MATCH);

            $this->validator = $validator;
        }

        return $this->validator;
    }

    /**
     * Sets the validator to use for this element
     *
     * @param  ValidatorInterface $validator
     * @return Application\Form\Element\Phone
     */
    public function setValidator(ValidatorInterface $validator)
    {
        $this->validator = $validator;
        return $this;
    }

    /**
     * Provide default input rules for this element
     *
     * Attaches a phone number validator.
     *
     * @return array
     */
    public function getInputSpecification()
    {
        return array(
            'name' => $this->getName(),
            'required' => false,
            'filters' => array(
                array('name' => 'Zend\Filter\StringTrim'),
            ),
//            'validators' => array(
//                $this->getValidator(),
//            ),
        );
    }
}