<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CriaTabelaProjects extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('projects');

        $table
            ->addColumn('title', 'string')
            ->addColumn('link', 'string')
            ->addColumn('description', 'string')
            ->addColumn('image_id', 'integer', ['signed' => false])
            ->addColumn('user_id', 'integer', ['signed' => false])
            ->addForeignKey('user_id', 'users', 'id')
            ->addForeignKey('image_id', 'images', 'id')
            ->create();
    }
}
