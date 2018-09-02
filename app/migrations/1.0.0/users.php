<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class UsersMigration_100
 */
class UsersMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('users', [
                'columns' => [
                    new Column(
                        'user_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => true,
                            'autoIncrement' => true,
                            'size' => 11,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'username',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 25,
                            'after' => 'user_id'
                        ]
                    ),
                    new Column(
                        'first_name',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 25,
                            'after' => 'username'
                        ]
                    ),
                    new Column(
                        'last_name',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 25,
                            'after' => 'first_name'
                        ]
                    ),
                    new Column(
                        'password',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 255,
                            'after' => 'last_name'
                        ]
                    ),
                    new Column(
                        'email_address',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'size' => 255,
                            'after' => 'password'
                        ]
                    ),
                    new Column(
                        'new_email_address',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'size' => 255,
                            'after' => 'email_address'
                        ]
                    ),
                    new Column(
                        'rank_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'default' => "1",
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'new_email_address'
                        ]
                    ),
                    new Column(
                        'active',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'default' => "1",
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'rank_id'
                        ]
                    ),
                    new Column(
                        'token',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'size' => 255,
                            'after' => 'active'
                        ]
                    ),
                    new Column(
                        'avatar',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'default' => "default.jpg",
                            'size' => 255,
                            'after' => 'token'
                        ]
                    ),
                    new Column(
                        'description',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'default' => "Articool newbie",
                            'notNull' => true,
                            'size' => 255,
                            'after' => 'avatar'
                        ]
                    ),
                    new Column(
                        'created_at',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'default' => "CURRENT_TIMESTAMP",
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'description'
                        ]
                    ),
                    new Column(
                        'updated_at',
                        [
                            'type' => Column::TYPE_TIMESTAMP,
                            'default' => "CURRENT_TIMESTAMP",
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'created_at'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['user_id'], 'PRIMARY'),
                    new Index('username', ['username'], 'UNIQUE'),
                    new Index('email_address', ['email_address'], 'UNIQUE'),
                    new Index('user_id', ['user_id'], null)
                ],
                'options' => [
                    'TABLE_TYPE' => 'BASE TABLE',
                    'AUTO_INCREMENT' => '34',
                    'ENGINE' => 'InnoDB',
                    'TABLE_COLLATION' => 'latin1_swedish_ci'
                ],
            ]
        );
    }

    /**
     * Run the migrations
     *
     * @return void
     */
    public function up()
    {

    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {

    }

}
