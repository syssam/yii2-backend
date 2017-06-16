<?php

use yii\db\Migration;

class m170611_094200_factory_attribute extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('factory_attribute', [
            'factory_id' => $this->integer(11)->notNull(),
            'attribute_id' => $this->integer(11)->notNull(),
            'text' => $this->text(),
            'language_id' => $this->integer(11)->notNull()->defaultValue(0),
        ], $tableOptions);

        $this->createIndex(
            'idx-factory_attribute',
            'factory_attribute',
            [
                'factory_id',
            ]
        );
    }

    public function down()
    {
        $this->dropTable('{{%factory_attribute}}');
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
