<?php

class PostAuthor extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=20, nullable=false)
     */
    public $post_id;

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=11, nullable=false)
     */
    public $user_id;

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
        $this->setSource("post_author");
        $this->belongsTo('post_id', '\Posts', 'post_id', ['alias' => 'Posts']);
        $this->belongsTo('user_id', '\Users', 'user_id', ['alias' => 'Users']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'post_author';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return PostAuthor[]|PostAuthor|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return PostAuthor|\Phalcon\Mvc\Model\ResultInterface
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
