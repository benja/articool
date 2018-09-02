<?php

class Ranks extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $rank_id;

    /**
     *
     * @var string
     * @Column(type="string", length=25, nullable=false)
     */
    public $rank_name;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $rank_description;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("benjamin_articool");
        $this->setSource("ranks");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'ranks';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Ranks[]|Ranks|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Ranks|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
