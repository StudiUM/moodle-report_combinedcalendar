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

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

/**
 * Combined calendar form class.
 *
 * @package   report_combinedcalendar
 * @author    Annouar Faraman <annouar.faraman@umontreal.ca>
 * @copyright 2022 Université de Montréal
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class combinedcalendar_form extends moodleform {

    /**
     * Defines forms elements
     */
    public function definition() {
        global $CFG, $PAGE;

        $mform = $this->_form;

        // Adding export form fieldset.
        $mform->addElement('header', 'combinedcalendarformheader', get_string('formheader', 'report_combinedcalendar'));

        // Adding dates fields.
        $mform->addElement('date_selector', 'start', get_string('start', 'report_combinedcalendar'));

        $mform->addElement('date_selector', 'end', get_string('end', 'report_combinedcalendar'));

        // Adding a submit button.
        $mform->addElement('submit', 'displaybutton', get_string('display', 'report_combinedcalendar'));
    }
}

