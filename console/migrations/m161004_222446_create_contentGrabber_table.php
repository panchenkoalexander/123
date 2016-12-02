<?php

use yii\db\Migration;

/**
 * Handles the creation for table `contentGrabber_table`.
 */
class m161004_222446_create_contentGrabber_table extends Migration
{
    public function init()
    {
        $this->db = 'grabberDb';
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('contentGrabber', [
            'id' => $this->primaryKey(),
            'contentId' => $this->integer()->notNull(),
            'content' => $this->text()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('contentGrabber');
    }
}
