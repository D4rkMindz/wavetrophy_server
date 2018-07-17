<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Init extends AbstractMigration
{
    public function change()
    {
        $this->execute("ALTER DATABASE CHARACTER SET 'utf8mb4';");
        $this->execute("ALTER DATABASE COLLATE='utf8mb4_unicode_ci';");
        $table = $this->table("address", ['engine' => "InnoDB", 'encoding' => "utf8mb4", 'collation' => "utf8mb4_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('address')->hasColumn('id')) {
            $this->table("address")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("address")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 45, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'id'])->update();
        $table->addColumn('city', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'name'])->update();
        $table->addColumn('street', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'city'])->update();
        $table->addColumn('zipcode', 'string', ['null' => false, 'limit' => 10, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'street'])->update();
        $table->addColumn('coordinate_lat', 'string', ['null' => false, 'limit' => 45, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'comment' => "The table for addresses", 'after' => 'zipcode'])->update();
        $table->addColumn('coordinate_lon', 'string', ['null' => false, 'limit' => 45, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'coordinate_lat'])->update();
        $table->addColumn('map_url', 'string', ['null' => true, 'limit' => 1000, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'coordinate_lon'])->update();
        $table->addColumn('description', 'text', ['null' => true, 'limit' => MysqlAdapter::TEXT_LONG, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'map_url'])->update();
        $table->save();
        $table = $this->table("car", ['engine' => "InnoDB", 'encoding' => "utf8mb4", 'collation' => "utf8mb4_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('car')->hasColumn('id')) {
            $this->table("car")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("car")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $table->addColumn('hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'id'])->update();
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 45, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'hash'])->update();
        $table->addColumn('reach', 'decimal', ['null' => false, 'precision' => 5, 'scale' => 2, 'after' => 'name'])->update();
        $table->addColumn('power_supply', 'string', ['null' => true, 'default' => 'AC', 'limit' => 45, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'comment' => "Either AC or DC charging", 'after' => 'reach'])->update();
        $table->addColumn('battery_size', 'decimal', ['null' => true, 'precision' => 5, 'scale' => 2, 'comment' => "The size of the battery in KW", 'after' => 'power_supply'])->update();
        $table->addColumn('power_supply_min', 'decimal', ['null' => true, 'precision' => 5, 'scale' => 2, 'comment' => "The minimum charging rate in KW (eg 3,6)", 'after' => 'battery_size'])->update();
        $table->addColumn('power_supply_max', 'decimal', ['null' => true, 'precision' => 5, 'scale' => 2, 'comment' => "The maximum charging ratein KW (eg. 22)", 'after' => 'power_supply_min'])->update();
        $table->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'after' => 'power_supply_max'])->update();
        $table->addColumn('created_by', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'created_at'])->update();
        $table->addColumn('modified_at', 'datetime', ['null' => true, 'after' => 'created_by'])->update();
        $table->addColumn('modified_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'modified_at'])->update();
        $table->addColumn('archived_at', 'datetime', ['null' => true, 'after' => 'modified_by'])->update();
        $table->addColumn('archived_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'archived_at'])->update();
        $table->save();
        $table = $this->table("contact", ['engine' => "InnoDB", 'encoding' => "utf8mb4", 'collation' => "utf8mb4_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('contact')->hasColumn('id')) {
            $this->table("contact")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable', 'comment' => "The table for the public contacts"])->update();
        } else {
            $this->table("contact")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable', 'comment' => "The table for the public contacts"])->update();
        }
        $table->addColumn('first_name', 'string', ['null' => false, 'limit' => 45, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'id'])->update();
        $table->addColumn('last_name', 'string', ['null' => false, 'limit' => 45, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'first_name'])->update();
        $table->addColumn('phone_number', 'string', ['null' => true, 'limit' => 45, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'last_name'])->update();
        $table->addColumn('mobile_number', 'string', ['null' => true, 'limit' => 45, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'phone_number'])->update();
        $table->save();
        $table = $this->table("email_token", ['engine' => "InnoDB", 'encoding' => "utf8mb4", 'collation' => "utf8mb4_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('email_token')->hasColumn('id')) {
            $this->table("email_token")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("email_token")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $table->addColumn('user_hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'id'])->update();
        $table->addColumn('token', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'user_hash'])->update();
        $table->addColumn('issued_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'after' => 'token'])->update();
        $table->save();
        $table = $this->table("event", ['engine' => "InnoDB", 'encoding' => "utf8mb4", 'collation' => "utf8mb4_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('event')->hasColumn('id')) {
            $this->table("event")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("event")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $table->addColumn('wavetrophy_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'id'])->update();
        $table->addColumn('group_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'wavetrophy_id'])->update();
        $table->addColumn('address_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'group_id'])->update();
        $table->addColumn('title', 'string', ['null' => false, 'limit' => 45, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'address_id'])->update();
        $table->addColumn('description', 'text', ['null' => false, 'limit' => MysqlAdapter::TEXT_LONG, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'title'])->update();
        $table->addColumn('start', 'datetime', ['null' => false, 'after' => 'description'])->update();
        $table->addColumn('end', 'datetime', ['null' => false, 'after' => 'start'])->update();
        $table->addColumn('day', 'string', ['null' => false, 'limit' => 5, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'comment' => "Day is the day of the wave trophy event", 'after' => 'end'])->update();
        $table->save();
        if($this->table('event')->hasIndex('fk_event_wavetrophy1_idx')) {
            $this->table("event")->removeIndexByName('fk_event_wavetrophy1_idx');
        }
        $this->table("event")->addIndex(['wavetrophy_id'], ['name' => "fk_event_wavetrophy1_idx", 'unique' => false])->save();
        if($this->table('event')->hasIndex('fk_event_group1_idx')) {
            $this->table("event")->removeIndexByName('fk_event_group1_idx');
        }
        $this->table("event")->addIndex(['group_id'], ['name' => "fk_event_group1_idx", 'unique' => false])->save();
        if($this->table('event')->hasIndex('fk_event_address1_idx')) {
            $this->table("event")->removeIndexByName('fk_event_address1_idx');
        }
        $this->table("event")->addIndex(['address_id'], ['name' => "fk_event_address1_idx", 'unique' => false])->save();
        $table = $this->table("event_image", ['engine' => "InnoDB", 'encoding' => "utf8mb4", 'collation' => "utf8mb4_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('event_image')->hasColumn('id')) {
            $this->table("event_image")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("event_image")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $table->addColumn('event_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'id'])->update();
        $table->addColumn('image_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'event_id'])->update();
        $table->save();
        if($this->table('event_image')->hasIndex('fk_event_has_image_image1_idx')) {
            $this->table("event_image")->removeIndexByName('fk_event_has_image_image1_idx');
        }
        $this->table("event_image")->addIndex(['image_id'], ['name' => "fk_event_has_image_image1_idx", 'unique' => false])->save();
        if($this->table('event_image')->hasIndex('fk_event_has_image_event1_idx')) {
            $this->table("event_image")->removeIndexByName('fk_event_has_image_event1_idx');
        }
        $this->table("event_image")->addIndex(['event_id'], ['name' => "fk_event_has_image_event1_idx", 'unique' => false])->save();
        $table = $this->table("group", ['engine' => "InnoDB", 'encoding' => "utf8mb4", 'collation' => "utf8mb4_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('group')->hasColumn('id')) {
            $this->table("group")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("group")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $table->addColumn('wavetrophy_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'id'])->update();
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'wavetrophy_id'])->update();
        $table->save();
        if($this->table('group')->hasIndex('fk_group_wavetrophy_idx')) {
            $this->table("group")->removeIndexByName('fk_group_wavetrophy_idx');
        }
        $this->table("group")->addIndex(['wavetrophy_id'], ['name' => "fk_group_wavetrophy_idx", 'unique' => false])->save();
        $table = $this->table("image", ['engine' => "InnoDB", 'encoding' => "utf8mb4", 'collation' => "utf8mb4_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('image')->hasColumn('id')) {
            $this->table("image")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("image")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $table->addColumn('url', 'string', ['null' => false, 'limit' => 1000, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'id'])->update();
        $table->addColumn('name', 'string', ['null' => true, 'limit' => 255, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'url'])->update();
        $table->save();
        $table = $this->table("image_has_address", ['engine' => "InnoDB", 'encoding' => "utf8mb4", 'collation' => "utf8mb4_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('image_has_address')->hasColumn('id')) {
            $this->table("image_has_address")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("image_has_address")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $table->addColumn('image_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'id'])->update();
        $table->addColumn('address_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'image_id'])->update();
        $table->save();
        if($this->table('image_has_address')->hasIndex('fk_image_has_address_address1_idx')) {
            $this->table("image_has_address")->removeIndexByName('fk_image_has_address_address1_idx');
        }
        $this->table("image_has_address")->addIndex(['address_id'], ['name' => "fk_image_has_address_address1_idx", 'unique' => false])->save();
        if($this->table('image_has_address')->hasIndex('fk_image_has_address_image1_idx')) {
            $this->table("image_has_address")->removeIndexByName('fk_image_has_address_image1_idx');
        }
        $this->table("image_has_address")->addIndex(['image_id'], ['name' => "fk_image_has_address_image1_idx", 'unique' => false])->save();
        $table = $this->table("participant", ['engine' => "InnoDB", 'encoding' => "utf8mb4", 'collation' => "utf8mb4_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('participant')->hasColumn('id')) {
            $this->table("participant")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable', 'comment' => "The user for a specific WAVE trophy event. A user can participate at many trophies."])->update();
        } else {
            $this->table("participant")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable', 'comment' => "The user for a specific WAVE trophy event. A user can participate at many trophies."])->update();
        }
        $table->addColumn('group_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'id'])->update();
        $table->addColumn('user_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'group_id'])->update();
        $table->save();
        if($this->table('participant')->hasIndex('fk_group_has_user_user1_idx')) {
            $this->table("participant")->removeIndexByName('fk_group_has_user_user1_idx');
        }
        $this->table("participant")->addIndex(['user_id'], ['name' => "fk_group_has_user_user1_idx", 'unique' => false])->save();
        if($this->table('participant')->hasIndex('fk_group_has_user_group1_idx')) {
            $this->table("participant")->removeIndexByName('fk_group_has_user_group1_idx');
        }
        $this->table("participant")->addIndex(['group_id'], ['name' => "fk_group_has_user_group1_idx", 'unique' => false])->save();
        $table = $this->table("permission", ['engine' => "InnoDB", 'encoding' => "utf8mb4", 'collation' => "utf8mb4_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('permission')->hasColumn('id')) {
            $this->table("permission")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable', 'comment' => "the table for the permissions"])->update();
        } else {
            $this->table("permission")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable', 'comment' => "the table for the permissions"])->update();
        }
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 45, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'id'])->update();
        $table->addColumn('level', 'string', ['null' => false, 'limit' => 45, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'name'])->update();
        $table->save();
        $table = $this->table("team", ['engine' => "InnoDB", 'encoding' => "utf8mb4", 'collation' => "utf8mb4_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('team')->hasColumn('id')) {
            $this->table("team")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("team")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $table->addColumn('car_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'id'])->update();
        $table->addColumn('group_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'car_id'])->update();
        $table->addColumn('hash', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'group_id'])->update();
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 45, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'hash'])->update();
        $table->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'after' => 'name'])->update();
        $table->addColumn('created_by', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'created_at'])->update();
        $table->addColumn('modified_at', 'datetime', ['null' => true, 'after' => 'created_by'])->update();
        $table->addColumn('modified_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'modified_at'])->update();
        $table->addColumn('archived_at', 'datetime', ['null' => true, 'after' => 'modified_by'])->update();
        $table->addColumn('archived_by', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'archived_at'])->update();
        $table->save();
        if($this->table('team')->hasIndex('fk_team_car1_idx')) {
            $this->table("team")->removeIndexByName('fk_team_car1_idx');
        }
        $this->table("team")->addIndex(['car_id'], ['name' => "fk_team_car1_idx", 'unique' => false])->save();
        if($this->table('team')->hasIndex('fk_team_group1_idx')) {
            $this->table("team")->removeIndexByName('fk_team_group1_idx');
        }
        $this->table("team")->addIndex(['group_id'], ['name' => "fk_team_group1_idx", 'unique' => false])->save();
        $table = $this->table("user", ['engine' => "InnoDB", 'encoding' => "utf8mb4", 'collation' => "utf8mb4_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('user')->hasColumn('id')) {
            $this->table("user")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("user")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $table->addColumn('permission_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'id'])->update();
        $table->addColumn('username', 'string', ['null' => false, 'limit' => 50, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'permission_id'])->update();
        $table->addColumn('first_name', 'string', ['null' => false, 'limit' => 45, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'username'])->update();
        $table->addColumn('password', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'first_name'])->update();
        $table->addColumn('email', 'string', ['null' => true, 'limit' => 255, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'password'])->update();
        $table->addColumn('last_name', 'string', ['null' => true, 'limit' => 45, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'email'])->update();
        $table->save();
        if($this->table('user')->hasIndex('fk_user_permission1_idx')) {
            $this->table("user")->removeIndexByName('fk_user_permission1_idx');
        }
        $this->table("user")->addIndex(['permission_id'], ['name' => "fk_user_permission1_idx", 'unique' => false])->save();
        $table = $this->table("wavetrophy", ['engine' => "InnoDB", 'encoding' => "utf8mb4", 'collation' => "utf8mb4_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('wavetrophy')->hasColumn('id')) {
            $this->table("wavetrophy")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("wavetrophy")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $table->addColumn('name', 'string', ['null' => false, 'limit' => 45, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'id'])->update();
        $table->addColumn('country', 'string', ['null' => false, 'limit' => 45, 'collation' => "utf8mb4_unicode_ci", 'encoding' => "utf8mb4", 'after' => 'name'])->update();
        $table->save();
    }
}
