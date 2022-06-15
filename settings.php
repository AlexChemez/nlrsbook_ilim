<?php

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configtext('nlrsbook_ilim/org_token', get_string('org_token', 'block_nlrsbook_ilim'), "", null));
}