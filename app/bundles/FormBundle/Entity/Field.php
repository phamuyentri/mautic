<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic Contributors. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.org
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Mautic\FormBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Mautic\CoreBundle\Doctrine\Mapping\ClassMetadataBuilder;

/**
 * Class Field
 *
 * @package Mautic\FormBundle\Entity
 *
 * @Serializer\ExclusionPolicy("all")
 */
class Field
{

    /**
     * @var int
     *
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"formDetails"})
     */
    private $id;

    /**
     * @var string
     *
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"formDetails"})
     */
    private $label;

    /**
     * @var bool
     *
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"formDetails"})
     */
    private $showLabel = true;

    /**
     * @var string
     *
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"formDetails"})
     */
    private $alias;

    /**
     * @var string
     *
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"formDetails"})
     */
    private $type;

    /**
     * @var bool
     */
    private $isCustom = false;

    /**
     * @var array
     */
    private $customParameters = array();

    /**
     * @var string
     *
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"formDetails"})
     */
    private $defaultValue;

    /**
     * @var bool
     *
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"formDetails"})
     */
    private $isRequired = false;

    /**
     * @var string
     *
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"formDetails"})
     */
    private $validationMessage;

    /**
     * @var string
     *
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"formDetails"})
     */
    private $helpMessage;

    /**
     * @var int
     *
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"formDetails"})
     */
    private $order = 0;

    /**
     * @var array
     *
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"formDetails"})
     */
    private $properties = array();

    /**
     * @var Form
     */
    private $form;

    /**
     * @var string
     *
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"formDetails"})
     */
    private $labelAttributes;

    /**
     * @var string
     *
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"formDetails"})
     */
    private $inputAttributes;

    /**
     * @var array
     */
    private $changes;

    /**
     * @var
     */
    private $sessionId;

    /**
     * @param ORM\ClassMetadata $metadata
     */
    public static function loadMetadata (ORM\ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('form_fields')
            ->setCustomRepositoryClass('Mautic\FormBundle\Entity\FieldRepository');

        $builder->addId();

        $builder->addField('label', 'string');

        $builder->createField('showLabel', 'boolean')
            ->columnName('show_label')
            ->nullable()
            ->build();

        $builder->addField('alias', 'string');

        $builder->addField('type', 'string');

        $builder->createField('isCustom', 'boolean')
            ->columnName('is_custom')
            ->build();

        $builder->createField('customParameters', 'array')
            ->columnName('custom_parameters')
            ->nullable()
            ->build();

        $builder->createField('defaultValue', 'string')
            ->columnName('default_value')
            ->nullable()
            ->build();

        $builder->createField('isRequired', 'boolean')
            ->columnName('is_required')
            ->build();

        $builder->createField('validationMessage', 'string')
            ->columnName('validation_message')
            ->nullable()
            ->build();

        $builder->createField('helpMessage', 'string')
            ->columnName('help_message')
            ->nullable()
            ->build();

        $builder->createField('order', 'integer')
            ->columnName('field_order')
            ->build();

        $builder->addField('properties', 'array');

        $builder->createManyToOne('form', 'Form')
            ->inversedBy('actions')
            ->addJoinColumn('form_id', 'id', false, false, 'CASCADE')
            ->build();

        $builder->createField('labelAttributes', 'string')
            ->columnName('label_attributes')
            ->nullable()
            ->build();

        $builder->createField('inputAttributes', 'string')
            ->columnName('input_attributes')
            ->nullable()
            ->build();


    }

    /**
     * @param $prop
     * @param $val
     *
     * @return void
     */
    private function isChanged ($prop, $val)
    {
        if ($this->$prop != $val) {
            $this->changes[$prop] = array($this->$prop, $val);
        }
    }

    /**
     * @return array
     */
    public function getChanges ()
    {
        return $this->changes;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId ()
    {
        return $this->id;
    }

    /**
     * Set label
     *
     * @param string $label
     *
     * @return Field
     */
    public function setLabel ($label)
    {
        $this->isChanged('label', $label);
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel ()
    {
        return $this->label;
    }

    /**
     * Set alias
     *
     * @param string $alias
     *
     * @return Field
     */
    public function setAlias ($alias)
    {
        $this->isChanged('alias', $alias);
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias ()
    {
        return $this->alias;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Field
     */
    public function setType ($type)
    {
        $this->isChanged('type', $type);
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType ()
    {
        return $this->type;
    }

    /**
     * Set defaultValue
     *
     * @param string $defaultValue
     *
     * @return Field
     */
    public function setDefaultValue ($defaultValue)
    {
        $this->isChanged('defaultValue', $defaultValue);
        $this->defaultValue = $defaultValue;

        return $this;
    }

    /**
     * Get defaultValue
     *
     * @return string
     */
    public function getDefaultValue ()
    {
        return $this->defaultValue;
    }

    /**
     * Set isRequired
     *
     * @param boolean $isRequired
     *
     * @return Field
     */
    public function setIsRequired ($isRequired)
    {
        $this->isChanged('isRequired', $isRequired);
        $this->isRequired = $isRequired;

        return $this;
    }

    /**
     * Get isRequired
     *
     * @return boolean
     */
    public function getIsRequired ()
    {
        return $this->isRequired;
    }

    /**
     * Proxy function to getIsRequired
     *
     * @return bool
     */
    public function isRequired ()
    {
        return $this->getIsRequired();
    }

    /**
     * Set order
     *
     * @param integer $order
     *
     * @return Field
     */
    public function setOrder ($order)
    {
        $this->isChanged('order', $order);
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer
     */
    public function getOrder ()
    {
        return $this->order;
    }

    /**
     * Set properties
     *
     * @param array $properties
     *
     * @return Field
     */
    public function setProperties ($properties)
    {
        $this->isChanged('properties', $properties);
        $this->properties = $properties;

        return $this;
    }

    /**
     * Get properties
     *
     * @return array
     */
    public function getProperties ()
    {
        return $this->properties;
    }

    /**
     * Set validationMessage
     *
     * @param string $validationMessage
     *
     * @return Field
     */
    public function setValidationMessage ($validationMessage)
    {
        $this->isChanged('validationMessage', $validationMessage);
        $this->validationMessage = $validationMessage;

        return $this;
    }

    /**
     * Get validationMessage
     *
     * @return string
     */
    public function getValidationMessage ()
    {
        return $this->validationMessage;
    }

    /**
     * Set form
     *
     * @param Form $form
     *
     * @return Field
     */
    public function setForm (Form $form)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * Get form
     *
     * @return Form
     */
    public function getForm ()
    {
        return $this->form;
    }

    /**
     * Set labelAttributes
     *
     * @param string $labelAttributes
     *
     * @return Field
     */
    public function setLabelAttributes ($labelAttributes)
    {
        $this->isChanged('labelAttributes', $labelAttributes);
        $this->labelAttributes = $labelAttributes;

        return $this;
    }

    /**
     * Get labelAttributes
     *
     * @return string
     */
    public function getLabelAttributes ()
    {
        return $this->labelAttributes;
    }

    /**
     * Set inputAttributes
     *
     * @param string $inputAttributes
     *
     * @return Field
     */
    public function setInputAttributes ($inputAttributes)
    {
        $this->isChanged('inputAttributes', $inputAttributes);
        $this->inputAttributes = $inputAttributes;

        return $this;
    }

    /**
     * Get inputAttributes
     *
     * @return string
     */
    public function getInputAttributes ()
    {
        return $this->inputAttributes;
    }

    /**
     * @return array
     */
    public function convertToArray ()
    {
        return get_object_vars($this);
    }

    /**
     * Set showLabel
     *
     * @param boolean $showLabel
     *
     * @return Field
     */
    public function setShowLabel ($showLabel)
    {
        $this->isChanged('showLabel', $showLabel);
        $this->showLabel = $showLabel;

        return $this;
    }

    /**
     * Get showLabel
     *
     * @return boolean
     */
    public function getShowLabel ()
    {
        return $this->showLabel;
    }

    /**
     * Proxy function to getShowLabel()
     *
     * @return bool
     */
    public function showLabel ()
    {
        return $this->getShowLabel();
    }

    /**
     * Set helpMessage
     *
     * @param string $helpMessage
     *
     * @return Field
     */
    public function setHelpMessage ($helpMessage)
    {
        $this->isChanged('helpMessage', $helpMessage);
        $this->helpMessage = $helpMessage;

        return $this;
    }

    /**
     * Get helpMessage
     *
     * @return string
     */
    public function getHelpMessage ()
    {
        return $this->helpMessage;
    }

    /**
     * Set isCustom
     *
     * @param boolean $isCustom
     *
     * @return Field
     */
    public function setIsCustom ($isCustom)
    {
        $this->isCustom = $isCustom;

        return $this;
    }

    /**
     * Get isCustom
     *
     * @return boolean
     */
    public function getIsCustom ()
    {
        return $this->isCustom;
    }

    /**
     * Proxy function to getIsCustom()
     *
     * @return bool
     */
    public function isCustom ()
    {
        return $this->getIsCustom();
    }

    /**
     * Set customParameters
     *
     * @param array $customParameters
     *
     * @return Field
     */
    public function setCustomParameters ($customParameters)
    {
        $this->customParameters = $customParameters;

        return $this;
    }

    /**
     * Get customParameters
     *
     * @return array
     */
    public function getCustomParameters ()
    {
        return $this->customParameters;
    }

    /**
     * @return mixed
     */
    public function getSessionId ()
    {
        return $this->sessionId;
    }

    /**
     * @param mixed $sessionId
     */
    public function setSessionId ($sessionId)
    {
        $this->sessionId = $sessionId;
    }
}
