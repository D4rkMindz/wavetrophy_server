<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Init extends AbstractMigration
{
    public function change()
    {
        $this->execute("ALTER DATABASE CHARACTER SET 'utf8';");
        $this->execute("ALTER DATABASE COLLATE='utf8_unicode_ci';");
        $table = $this->table("address", ['engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('address')->hasColumn('id')) {
            $this->table("address")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("address")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $table->addColumn('hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'id'])->update();
        $table->addColumn('wavetrophy_hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'hash'])->update();
        $table->addColumn('road_group_hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'wavetrophy_hash'])->update();
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 45, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'road_group_hash'])->update();
        $table->addColumn('city', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'name'])->update();
        $table->addColumn('street', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'city'])->update();
        $table->addColumn('zipcode', 'string', ['null' => false, 'limit' => 10, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'street'])->update();
        $table->addColumn('coordinate_lat', 'string', ['null' => false, 'limit' => 45, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'comment' => "The table for addresses", 'after' => 'zipcode'])->update();
        $table->addColumn('coordinate_lon', 'string', ['null' => false, 'limit' => 45, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'coordinate_lat'])->update();
        $table->addColumn('map_url_android', 'string', ['null' => false, 'limit' => 1000, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'coordinate_lon'])->update();
        $table->addColumn('map_url_ios', 'string', ['null' => false, 'limit' => 1000, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'map_url_android'])->update();
        $table->addColumn('description', 'text', ['null' => true, 'limit' => MysqlAdapter::TEXT_LONG, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'map_url_ios'])->update();
        $table->addColumn('comment', 'string', ['null' => true, 'limit' => 255, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'comment' => "Comment about the location for the drivers", 'after' => 'description'])->update();
        $table->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'after' => 'comment'])->update();
        $table->addColumn('created_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'created_at'])->update();
        $table->addColumn('modified_at', 'datetime', ['null' => true, 'after' => 'created_by'])->update();
        $table->addColumn('modified_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'modified_at'])->update();
        $table->addColumn('archived_at', 'datetime', ['null' => true, 'after' => 'modified_by'])->update();
        $table->addColumn('archived_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'archived_at'])->update();
        $table->save();
        $table = $this->table("address_image", ['engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('address_image')->hasColumn('id')) {
            $this->table("address_image")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("address_image")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $table->addColumn('image_hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'comment' => "reference to image.hash", 'after' => 'id'])->update();
        $table->addColumn('address_hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'comment' => "reference to address.hash", 'after' => 'image_hash'])->update();
        $table->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'after' => 'address_hash'])->update();
        $table->addColumn('created_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'created_at'])->update();
        $table->addColumn('modified_at', 'datetime', ['null' => true, 'after' => 'created_by'])->update();
        $table->addColumn('modified_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'modified_at'])->update();
        $table->addColumn('archived_at', 'datetime', ['null' => true, 'after' => 'modified_by'])->update();
        $table->addColumn('archived_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'archived_at'])->update();
        $table->save();
        $table = $this->table("car", ['engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('car')->hasColumn('id')) {
            $this->table("car")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("car")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $table->addColumn('hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'id'])->update();
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 45, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'hash'])->update();
        $table->addColumn('reach', 'decimal', ['null' => false, 'precision' => 5, 'scale' => 2, 'after' => 'name'])->update();
        $table->addColumn('power_supply', 'string', ['null' => true, 'default' => 'AC', 'limit' => 45, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'comment' => "Either AC or DC charging", 'after' => 'reach'])->update();
        $table->addColumn('battery_size', 'decimal', ['null' => true, 'precision' => 5, 'scale' => 2, 'comment' => "The size of the battery in KW", 'after' => 'power_supply'])->update();
        $table->addColumn('power_supply_min', 'decimal', ['null' => true, 'precision' => 5, 'scale' => 2, 'comment' => "The minimum charging rate in KW (eg 3,6)", 'after' => 'battery_size'])->update();
        $table->addColumn('power_supply_max', 'decimal', ['null' => true, 'precision' => 5, 'scale' => 2, 'comment' => "The maximum charging ratein KW (eg. 22)", 'after' => 'power_supply_min'])->update();
        $table->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'after' => 'power_supply_max'])->update();
        $table->addColumn('created_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'created_at'])->update();
        $table->addColumn('modified_at', 'datetime', ['null' => true, 'after' => 'created_by'])->update();
        $table->addColumn('modified_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'modified_at'])->update();
        $table->addColumn('archived_at', 'datetime', ['null' => true, 'after' => 'modified_by'])->update();
        $table->addColumn('archived_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'archived_at'])->update();
        $table->save();
        $table = $this->table("contact", ['engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('contact')->hasColumn('id')) {
            $this->table("contact")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("contact")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $table->addColumn('hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'id'])->update();
        $table->addColumn('position', 'string', ['null' => false, 'limit' => 30, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'hash'])->update();
        $table->addColumn('phonenumber', 'string', ['null' => false, 'limit' => 15, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'position'])->update();
        $table->addColumn('first_name', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'phonenumber'])->update();
        $table->addColumn('last_name', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'first_name'])->update();
        $table->addColumn('email', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'last_name'])->update();
        $table->addColumn('wavetrohpy_hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'comment' => "reference wavetrophy.hash", 'after' => 'email'])->update();
        $table->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'after' => 'wavetrohpy_hash'])->update();
        $table->addColumn('created_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'created_at'])->update();
        $table->addColumn('modified_at', 'datetime', ['null' => true, 'after' => 'created_by'])->update();
        $table->addColumn('modified_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'modified_at'])->update();
        $table->addColumn('archived_at', 'datetime', ['null' => true, 'after' => 'modified_by'])->update();
        $table->addColumn('archived_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'archived_at'])->update();
        $table->save();
        $table = $this->table("event", ['engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('event')->hasColumn('id')) {
            $this->table("event")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("event")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $table->addColumn('hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'id'])->update();
        $table->addColumn('group_hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'comment' => "reference to group.hash", 'after' => 'hash'])->update();
        $table->addColumn('address_hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'group_hash'])->update();
        $table->addColumn('title', 'string', ['null' => false, 'limit' => 45, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'address_hash'])->update();
        $table->addColumn('description', 'text', ['null' => false, 'limit' => MysqlAdapter::TEXT_LONG, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'title'])->update();
        $table->addColumn('start', 'datetime', ['null' => false, 'after' => 'description'])->update();
        $table->addColumn('end', 'datetime', ['null' => false, 'after' => 'start'])->update();
        $table->addColumn('day', 'string', ['null' => false, 'limit' => 5, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'comment' => "Day is the day of the wave trophy event", 'after' => 'end'])->update();
        $table->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'after' => 'day'])->update();
        $table->addColumn('created_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'created_at'])->update();
        $table->addColumn('modified_at', 'datetime', ['null' => true, 'after' => 'created_by'])->update();
        $table->addColumn('modified_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'modified_at'])->update();
        $table->addColumn('archived_at', 'datetime', ['null' => true, 'after' => 'modified_by'])->update();
        $table->addColumn('archived_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'archived_at'])->update();
        $table->save();
        $table = $this->table("event_image", ['engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('event_image')->hasColumn('id')) {
            $this->table("event_image")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("event_image")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $table->addColumn('event_hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'comment' => "reference to event.image", 'after' => 'id'])->update();
        $table->addColumn('image_hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'comment' => "reference to image.hash", 'after' => 'event_hash'])->update();
        $table->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'after' => 'image_hash'])->update();
        $table->addColumn('created_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'created_at'])->update();
        $table->addColumn('modified_at', 'datetime', ['null' => true, 'after' => 'created_by'])->update();
        $table->addColumn('modified_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'modified_at'])->update();
        $table->addColumn('archived_at', 'datetime', ['null' => true, 'after' => 'modified_by'])->update();
        $table->addColumn('archived_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'archived_at'])->update();
        $table->save();
        $table = $this->table("image", ['engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('image')->hasColumn('id')) {
            $this->table("image")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("image")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $table->addColumn('hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'id'])->update();
        $table->addColumn('url', 'string', ['null' => false, 'limit' => 1000, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'hash'])->update();
        $table->addColumn('name', 'string', ['null' => true, 'limit' => 255, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'url'])->update();
        $table->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'after' => 'name'])->update();
        $table->addColumn('created_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'created_at'])->update();
        $table->addColumn('modified_at', 'datetime', ['null' => true, 'after' => 'created_by'])->update();
        $table->addColumn('modified_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'modified_at'])->update();
        $table->addColumn('archived_at', 'datetime', ['null' => true, 'after' => 'modified_by'])->update();
        $table->addColumn('archived_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'archived_at'])->update();
        $table->save();
        $table = $this->table("permission", ['engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('permission')->hasColumn('id')) {
            $this->table("permission")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable', 'comment' => "the table for the permissions"])->update();
        } else {
            $this->table("permission")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable', 'comment' => "the table for the permissions"])->update();
        }
        $table->addColumn('hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'id'])->update();
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 45, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'hash'])->update();
        $table->addColumn('level', 'string', ['null' => false, 'limit' => 45, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'name'])->update();
        $table->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'after' => 'level'])->update();
        $table->addColumn('created_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'created_at'])->update();
        $table->addColumn('modified_at', 'datetime', ['null' => true, 'after' => 'created_by'])->update();
        $table->addColumn('modified_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'modified_at'])->update();
        $table->addColumn('archived_at', 'datetime', ['null' => true, 'after' => 'modified_by'])->update();
        $table->addColumn('archived_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'archived_at'])->update();
        $table->save();
        $table = $this->table("position", ['engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('position')->hasColumn('id')) {
            $this->table("position")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("position")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $table->addColumn('hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'id'])->update();
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 45, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'hash'])->update();
        $table->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'after' => 'name'])->update();
        $table->addColumn('created_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'created_at'])->update();
        $table->addColumn('modified_at', 'datetime', ['null' => true, 'after' => 'created_by'])->update();
        $table->addColumn('modified_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'modified_at'])->update();
        $table->addColumn('archived_at', 'datetime', ['null' => true, 'after' => 'modified_by'])->update();
        $table->addColumn('archived_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'archived_at'])->update();
        $table->save();
        $table = $this->table("road_group", ['engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('road_group')->hasColumn('id')) {
            $this->table("road_group")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("road_group")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $table->addColumn('hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'id'])->update();
        $table->addColumn('wavetrophy_hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'comment' => "reference to wavetrohpy.hash", 'after' => 'hash'])->update();
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'wavetrophy_hash'])->update();
        $table->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'after' => 'name'])->update();
        $table->addColumn('created_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'created_at'])->update();
        $table->addColumn('modified_at', 'datetime', ['null' => true, 'after' => 'created_by'])->update();
        $table->addColumn('archived_at', 'datetime', ['null' => true, 'after' => 'modified_at'])->update();
        $table->addColumn('archived_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'archived_at'])->update();
        $table->addColumn('modified_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'archived_by'])->update();
        $table->save();
        $table = $this->table("team", ['engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('team')->hasColumn('id')) {
            $this->table("team")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("team")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $table->addColumn('hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'id'])->update();
        $table->addColumn('group_hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'comment' => "reference to group.hash", 'after' => 'hash'])->update();
        $table->addColumn('car_hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'comment' => "reference to car.hash", 'after' => 'group_hash'])->update();
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 45, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'car_hash'])->update();
        $table->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'after' => 'name'])->update();
        $table->addColumn('created_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'created_at'])->update();
        $table->addColumn('modified_at', 'datetime', ['null' => true, 'after' => 'created_by'])->update();
        $table->addColumn('modified_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'modified_at'])->update();
        $table->addColumn('archived_at', 'datetime', ['null' => true, 'after' => 'modified_by'])->update();
        $table->addColumn('archived_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'archived_at'])->update();
        $table->save();
        $table = $this->table("team_user", ['engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('team_user')->hasColumn('id')) {
            $this->table("team_user")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("team_user")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $table->addColumn('user_hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'id'])->update();
        $table->addColumn('team_hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'user_hash'])->update();
        $table->addColumn('position_hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'comment' => "The hash of the user for a team in a group on the WAVE
The user can have another position (e.g. group leader) for each Wave", 'after' => 'team_hash'])->update();
        $table->save();
        $table = $this->table("user", ['engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('user')->hasColumn('id')) {
            $this->table("user")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10])->update();
        } else {
            $this->table("user")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10])->update();
        }
        $table->addColumn('hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'id'])->update();
        $table->addColumn('permission_hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'comment' => "reference to permission.hash", 'after' => 'hash'])->update();
        $table->addColumn('username', 'string', ['null' => false, 'limit' => 50, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'permission_hash'])->update();
        $table->addColumn('password', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'username'])->update();
        $table->addColumn('language', 'string', ['null' => false, 'default' => 'de_CH', 'limit' => 5, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'password'])->update();
        $table->addColumn('first_name', 'string', ['null' => false, 'limit' => 45, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'language'])->update();
        $table->addColumn('email', 'string', ['null' => true, 'limit' => 255, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'first_name'])->update();
        $table->addColumn('last_name', 'string', ['null' => true, 'limit' => 45, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'email'])->update();
        $table->addColumn('is_public', 'integer', ['null' => true, 'default' => '0', 'limit' => MysqlAdapter::INT_TINY, 'precision' => 3, 'comment' => "Indicates if this contact should be shown in all contacts in the app", 'after' => 'last_name'])->update();
        $table->addColumn('mobile_number', 'string', ['null' => true, 'limit' => 45, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'comment' => "MUST be required if user is public", 'after' => 'is_public'])->update();
        $table->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'after' => 'mobile_number'])->update();
        $table->addColumn('created_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'created_at'])->update();
        $table->addColumn('modified_at', 'datetime', ['null' => true, 'after' => 'created_by'])->update();
        $table->addColumn('modified_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'modified_at'])->update();
        $table->addColumn('archived_at', 'datetime', ['null' => true, 'after' => 'modified_by'])->update();
        $table->addColumn('archived_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'archived_at'])->update();
        $table->save();
        $table = $this->table("wavetrophy", ['engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('wavetrophy')->hasColumn('id')) {
            $this->table("wavetrophy")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("wavetrophy")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $table->addColumn('hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'id'])->update();
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 45, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'hash'])->update();
        $table->addColumn('country', 'string', ['null' => false, 'limit' => 45, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'name'])->update();
        $table->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'after' => 'country'])->update();
        $table->addColumn('created_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'created_at'])->update();
        $table->addColumn('modified_at', 'datetime', ['null' => true, 'after' => 'created_by'])->update();
        $table->addColumn('modified_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'modified_at'])->update();
        $table->addColumn('archived_at', 'datetime', ['null' => true, 'after' => 'modified_by'])->update();
        $table->addColumn('archived_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'archived_at'])->update();
        $table->save();
    }
}
