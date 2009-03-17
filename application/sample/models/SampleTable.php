<?php
class SampleTable extends Zend_Db_Table_Abstract
{
    /**
     * Table name
     *
     * @var string
     * @access protected
     */
    protected $_name = 'SAMPLE_TABLE';

    /**
     * Primary key
     *
     * @var string
     * @access protected
     */
    protected $_primary = 'id';
}