<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace Tests\Unit\Core\ConstraintValidator;

use PHPUnit\Framework\MockObject\MockObject;
use PrestaShop\PrestaShop\Core\ConstraintValidator\Constraints\TypedRegex;
use PrestaShop\PrestaShop\Core\ConstraintValidator\TypedRegexValidator;
use PrestaShop\PrestaShop\Core\String\CharacterCleaner;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class TypedRegexValidatorTest extends ConstraintValidatorTestCase
{
    public function testItSucceedsForNameTypeWhenValidCharactersGiven()
    {
        $value = 'goodname';
        $this->validator->validate($value, new TypedRegex(['type' => 'name']));

        $this->assertNoViolation();
    }

    /**
     * @dataProvider getInvalidCharactersForNameType
     */
    public function testItFailsForNameTypeWhenInvalidCharacterGiven($invalidChar)
    {
        $this->validator->validate($invalidChar, new TypedRegex(['type' => 'name']));

        $this->buildViolation((new TypedRegex(['type' => 'name']))->message)
            ->setParameter('%s', '"' . $invalidChar . '"')
            ->assertRaised()
        ;
    }

    public function testItSucceedsForCatalogNameTypeWhenValidCharactersGiven()
    {
        $value = 'catalog name';
        $this->validator->validate($value, new TypedRegex(['type' => 'catalog_name']));

        $this->assertNoViolation();
    }

    /**
     * @dataProvider getInvalidCharactersForCatalogNameType
     */
    public function testItFailsForCatalogNameTypeWhenInvalidCharacterGiven($invalidChar)
    {
        $this->validator->validate($invalidChar, new TypedRegex(['type' => 'catalog_name']));

        $this->buildViolation((new TypedRegex(['type' => 'catalog_name']))->message)
            ->setParameter('%s', '"' . $invalidChar . '"')
            ->assertRaised()
        ;
    }

    public function testItSucceedsForGenericNameTypeWhenValidCharactersGiven()
    {
        $value = 'good generic name /';
        $this->validator->validate($value, new TypedRegex(['type' => 'generic_name']));

        $this->assertNoViolation();
    }

    /**
     * @dataProvider getInvalidCharactersForGenericNameType
     */
    public function testItFailsForGenericNameTypeWhenInvalidCharacterGiven($invalidChar)
    {
        $this->validator->validate($invalidChar, new TypedRegex(['type' => 'generic_name']));

        $this->buildViolation((new TypedRegex(['type' => 'catalog_name']))->message)
            ->setParameter('%s', '"' . $invalidChar . '"')
            ->assertRaised()
        ;
    }

    public function testItSucceedsForCityNameTypeWhenValidCharactersGiven()
    {
        $value = 'London';
        $this->validator->validate($value, new TypedRegex(['type' => 'city_name']));

        $this->assertNoViolation();
    }

    /**
     * @dataProvider getInvalidCharactersForCityNameType
     */
    public function testItFailsForCityNameTypeWhenInvalidCharacterGiven($invalidChar)
    {
        $this->validator->validate($invalidChar, new TypedRegex(['type' => 'city_name']));

        $this->buildViolation((new TypedRegex(['type' => 'city_name']))->message)
            ->setParameter('%s', '"' . $invalidChar . '"')
            ->assertRaised()
        ;
    }

    public function testItSucceedsForAddressTypeWhenValidCharactersGiven()
    {
        $value = '3197 Hillview Drive';
        $this->validator->validate($value, new TypedRegex(['type' => 'address']));

        $this->assertNoViolation();
    }

    /**
     * @dataProvider getInvalidCharactersForAddressType
     */
    public function testItFailsForAddressTypeWhenInvalidCharacterGiven($invalidChar)
    {
        $this->validator->validate($invalidChar, new TypedRegex(['type' => 'address']));

        $this->buildViolation((new TypedRegex(['type' => 'address']))->message)
            ->setParameter('%s', '"' . $invalidChar . '"')
            ->assertRaised()
        ;
    }

    public function testItSucceedsForPostCodeTypeWhenValidCharactersGiven()
    {
        $value = '94103';
        $this->validator->validate($value, new TypedRegex(['type' => 'post_code']));

        $this->assertNoViolation();
    }

    /**
     * @dataProvider getInvalidCharactersForPostCodeType
     */
    public function testItFailsForPostCodeTypeWhenInvalidCharacterGiven($invalidChar)
    {
        $this->validator->validate($invalidChar, new TypedRegex(['type' => 'post_code']));

        $this->buildViolation((new TypedRegex(['type' => 'post_code']))->message)
            ->setParameter('%s', '"' . $invalidChar . '"')
            ->assertRaised()
        ;
    }

    public function testItSucceedsForPhoneNumberTypeWhenValidCharactersGiven()
    {
        $value = '707-216-7924';
        $this->validator->validate($value, new TypedRegex(['type' => 'phone_number']));

        $this->assertNoViolation();
    }

    /**
     * @dataProvider getInvalidCharactersForPhoneNumberType
     */
    public function testItFailsForPhoneNumberTypeWhenInvalidCharacterGiven($invalidChar)
    {
        $this->validator->validate($invalidChar, new TypedRegex(['type' => 'phone_number']));

        $this->buildViolation((new TypedRegex(['type' => 'phone_number']))->message)
            ->setParameter('%s', '"' . $invalidChar . '"')
            ->assertRaised()
        ;
    }

    public function testItSucceedsForMessageTypeWhenValidCharactersGiven()
    {
        $value = 'some random message #)F@$. ';
        $this->validator->validate($value, new TypedRegex(['type' => 'message']));

        $this->assertNoViolation();
    }

    /**
     * @dataProvider getInvalidCharactersForMessageType
     */
    public function testItFailsForMessageTypeWhenInvalidCharacterGiven($invalidChar)
    {
        $this->validator->validate($invalidChar, new TypedRegex(['type' => 'message']));

        $this->buildViolation((new TypedRegex(['type' => 'message']))->message)
            ->setParameter('%s', '"' . $invalidChar . '"')
            ->assertRaised()
        ;
    }

    public function testItSucceedsForLanguageIsoCodeTypeWhenValidCharactersGiven()
    {
        $value = 'US';
        $this->validator->validate($value, new TypedRegex(['type' => 'language_iso_code']));

        $this->assertNoViolation();
    }

    /**
     * @dataProvider getInvalidCharactersForLanguageIsoCodeType
     */
    public function testItFailsForLanguageIsoCodeTypeWhenInvalidCharacterGiven($invalidChar)
    {
        $this->validator->validate($invalidChar, new TypedRegex(['type' => 'language_iso_code']));

        $this->buildViolation((new TypedRegex(['type' => 'language_iso_code']))->message)
            ->setParameter('%s', '"' . $invalidChar . '"')
            ->assertRaised()
        ;
    }

    public function testItSucceedsForLanguageCodeTypeWhenValidCharactersGiven()
    {
        $value = 'lt-LT';
        $this->validator->validate($value, new TypedRegex(['type' => 'language_code']));

        $this->assertNoViolation();
    }

    /**
     * @dataProvider getInvalidCharactersForLanguageCodeType
     */
    public function testItFailsForLanguageCodeTypeWhenInvalidCharacterGiven($invalidChar)
    {
        $this->validator->validate($invalidChar, new TypedRegex(['type' => 'language_code']));

        $this->buildViolation((new TypedRegex(['type' => 'language_code']))->message)
            ->setParameter('%s', '"' . $invalidChar . '"')
            ->assertRaised()
        ;
    }

    /**
     * @return array
     */
    public function getInvalidCharactersForNameType()
    {
        return [
            ['0'], ['2'], ['<'], ['>'], ['?'], ['#'], ['%'], [','], [';'], ['+'], ['??'], [':'], ['!'], ['='], ['#'],
            ['"'], ['$'], ['}'], ['{'], ['@'], ['|'],
        ];
    }

    /**
     * @return array
     */
    public function getInvalidCharactersForCatalogNameType()
    {
        return [
            ['<'], ['>'], [';'], ['='], ['#'], ['{'], ['}'],
        ];
    }

    /**
     * @return array
     */
    public function getInvalidCharactersForGenericNameType()
    {
        return [
            ['<'], ['>'], ['='], ['{'], ['}'],
        ];
    }

    /**
     * @return array
     */
    public function getInvalidCharactersForCityNameType()
    {
        return [
            ['!'], ['>'], ['<'], [';'], ['?'], ['='], ['+'], ['@'], ['#'], ['"'], ['??'], ['{'], ['}'], ['_'],
            ['$'], ['%'],
        ];
    }

    /**
     * @return array
     */
    public function getInvalidCharactersForAddressType()
    {
        return [
            ['!'], ['>'], ['<'], ['?'], ['='], ['+'], ['@'], ['{'], ['}'], ['_'], ['$'], ['%'],
        ];
    }

    /**
     * @return array
     */
    public function getInvalidCharactersForPostCodeType()
    {
        return [
            ['<'], ['>'], ['?'], ['#'], ['%'], [','], [';'], ['+'], ['??'], [':'], ['!'], ['='], ['#'],
            ['"'], ['$'], ['}'], ['{'], ['@'], ['|'], ['??'], ['??'],
        ];
    }

    /**
     * @return array
     */
    public function getInvalidCharactersForPhoneNumberType()
    {
        return [
            ['<'], ['>'], ['?'], ['#'], ['%'], [','], [';'], ['??'], [':'], ['!'], ['='], ['#'],
            ['"'], ['$'], ['}'], ['{'], ['@'], ['|'], ['??'], ['??'], ['r'],
        ];
    }

    public function getInvalidCharactersForMessageType()
    {
        return [
            ['<'], ['>'], ['{'], ['}'],
        ];
    }

    public function getInvalidCharactersForLanguageIsoCodeType()
    {
        return [
            ['a'], ['??'], ['abcd'], ['2'], ['26'], ['ABCE'],
        ];
    }

    public function getInvalidCharactersForLanguageCodeType()
    {
        return [
            ['az-acc'], ['1'], ['12-22'], ['??i-as'],
        ];
    }

    protected function createValidator()
    {
        return new TypedRegexValidator($this->createCharacterCleanersMock());
    }

    /**
     * @return MockObject|CharacterCleaner
     */
    private function createCharacterCleanersMock()
    {
        $toolsMock = $this->getMockBuilder(CharacterCleaner::class)
            ->disableOriginalConstructor()
            ->getMock();
        $toolsMock
            ->method('cleanNonUnicodeSupport')
            ->will($this->returnArgument(0));

        return $toolsMock;
    }
}
