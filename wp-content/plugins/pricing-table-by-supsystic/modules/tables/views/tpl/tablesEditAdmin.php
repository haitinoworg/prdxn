<section>
	<div class="supsystic-item supsystic-panel" style="padding-left: 10px;">
		<div id="containerWrapper">
			<div class="ptsTableSettingsShell row">
                <?php echo htmlPts::hidden('params[is_horisontal_row_type]', array(
                    'value' => isset($this->table['params']['is_horisontal_row_type']) ? $this->table['params']['is_horisontal_row_type']['val'] : '0',
                )); ?>
				<div class="ptsTableSetting col-md-3">
					<p>
                        <?php if(isset($this->table['params']['is_horisontal_row_type']['val']) && $this->table['params']['is_horisontal_row_type']['val'] == 1) { ?>
                            <span class="sup-complete-txt"><?php _e('Rows', PTS_LANG_CODE)?>:</span>
                            <span class="sup-reduce-txt"><?php _e('Rows', PTS_LANG_CODE)?>:</span>
                        <?php } else { ?>
                            <span class="sup-complete-txt"><?php _e('Columns', PTS_LANG_CODE)?>:</span>
                            <span class="sup-reduce-txt"><?php _e('Cols', PTS_LANG_CODE)?>:</span>
                        <?php } ?>
						<span class="ptsTableColsNum ptsTableColsNum_<?php echo $this->table['view_id']?>">
							<?php echo (isset($this->table['params']['cols_num']) ? $this->table['params']['cols_num']['val'] : 0);?>
						</span>
						<a href="#" class="button button-sup-small ptsAddColumnBtn">
							<?php if(isset($this->table['params']['is_horisontal_row_type']['val']) && $this->table['params']['is_horisontal_row_type']['val'] == 1) { ?>
                                <span class="sup-complete-txt"><?php _e('Add Row', PTS_LANG_CODE)?></span>
                                <span class="sup-reduce-txt"><?php _e('Add Row', PTS_LANG_CODE)?></span>
                            <?php } else { ?>
                                <span class="sup-complete-txt"><?php _e('Add Column', PTS_LANG_CODE)?></span>
                                <span class="sup-reduce-txt"><?php _e('Add Col', PTS_LANG_CODE)?></span>
                            <?php } ?>
						</a>
                        <?php if(isset($this->table['params']['is_horisontal_row_type']['val']) && $this->table['params']['is_horisontal_row_type']['val'] == 1) { ?>
                            <i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('New row will be added in the end of your table rows area.', PTS_LANG_CODE))?>"></i>
                        <?php } else { ?>
						    <i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('New column will be added in the end of your table.', PTS_LANG_CODE))?>"></i>
                        <?php } ?>
					</p>
				</div>
				<div class="ptsTableSetting col-md-3">
					<label>
						<span class="sup-complete-txt"><?php _e('Description Text Color', PTS_LANG_CODE)?>:</span>
						<span class="sup-reduce-txt"><?php _e('Desc. Text Color', PTS_LANG_CODE)?>:</span>
						<?php echo htmlPts::hidden('params[text_color_desc]', array(
							'attrs' => 'class="ptsColorPickTextColorDesc"',
							'value' => isset($this->table['params']['text_color_desc']) ? $this->table['params']['text_color_desc']['val'] : '',
						));?>
						<div class="ptsTear ptsColorPickTextColorDescTear"></div>
						<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Text color for table columns description element. You can always specify text color for any text element inside table using text editor.', PTS_LANG_CODE))?>"></i>
					</label>
				</div>
				<div class="ptsTableSetting col-md-3">
					<label>
						<?php echo htmlPts::checkbox('params[enb_desc_col]', array(
							'checked' => (isset($this->table['params']['enb_desc_col']) ? (int) $this->table['params']['enb_desc_col']['val'] : 0)
						))?>
						<span class="sup-complete-txt"><?php
							(isset($this->table['params']['is_horisontal_row_type']['val']) && $this->table['params']['is_horisontal_row_type']['val'] == 1) ?
								_e('Enable Description Row', PTS_LANG_CODE) : _e('Enable Description Column', PTS_LANG_CODE)
                            ?></span>
                        <span class="sup-reduce-txt"><?php
							(isset($this->table['params']['is_horisontal_row_type']['val']) && $this->table['params']['is_horisontal_row_type']['val'] == 1) ? _e('Enb. Desc. Row', PTS_LANG_CODE) : _e('Enb. Desc. Col', PTS_LANG_CODE) ?>
                        </span>
						<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Add additional description column into table. You can add there descriptions for your rows.', PTS_LANG_CODE))?>"></i>
					</label>
				</div>
				<div class="ptsTableSetting col-md-3">
					<label>
						<!-- Here we used Enable as option even for hide param - to make it more user-friendly - Like It:) -->
						<?php echo htmlPts::checkbox('params[enb_head_row]', array(
							'checked' => !(isset($this->table['params']['hide_head_row']) && (int) $this->table['params']['hide_head_row']['val'])
						))?>
						<span class="sup-complete-txt"><?php
							(isset($this->table['params']['is_horisontal_row_type']['val']) && $this->table['params']['is_horisontal_row_type']['val'] == 1) ?
                            _e('Enable Head Column', PTS_LANG_CODE) : _e('Enable Head Row', PTS_LANG_CODE)
							?></span>
						<span class="sup-reduce-txt"><?php
							(isset($this->table['params']['is_horisontal_row_type']['val']) && $this->table['params']['is_horisontal_row_type']['val'] == 1) ?
                            _e('Enb. Head Column', PTS_LANG_CODE) : _e('Enb. Head Row', PTS_LANG_CODE)
                            ?></span>
						<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Hide head row in all columns. Usually it is the first row in table.', PTS_LANG_CODE))?>"></i>
					</label>
				</div>
				<div class="ptsTableSetting col-md-3">
					<p>
						<?php
						    (isset($this->table['params']['is_horisontal_row_type']['val']) && $this->table['params']['is_horisontal_row_type']['val'] == 1) ?
                                _e('Cols', PTS_LANG_CODE) : _e('Rows', PTS_LANG_CODE)
                        ?>:
						<span class="ptsTableRowsNum ptsTableRowsNum_<?php echo $this->table['view_id']?>">
							<?php echo (isset($this->table['params']['rows_num']) ? $this->table['params']['rows_num']['val'] : 0);?>
						</span>
						<a href="#" class="button button-sup-small ptsAddRowBtn"><?php
							(isset($this->table['params']['is_horisontal_row_type']['val']) && $this->table['params']['is_horisontal_row_type']['val'] == 1) ?
                                _e('Add Col', PTS_LANG_CODE) : _e('Add Row', PTS_LANG_CODE)
                            ?></a>
                        <?php if(isset($this->table['params']['is_horisontal_row_type']['val']) && $this->table['params']['is_horisontal_row_type']['val'] == 1) { ?>
                            <i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('New column will be added in the end of your table.', PTS_LANG_CODE))?>"></i>
                        <?php } else { ?>
						    <i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('New row will be added in the end of your table rows area.', PTS_LANG_CODE))?>"></i>
                        <?php } ?>
					</p>
				</div>
				<div class="ptsTableSetting col-md-3">
					<label>
						<?php _e('Header Text Color', PTS_LANG_CODE)?>:
						<?php echo htmlPts::hidden('params[text_color_header]', array(
							'attrs' => 'class="ptsColorPickTextColorHeader"',
							'value' => isset($this->table['params']['text_color_header']) ? $this->table['params']['text_color_header']['val'] : '',
						));?>
						<div class="ptsTear ptsColorPickTextColorHeaderTear"></div>
						<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Text color for table columns header element. You can always specify text color for any text element inside table using text editor.', PTS_LANG_CODE))?>"></i>
					</label>
				</div>
				<div class="ptsTableSetting col-md-3">
					<label>
						<!-- Here we used Enable as option even for hide param - to make it more user-friendly - Like It:) -->
						<?php echo htmlPts::checkbox('params[enb_foot_row]', array(
							'checked' => !(isset($this->table['params']['hide_foot_row']) && (int) $this->table['params']['hide_foot_row']['val'])
						))?>
						<span class="sup-complete-txt"><?php
							(isset($this->table['params']['is_horisontal_row_type']['val']) && $this->table['params']['is_horisontal_row_type']['val'] == 1) ?
                                _e('Enable Footer Column', PTS_LANG_CODE) : _e('Enable Footer Row', PTS_LANG_CODE)

							?></span>
						<span class="sup-reduce-txt"><?php
							(isset($this->table['params']['is_horisontal_row_type']['val']) && $this->table['params']['is_horisontal_row_type']['val'] == 1) ?
								_e('Enb. Footer Column', PTS_LANG_CODE) : _e('Enb. Footer Row', PTS_LANG_CODE)
                            ?></span>
						<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Hide footer row in all columns. Usually it is last row in table.', PTS_LANG_CODE))?>"></i>
					</label>
				</div>
				<?php if (!isset($this->table['params']['is_horisontal_row_type']['val']) || $this->table['params']['is_horisontal_row_type']['val'] != 1) { ?>
				<div class="ptsTableSetting col-md-3">
					<label>
						<!-- Here we used Enable as option even for hide param - to make it more user-friendly - Like It:) -->
						<?php echo htmlPts::checkbox('params[enb_desc_row]', array(
							'checked' => !(isset($this->table['params']['hide_desc_row']) && (int) $this->table['params']['hide_desc_row']['val'])
						))?>
						<span class="sup-complete-txt"><?php _e('Enable Description Row', PTS_LANG_CODE)?></span>
						<span class="sup-reduce-txt"><?php _e('Enb. Description Row', PTS_LANG_CODE)?></span>
						<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Hide description row in all columns.', PTS_LANG_CODE))?>"></i>
					</label>
				</div>
				<?php } ?>
				<div class="ptsTableSetting col-md-3">
					<label style="float: left; padding-right: 5px;">
						<?php echo htmlPts::radiobutton('params[calc_width]', array(
							'value' => 'table',
							'checked' => (isset($this->table['params']['calc_width']) && $this->table['params']['calc_width']['val'] == 'table'),
						))?>
						<span class="sup-complete-txt"><?php _e('Table Width', PTS_LANG_CODE)?>:</span>
						<span class="sup-reduce-txt"><?php _e('Tbl. Width', PTS_LANG_CODE)?>:</span>
						<?php echo htmlPts::text('params[table_width]', array(
							'value' => (isset($this->table['params']['table_width']) ? $this->table['params']['table_width']['val'] : 0),
							'attrs' => 'style="width: 50px"',
						))?>
					</label>
					<span style="display: table; float: left;">
						<label style="display: table-row;">
							<?php echo htmlPts::radiobutton('params[table_width_measure]', array(
								'value' => 'px',
								'checked' => (isset($this->table['params']['table_width_measure']) && $this->table['params']['table_width_measure']['val'] == 'px'),
							))?>px
						</label>
						<label style="display: table-row;">
							<?php echo htmlPts::radiobutton('params[table_width_measure]', array(
								'value' => '%',
								'checked' => (isset($this->table['params']['table_width_measure']) && $this->table['params']['table_width_measure']['val'] == '%'),
							))?>%
						</label>
					</span>
					<i style="margin-top: 12px;" class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Set width for table. Width for each column in this case will be calculated as width of whole table divided for total columns number.', PTS_LANG_CODE))?>"></i>
				</div>
				<div class="ptsTableSetting col-md-3">
					<label>
						<?php _e('Background Color', PTS_LANG_CODE)?>:
						<?php echo htmlPts::hidden('params[bg_color]', array(
							'attrs' => 'class="ptsColorPickBgColor"',
							'value' => (isset($this->table['params']['bg_color']) ? $this->table['params']['bg_color']['val'] : '#fff'),
						));?>
						<div class="ptsTear ptsColorPickBgColorTear"></div>
						<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Common background color for table.', PTS_LANG_CODE))?>"></i>
					</label>
				</div>
				<div class="ptsTableSetting col-md-3">
					<label>
						<?php echo htmlPts::checkbox('params[enb_hover_animation]', array(
							'checked' => (isset($this->table['params']['enb_hover_animation']) ? (int) $this->table['params']['enb_hover_animation']['val'] : 0)
						))?>
						<?php _e('Enable Hover Animation', PTS_LANG_CODE)?>
						<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Animate column when mouse is hovering on it. Will work ONLY on fronted, disabled in admin area WySiWyg editor as it can break it in edit mode.', PTS_LANG_CODE))?>"></i>
					</label>
				</div>
				<div class="ptsTableSetting col-md-3">
					<label>
						<?php _e('Text Align', PTS_LANG_CODE)?>
						<?php echo htmlPts::selectbox('params[text_align]', array(
							'options' => array('left' => 'left', 'center' => 'center', 'right' => 'right'),
							'value' => (isset($this->table['params']['text_align']['val']) ? $this->table['params']['text_align']['val'] : 'center'),
							'attrs' => 'class="chosen"'
						))?>
						<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Text align in table: left, center, right', PTS_LANG_CODE))?>"></i>
					</label>
				</div>
				<div class="ptsTableSetting col-md-3">
					<label>
						<?php _e('Font', PTS_LANG_CODE)?>:
						<?php echo htmlPts::fontsList('params[font_family]', array(
							'value' => isset($this->table['params']['font_family']) ? $this->table['params']['font_family']['val'] : '',
							'attrs' => 'class="chosen"'
						))?>
						<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Font for table. You can always set other font for any text element using text editor tool. Just click on text - and start edit it!', PTS_LANG_CODE))?>"></i>
					</label>
				</div>
                <?php if(isset($this->table['params']['is_horisontal_row_type']['val']) && $this->table['params']['is_horisontal_row_type']['val'] != 1) { ?>
                    <div class="ptsTableSetting col-md-3">
                        <label>
                            <?php echo htmlPts::radiobutton('params[calc_width]', array(
                                'value' => 'col',
                                'checked' => (!isset($this->table['params']['calc_width']) || $this->table['params']['calc_width']['val'] == 'col'),
                            ))?>
                            <?php _e('Column Width', PTS_LANG_CODE)?>:
                            <?php echo htmlPts::text('params[col_width]', array(
                                'value' => (isset($this->table['params']['col_width']) ? $this->table['params']['col_width']['val'] : 186),	//186 - normal, default col width
                                'attrs' => 'style="width: 50px"',
                            ))?>
                            px
                            <i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Set width for each column. Total table width in this case will be calculated as sum of all your columns width.', PTS_LANG_CODE))?>"></i>
                        </label>
                    </div>
                <?php } ?>
				<div class="ptsTableSetting col-md-3">
					<label>
						<?php _e('Rows Text Color', PTS_LANG_CODE)?>:
						<?php echo htmlPts::hidden('params[text_color]', array(
							'attrs' => 'class="ptsColorPickTextColor"',
							'value' => isset($this->table['params']['text_color']) ? $this->table['params']['text_color']['val'] : '',
						));?>
						<div class="ptsTear ptsColorPickTextColorTear"></div>
						<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Common text color for table. You can always specify text color for any text element inside table using text editor.', PTS_LANG_CODE))?>"></i>
					</label>
				</div>
				<div class="ptsTableSetting col-md-3">
					<label>
						<!-- Here we used Enable as option even for hide param - to make it more user-friendly - Like It:) -->
						<?php echo htmlPts::checkbox('params[enb_responsive]', array(
							'checked' => !(isset($this->table['params']['dsbl_responsive']) ? (int) $this->table['params']['dsbl_responsive']['val'] : 0)
						))?>
						<span class="sup-complete-txt"><?php _e('Enable Responsivity', PTS_LANG_CODE)?></span>
						<span class="sup-reduce-txt"><?php _e('Enb. Responsivity', PTS_LANG_CODE)?></span>
						<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('When device screen is small (mobile device or some tablets) usually table will go into responsive mode: all columns will be shown one-by-one below each other. But if you need to disable this feature - you can do this with this option. This feature influences only on frontend table view.', PTS_LANG_CODE))?>"></i>
					</label>
				</div>
				<div class="ptsTableSetting col-md-3">
					<label>
						<?php _e('Table Align', PTS_LANG_CODE)?>
						<?php echo htmlPts::selectbox('params[table_align]', array(
							'options' => array('left' => 'left', 'center' => 'center', 'right' => 'right', 'none' => 'none'),
							'value' => (isset($this->table['params']['table_align']['val']) ? $this->table['params']['table_align']['val'] : 'none'),
							'attrs' => 'class="chosen"'
						))?>
						<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Table align in page: left, center, right, none', PTS_LANG_CODE))?>"></i>
					</label>
				</div>
				<!-- Responsive text option
				<div class="ptsTableSetting col-md-3">
					<label>
						<?php echo htmlPts::checkbox('params[responsive_text]', array(
							'checked' => (isset($this->table['params']['responsive_text']) ? (int) $this->table['params']['responsive_text']['val'] : 0)
						))?>
						<span class="sup-complete-txt"><?php _e('Enable Responsive Text', PTS_LANG_CODE)?></span>
						<span class="sup-reduce-txt"><?php _e('Enb. Responsive Text', PTS_LANG_CODE)?></span>
					</label>
				</div>
				-->
				<div class="ptsTableSetting col-md-3">
					<label>
						<?php echo htmlPts::checkbox('params[disable_custom_tooltip_style]', array(
							'checked' => (isset($this->table['params']['disable_custom_tooltip_style']) ? (int) $this->table['params']['disable_custom_tooltip_style']['val'] : 0)
						))?>
						<span class="sup-complete-txt"><?php _e('Disable Custom Tooltip Styles', PTS_LANG_CODE)?></span>
						<span class="sup-reduce-txt"><?php _e('Disable Custom Tooltip Styles', PTS_LANG_CODE)?></span>
					</label>
					<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Disable supsystic styles for tooltips in your pricing table', PTS_LANG_CODE))?>"></i>
				</div>
                <?php if(isset($this->table['params']['is_horisontal_row_type']['val']) && $this->table['params']['is_horisontal_row_type']['val'] != 1) { ?>
                    <div class="ptsTableSetting col-md-3 ptsRespMinColW ptsDisplNone">
                        <label>
                            <?php _e('Min Column Width', PTS_LANG_CODE)?>
                            <?php echo htmlPts::text('params[resp_min_col_width]', array(
                                'value' => (isset($this->table['params']['resp_min_col_width']) ? $this->table['params']['resp_min_col_width']['val'] : 150),
                                'attrs' => 'style="width: 50px"',
                            ))?>
                            <?php _e('px', PTS_LANG_CODE)?>
                            <i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Column width (is indicated in pixels by default) at which table will go to responsive mode', PTS_LANG_CODE))?>"></i>
                        </label>
                    </div>
                <?php } ?>
				<div style="clear: both;"></div>
				<hr />
			</div>
			<div id="ptsCanvas" class="clearfix">
				<?php echo $this->renderedTable?>
			</div>
		</div>
	</div>
</section>
<div id="ptsTableEditorFooter">
	<?php echo $this->editorFooter; ?>
</div>
<div id="ptsTableAllColsHaveBgColorWnd" style="display: none;" title="<?php _e('Notice', PTS_LANG_CODE)?>">
	<p><?php _e('Please be adviced that all columns in your table have enabled Fill color feature - so changing background color for table may not influence to all table view, or maybe will not influence to table view at all (depending of template that you selected for your table).', PTS_LANG_CODE)?></p>
</div>
