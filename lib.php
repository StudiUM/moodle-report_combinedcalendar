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
 * Validate dates.
 *
 * @param int|false $start Start timestamp
 * @param int|false $end End timestamp
 * @return array
 */
function report_combinedcalendar_validate_dates($start, $end) {
    global $OUTPUT;

    $result = array('success' => false, 'error' => '');

    if ($start < $end) {
        $startdatetime = new DateTime('@' . $start);
        $enddatetime = new DateTime('@' . $end);
        $interval = $startdatetime->diff($enddatetime);
        $daysdiff = $interval->format('%a');

        if ($daysdiff <= 30) {
            $result['success'] = true;
        } else {
            $result['error'] = $OUTPUT->render_from_template('report_combinedcalendar/endstartintervalerror', []);
        }
    } else if ($start == $end) {
        $result['success'] = true;
    } else {
        $result['error'] = $OUTPUT->render_from_template('report_combinedcalendar/endgreaterthanstarterror', []);;
    }

    return $result;
}

/**
 * Group calendar events by a field.
 *
 * @param string $field (group|datetime).
 * @param array $calendarevents calendar events.
 * @return array
 */
function report_combinedcalendar_events_group_by($field, $calendarevents) {
    $events = array();
    switch ($field) {
        case 'group':
            foreach ($calendarevents as $element) {
                $events[$element->groupid][date('Y-m-d H:i', $element->timestart)][] = 'group';
            }
          break;
        case 'datetime':
            foreach ($calendarevents as $element) {
                $eventdatetime = date('Y-m-d', $element->timestart).'|'.$element->timestart.'|'.$element->timeduration;
                $events[date('Y-m-d H:i', $element->timestart)][] = $eventdatetime;
            }
          break;
    }

    return $events;
}

/**
 * Get combined calendar groups.
 *
 * @param array $calendareventsbygroup Calendar events by group.
 * @param array $calendareventsbydatetimekeys calendar events by datetime array keys.
 * @return array
 */
function get_combined_calendar_groups($calendareventsbygroup, $calendareventsbydatetimekeys) {

    $result  = array();

    foreach ($calendareventsbygroup as $groupid => $groupeventsdata) {
        // Group name.
        $groupname = groups_get_group_name($groupid);

        // Group members.
        $groupmembers = groups_get_members($groupid);
        foreach ($groupeventsdata as $groupevent) {
            $members = array();
            foreach ($groupmembers as $member) {
                $members[]['member'] = $member->firstname.'  '.$member->lastname;
            }
        }

        // Group events.
        $groupevents = array();
        $groupeventsbydatetime = array_keys($groupeventsdata);
        foreach ($calendareventsbydatetimekeys as $event) {
            if (in_array($event, $groupeventsbydatetime)) {
                array_push($groupevents, array('hasevent' => true, 'members' => $members));
            } else {
                $groupevents[]['hasevent'] = false;
            }
        }

        $groupdata = array('name' => $groupname,
            'groupevents' => $groupevents
        );

        $result[] = $groupdata;
    }

    return $result;
}

/**
 * Get combined calendar events.
 *
 * @param array $calendareventsbydatetime Calendar events by datetime.
 * @return array
 */
function get_combined_calendar_events($calendareventsbydatetime) {

    $result  = array();

    foreach ($calendareventsbydatetime as $event => $data) {
        $eventdata = explode('|', reset($data));

        // Event date.
        $eventdate = $eventdata[0];

        // Event slot.
        $eventslotstart = date('H:i', $eventdata[1]);
        $eventslotend = date('H:i', $eventdata[1] + $eventdata[2]);
        $eventslot = $eventslotstart.' '.get_string('to', 'report_combinedcalendar').' '.$eventslotend;

        $eventdata = array('date' => $eventdate,
            'timeslot' => $eventslot,
        );

        $result[] = $eventdata;
    }

    return $result;
}

/**
 * Get combined calendar dates.
 *
 * @param array $combinedcalendarevents Combined calendar events.
 * @return array
 */
function get_combined_calendar_dates($combinedcalendarevents) {

    $result  = array();

    $dates = array_count_values(array_column($combinedcalendarevents, 'date'));

    foreach ($dates as $date => $count) {

        $datedata = array('date' => $date,
            'count' => $count
        );

        $result[] = $datedata;
    }

    return $result;
}

/**
 * Get combined calendar data.
 *
 * @param int|false $start Start timestamp.
 * @param int|false $end End timestamp.
 * @param int $courseid Course id.
 * @return array
 */
function get_combined_calendar_data($start, $end, $courseid) {

    // Get calendar events.
    $calendarevents = calendar_get_legacy_events($start, $end, true, true, $courseid);

    $calendargroupevents = array_filter($calendarevents, function ($event) {
        return ($event->eventtype == 'group');
    });

    if (!empty($calendarevents)) {
        // Get combined calendar events.
        $calendareventsbydatetime = report_combinedcalendar_events_group_by('datetime', $calendargroupevents);
        $combinedcalendarevents = get_combined_calendar_events($calendareventsbydatetime);

        // Get combined calendar dates.
        $combinedcalendardates = get_combined_calendar_dates($combinedcalendarevents);

        // Get combined calendar groups.
        $calendareventsbygroup = report_combinedcalendar_events_group_by('group', $calendargroupevents);
        $calendareventsbydatetimekeys = array_keys($calendareventsbydatetime);
        $combinedcalendargroups = get_combined_calendar_groups($calendareventsbygroup, $calendareventsbydatetimekeys);

        $datatodisplay = array('hasevents' => true, 'dates' => $combinedcalendardates,
            'events' => $combinedcalendarevents, 'groups' => $combinedcalendargroups);
    } else {
        $datatodisplay = array('hasevents' => false);
    }

    return $datatodisplay;
}

/**
 * Print combined calendar.
 *
 * @param int|false $start Start timestamp
 * @param int|false $end End timestamp
 * @param int $courseid Course id.
 */
function print_combined_calendar($start, $end, $courseid) {
    global $OUTPUT;

    $result = report_combinedcalendar_validate_dates($start, $end);

    if ($result['success']) {
        $end = strtotime("+1 day", $end);
        $combinedcalendardata = get_combined_calendar_data($start, $end, $courseid);
        $toprint = $OUTPUT->render_from_template('report_combinedcalendar/combinedcalendartable', $combinedcalendardata);
    } else {
        $toprint  = $result['error'];
    }

    echo $toprint;
}
