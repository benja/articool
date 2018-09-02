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

    /*
        Custom made functions
    */

    public static function getPosts()
    {
        $posts = Posts::find([
            'conditions' => 'post_active = :post_active:',
            'limit' => 10,
            'order' => 'created_at DESC',
            'bind' => [
                'post_active' => 1
            ]
        ]);

        return $posts;
    }

    public static function getPostReadTime($post_id)
    {
        // Find the post by ID
        $post = Posts::findFirst($post_id);

        $text = str_word_count($post->post_body); // Get the text wordcount
        $wordperminute = 200; // Average words per minute for a slow reader

        $readtime = floor( ($text / $wordperminute) ); // Wordcount / average words per minute, then we round it down using floor.
        $ending = 'minutes';

        return 'Approximately a ' . $readtime . ' minute read';
    }

    public static function getPostAuthors($post_id)
    {
        $url = new Url();
        $url->setBaseUri('/articool/'); // This has to change based on what directory it is in

        $author = Posts::findFirst($post_id);
        $contributor = PostAuthor::find([
            'conditions' => 'post_id = :post_id:',
            'limit' => 10,
            'order' => 'created_at DESC',
            'bind' => [
                'post_id' => $post_id
            ]
        ]);

        foreach($contributor as $helper) {
            $contributors[] = '<a style="text-decoration: none; color: #FFF;" href="
            '. $url->get('profile/' . $helper->users->username) .'
            "> <img class="post__post__avatar" src="
            ' . $url->get('img/avatars/' . $helper->users->avatar) . '
            ">'. $helper->users->first_name . " " . $helper->users->last_name .' </a>';
        }

        // get the last element in array, push in "and" before the last element, add an empty array before the front to add comma, authorlist is the list with all of the contributors
        $last_element = array_pop($contributors);
        array_push($contributors, 'and ' . $last_element);
        array_unshift($contributors, '');
        $authorlist = implode(', ', $contributors);

        return 'Written by <a style="text-decoration: none; color: #FFF;" href="
        '. $url->get('profile/' . $author->users->username) .'
        "> <img class="post__post__avatar" src="
        ' . $url->get('img/avatars/' . $author->users->avatar) . '
        ">'. $author->users->first_name . " " . $author->users->last_name .'</a>' . $authorlist;

    }

    /*
     *  POST AUTHOR RAW (FOR TITLE)
     */

    public static function getPostAuthorsTitle($post_id)
    {
        $author = Posts::findFirst($post_id);
        $contributor = PostAuthor::find([
            'conditions' => 'post_id = :post_id:',
            'limit' => 10,
            'order' => 'created_at DESC',
            'bind' => [
                'post_id' => $post_id
            ]
        ]);

        foreach($contributor as $helper) {
            $contributors[] =  $helper->users->first_name . " " . $helper->users->last_name;
        }

        // get the last element in array, push in "and" before the last element, add an empty array before the front to add comma, authorlist is the list with all of the contributors
        $last_element = array_pop($contributors);
        array_push($contributors, 'and ' . $last_element);
        array_unshift($contributors, '');
        $authorlist = implode(', ', $contributors);

        return $author->users->first_name . " " . $author->users->last_name . "" . $authorlist;

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
