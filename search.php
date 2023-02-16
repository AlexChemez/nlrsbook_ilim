<?php

require(__DIR__ . '/../../config.php');

require_once($CFG->dirroot . "/blocks/nlrsbook_auth/Query.php");
require_login();
use App\Querys\Query;


$PAGE->set_title('Библиопоиск «Илим»');
$PAGE->set_heading('Библиопоиск «Илим»');
$PAGE->set_pagelayout('standard');

$searchUrl = $CFG->wwwroot.'/blocks/nlrsbook_ilim/search.php';
$online2Url = Query::getUrl("https%3A%2F%2Fe.nlrs.ru%2Fonline2");

$token = Query::getToken();

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
  data-show-shelf-buttons="1"
></script>
<script>
    ecsbEpsEfed.setAuthorizationHeader('Bearer $token');
    ecsbEpsEfed.renderSearchUI();
</script>
XML;

echo $OUTPUT->header();

echo $template;

echo $OUTPUT->footer();
