<?php
namespace PostShift\Responses;

use Modeler\Model;
use Modeler\Property;

/**
 * @method boolean hasLivetime()
 * @method string getLivetime()
 */
class LiveTimeResponse extends Model
{
    /**
     * @return array
     */
    protected static function mapProperties()
    {
        return [
            'livetime' => Property::integer()->notNull(),
        ];
    }
}
