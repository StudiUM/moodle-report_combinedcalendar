<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Unit tests for report_combinedcalendar lib.
 *
 * @package   report_combinedcalendar
 * @category  test
 * @author    Annouar Faraman <annouar.faraman@umontreal.ca>
 * @copyright 2022 Université de Montréal
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace report_combinedcalendar;

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/report/combinedcalendar/lib.php');
require_once($CFG->dirroot . '/calendar/tests/externallib_test.php');

/**
 * Unit tests for report_combinedcalendar lib
 *
 * @package   report_combinedcalendar
 * @category  test
 * @author    Annouar Faraman <annouar.faraman@umontreal.ca>
 * @copyright 2022 Université de Montréal
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class lib_test extends \advanced_testcase {

    /**
     * Set up for every test
     */
    public function setUp(): void {
        $this->resetAfterTest();
        $this->setAdminUser();
    }

    /**
     * Test report_combinedcalendar_validate_dates function.
     */
    public function test_report_combinedcalendar_validate_dates() {
        global $OUTPUT;

        // Success.
        $start = strtotime("22 February 2022");
        $end = strtotime("25 February 2022");
        $result = report_combinedcalendar_validate_dates($start, $end);
        $expectedresult = array('success' => true, 'error' => '');
        $this->assertEquals($expectedresult, $result);

        // Error : Start is greater than end.
        $start = strtotime("28 February 2022");
        $end = strtotime("25 February 2022");
        $result = report_combinedcalendar_validate_dates($start, $end);
        $expectedresult = array('success' => false,
            'error' => $OUTPUT->render_from_template('report_combinedcalendar/endgreaterthanstarterror', []));
        $this->assertEquals($expectedresult, $result);

        // Error : The inerval between start and end is greater than 30 days.
        $start = strtotime("22 February 2022");
        $end = strtotime("25 April 2022");
        $result = report_combinedcalendar_validate_dates($start, $end);
        $expectedresult = array('success' => false,
            'error' => $OUTPUT->render_from_template('report_combinedcalendar/endstartintervalerror', []));
        $this->assertEquals($expectedresult, $result);
    }

    /**
     * Test get_combined_calendar_data function.
     */
    public function test_get_combined_calendar_data() {
        global $DB;

        $generator = $this->getDataGenerator();

        // Create course.
        $course = $generator->create_course();

        // Create users.
        $student1 = $generator->create_user();
        $student2 = $generator->create_user();
        $student3 = $generator->create_user();
        $student4 = $generator->create_user();
        $teacher1 = $generator->create_user();
        $teacher2 = $generator->create_user();

        // Users enrolments.
        $studentrole = $DB->get_record('role', array('shortname' => 'student'));
        $teacherrole = $DB->get_record('role', array('shortname' => 'editingteacher'));
        $generator->enrol_user($student1->id, $course->id, $studentrole->id, 'manual');
        $generator->enrol_user($student2->id, $course->id, $studentrole->id, 'manual');
        $generator->enrol_user($student3->id, $course->id, $studentrole->id, 'manual');
        $generator->enrol_user($student4->id, $course->id, $studentrole->id, 'manual');
        $generator->enrol_user($teacher1->id, $course->id, $teacherrole->id, 'manual');
        $generator->enrol_user($teacher2->id, $course->id, $teacherrole->id, 'manual');

        // Create groups.
        $group1 = $generator->create_group(array('courseid' => $course->id));
        $group2 = $generator->create_group(array('courseid' => $course->id));
        $group3 = $generator->create_group(array('courseid' => $course->id));
        $group4 = $generator->create_group(array('courseid' => $course->id));

        // Adding users to groups.
        $generator->create_group_member(array('userid' => $student1->id, 'groupid' => $group1->id));
        $generator->create_group_member(array('userid' => $student2->id, 'groupid' => $group1->id));
        $generator->create_group_member(array('userid' => $student3->id, 'groupid' => $group2->id));
        $generator->create_group_member(array('userid' => $student4->id, 'groupid' => $group2->id));
        $generator->create_group_member(array('userid' => $teacher1->id, 'groupid' => $group3->id));
        $generator->create_group_member(array('userid' => $teacher2->id, 'groupid' => $group4->id));

        // Create calendar event 1.
        $record = new \stdClass();
        $record->courseid = $course->id;
        $record->groupid = $group1->id;
        $record->timestart = strtotime("2022-02-20 8:00");
        $record->timeduration = 10800;
        \core_calendar_externallib_testcase::create_calendar_event('session 1', 0,
            'group', 0, null, $record);

        // Create calendar event 2.
        $record = new \stdClass();
        $record->courseid = $course->id;
        $record->groupid = $group3->id;
        $record->timestart = strtotime("2022-02-20 8:00");
        $record->timeduration = 10800;
        \core_calendar_externallib_testcase::create_calendar_event('session 1', 0,
            'group', 0, null, $record);

        // Create calendar event 3.
        $record = new \stdClass();
        $record->courseid = $course->id;
        $record->groupid = $group2->id;
        $record->timestart = strtotime("2022-02-22 13:30");
        $record->timeduration = 7200;
        \core_calendar_externallib_testcase::create_calendar_event('session 2', 0,
            'group', 0, null, $record);

        // Create calendar event 4.
        $record = new \stdClass();
        $record->courseid = $course->id;
        $record->groupid = $group4->id;
        $record->timestart = strtotime("2022-02-22 13:30");
        $record->timeduration = 7200;
        \core_calendar_externallib_testcase::create_calendar_event('session 2', 0,
            'group', 0, null, $record);

        // There are some events between the two dates.
        $start = strtotime("20 February 2022");
        $end = strtotime("25 February 2022");
        $result = get_combined_calendar_data($start, $end, $course->id);
        $expectedevents = array(array('date' => '2022-02-20', 'timeslot' => '08:00 to 11:00'),
            array('date' => '2022-02-22', 'timeslot' => '13:30 to 15:30')
        );

        $this->assertTrue($result['hasevents']);
        $this->assertEquals($expectedevents, $result['events']);
        $this->assertCount(4, $result['groups']);

        // There are no events between the two dates.
        $start = strtotime("25 February 2022");
        $end = strtotime("27 February 2022");
        $result = get_combined_calendar_data($start, $end, $course->id);
        $expectedevents = array(array('date' => '2022-02-20', 'timeslot' => '08:00 to 11:00'),
            array('date' => '2022-02-22', 'timeslot' => '13:30 to 15:30')
        );

        $this->assertFalse($result['hasevents']);
    }
}

