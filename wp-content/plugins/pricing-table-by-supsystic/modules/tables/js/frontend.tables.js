var g_ptsEdit = false
,	g_ptsBlockFabric = null
,	g_ptsHoverAnim = 300	// Table hover animation lenght, ms - hardcoded for now
,	g_ptsHoverMargin = 20;	// Table hover margin displace, px - hardcoded for now
jQuery(document).ready(function(){
	_ptsInitFabric();
	if(typeof(ptsTables) !== 'undefined' && ptsTables && ptsTables.length) {
		for(var i = 0; i < ptsTables.length; i++) {
			g_ptsBlockFabric.addFromHtml(ptsTables[ i ], jQuery('#'+ ptsTables[ i ].view_id));
		}
	}

	jQuery(window).on('resize', function(){
		var $cols = jQuery('.ptsEl.ptsCol[data-el="table_col"]');
		$cols.height('auto');
	});
});
jQuery(window).load(function() {
	jQuery('body').trigger('resize');
});
//in case images are loading dynamically
jQuery('.ptsEl.ptsCol[data-el="table_col"] img').on('load', function() {
	jQuery('body').trigger('resize');
});
function _ptsInitFabric() {
	g_ptsBlockFabric = new ptsBlockFabric();
}
function ptsGetFabric() {
	return g_ptsBlockFabric;
}
function _ptsIsEditMode() {
	return (typeof(g_ptsEditMode) !== 'undefined' && g_ptsEditMode);
}