<?php

use yii\db\Migration;

class m170611_093618_factory_tag extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('factory_tag', [
            'factory_id' => $this->integer(11)->notNull(),
            'tag_id' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->createIndex(
            'idx-factory_tag',
            'factory_tag',
            [
                'factory_id',
                'tag_id',
            ]
        );
    }

    public function down()
    {
        $this->dropTable('{{%factory_tag}}');
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
