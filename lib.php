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
 * Public API of the combined calendar report.
 *
 * Defines the APIs used by combined calendar reports
 *
 * @package   report_combinedcalendar
 * @author    Annouar Faraman <annouar.faraman@umontreal.ca>
 * @copyright 2022 Université de Montréal
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/**
 * This function extends the navigation with the report items
 *
 * @param navigation_node $navigation The navigation node to extend
 * @param stdClass $course The course to object for the report
 * @param stdClass $context The context of the course
 */
function report_combinedcalendar_extend_navigation_course($navigation, $course, $context) {
    if (has_capability('report/combinedcalendar:view', $context)) {
        $url = new moodle_url('/report/combinedcalendar/index.php', array('id' => $course->id));
        $navigation->add(get_string('pluginname', 'report_combinedcalendar'), $url,
            navigation_node::TYPE_SETTING, null, null, new pix_icon('i/report', ''));
    }
}

/**
 * Print selected dates.
 *
 * @param int|false $start Start timestamp
 * @param int|false $end End timestamp
 */
function print_selected_dates($start, $end) {
    if ($start < $end) {
        $onedaytoseconds = 86400;
        $oneyeartoseconds = 365 * $onedaytoseconds;
        $onemonthtoseconds = 30 * $onedaytoseconds;

        $diff = $end - $start;
        $yearsdiff = floor($diff / ($oneyeartoseconds));
        $monthsdiff = floor(($diff - $yearsdiff * $oneyeartoseconds) / $onemonthtoseconds);

        if ($monthsdiff < 1) {
            $toprint = "Start date =======".date('Y-m-d', $start)."<br>".
                "End date =======".date('Y-m-d', $end);
        } else {
            $toprint = '<div class="alert alert-danger" role="alert">'.
                get_string('endstartintervalerror', 'report_combinedcalendar').
                '</div>';
        }
    } else if ($start == $end) {
        $toprint = "Start date =======".date('Y-m-d', $start)."<br>".
            "End date =======".date('Y-m-d', $end);
    } else {
        $toprint = '<div class="alert alert-danger" role="alert">'.
            get_string('endgreaterthanstarterror', 'report_combinedcalendar').
            '</div>';
    }

    echo $toprint;
}
