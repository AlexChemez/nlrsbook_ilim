<?php

// die('d');

require(__DIR__ . '/../../config.php');

require_once($CFG->dirroot . "/blocks/nlrsbook_auth/Query.php");
use App\Querys\Query;
$seamlessAuthOrgId = 1;


// require_once(__DIR__ . '/lib.php');

// global $CFG;
// global $DB;

// die('zz');

// $id = optional_param('id', 0, PARAM_INT);
// $i = optional_param('i', 0, PARAM_INT);



// if ($id) {
    // $cm = get_coursemodule_from_id('nlrsbook', $id, 0, false, MUST_EXIST);
//     $course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
//     $moduleinstance = $DB->get_record('nlrsbook', array('id' => $cm->instance), '*', MUST_EXIST);
// } else if ($i) {
//     $moduleinstance = $DB->get_record('nlrsbook', array('id' => $n), '*', MUST_EXIST);
//     $course = $DB->get_record('course', array('id' => $moduleinstance->course), '*', MUST_EXIST);
//     $cm = get_coursemodule_from_instance('nlrsbook', $moduleinstance->id, $course->id, false, MUST_EXIST);
// } else {
//     print_error(get_string('missingidandcmid', 'mod_nlrsbook'));
// }

// require_login($course, true, $cm);

// $host = 'https://e.nlrs.ru/graphql';
// $user_id = $USER->id;
// $instance = $DB->get_record('nlrsbook_shelf', array('user_id' => $USER->id), '*', IGNORE_MISSING );

// $nlrsbook_id = $moduleinstance->nlrsbook_id;

// if ($instance->token) {
//     $token = $instance->token;
// } else {
//     $getToken = checkToken($user_id, $host);
//     $row = new stdClass();
//     $row->user_id = $user_id;
//     $row->token = $getToken;
//     $row->datetime = '1';
//     $DB->insert_record('nlrsbook_shelf', $row);
//     $token = $getToken;
// }
// $token = 'asdasd';


// $modulecontext = context_module::instance();
// $bookdata = getShelf($nlrsbook_id, $token);
// $PAGE->set_url('/mod/nlrsbook/asd.php', array());
$PAGE->set_title('Библиопоиск «Илим»');
$PAGE->set_heading('Библиопоиск «Илим»');
// $PAGE->set_context($modulecontext);
$PAGE->set_pagelayout('standard');



$seamlessAuthUserId = 48059; // TODO: получать из токена
$seamlessAuthSignature = 'y3Mz2ahGpv7GMLGttHZ7PBTsfDaHtmPX'; // TODO: реализовать генерацию подписи, пока стоит временная заглушка
$baseUrl = "https://e.nlrs.ru/seamless-auth-redirect?seamlessAuthUserId=${nlrsUserId}&seamlessAuthSignature=${seamlessAuthSignature}";

$online2Url = "${baseUrl}&override_redirect=https%3A%2F%2Fe.nlrs.ru%2Fonline2";


// global $CFG;
// die($CFG->wwwroot);

$secret = get_config('nlrsbook_auth', 'org_private_key'); // Секретный ключ организации
$seamlessAuthSignature = Query::generateServerApiRequestSignature([
    'orgId' => $seamlessAuthOrgId,
    'userId' => $seamlessAuthUserId,
], $secret);

$searchUrl = $CFG->wwwroot.'/blocks/nlrsbook_ilim/search.php';

$template = <<<XML

<style>
#ecsb-eps-widget {
    zoom: 0.8;
}
.searchPillsDesktop {
    margin-top: 24px;
}

@media (min-width: 768px) {
	.pagelayout-standard #page.drawers .main-inner, body.limitedwidth #page.drawers .main-inner {
		max-width: 1024px !important;
	}
}

.ecsb-eps-doc-button-order {
	display: none !important;
}

</style>

<div class="main-inner">
	<div class="row">
		<div class="col-xs-12">
			<div id="ecsb-eps-container"></div>
		</div>
	</div>
</div>

<script
  src="https://new.nlrs.ru/ecsb-example/dist/script.js"
  data-id="ecsb-eps-efed-script"
  data-partner-id="1"
  data-eps-search-results-url="$searchUrl"
  data-efed-viewer-url="$online2Url"
  data-efed-viewer-url-book-id-placement="path"
  data-ui-primary-color="#0f6cbf"
  data-seamless-auth-org-id="$seamlessAuthOrgId"
  data-seamless-auth-user-id="$seamlessAuthUserId"
  data-seamless-auth-signature="$seamlessAuthSignature"
  data-show-shelf-buttons="1"
  data-secret="$secret"
></script>
<script>
    // qweзапуск работы поискового интерфейса
    ecsbEpsEfed.renderSearchUI();
</script>
XML;

// $template = str_replace('{{ $searchUrl }}', $CFG->wwwroot.'/blocks/nlrsbook_ilim/search.php', $template);
// $template = str_replace('{{ $online2Url }}', $online2Url, $template);


echo $OUTPUT->header();

echo $template;

echo $OUTPUT->footer();