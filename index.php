<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Combined calendar report.
 *
 * @package   report_combinedcalendar
 * @author    Annouar Faraman <annouar.faraman@umontreal.ca>
 * @copyright 2022 Université de Montréal
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->dirroot.'/lib/statslib.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->dirroot.'/report/combinedcalendar/lib.php');
require_once($CFG->dirroot.'/report/combinedcalendar/combinedcalendar_form.php');

$id = optional_param('id', 0, PARAM_INT);

$params = array();
if (!empty($id)) {
    $params['id'] = $id;
}

$url = new moodle_url("/report/combinedcalendar/index.php", $params);

$PAGE->set_url('/report/combinedcalendar/index.php', array('id' => $id));
$PAGE->set_pagelayout('report');

// Get course details.
$course = null;
if ($id) {
    $course = $DB->get_record('course', array('id' => $id), '*', MUST_EXIST);
    require_login($course);
    $context = context_course::instance($course->id);
} else {
    require_login();
    $context = context_system::instance();
    $PAGE->set_context($context);
}

$PAGE->set_context($context);
$PAGE->set_title(format_string(get_string('formheader', 'report_combinedcalendar')));
$PAGE->set_heading(format_string($course->fullname));

require_capability('report/combinedcalendar:view', $context);

// Instantiate combinedcalendar_form.
$mform = new combinedcalendar_form($url);

echo $OUTPUT->header();
$mform->display();

// Form processing.
if ($formdata = $mform->get_data()) {
    print_selected_dates($formdata->start, $formdata->end);
}
echo $OUTPUT->footer();
