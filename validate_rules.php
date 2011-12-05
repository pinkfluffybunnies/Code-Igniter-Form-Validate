<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * This file may contain as many rulesets as desired. All that matters is that the desired ruleset be
 * an array element of the $config['rules'] base array.
 * Rulesets are defined in key/value pairs as array elements of the set you defining.
 * ------------------------------------------------------------------------------------------------------------
 * Each array breaks down as follows;
 *
 * form field |        required 0=no, 1=yes | Display name for errors  |  regular expression validation rule
 * ------------------------------------------------------------------------------------------------------------
 * 'login_id' => array('required' => 1,       'field' => 'Login ID',     'regex' => '^[A-Za-z\s]{6,32}$'),
 *
 * See README also.
 * ------------------------------------------------------------------------------------------------------------
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

# Login form rules
$config['rules']['login'] = array(
  'login_id' => array('required' => 1, 'field' => 'Login ID', 'regex' => '^[A-Za-z\s]{6,32}$'),
  'login_pw' => array('required' => 1, 'field' => 'Password', 'regex' => '^[A-Za-z0-9\!_\-\*\.]{6,16}$')
);

$config['rules']['signup'] = array(
  'op'               => array('required' => 0, 'field' => 'op',                      'regex' => '^reg$'),
  'org_name'         => array('required' => 1, 'field' => 'Organization Name',       'regex' => '^[A-Za-z0-9\'\.\-\_\s]{1,80}$'),
  'org_addr'         => array('required' => 1, 'field' => 'Org Address',             'regex' => '^[A-Za-z0-9\'\s\.\-]{1,80}$'),
  'org_city'         => array('required' => 1, 'field' => 'Org City',                'regex' => '^[A-Za-z\'\-\s]{1,40}$'),
  'org_state'        => array('required' => 1, 'field' => 'Org State',               'regex' => '^[0-9]{1,2}$'),
  'org_zipcode'      => array('required' => 1, 'field' => 'Org Zipcode',             'regex' => '^[0-9\-]{5,10}$'),
  'org_day_phone'    => array('required' => 1, 'field' => 'Org Daytime Phone',       'regex' => '^[0-9]{10}|[0-9]{3}\-{1}[0-9]{3}\-{1}[0-9]{4}$'),
  'org_tax_id'       => array('required' => 1, 'field' => 'Org Tax ID',              'regex' => '^[0-9]{9}|[0-9]{2}\-{1}[0-9]{7}$'),
  'min_first_name'   => array('required' => 1, 'field' => 'Minister First Name',     'regex' => '^[A-Za-z\s]{1,40}$'),
  'min_last_name'    => array('required' => 1, 'field' => 'Minister Last Name',      'regex' => '^[A-Za-z\s]{1,40}$'),
  'min_home_addr1'   => array('required' => 1, 'field' => 'Minister Home Address 1', 'regex' => '^[A-Za-z0-9\s\'\.\-]{1,80}$'),
  'min_home_addr2'   => array('required' => 0, 'field' => 'Minister Home Address 2', 'regex' => '^[A-Za-z0-9\s\.\-]{1,80}$'),
  'min_city'         => array('required' => 1, 'field' => 'Minister City',           'regex' => '^[A-Za-z\'\-\s]{1,40}$'),
  'min_state'        => array('required' => 1, 'field' => 'Minister State',          'regex' => '^[0-9]{1,2}$'),
  'min_zipcode'      => array('required' => 1, 'field' => 'Minister Zipcode',        'regex' => '^[0-9\-]{5,10}$'),
  'min_day_phone'    => array('required' => 1, 'field' => 'Org Daytime Phone',       'regex' => '^[0-9]{10}|[0-9]{3}\-{1}[0-9]{3}\-{1}[0-9]{4}$'),
  'min_mobile_phone' => array('required' => 0, 'field' => 'Org Mobile Phone',        'regex' => '^[0-9]{10}|[0-9]{3}\-{1}[0-9]{3}\-{1}[0-9]{4}$'),
  'admin_login_id'   => array('required' => 1, 'field' => 'Admin Login ID',          'regex' => '^[A-Za-z\-\_\s]{6,20}$'),
  'admin_login_pw1'  => array('required' => 1, 'field' => 'Admin Password',          'regex' => '^[A-Za-z0-9\!_\-\*\.]{6,16}$'),
  'admin_login_pw2'  => array('required' => 1, 'field' => 'Confirm Password',        'regex' => '^[A-Za-z0-9\!_\-\*\.]{6,16}$'),
  'admin_email1'     => array('required' => 1, 'field' => 'Admin Email Address',     'regex' => '^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$'),
  'admin_email2'     => array('required' => 1, 'field' => 'Confirm Email Address',   'regex' => '^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$'),
  'cap_code'         => array('required' => 1, 'field' => 'Captcha Code',            'regex' => '^[A-Za-z0-9]+$')
);

$config['rules']['contact'] = array(
  'sndr_name'  => array('required' => 1, 'field' => 'Full Name',     'regex' => '^[A-Za-z\s]{1,80}$'),
  'sndr_email' => array('required' => 1, 'field' => 'Email Address', 'regex' => '^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$'),
  'sndr_subj'  => array('required' => 1, 'field' => 'Subject',       'regex' => '^[0-9]+$'),
  'urgency'    => array('required' => 1, 'field' => 'Urgency',       'regex' => '^[0-3]{1}$'),
  'sndr_msg'   => array('required' => 1, 'field' => 'Your Message',  'regex' => '^[A-Za-z0-9\-\_\.\,\"\'\@\#\$\%\^\&\*\(\)\+\=\[\]\{\}\:\;\/\\\|\!\~\`]+$'),
  'cap_code'   => array('required' => 1, 'field' => 'Image Code',    'regex' => '^[A-Za-z0-9]{1,10}$')
);
?>