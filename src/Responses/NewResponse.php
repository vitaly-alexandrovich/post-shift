<?php
namespace PostShift\Responses;

use Modeler\Model;
use Modeler\Property;

/**
 * @method boolean hasEmail()
 * @method string getEmail()
 * @method boolean hasKey()
 * @method string getKey()
 */
class NewResponse extends Model
{
    /**
     * @return array
     */
    protected static function mapProperties()
    {
        return [
            'email' => Property::string()->notNull(),
            'key' => Property::string()->notNull(),
        ];
    }
}
