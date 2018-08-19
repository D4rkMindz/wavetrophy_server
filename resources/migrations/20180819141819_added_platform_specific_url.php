<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class AddedPlatformSpecificUrl extends AbstractMigration
{
    public function change()
    {
        $table = $this->table("address");
        $table->addColumn('map_url_android', 'string', ['null' => false, 'limit' => 1000, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'coordinate_lon']);
        $table->addColumn('map_url_ios', 'string', ['null' => false, 'limit' => 1000, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'map_url_android']);
        $this->table("address")->changeColumn('description', 'text', ['null' => true, 'limit' => MysqlAdapter::TEXT_LONG, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'map_url_ios'])->update();
        $this->table("address")->changeColumn('created_at', 'datetime', ['null' => false, 'default' => "CURRENT_TIMESTAMP", 'after' => 'description'])->update();
        $this->table("address")->changeColumn('created_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'created_at'])->update();
        $this->table("address")->changeColumn('modified_at', 'datetime', ['null' => true, 'after' => 'created_by'])->update();
        $this->table("address")->changeColumn('modified_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'modified_at'])->update();
        $this->table("address")->changeColumn('archived_at', 'datetime', ['null' => true, 'after' => 'modified_by'])->update();
        $this->table("address")->changeColumn('archived_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'archived_at'])->update();
        $this->table("address")->changeColumn('comment', 'string', ['null' => true, 'limit' => 255, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'comment' => "Comment about the location for the drivers", 'after' => 'archived_by'])->update();
        $table->save();
        if($this->table('address')->hasColumn('map_url')) {
            $this->table("address")->removeColumn('map_url')->update();
        }
        $table = $this->table("address", ['id' => false, 'primary_key' => ["id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => "", 'row_format' => "Compact"]);
        $table->save();
        $table = $this->table("address_image", ['id' => false, 'primary_key' => ["id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => "", 'row_format' => "Compact"]);
        $table->save();
        $table = $this->table("car", ['id' => false, 'primary_key' => ["id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => "", 'row_format' => "Compact"]);
        $table->save();
        $table = $this->table("contact", ['id' => false, 'primary_key' => ["id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => "", 'row_format' => "Compact"]);
        $table->save();
        $table = $this->table("event", ['id' => false, 'primary_key' => ["id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => "", 'row_format' => "Compact"]);
        $table->save();
        $table = $this->table("event_image", ['id' => false, 'primary_key' => ["id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => "", 'row_format' => "Compact"]);
        $table->save();
        $table = $this->table("image", ['id' => false, 'primary_key' => ["id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => "", 'row_format' => "Compact"]);
        $table->save();
        $table = $this->table("permission", ['id' => false, 'primary_key' => ["id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => "", 'row_format' => "Compact"]);
        $table->save();
        $table = $this->table("road_group", ['id' => false, 'primary_key' => ["id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => "", 'row_format' => "Compact"]);
        $table->save();
        $table = $this->table("team", ['id' => false, 'primary_key' => ["id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => "", 'row_format' => "Compact"]);
        $table->save();
        $table = $this->table("user", ['id' => false, 'primary_key' => ["id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => "", 'row_format' => "Compact"]);
        $table->save();
        $table = $this->table("wavetrophy", ['id' => false, 'primary_key' => ["id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => "", 'row_format' => "Compact"]);
        $table->save();
    }
}
