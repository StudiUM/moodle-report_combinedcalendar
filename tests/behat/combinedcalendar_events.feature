@report @report_combinedcalendar @javascript
Feature: Combined calendar
  As a teacher
  I need to check the result of the course combined calendar

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | teacher1 | Teacher1   | t1        | teacher1@example.com |
    And the following "courses" exist:
      | fullname | shortname | format | startdate   |
      | Course 1 | C1        | topics | 1645315200  |
      | Course 2 | C2        | topics | 1645315200  |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher1 | C1     | teacher        |
      | teacher1 | C2     | teacher        |
    And the following "users" exist:
      | username | firstname | lastname | email                |
      | student1 | Student1   | s1      | student1@example.com |
      | student2 | Student2   | s2      | student2@example.com |
      | student3 | Student3   | s3      | student3@example.com |
      | student4 | Student4   | s4      | student4@example.com |
      | teacher2 | Teacher2   | t2      | teacher2@example.com |
      | teacher3 | Teacher3   | t3      | teacher3@example.com |
      | manager1 | Manager1   | m1      | manager1@example.com |
      | student1a | student1a   | s1a      | student1a@example.com |
      | student2a | student2a   | s2a      | student2a@example.com |
      | student1b | student1b   | s1b      | student1b@example.com |
      | student2b | student2b   | s2b      | student2b@example.com |
    And the following "course enrolments" exist:
      | user      | course | role    |
      | student1  | C1     | student |
      | student2  | C1     | student |
      | student3  | C1     | student |
      | student4  | C1     | student |
      | teacher2  | C1     | teacher |
      | teacher3  | C1     | teacher |
      | manager1  | C1     | manager |
      | student1a | C2     | student |
      | student2a | C2     | student |
      | student1b | C2     | student |
      | student2b | C2     | student |
    And the following "groups" exist:
      | name    | course | idnumber |
      | Group 1 | C1     | G1       |
      | Group 2 | C1     | G2       |
      | Group 3 | C1     | G3       |
      | Group 4 | C1     | G4       |
      | Group 5 | C1     | G5       |
      | Group a | C2     | Ga       |
      | Group b | C2     | Gb       |
    And the following "group members" exist:
      | user     | group |
      | manager1 | G1    |
      | teacher1 | G2    |
      | teacher2 | G2    |
      | teacher3 | G3    |
      | student1 | G4    |
      | student2 | G4    |
      | student3 | G5    |
      | student4 | G5    |
      | student1a | Ga    |
      | student2a | Ga    |
      | student1b | Gb    |
      | student2b | Gb    |
    And I log in as "admin"
    And I am on "Course 1" course homepage with editing mode on
    And I add the "Calendar" block
    # create event 1 in course 1
    And I follow "This month"
    And I press "New event"
    And I set the field "Event title" to "Event 1"
    And I set the field "timestart[day]" to "10"
    And I set the field "timestart[month]" to "3"
    And I set the field "timestart[year]" to "2022"
    And I set the field "timestart[hour]" to "8"
    And I set the field "timestart[minute]" to "30"
    And I set the field "Type of event" to "group"
    And I set the field "Group" to "Group 1"
    And I click on "Show more" "link"
    And I set the field "Until" to "1"
    And I set the field "timedurationuntil[day]" to "10"
    And I set the field "timedurationuntil[month]" to "3"
    And I set the field "timedurationuntil[year]" to "2022"
    And I set the field "timedurationuntil[hour]" to "11"
    And I set the field "timedurationuntil[minute]" to "30"
    And I press "Save"
    # create event 2 in course 1
    And I am on "Course 1" course homepage
    And I follow "This month"
    And I press "New event"
    And I set the field "Event title" to "Event 1"
    And I set the field "timestart[day]" to "10"
    And I set the field "timestart[month]" to "3"
    And I set the field "timestart[year]" to "2022"
    And I set the field "timestart[hour]" to "8"
    And I set the field "timestart[minute]" to "30"
    And I set the field "Type of event" to "group"
    And I set the field "Group" to "Group 2"
    And I click on "Show more" "link"
    And I set the field "Until" to "1"
    And I set the field "timedurationuntil[day]" to "10"
    And I set the field "timedurationuntil[month]" to "3"
    And I set the field "timedurationuntil[year]" to "2022"
    And I set the field "timedurationuntil[hour]" to "11"
    And I set the field "timedurationuntil[minute]" to "30"
    And I press "Save"
    # create event 3 in course 1
    And I am on "Course 1" course homepage
    And I follow "This month"
    And I press "New event"
    And I set the field "Event title" to "Event 1"
    And I set the field "timestart[day]" to "10"
    And I set the field "timestart[month]" to "3"
    And I set the field "timestart[year]" to "2022"
    And I set the field "timestart[hour]" to "8"
    And I set the field "timestart[minute]" to "30"
    And I set the field "Type of event" to "group"
    And I set the field "Group" to "Group 4"
    And I click on "Show more" "link"
    And I set the field "Until" to "1"
    And I set the field "timedurationuntil[day]" to "10"
    And I set the field "timedurationuntil[month]" to "3"
    And I set the field "timedurationuntil[year]" to "2022"
    And I set the field "timedurationuntil[hour]" to "11"
    And I set the field "timedurationuntil[minute]" to "30"
    And I press "Save"
    # create event 4 in course 1
    And I am on "Course 1" course homepage
    And I follow "This month"
    And I press "New event"
    And I set the field "Event title" to "Event 2"
    And I set the field "timestart[day]" to "10"
    And I set the field "timestart[month]" to "3"
    And I set the field "timestart[year]" to "2022"
    And I set the field "timestart[hour]" to "13"
    And I set the field "timestart[minute]" to "15"
    And I set the field "Type of event" to "group"
    And I set the field "Group" to "Group 1"
    And I click on "Show more" "link"
    And I set the field "Until" to "1"
    And I set the field "timedurationuntil[day]" to "10"
    And I set the field "timedurationuntil[month]" to "3"
    And I set the field "timedurationuntil[year]" to "2022"
    And I set the field "timedurationuntil[hour]" to "15"
    And I set the field "timedurationuntil[minute]" to "30"
    And I press "Save"
    # create event 5 in course 1
    And I am on "Course 1" course homepage
    And I follow "This month"
    And I press "New event"
    And I set the field "Event title" to "Event 2"
    And I set the field "timestart[day]" to "10"
    And I set the field "timestart[month]" to "3"
    And I set the field "timestart[year]" to "2022"
    And I set the field "timestart[hour]" to "13"
    And I set the field "timestart[minute]" to "15"
    And I set the field "Type of event" to "group"
    And I set the field "Group" to "Group 3"
    And I click on "Show more" "link"
    And I set the field "Until" to "1"
    And I set the field "timedurationuntil[day]" to "10"
    And I set the field "timedurationuntil[month]" to "3"
    And I set the field "timedurationuntil[year]" to "2022"
    And I set the field "timedurationuntil[hour]" to "15"
    And I set the field "timedurationuntil[minute]" to "30"
    And I press "Save"
    # create event 6 in course 1
    And I am on "Course 1" course homepage
    And I follow "This month"
    And I press "New event"
    And I set the field "Event title" to "Event 2"
    And I set the field "timestart[day]" to "10"
    And I set the field "timestart[month]" to "3"
    And I set the field "timestart[year]" to "2022"
    And I set the field "timestart[hour]" to "13"
    And I set the field "timestart[minute]" to "15"
    And I set the field "Type of event" to "group"
    And I set the field "Group" to "Group 5"
    And I click on "Show more" "link"
    And I set the field "Until" to "1"
    And I set the field "timedurationuntil[day]" to "10"
    And I set the field "timedurationuntil[month]" to "3"
    And I set the field "timedurationuntil[year]" to "2022"
    And I set the field "timedurationuntil[hour]" to "15"
    And I set the field "timedurationuntil[minute]" to "30"
    And I press "Save"
    # create event 7 in course 1
    And I am on "Course 1" course homepage
    And I follow "This month"
    And I press "New event"
    And I set the field "Event title" to "Event 3"
    And I set the field "timestart[day]" to "14"
    And I set the field "timestart[month]" to "3"
    And I set the field "timestart[year]" to "2022"
    And I set the field "timestart[hour]" to "9"
    And I set the field "timestart[minute]" to "00"
    And I set the field "Type of event" to "group"
    And I set the field "Group" to "Group 1"
    And I click on "Show more" "link"
    And I set the field "Until" to "1"
    And I set the field "timedurationuntil[day]" to "14"
    And I set the field "timedurationuntil[month]" to "3"
    And I set the field "timedurationuntil[year]" to "2022"
    And I set the field "timedurationuntil[hour]" to "12"
    And I set the field "timedurationuntil[minute]" to "00"
    And I press "Save"
    # create event 8 in course 1
    And I am on "Course 1" course homepage
    And I follow "This month"
    And I press "New event"
    And I set the field "Event title" to "Event 3"
    And I set the field "timestart[day]" to "14"
    And I set the field "timestart[month]" to "3"
    And I set the field "timestart[year]" to "2022"
    And I set the field "timestart[hour]" to "9"
    And I set the field "timestart[minute]" to "00"
    And I set the field "Type of event" to "group"
    And I set the field "Group" to "Group 3"
    And I click on "Show more" "link"
    And I set the field "Until" to "1"
    And I set the field "timedurationuntil[day]" to "14"
    And I set the field "timedurationuntil[month]" to "3"
    And I set the field "timedurationuntil[year]" to "2022"
    And I set the field "timedurationuntil[hour]" to "12"
    And I set the field "timedurationuntil[minute]" to "00"
    And I press "Save"
    # create event 9 in course 1
    And I am on "Course 1" course homepage
    And I follow "This month"
    And I press "New event"
    And I set the field "Event title" to "Event 3"
    And I set the field "timestart[day]" to "14"
    And I set the field "timestart[month]" to "3"
    And I set the field "timestart[year]" to "2022"
    And I set the field "timestart[hour]" to "9"
    And I set the field "timestart[minute]" to "00"
    And I set the field "Type of event" to "group"
    And I set the field "Group" to "Group 4"
    And I click on "Show more" "link"
    And I set the field "Until" to "1"
    And I set the field "timedurationuntil[day]" to "14"
    And I set the field "timedurationuntil[month]" to "3"
    And I set the field "timedurationuntil[year]" to "2022"
    And I set the field "timedurationuntil[hour]" to "12"
    And I set the field "timedurationuntil[minute]" to "00"
    And I press "Save"
    And I am on "Course 2" course homepage with editing mode on
    And I add the "Calendar" block
    # create event 1 in course 2
    And I follow "This month"
    And I press "New event"
    And I set the field "Event title" to "Event 1"
    And I set the field "timestart[day]" to "10"
    And I set the field "timestart[month]" to "3"
    And I set the field "timestart[year]" to "2022"
    And I set the field "timestart[hour]" to "8"
    And I set the field "timestart[minute]" to "30"
    And I set the field "Type of event" to "group"
    And I set the field "Group" to "Group a"
    And I click on "Show more" "link"
    And I set the field "Until" to "1"
    And I set the field "timedurationuntil[day]" to "10"
    And I set the field "timedurationuntil[month]" to "3"
    And I set the field "timedurationuntil[year]" to "2022"
    And I set the field "timedurationuntil[hour]" to "11"
    And I set the field "timedurationuntil[minute]" to "30"
    And I press "Save"
    # create event 2 in course 2
    And I am on "Course 2" course homepage
    And I follow "This month"
    And I press "New event"
    And I set the field "Event title" to "Event 2"
    And I set the field "timestart[day]" to "10"
    And I set the field "timestart[month]" to "3"
    And I set the field "timestart[year]" to "2022"
    And I set the field "timestart[hour]" to "8"
    And I set the field "timestart[minute]" to "30"
    And I set the field "Type of event" to "group"
    And I set the field "Group" to "Group b"
    And I click on "Show more" "link"
    And I set the field "Until" to "1"
    And I set the field "timedurationuntil[day]" to "10"
    And I set the field "timedurationuntil[month]" to "3"
    And I set the field "timedurationuntil[year]" to "2022"
    And I set the field "timedurationuntil[hour]" to "11"
    And I set the field "timedurationuntil[minute]" to "30"
    And I press "Save"
    # create event 3 in course 2
    And I am on "Course 2" course homepage
    And I follow "This month"
    And I press "New event"
    And I set the field "Event title" to "Event 3"
    And I set the field "timestart[day]" to "16"
    And I set the field "timestart[month]" to "3"
    And I set the field "timestart[year]" to "2022"
    And I set the field "timestart[hour]" to "9"
    And I set the field "timestart[minute]" to "00"
    And I set the field "Type of event" to "group"
    And I set the field "Group" to "Group b"
    And I click on "Show more" "link"
    And I set the field "Until" to "1"
    And I set the field "timedurationuntil[day]" to "16"
    And I set the field "timedurationuntil[month]" to "3"
    And I set the field "timedurationuntil[year]" to "2022"
    And I set the field "timedurationuntil[hour]" to "12"
    And I set the field "timedurationuntil[minute]" to "00"
    And I press "Save"
    And I log out

  @javascript
  Scenario: View course calendar events between the two selected dates 
    Given I log in as "teacher1"
    And I am on "Course 1" course homepage
    And I navigate to "More" in current page administration
    And I follow "Combined calendar"
    And I should see "Start"
    And I should see "End"
    And I set the following fields to these values:
      | start[day]          |  10       |
      | start[month]        |  3        |
      | start[year]         |  2022     |
      | end[day]            |  20       |
      | end[month]          |  3        |
      | end[year]           |  2022     |
    When I press "Display"
    Then the following should exist in the "combined-calendar-table" table:
      | Dates      | 2022-03-10  |  2022-03-14   |
    And the following should exist in the "combined-calendar-table" table:
      |     1      |        2       |        3       |       4        |
      | Hours      | 08:30 to 11:30 | 13:15 to 15:30 | 09:00 to 12:00 |
      | Group 1    | Manager1 m1    | Manager1 m1    | Manager1 m1    |
      | Group 2    | Teacher1 t1    |                |                |
      | Group 2    | Teacher2 t2    |                |                |
      | Group 3    |                | Teacher3 t3    | Teacher3 t3    |
      | Group 4    | Student1 s1    |                | Student1 s1    |
      | Group 4    | Student2 s2    |                | Student2 s2    |
      | Group 5    |                | Student3 s3    |                |
      | Group 5    |                | Student4 s4    |                |

  @javascript
  Scenario: View another course calendar events between the two selected dates 
    Given I log in as "teacher1"
    And I am on "Course 2" course homepage
    And I navigate to "More" in current page administration
    And I follow "Combined calendar"
    And I should see "Start"
    And I should see "End"
    And I set the following fields to these values:
      | start[day]          |  10       |
      | start[month]        |  3        |
      | start[year]         |  2022     |
      | end[day]            |  20       |
      | end[month]          |  3        |
      | end[year]           |  2022     |
    When I press "Display"
    Then the following should exist in the "combined-calendar-table" table:
      | Dates      | 2022-03-10  |  2022-03-16   |
    And the following should exist in the "combined-calendar-table" table:
      |     1      |        2       |        3       |
      | Hours      | 08:30 to 11:30 | 09:00 to 12:00 |
      | Group a    | student1a s1a  |                |
      | Group a    | student2a s2a  |                |
      | Group b    | student1b s1b  |  student1b s1b |
      | Group b    | student2b s2b  |  student2b s2b |

  Scenario: There are no events between the two selected dates
    Given I log in as "teacher1"
    And I am on "Course 1" course homepage
    And I navigate to "More" in current page administration
    And I follow "Combined calendar"
    And I set the following fields to these values:
      | start[day]          |  20       |
      | start[month]        |  3        |
      | start[year]         |  2022     |
      | end[day]            |  24       |
      | end[month]          |  3        |
      | end[year]           |  2022     |
    When I press "Display"
    Then I should see "There are no events between the two selected dates"
    And I am on "Course 2" course homepage
    And I navigate to "More" in current page administration
    And I follow "Combined calendar"
    And I set the following fields to these values:
      | start[day]          |  21       |
      | start[month]        |  3        |
      | start[year]         |  2022     |
      | end[day]            |  25       |
      | end[month]          |  3        |
      | end[year]           |  2022     |
    When I press "Display"
    Then I should see "There are no events between the two selected dates"
