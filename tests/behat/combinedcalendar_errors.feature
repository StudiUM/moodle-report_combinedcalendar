@report @report_combinedcalendar
Feature: Combined calendar form testing
  In order to ensure the combined calendar form works as expected
  As an admin
  I need to make some tests

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | teacher1 | Teacher   | 1        | teacher1@example.com |
    And the following "courses" exist:
      | fullname | shortname | format |
      | Course 1 | C1        | topics |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher1 | C1     | editingteacher |
    And I log in as "teacher1"
    And I am on "Course 1" course homepage
    And I navigate to "More" in current page administration
    And I follow "Combined calendar"

  Scenario: Start date is greater than end date
    And I set the following fields to these values:
      | start[day]          |  25       |
      | start[month]        |  3        |
      | start[year]         |  2022     |
      | end[day]            |  26       |
      | end[month]          |  2        |
      | end[year]           |  2022     |
    When I press "Display"
    Then I should see "Please ensure that the End Date is greater than or equal to the Start Date"

  Scenario: The interval between the two selected dates is greater than 30 days
    And I set the following fields to these values:
      | start[day]          |  20       |
      | start[month]        |  2        |
      | start[year]         |  2022     |
      | end[day]            |  25       |
      | end[month]          |  4        |
      | end[year]           |  2022     |
    When I press "Display"
    Then I should see "Please ensure that the interval between the two dates is less than or equal to 30 days"
