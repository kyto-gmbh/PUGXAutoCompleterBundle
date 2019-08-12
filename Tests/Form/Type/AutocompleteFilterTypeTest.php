<?php

namespace PUGX\AutocompleterBundle\Tests\Form\Type;

use PUGX\AutocompleterBundle\Form\Type\AutocompleteFilterType;

class AutocompleteFilterTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testGetBlockPrefix()
    {
        $registry = $this->getMock('Doctrine\Common\Persistence\ManagerRegistry');
        $type = new AutocompleteFilterType($registry);
        $this->assertEquals('filter_autocomplete', $type->getBlockPrefix());
    }
}
