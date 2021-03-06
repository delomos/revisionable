<?php namespace Venturecraft\Revisionable;

/**
 * FieldFormatter
 *
 * Allows formatting of fields
 *
 * (c) Venture Craft <http://www.venturecraft.com.au>
 */

class FieldFormatter
{


    /**
     * Format the value according to the provided formats
     *
     * @param  $key
     * @param  $value
     * @param  $formats
     *
     * @return string formated value
     */
    public static function format($key, $value, $formats)
    {

        foreach ($formats as $pkey => $format) {
            $parts = explode(':', $format);
            if (sizeof($parts) === 1) {
                continue;
            }

            if ($pkey == $key) {
                $method = array_shift($parts);

                if (method_exists(get_class(), $method)) {
                    return self::$method($value, implode(':', $parts));
                }
                break;
            }
        }

        return $value;

    }


    /**
     * Check if a field is empty
     *
     * @param $value
     * @param array $options
     *
     * @return string
     */
    public static function isEmpty($value, $options = array())
    {
        $value_set = isset($value) && $value != '';
        return sprintf(self::boolean($value_set, $options), $value);
    }


    /**
     * Boolean
     *
     * @param        $value
     * @param  array $options The false / true values to return
     *
     * @return string   Formatted version of the boolean field
     */
    public static function boolean($value, $options = null)
    {

        if (!is_null($options)) {
            $options = explode('|', $options);
        }

        if (sizeof($options) != 2) {
            $options = array('No', 'Yes');
        }

        return $options[!!$value];
    }


    /**
     * Format the string response, default is to just return the string
     *
     * @param  $value
     * @param  $format
     *
     * @return formatted string
     */
    public static function string($value, $format = null)
    {
        if (is_null($format)) {
            $format = '%s';
        }

        return sprintf($format, $value);
    }

}
