<?php

use yii\db\Migration;

/**
 * Handles the creation for table `category`.
 * Has foreign keys to the tables:
 *
 * - `engine`
 */
class m160915_023627_create_category extends Migration
{
    public function init()
    {
        $this->db = 'catalogueDb';
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'parentId' => $this->integer()->notNull(),
            'engineId' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(),
            'level' => $this->smallInteger(2)->notNull()->defaultValue(0),
            'hasChild' => $this->smallInteger(1)->notNull()->defaultValue(0),
        ]);

        // creates index for column engineId`
        $this->createIndex(
            'idx-category-engineId',
            'category',
            'engineId'
        );

        // add foreign key for table `engine`
        $this->addForeignKey(
            'fk-category-engineId',
            'category',
            'engineId',
            'engine',
            'id',
            'CASCADE'
        );

        // creates index for column parentId`
        $this->createIndex(
            'idx-category-parentId',
            'category',
            'parentId'
        );

        // add foreign key for table `category`
        $this->addForeignKey(
            'fk-category-parentId',
            'category',
            'parentId',
            'category',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `engine`
        $this->dropForeignKey(
            'fk-category-engineId',
            'category'
        );

        // drops index for column `engineId`
        $this->dropIndex(
            'idx-category-engineId',
            'category'
        );

        // drops foreign key for table `engine`
        $this->dropForeignKey(
            'fk-category-engineId',
            'category'
        );

        // drops index for column `parentId`
        $this->dropIndex(
            'fk-category-parentId',
            'category'
        );

        $this->dropTable('category');
    }
}
