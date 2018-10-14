<?php

class Actions extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="action_id", type="integer", length=11, nullable=false)
     */
    public $action_id;

    /**
     *
     * @var integer
     * @Column(column="user_id", type="integer", length=11, nullable=true)
     */
    public $user_id;

    /**
     *
     * @var integer
     * @Column(column="post_id", type="integer", length=11, nullable=true)
     */
    public $post_id;

    /**
     *
     * @var string
     * @Column(column="action", type="string", length=50, nullable=true)
     */
    public $action;

    /**
     *
     * @var string
     * @Column(column="user_agent", type="string", nullable=true)
     */
    public $user_agent;

    /**
     *
     * @var string
     * @Column(column="created_at", type="string", nullable=false)
     */
    public $created_at;

    /**
     *
     * @var string
     * @Column(column="updated_at", type="string", nullable=false)
     */
    public $updated_at;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("benjamin_articool");
        $this->setSource("actions");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'actions';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Actions[]|Actions|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Actions|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /*
        Update the updated_at section in the database
        every time the row gets updated
    */
    public function beforeUpdate()
    {
        // Set default timezone
        date_default_timezone_set('Europe/Oslo');

        // Update updated_at field everytime the row updates
        $this->updated_at = date("Y-m-d H:i:s");
    }

}
