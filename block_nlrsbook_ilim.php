<?php

class block_nlrsbook_ilim extends block_base {

    public function init() {
        $this->title = get_string('nlrsbook_ilim', 'block_nlrsbook_ilim');
    }

    public function get_content() {
        global $CFG;
        if ($this->content !== null) {
            return $this->content;
        }

        $mainPage = file_get_contents($CFG->dirroot . "/blocks/nlrsbook_ilim/templates/rendermainpage.moustache");
        $mainPage = str_replace('{{ $searchUrl }}', $CFG->wwwroot.'/blocks/nlrsbook_ilim/search.php', $mainPage);

        $this->content = new stdClass;
        $this->content->text  = $mainPage;

        return $this->content;
    }

/*    public function hide_header()
    {
        return true;
    }*/

    function has_config()
    {
        return true;
    }

}