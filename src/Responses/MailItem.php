<?php
namespace PostShift\Responses;

use Modeler\Model;
use Modeler\Property;

/**
 * @method boolean hasId()
 * @method boolean hasDate()
 * @method boolean hasSubject()
 * @method boolean hasFrom()
 * @method integer getId()
 * @method string getDate()
 * @method string getSubject()
 * @method string getFrom()
 */
class MailItem extends Model
{
    /**
     * @return array
     */
    protected static function mapProperties()
    {
        return [
            'id' => Property::integer()->notNull(),
            'date' => Property::string()->notNull(),
            'subject' => Property::string()->notNull(),
            'from' => Property::string()->notNull(),
        ];
    }
}
