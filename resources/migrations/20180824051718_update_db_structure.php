<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class UpdateDbStructure extends AbstractMigration
{
    public function change()
    {
        $table = $this->table("user");
        $table->addColumn('hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'id']);
        $this->table("user")->changeColumn('permission_hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'comment' => "reference to permission.hash", 'after' => 'hash'])->update();
        $this->table("user")->changeColumn('team_hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'comment' => "reference to team.hash", 'after' => 'permission_hash'])->update();
        $this->table("user")->changeColumn('username', 'string', ['null' => false, 'limit' => 50, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'team_hash'])->update();
        $this->table("user")->changeColumn('first_name', 'string', ['null' => false, 'limit' => 45, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'username'])->update();
        $this->table("user")->changeColumn('password', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'first_name'])->update();
        $this->table("user")->changeColumn('language', 'string', ['null' => false, 'default' => "de_CH", 'limit' => 5, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'password'])->update();
        $this->table("user")->changeColumn('email', 'string', ['null' => true, 'limit' => 255, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'language'])->update();
        $this->table("user")->changeColumn('last_name', 'string', ['null' => true, 'limit' => 45, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'email'])->update();
        $this->table("user")->changeColumn('is_public', 'integer', ['null' => true, 'default' => "0", 'limit' => MysqlAdapter::INT_TINY, 'precision' => 3, 'comment' => "Indicates if this contact should be shown in all contacts in the app", 'after' => 'last_name'])->update();
        $this->table("user")->changeColumn('mobile_number', 'string', ['null' => true, 'limit' => 45, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'comment' => "MUST be required if user is public", 'after' => 'is_public'])->update();
        $this->table("user")->changeColumn('created_at', 'datetime', ['null' => false, 'default' => "CURRENT_TIMESTAMP", 'after' => 'mobile_number'])->update();
        $this->table("user")->changeColumn('created_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'created_at'])->update();
        $this->table("user")->changeColumn('modified_at', 'datetime', ['null' => true, 'after' => 'created_by'])->update();
        $this->table("user")->changeColumn('modified_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'modified_at'])->update();
        $this->table("user")->changeColumn('archived_at', 'datetime', ['null' => true, 'after' => 'modified_by'])->update();
        $this->table("user")->changeColumn('archived_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'archived_at'])->update();
        $table->save();
    }
}
