<?php

namespace PUGX\AutocompleterBundle\Tests\Form\Type;

use PUGX\AutocompleterBundle\Form\Type\AutocompleteType;

class AutocompleteTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildForm()
    {
        $registry = $this->getMock('Doctrine\Common\Persistence\ManagerRegistry');
        $builder = $this->getMockBuilder('Symfony\Component\Form\FormBuilder')->disableOriginalConstructor()->getMock();
        $transformer = $this->getMockBuilder('PUGX\AutocompleterBundle\Tests\Form\Transformer\ObjectToIdTransformer')->disableOriginalConstructor()->getMock();
        $builder->expects($this->exactly(1))->method('addModelTransformer');

        $type = new AutocompleteType($registry);
        $options = array('class' => 'Foo');
        $type->buildForm($builder, $options);
    }

    /**
     * @expectedException Symfony\Component\Form\Exception\InvalidConfigurationException
     */
    public function testBuildFormException()
    {
        $registry = $this->getMock('Doctrine\Common\Persistence\ManagerRegistry');
        $builder = $this->getMockBuilder('Symfony\Component\Form\FormBuilder')->disableOriginalConstructor()->getMock();

        $type = new AutocompleteType($registry);
        $options = array();
        $type->buildForm($builder, $options);
    }

    public function testSetDefaultOptions()
    {
        $registry = $this->getMock('Doctrine\Common\Persistence\ManagerRegistry');
        $resolver = $this->getMock('Symfony\Component\OptionsResolver\OptionsResolver');
        $resolver->expects($this->once())->method('setDefaults');

        $type = new AutocompleteType($registry);
        $type->configureOptions($resolver);
    }

    public function testGetParent()
    {
        $registry = $this->getMock('Doctrine\Common\Persistence\ManagerRegistry');
        $type = new AutocompleteType($registry);
        if (!method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix')) {
            $this->assertEquals('text', $type->getParent());
        } else {
            $this->assertEquals('Symfony\Component\Form\Extension\Core\Type\TextType', $type->getParent());
        }
    }

    public function testGetBlockPrefix()
    {
        $registry = $this->getMock('Doctrine\Common\Persistence\ManagerRegistry');
        $type = new AutocompleteType($registry);
        $this->assertEquals('autocomplete', $type->getBlockPrefix());
    }
}
