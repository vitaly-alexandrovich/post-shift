<?php
namespace PostShift\Responses;

use Modeler\Model;
use Modeler\Property;

/**
 * @method boolean hasMessage()
 * @method string getMessage()
 */
class GetMailResponse extends Model
{
    /**
     * @return array
     */
    protected static function mapProperties()
    {
        return [
            'message' => Property::string()->notNull(),
        ];
    }
}
