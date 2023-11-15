<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%apples}}`.
 */
class m231115_111003_create_apples_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%apples}}', [
            'id' => $this->primaryKey(),
            'color' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'fallen_at' => $this->integer(),
            'status' => $this->smallInteger()->notNull(),
            'size' => $this->decimal(3, 2)->defaultValue(1.00),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%apples}}');
    }
}
