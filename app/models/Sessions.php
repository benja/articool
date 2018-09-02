<?php

class Sessions extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $session_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $user_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $session_ip;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $session_token;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $session_identifier;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $created_at;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $updated_at;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("benjamin_articool");
        $this->setSource("sessions");
        $this->belongsTo('user_id', '\Users', 'user_id', ['alias' => 'Users']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sessions';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Sessions[]|Sessions|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Sessions|\Phalcon\Mvc\Model\ResultInterface
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
