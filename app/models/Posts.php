<?php
use Phalcon\Mvc\Url;
class Posts extends \Phalcon\Mvc\Model
{
    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=20, nullable=false)
     */
    public $post_id;

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
    public $post_title;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $post_body;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $post_language;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $post_genre;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=false)
     */
    public $post_active;

    /**
     *
     * @var integer
     * @Column(type="integer", length=20, nullable=false)
     */
    public $post_views;

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
        $this->setSource("posts");
        $this->belongsTo('user_id', '\Users', 'user_id', ['alias' => 'Users']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'posts';
    }
    
    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Posts[]|Posts|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Posts|\Phalcon\Mvc\Model\ResultInterface
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
    }

}
