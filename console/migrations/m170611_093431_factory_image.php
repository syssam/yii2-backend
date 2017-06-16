<?php

use yii\db\Migration;

class m170611_093431_factory_image extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('factory_image', [
            'factory_id' => $this->integer(11)->notNull(),
            'image' => $this->string(255)->notNull(),
            'sort_order' => $this->integer(3)->notNull()->defaultValue(0),
        ], $tableOptions);

        $this->createIndex(
            'idx-factory_image',
            'factory_image',
            [
                'factory_id',
            ]
        );
    }

    public function down()
    {
        $this->dropTable('factory_image');
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
