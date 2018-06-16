<?php

namespace Railken\LaraOre\RecurringService\Attributes\Country;

use Railken\Laravel\Manager\Attributes\BaseAttribute;
use Railken\Laravel\Manager\Contracts\EntityContract;
use Railken\Laravel\Manager\Tokens;
use Respect\Validation\Validator as v;

class CountryAttribute extends BaseAttribute
{
    /**
     * Name attribute.
     *
     * @var string
     */
    protected $name = 'country';

    /**
     * Is the attribute required
     * This will throw not_defined exception for non defined value and non existent model.
     *
     * @var bool
     */
    protected $required = true;

    /**
     * Is the attribute unique.
     *
     * @var bool
     */
    protected $unique = false;

    /**
     * List of all exceptions used in validation.
     *
     * @var array
     */
    protected $exceptions = [
        Tokens::NOT_DEFINED    => Exceptions\RecurringServiceCountryNotDefinedException::class,
        Tokens::NOT_VALID      => Exceptions\RecurringServiceCountryNotValidException::class,
        Tokens::NOT_AUTHORIZED => Exceptions\RecurringServiceCountryNotAuthorizedException::class,
        Tokens::NOT_UNIQUE     => Exceptions\RecurringServiceCountryNotUniqueException::class,
    ];

    /**
     * List of all permissions.
     */
    protected $permissions = [
        Tokens::PERMISSION_FILL => 'recurringservice.attributes.country.fill',
        Tokens::PERMISSION_SHOW => 'recurringservice.attributes.country.show',
    ];

    /**
     * Is a value valid ?
     *
     * @param EntityContract $entity
     * @param mixed          $value
     *
     * @return bool
     */
    public function valid(EntityContract $entity, $value)
    {
        try {
            (new \League\ISO3166\ISO3166())->alpha2($value);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
