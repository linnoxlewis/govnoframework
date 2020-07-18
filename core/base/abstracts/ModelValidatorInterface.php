<?php

namespace core\base\abstracts;

/**
 * Interface ModelValidator
 *
 * @package core\base\abstracts
 */
interface ModelValidatorInterface
{
    /**
     * Required validation type
     *
     * @var string
     */
    const REQUIRED_TYPE = 'required';

    /**
     * String validation type
     *
     * @var string
     */
    const STRING_TYPE = 'string';

    /**
     * Integer validation type
     *
     * @var string
     */
    const INT_TYPE = 'integer';

    /**
     * Float validation type
     *
     * @var string
     */
    const FLOAT_TYPE = 'float';

    /**
     * Boolean validation type
     *
     * @var string
     */
    const BOOL_TYPE = 'boolean';

    /**
     * Compare validation type
     *
     * @var string
     */
    const COMPARE_TYPE = 'compare';

    /**
     * Real validation type
     *
     * @var string
     */
    const REAL_TYPE = 'real';

    /**
     * Double validation type
     *
     * @var string
     */
    const DOUBLE_TYPE = 'double';

    /**
     * Email validation type
     *
     * @var string
     */
    const EMAIL_TYPE = 'email';

    /**
     * Ip validation type
     *
     * @var string
     */
    const IP_TYPE = 'ip';

    /**
     * Array validation type
     *
     * @var string
     */
    const ARRAY_TYPE = 'array';

    /**
     * In-range validation type
     *
     * @var string
     */
    const IN_TYPE = 'in';

    /**
     * Url validation type
     *
     * @var string
     */
    const URL_TYPE = 'url';

    /**
     * Safe validation type
     *
     * @var string
     */
    const SAFE_TYPE = 'safe';

    /**
     * Preg match validation type
     *
     * @var string
     */
    const MATCH_TYPE = 'match';

    /**
     * Validate rules
     *
     * @param array $rules      rules
     * @param array $properties properties
     *
     * @return mixed
     */
    public function validate(array $rules, array $properties);
}
