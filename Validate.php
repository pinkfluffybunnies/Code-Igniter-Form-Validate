<?php
/* CLASS Validate - Copyright 2011
 * Author: Rik Davis
 * Version: 1.0.0
 * Release: 2011-12-04
 * ------------------------
 * Please see README for detailed documentation about installation and usage.
 *
 * This file is part of the Validate project.
 *
 * Foobar is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Validate is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with Validate.php.  If not, see <http://www.gnu.org/licenses/>.
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Validate {
  private $object;
  private $rules     = array();
  private $results   = array();
  public $field_vals = array();

  function __construct() {
    $this->object  =& get_instance();
    $this->results = new Results();
  }

  /* Function: is_valid
   * Description: I would have named this validate, but that would have conflicted with the constructor.
   *              This method is the heart of the class and performs the automated testing of every field
   *              posted versus every field listed in the defined ruleset.
   * $set: string name of rule set to load
   * $case_sensative: Sets whether the regex statement of the rule is case insensative or not. Defaults to true if not supplied.
   */
  function is_valid($set, $case_insensative = true) {
    # Load up the desired rule set
    $this->load_rule_set($set);

    # Process form args
    foreach($_POST as $key => $val) {
      if(!preg_match('/submit/i', $key)) { # Skip submit field post
        if($key == 'cap_code' && ($val == 'Enter Image Code' || is_null($val) || empty($val))) {
          $this->results->missing[$key] = "{$this->rules[$key]['field']} is missing";
          $this->results->errors++;
          continue;
        }

        $this->store_field_value($key, $val);  # Store values for repopulating the form

        # Make missing conditional based on required flag
        $required = $this->rules[$key]['required'];
        if($required) {
          $this->_is_missing($key, $this->rules[$key]['field'], $val);
          if(isset($this->results->missing[$key])) {  # if missing detected, skip to next iteration
            continue;
          }
        }

        # If missing fell through, check invalid
        $this->is_invalid($key, $this->rules[$key]['field'], $val, $case_insensative);

        if(!count($this->results->missing) && !count($this->results->invalid)) {
          $this->results->valid[$key] = $val;
        }
      }
    }
    return $this->results;
  }

  /* Function: validate_input
   * Description: Can be used to validate a single input. Requires manually supplied parameters
   *              versus the automagic method is_valid
   * $set: string name of rule set to load
   * $field: string name of form field to validate
   * $value: string to perform validation test against
   * $case_sensative: Sets whether the regex statement of the rule is case insensative or not. Defaults to true if not supplied.
   */
  function validate_input($set, $field, $value, $case_insensative = true) {
    # Load up the desired rule set
    $this->load_rule_set($set);

    $ins = '';
    # Handle case sensativity
    if($case_insensative)	{
      $ins = 'i';
    }
    $regex = '/' . $this->rules[$field]['regex'] . '/' . $ins;  # Create regex from field name

    if(preg_match($regex, $value)) {
      return 1;
    } else {
      return 0;
    }
  }

 /* Function: load_rule_set
  * Access: Private
  * Description: Will load the rule set supplied by attempting to load the set from the validation_rules file.
  * $set: string name of rule set to load.
  */
  private function load_rule_set($set) {
    $rules = $this->object->config->item('rules');
    $this->rules = $rules[$set];
    return;
  }

 /* Function: _store_field_value
  * Access: Private
  * Description: This method will store the value submitted by the user for recall later by the get_field_value method.
  * $key: string field name of for key-based reference during recall.
  * $val: mixed type of whatever value is to be associated with the key.
  */
  private function _store_field_value($key, $val) {
    $this->field_vals[$key] = $val;
    return;
  }

 /* Function: get_field_value
  * Access: Public
  * Description: This method will retrieve a stored value for the purposes of re-populating form fields.
  * $field_name: string field name of stored field value to retrieve.
  */
  function get_field_value($field_name) {
    if(!isset($this->field_vals[$field_name])) {
      return '';
    }
    return $this->field_vals[$field_name];
  }

 /* Function: _is_missing
  * Access: Private
  * Description: This method checks if a field should be classified as missing a value. It's assumed that
  *              missing fields are required and hence, the missing status.
  * $field_name: string form field name to check for missing value.
  * $field_text: string name of display text to use for error displaying
  * $val: string value to check against.
  */
  private function _is_missing($field_name, $field_text, $val) {
    if(strlen($val) == 0 || is_null($val)) {
      $this->results->missing[$field_name] = "$field_text is missing";
      $this->results->errors++;
    }
	return;
  }

 /* Function: _is_invalid
  * Access: Private
  * Description: This method runs the supplied value through the regular expression engine and returns whether
  *              the value passed or failed the rule.
  * $field_name: string form field name to check for missing value.
  * $field_text: string name of display text to use for error displaying
  * $val: string value to check against.
  * $case_insensative: Passed down from its caller, but sets case sensativity for the regex statement.
  */
  private function is_invalid($field_name, $field_text, $val, $case_insensative) {
    $ins = '';
    # Handle case sensativity
    if($case_insensative)	{
      $ins = 'i';
    }
    $regex = '/' . $this->rules[$field_name]['regex'] . '/' . $ins;	# Create regex from field name

    if(!preg_match($regex, $val)) {
      $this->results->invalid[$field_name] = "$field_text is invalid";
      $this->results->errors++;
    }
	return;
  }

 /* Function: has_errors
  * Access: Public
  * Description: This mthod simply determines if anything was missing or invalid and returns true
  *              for found errors and false for lack thereof.
  * Returns: Boolean
  *          TRUE  => Errors present
  *          FALSE => No errors present
  */
  function has_errors() {
    if(count($this->results->missing) || count($this->results->invalid) || count($this->results->errors)) {
      return TRUE;
    }
    return FALSE;
  }

 /* Function: get_last_error
  * Access: Public
  * Description: This method retrieves the last error pushed to either of the missing or invalid stacks.
  *              Its typical usage is to determine if errors are present, but using the has_errors method
  *              is probably a better candidate for that purpose.
  * Returns: string value of last error message. Missing takes precedence over invalid in this method.
  */
  function get_last_error() {
    if(count($this->results->missing) > 0) {
      $keys = array_keys($this->results->missing);
      return $this->results->missing[$keys[0]];
    } elseif(count($this->results->invalid) > 0) {
      $keys = array_keys($this->results->invalid);
      return $this->results->invalid[$keys[0]];
    }
  }

 /* Function: format_errors
  * Access: Public
  * Description: This method aggrigates all missing and invalid errors and formats them into an HTML string
  *              composed of an unordered list.
  * Returns: String of HTML tags compiled into an unordered list of all errors found.
  */
  function format_errors() {
    $outHtml = '';
    # handle missings
    if(count($this->results->missing)) {
      $outHtml .= "Missing Fields<br />\n";
      $outHtml .= "<ul>\n";
      foreach($this->results->missing as $field => $msg) {
        $outHtml .= "  <li>$msg</li>\n";
      }
      $outHtml .= "</ul>\n";
    }

    # handle invalids
    if(count($this->results->invalid)) {
      $outHtml .= "Invalid Fields<br />\n";
      $outHtml .= "<ul>\n";
      foreach($this->results->invalid as $field => $msg) {
        $outHtml .= "  <li>$msg</li>\n";
      }
      $outHtml .= "</ul>\n";
    }
    return $outHtml;
  }
}

/* CLASS Results
 * Description: This class is simply a container object for holding each occurance of validation
 *              error states in key/value structure. No constructor is used as the properties
 *              become accessible to the caller upon instantiation.
 */
class Results {
  public $valid   = array();
  public $invalid = array();
  public $missing = array();
  public $errors  = array();
}
?>
