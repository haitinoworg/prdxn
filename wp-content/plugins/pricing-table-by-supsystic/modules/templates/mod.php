<?php
class templatesPts extends modulePts {
    protected $_styles = array();
	private $_cdnUrl = '';
	
	public function __construct($d) {
		parent::__construct($d);
		$this->getCdnUrl();	// Init CDN URL
	}
	public function getCdnUrl() {
		if(empty($this->_cdnUrl)) {
			/*if(uriPts::isHttps()) {
				$this->_cdnUrl = 'https://supsystic.com/';
			} else {
				$this->_cdnUrl = 'http://cdn.supsystic.com/';
			}*/
			$this->_cdnUrl = (uriPts::isHttps() ? 'https' : 'http'). '://supsystic-42d7.kxcdn.com/';
		}
		return $this->_cdnUrl;
	}
    public function init() {
        if (is_admin()) {
			if($isAdminPlugOptsPage = framePts::_()->isAdminPlugOptsPage()) {
				$this->loadCoreJs();
				$this->loadAdminCoreJs();
				$this->loadCoreCss();
				$this->loadChosenSelects();
				framePts::_()->addScript('adminOptionsPts', PTS_JS_PATH. 'admin.options.js', array(), false, true);
				add_action('admin_enqueue_scripts', array($this, 'loadMediaScripts'));
			}
			// Some common styles - that need to be on all admin pages - be careful with them
			framePts::_()->addStyle('supsystic-for-all-admin-'. PTS_CODE, PTS_CSS_PATH. 'supsystic-for-all-admin.css');
		}
        parent::init();
    }
	public function loadMediaScripts() {
		if(function_exists('wp_enqueue_media')) {
			wp_enqueue_media();
		}
	}
	public function loadTooltipster() {
		framePts::_()->addScript('tooltipster', $this->_cdnUrl. 'lib/tooltipster/jquery.tooltipster.min.js');
		framePts::_()->addStyle('tooltipster', $this->_cdnUrl. 'lib/tooltipster/tooltipster.css');
	}
	public function loadSlimscroll() {
		framePts::_()->addScript('jquery.slimscroll', $this->_cdnUrl. 'js/jquery.slimscroll.js');
	}
	public function loadCodemirror() {
		framePts::_()->addStyle('ptsCodemirror', $this->_cdnUrl. 'lib/codemirror/codemirror.css');
		framePts::_()->addStyle('codemirror-addon-hint', $this->_cdnUrl. 'lib/codemirror/addon/hint/show-hint.css');
		framePts::_()->addScript('ptsCodemirror', $this->_cdnUrl. 'lib/codemirror/codemirror.js');
		framePts::_()->addScript('codemirror-addon-show-hint', $this->_cdnUrl. 'lib/codemirror/addon/hint/show-hint.js');
		framePts::_()->addScript('codemirror-addon-xml-hint', $this->_cdnUrl. 'lib/codemirror/addon/hint/xml-hint.js');
		framePts::_()->addScript('codemirror-addon-html-hint', $this->_cdnUrl. 'lib/codemirror/addon/hint/html-hint.js');
		framePts::_()->addScript('codemirror-mode-xml', $this->_cdnUrl. 'lib/codemirror/mode/xml/xml.js');
		framePts::_()->addScript('codemirror-mode-javascript', $this->_cdnUrl. 'lib/codemirror/mode/javascript/javascript.js');
		framePts::_()->addScript('codemirror-mode-css', $this->_cdnUrl. 'lib/codemirror/mode/css/css.js');
		framePts::_()->addScript('codemirror-mode-htmlmixed', $this->_cdnUrl. 'lib/codemirror/mode/htmlmixed/htmlmixed.js');
	}
	public function loadJqGrid() {
		static $loaded = false;
		if(!$loaded) {
			$this->loadJqueryUi();
			framePts::_()->addScript('jq-grid', $this->_cdnUrl. 'lib/jqgrid/jquery.jqGrid.min.js');
			framePts::_()->addStyle('jq-grid', $this->_cdnUrl. 'lib/jqgrid/ui.jqgrid.css');
			$langToLoad = utilsPts::getLangCode2Letter();
			$availableLocales = array('ar','bg','bg1251','cat','cn','cs','da','de','dk','el','en','es','fa','fi','fr','gl','he','hr','hr1250','hu','id','is','it','ja','kr','lt','mne','nl','no','pl','pt','pt','ro','ru','sk','sr','sr','sv','th','tr','tw','ua','vi');
			if(!in_array($langToLoad, $availableLocales)) {
				$langToLoad = 'en';
			}
			framePts::_()->addScript('jq-grid-lang', $this->_cdnUrl. 'lib/jqgrid/i18n/grid.locale-'. $langToLoad. '.js');
			$loaded = true;
		}
	}
	public function loadFontAwesome() {
		framePts::_()->addStyle('font-awesomePts', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css');
	}
	public function loadChosenSelects() {
		framePts::_()->addStyle('jquery.chosen', $this->_cdnUrl. 'lib/chosen/chosen.min.css');
		framePts::_()->addScript('jquery.chosen', $this->_cdnUrl. 'lib/chosen/chosen.jquery.min.js');
	}
	public function loadJqplot() {
		static $loaded = false;
		if(!$loaded) {
			$jqplotDir = $this->_cdnUrl. 'lib/jqplot/';

			framePts::_()->addStyle('jquery.jqplot', $jqplotDir. 'jquery.jqplot.min.css');

			framePts::_()->addScript('jplot', $jqplotDir. 'jquery.jqplot.min.js');
			framePts::_()->addScript('jqplot.canvasAxisLabelRenderer', $jqplotDir. 'jqplot.canvasAxisLabelRenderer.min.js');
			framePts::_()->addScript('jqplot.canvasTextRenderer', $jqplotDir. 'jqplot.canvasTextRenderer.min.js');
			framePts::_()->addScript('jqplot.dateAxisRenderer', $jqplotDir. 'jqplot.dateAxisRenderer.min.js');
			framePts::_()->addScript('jqplot.canvasAxisTickRenderer', $jqplotDir. 'jqplot.canvasAxisTickRenderer.min.js');
			framePts::_()->addScript('jqplot.highlighter', $jqplotDir. 'jqplot.highlighter.min.js');
			framePts::_()->addScript('jqplot.cursor', $jqplotDir. 'jqplot.cursor.min.js');
			framePts::_()->addScript('jqplot.barRenderer', $jqplotDir. 'jqplot.barRenderer.min.js');
			framePts::_()->addScript('jqplot.categoryAxisRenderer', $jqplotDir. 'jqplot.categoryAxisRenderer.min.js');
			framePts::_()->addScript('jqplot.pointLabels', $jqplotDir. 'jqplot.pointLabels.min.js');
			framePts::_()->addScript('jqplot.pieRenderer', $jqplotDir. 'jqplot.pieRenderer.min.js');
			$loaded = true;
		}
	}
	public function loadMagicAnims() {
		static $loaded = false;
		if(!$loaded) {
			framePts::_()->addStyle('jquery.jqplot', $this->_cdnUrl. 'css/magic.min.css');
			$loaded = true;
		}
	}
	public function loadAdminCoreJs() {
		framePts::_()->addScript('jquery-ui-dialog');
		framePts::_()->addScript('jquery-ui-slider');
		framePts::_()->addScript('wp-color-picker');
		framePts::_()->addScript('icheck', PTS_JS_PATH. 'icheck.min.js');
		$this->loadTooltipster();
	}
	public function loadCoreJs() {
		framePts::_()->addScript('jquery');

		framePts::_()->addScript('commonPts', PTS_JS_PATH . 'common.js');
		framePts::_()->addScript('corePts', PTS_JS_PATH . 'core.js');
		
		$ajaxurl = admin_url('admin-ajax.php');
		$jsData = array(
			'siteUrl'					=> PTS_SITE_URL,
			'imgPath'					=> PTS_IMG_PATH,
			'cssPath'					=> PTS_CSS_PATH,
			'loader'					=> PTS_LOADER_IMG, 
			'close'						=> PTS_IMG_PATH. 'cross.gif', 
			'ajaxurl'					=> $ajaxurl,
			'options'					=> framePts::_()->getModule('options')->getAllowedPublicOptions(),
			'PTS_CODE'					=> PTS_CODE,
			//'ball_loader'				=> PTS_IMG_PATH. 'ajax-loader-ball.gif',
			//'ok_icon'					=> PTS_IMG_PATH. 'ok-icon.png',
		);
		if(is_admin()) {
			$jsData['isPro'] = framePts::_()->getModule('supsystic_promo')->isPro();
		}
		$jsData = dispatcherPts::applyFilters('jsInitVariables', $jsData);
		framePts::_()->addJSVar('corePts', 'PTS_DATA', $jsData);
	}
	public function loadCoreCss() {
		$this->_styles = dispatcherPts::applyFilters('coreCssList', array(
			'stylePts'			=> array('path' => PTS_CSS_PATH. 'style.css', 'for' => 'admin'), 
			'supsystic-uiPts'	=> array('path' => PTS_CSS_PATH. 'supsystic-ui.css', 'for' => 'admin'), 
			'dashicons'			=> array('for' => 'admin'),
			'bootstrap-alerts'	=> array('path' => PTS_CSS_PATH. 'bootstrap-alerts.css', 'for' => 'admin'),
			'icheck'			=> array('path' => PTS_CSS_PATH. 'jquery.icheck.css', 'for' => 'admin'),
			'wp-color-picker'	=> array('for' => 'admin'),
		));
		foreach($this->_styles as $s => $sInfo) {
			if(!empty($sInfo['path'])) {
				framePts::_()->addStyle($s, $sInfo['path']);
			} else {
				framePts::_()->addStyle($s);
			}
		}
		$this->loadFontAwesome();
	}
	public function loadJqueryUi() {
		static $loaded = false;
		if(!$loaded) {
			framePts::_()->addStyle('jquery-ui', PTS_CSS_PATH. 'jquery-ui.min.css');
			framePts::_()->addStyle('jquery-ui.structure', PTS_CSS_PATH. 'jquery-ui.structure.min.css');
			framePts::_()->addStyle('jquery-ui.theme', PTS_CSS_PATH. 'jquery-ui.theme.min.css');
			framePts::_()->addStyle('jquery-slider', PTS_CSS_PATH. 'jquery-slider.css');
			$loaded = true;
		}
	}
	public function loadDatePicker() {
		framePts::_()->addScript('jquery-ui-datepicker');
	}
	public function loadBootstrap() {
		static $loaded = false;
		if(!$loaded) {
			framePts::_()->addStyle('bootstrap', framePts::_()->getModule('tables')->getAssetsUrl(). 'css/bootstrap.min.css');
			framePts::_()->addStyle('bootstrap-theme', framePts::_()->getModule('tables')->getAssetsUrl(). 'css/bootstrap-theme.min.css');
			framePts::_()->addScript('bootstrap', PTS_JS_PATH. 'bootstrap.min.js');
			
			framePts::_()->addStyle('jasny-bootstrap', PTS_CSS_PATH. 'jasny-bootstrap.min.css');
			framePts::_()->addScript('jasny-bootstrap', PTS_JS_PATH. 'jasny-bootstrap.min.js');
			$loaded = true;
		}
	}
	public function loadTinyMce() {
		static $loaded = false;
		if(!$loaded) {
			framePts::_()->addScript('pts.tinymce', PTS_JS_PATH. 'tinymce/tinymce.min.js');
			framePts::_()->addScript('pts.jquery.tinymce', PTS_JS_PATH. 'tinymce/jquery.tinymce.min.js');
			$loaded = true;
		}
	}
	public function loadCustomBootstrapColorpicker() {
		static $loaded = false;
		if(!$loaded) {
			framePts::_()->addScript('pts.colorpicker.script', PTS_JS_PATH. 'color_picker/jquery.colorpicker.js');
			framePts::_()->addStyle('pts.colorpicker.style', PTS_JS_PATH. 'color_picker/jquery.colorpicker.css');
			framePts::_()->addScript('jquery.bootstrap.colorpicker.tinycolor', PTS_JS_PATH. 'jquery.bootstrap.colorpicker/tinycolor.js');
			$loaded = true;
		}
	}
	public function loadBootstrapPartial() {
		static $loaded = false;
		if(!$loaded) {
			$this->loadBootstrapPartialOnlyCss();
			framePts::_()->addScript('bootstrap', PTS_JS_PATH. 'bootstrap.min.js');
			framePts::_()->addStyle('jasny-bootstrap', PTS_CSS_PATH. 'jasny-bootstrap.min.css');
			framePts::_()->addScript('jasny-bootstrap', PTS_JS_PATH. 'jasny-bootstrap.min.js');
			$loaded = true;
		}
	}
	public function loadBootstrapPartialOnlyCss() {
		static $loaded = false;
		if(!$loaded) {
			framePts::_()->addStyle('bootstrap.partial', framePts::_()->getModule('tables')->getAssetsUrl(). 'css/bootstrap.partial.min.css');
			$loaded = true;
		}
	}
	public function loadBootstrapSimple() {
		static $loaded = false;
		if(!$loaded) {
			framePts::_()->addStyle('bootstrap-simple', PTS_CSS_PATH. 'bootstrap-simple.css');
			$loaded = true;
		}
	}
	public function loadGoogleFont( $font ) {
		static $loaded = array();
		if(!isset($loaded[ $font ])) {
			framePts::_()->addStyle('google.font.'. str_replace(array(' '), '-', $font), 'https://fonts.googleapis.com/css?family='. urlencode($font));
			$loaded[ $font ] = 1;
		}
	}
}
