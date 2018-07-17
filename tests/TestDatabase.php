<?php
/**
 * Created by PhpStorm.
 * User: Björn Pfoster
 * Date: 18.12.2017
 * Time: 22:46
 */

namespace App\Test;


class TestDatabase
{
    public function all()
    {
        return [
//            'article' => $this->article(),
//            'article_description' => $this->article_description(),
//            'article_quality' => $this->article_quality(),
//            'article_title' => $this->article_title(),
//            'city' => $this->city(3),
//            'department' => $this->department(),
//            'department_event' => $this->department_event(),
//            'department_group' => $this->department_group(),
//            'department_region' => $this->department_region(),
//            'department_type' => $this->department_type(),
//            'educational_course' => $this->educational_course(),
//            'educational_course_description' => $this->educational_course_description(),
//            'educational_course_image' => $this->educational_course_image(),
//            'educational_course_organiser' => $this->educational_course_organiser(),
//            'educational_course_participant' => $this->educational_course_participant(),
//            'educational_course_title' => $this->educational_course_title(),
//            'email_token' => $this->email_token(),
//            'event' => $this->event(),
//            'event_description' => $this->event_description(),
//            'event_title' => $this->event_title(),
//            'event_participant' => $this->event_participant(),
//            'event_participation_status' => $this->event_participation_status(),
//            'event_image' => $this->event_image(),
//            'gender' => $this->gender(),
//            'image' => $this->image(),
//            'language' => $this->language(),
//            'permission' => $this->permission(),
//            'position' => $this->position(),
//            'sl_chest' => $this->sl_chest(),
//            'sl_corridor' => $this->sl_corridor(),
//            'sl_location' => $this->sl_location(),
//            'sl_room' => $this->sl_room(),
//            'sl_shelf' => $this->sl_shelf(),
//            'sl_tray' => $this->sl_tray(),
//            'storage_place' => $this->storage_place(),
            'user' => $this->user(),
        ];
    }

    private function image()
    {
        return [
            [
                'id' => '1',
                'hash' => 'hash_test_1',
                'url' => '/img/events/image-url-1.jpg',
                'type' => 'jpg',
                'created_at' => '2017-01-01 10:00:00',
                'created_by' => $this->user()[0]['hash'],
                'modified_at' => null,
                'modified_by' => null,
                'archived_at' => null,
                'archived_by' => null,
            ],
            [
                'id' => '2',
                'hash' => 'hash_test_2',
                'url' => '/img/events/image-url-2.jpg',
                'type' => 'jpg',
                'created_at' => '2017-01-01 10:00:00',
                'created_by' => $this->user()[1]['hash'],
                'modified_at' => null,
                'modified_by' => null,
                'archived_at' => null,
                'archived_by' => null,
            ],
            [
                'id' => '3',
                'hash' => 'hash_test_3',
                'url' => '/img/events/image-url-3.jpg',
                'type' => 'jpg',
                'created_at' => '2017-01-01 10:00:00',
                'created_by' => $this->user()[1]['hash'],
                'modified_at' => null,
                'modified_by' => null,
                'archived_at' => '2017-01-01 11:00:00',
                'archived_by' => '1',
            ],
        ];
    }

    private function permission()
    {
        return [
            [
                'id' => '1',
                'hash' => 'hash_test_1',
                'level' => '64',
                'name' => 'Super Admin',
            ],
            [
                'id' => '2',
                'hash' => 'hash_test_2',
                'level' => '32',
                'name' => 'Admin',
            ],
            [
                'id' => '3',
                'hash' => 'hash_test_3',
                'level' => '16',
                'name' => 'Super User',
            ],
            [
                'id' => '4',
                'hash' => 'hash_test_4',
                'level' => '8',
                'name' => 'User',
            ],
            [
                'id' => '5',
                'hash' => 'hash_test_5',
                'level' => '4',
                'name' => 'Guest',
            ],
            [
                'id' => '6',
                'hash' => 'hash_test_6',
                'level' => '2',
                'name' => 'Anonymous',
            ],
        ];
    }

    /**
     * $this->baseurl method for Test Database.
     *
     * @param string $path
     * @return mixed|string
     */
    private function baseurl(string $path)
    {
        $baseUri = dirname(dirname($_SERVER['SCRIPT_NAME']));
        $result = str_replace('\\', '/', $baseUri) . $path;
        $result = str_replace('//', '/', $result);
        return $result;
    }

    /**
     * Get language table data.
     * @return array
     */
    private function language()
    {
        return [
            [
                'id' => '1',
                'hash' => 'hash_test_1',
                'name' => 'de_CH',
                'abbreviation' => 'de',
            ],
            [
                'id' => '2',
                'hash' => 'hash_test_2',
                'name' => 'en_GB',
                'abbreviation' => 'en',
            ],
            [
                'id' => '3',
                'hash' => 'hash_test_3',
                'name' => 'fr_CH',
                'abbreviation' => 'fr',
            ],
            [
                'id' => '4',
                'hash' => 'hash_test_4',
                'name' => 'it_CH',
                'abbreviation' => 'it',
            ],
        ];
    }

    private function position()
    {
        return [
            [
                'id' => '1',
                'hash' => 'hash_test_1',
                'name_de' => 'Abteilungsleiter',
                'name_en' => 'Head of department',
                'name_fr' => 'Capo dipartimento',
                'name_it' => 'Chef de département',
            ],
            [
                'id' => '2',
                'hash' => 'hash_test_2',
                'name_de' => 'Lagerleiter',
                'name_en' => 'Camp leader',
                'name_fr' => 'Chef de camp',
                'name_it' => 'Capo  del campeggio',
            ],
            [
                'id' => '3',
                'hash' => 'hash_test_3',
                'name_de' => 'Gruppenleiter',
                'name_en' => 'Team leader',
                'name_fr' => 'Chef d\'équipe',
                'name_it' => 'Capogruppo',
            ],
            [
                'id' => '4',
                'hash' => 'hash_test_4',
                'name_de' => 'Hilfsleiter',
                'name_en' => 'Auxiliary conductors',
                'name_fr' => 'Conducteurs auxiliaires',
                'name_it' => 'Conduttori ausiliari',
            ],
            [
                'id' => '5',
                'hash' => 'hash_test_5',
                'name_de' => 'Teilnehmer',
                'name_en' => 'Participants',
                'name_fr' => 'Participants',
                'name_it' => 'Partecipanti',
            ],
            [
                'id' => '6',
                'hash' => 'hash_test_6',
                'name_de' => 'Eltern',
                'name_en' => 'Parent',
                'name_fr' => 'Parent',
                'name_it' => 'Ragazzo',
            ],
        ];
    }

    private function user()
    {
        return [
            [
                'id' => '1',
                'hash' => 'hash_test_1',
                'city_id' => '1',
                'language_hash' => $this->language()[0]['hash'],
                'permission_hash' => $this->language()[0]['hash'],
                'position_hash' => $this->position()[0]['hash'],
                'gender_hash' => $this->gender()[0]['hash'],
                'department_hash' => $this->department()[0]['hash'],
                'first_name' => 'Max',
                'email' => 'max.mustermann@example.com',
                'username' => 'max',
                'cevi_name' => 'asöfd',
                'signup_completed' => true,
                'js_certificate' => true,
                'last_name' => 'Mustermann',
                'address' => 'Examplehausenerstrasse 1',
                'password' => password_hash('mäxle1', PASSWORD_BCRYPT),
                'birthdate' => '1998-06-05',
                'phone' => '012 345 67 89',
                'mobile' => '076 123 45 67',
                'js_certificate_until' => '2019',
                'created_at' => '2017-01-01 00:00:00',
                'created_by' => '0',
            ],
            [
                'id' => '2',
                'hash' => 'hash_test_2',
                'city_id' => '2',
                'language_hash' => $this->language()[1]['hash'],
                'permission_hash' => $this->language()[1]['hash'],
                'position_hash' => $this->position()[0]['hash'],
                'gender_hash' => $this->gender()[1]['hash'],
                'department_hash' => $this->department()[0]['hash'],
                'first_name' => 'Maxine',
                'email' => 'maxine.mustermann@example.com',
                'username' => 'maxine',
                'password' => password_hash('maxine1', PASSWORD_BCRYPT),
                'signup_completed' => true,
                'js_certificate' => true,
                'last_name' => 'Mustermann',
                'address' => 'Examplehausenerstrasse 2',
                'cevi_name' => 'Maus',
                'birthdate' => '1998-06-05',
                'phone' => '012 355 67 89',
                'mobile' => '076 523 45 67',
                'js_certificate_until' => '2019',
                'created_at' => '2017-01-01 00:00:00',
                'created_by' => '0',
            ],
            [
                'id' => '3',
                'hash' => 'hash_test_3',
                'city_id' => '3',
                'language_hash' => $this->language()[0]['hash'],
                'permission_hash' => $this->language()[2]['hash'],
                'position_hash' => $this->position()[2]['hash'],
                'gender_hash' => $this->gender()[1]['hash'],
                'department_hash' => $this->department()[0]['hash'],
                'first_name' => 'Maxinea',
                'email' => 'maxine.mustermann@example.com',
                'username' => 'maxinea',
                'password' => password_hash('maxines1', PASSWORD_BCRYPT),
                'signup_completed' => true,
                'js_certificate' => true,
                'last_name' => 'Mustermann',
                'address' => 'Examplehausenerstrasse 3',
                'cevi_name' => 'Maus',
                'birthdate' => '1998-06-05',
                'phone' => '013 345 67 89',
                'mobile' => '073 133 45 67',
                'js_certificate_until' => '2017',
                'created_at' => '2017-01-01 00:00:00',
                'created_by' => '0',
            ],
        ];
    }

    // TODO continue here creating test database
}
