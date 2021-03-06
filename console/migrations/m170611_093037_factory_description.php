<?php

use yii\db\Migration;

class m170611_093037_factory_description extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('factory_description', [
            'factory_id' => $this->integer(11)->notNull(),
            'name' => $this->string(255)->notNull(),
            'address' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'language_id' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->createIndex(
            'idx-factory_description',
            'factory_description',
            [
                'factory_id',
            ]
        );
    }

    public function down()
    {
        $this->dropTable('factory_description');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
