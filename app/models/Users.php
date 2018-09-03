<?php

class Users extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $user_id;

    /**
     *
     * @var string
     * @Column(type="string", length=25, nullable=false)
     */
    public $username;

    /**
     *
     * @var string
     * @Column(type="string", length=25, nullable=false)
     */
    public $first_name;

    /**
     *
     * @var string
     * @Column(type="string", length=25, nullable=false)
     */
    public $last_name;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $password;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $email_address;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $new_email_address;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $rank_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=false)
     */
    public $active;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $token;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $avatar;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $description;

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
        $this->setSource("users");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users[]|Users|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function getAuthors(int $post_id)
    {
        $post_id;
        $authors = PostAuthor::find([
            'type'  => 'user_id',
            'conditions' => 'post_id = ' . $post_id
        ]);
        return $authors;
    }

    public static function getApprovedAuthors()
    {
        $users = Users::find([
            'conditions' => 'rank_id >= :rank_id: AND active = :active:',
            'bind' => [
                'rank_id' => 2,
                'active' => 1
            ]
        ]);

        return $users;
    }

    // since users isn't related to sessions, we need to get the sessions values FOR the user somehow.
    // therefore we find the session values through a query search
    public static function getAuthTokens($user_id)
    {
        $tokens = Sessions::find([
            'conditions' => 'user_id = :user_id:',
            'bind' => [
                'user_id' => $user_id
            ],
            'order' => 'session_id DESC',
            'limit' => 1
        ]);

        return $tokens[0];
    }


    public function beforeUpdate()
    {
        // Set default timezone
        date_default_timezone_set('Europe/Oslo');

        // Update updated_at field everytime the row updates
        $this->updated_at = date("Y-m-d H:i:s");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'users';
    }

}
