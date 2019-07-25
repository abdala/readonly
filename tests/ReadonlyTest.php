<?php

declare(strict_types=1);

namespace Tests\Abdala;

use Abdala\Readonly;
use Abdala\InvalidProperty;
use Abdala\InvalidVisibility;
use Abdala\RequiredProperty;
use Abdala\ReadonlyProperty;
use Abdala\NotFinalClass;
use PHPUnit\Framework\Error\Notice;
use PHPUnit\Framework\TestCase;
use TypeError;
use stdClass;

class ReadonlyTest extends TestCase
{
    public function test_it_can_set_attributes_values_without_a_contructor()
    {
        $email = new EmailTest('abdala@email.com');

        self::assertEquals('abdala@email.com', $email->value);
    }

    public function test_attributes_are_readonly()
    {
        $email = new EmailTest('abdala@email.com');

        self::expectException(ReadonlyProperty::class);

        $email->value = 'abdala@gemail.com';
    }

    public function test_notice_on_undefined_property()
    {
        $email = new EmailTest('abdala@email.com');

        self::expectException(Notice::class);

        $email->invalid;
    }

    public function test_it_continues_to_verify_attributes_type()
    {
        self::expectException(TypeError::class);

        $email = new EmailTest(42);
    }

    public function test_it_check_for_required_values()
    {
        self::expectException(RequiredProperty::class);

        new EmailTest();
    }

    public function test_it_allows_default_values()
    {
        $email = new EmailTest('abdala@email.com');
        $user = new UserTest('Abdala', $email);

        self::assertEquals('active', $user->status);
        self::assertNull($user->picture);
    }

    public function test_it_only_allows_non_scalar_values_that_are_readonly()
    {
        self::expectException(InvalidProperty::class);

        new InvalidClassTest(new stdClass);
    }

    public function test_class_should_always_be_final()
    {
        self::expectException(NotFinalClass::class);

        new NotFinalClassTest();
    }

    public function test_class_should_not_contain_public_properties()
    {
        self::expectException(InvalidVisibility::class);

        new PublicPropertyClassTest();
    }
}

final class UserTest
{
    use Readonly;

    private string $name;

    private EmailTest $email;

    private string $status = 'active';

    private ?string $picture;
}

final class EmailTest
{
    use Readonly;

    private string $value;
}

class NotFinalClassTest
{
    use Readonly;
}

final class InvalidClassTest
{
    use Readonly;

    private stdClass $nonReadonly;
}

final class PublicPropertyClassTest
{
    use Readonly;

    public string $invalid;
}
