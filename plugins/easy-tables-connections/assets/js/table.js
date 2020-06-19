/* =========================================================
 * table.js v1.0.0
 * =========================================================
 * Copyright 2013 Wpbakery
 *
 * Vc table javascript
 * ========================================================= */
var vcTable = {};
(function($,_){
    String.prototype.cell_attributes = [];

    // $('body').on('click', '.lk-thickbox', function() {
    //     setTimeout( function() {
    //         $('#TB_window').css({
    //             'z-index': 100050,
    //             'width': 350,
    //             'height': 350,
    //         });
    //     }, 0.001);
    // }); 

    $('body').on('click', '.vc_control-btn-edit', function() {
        var classEl = $(this).closest('.wpb_vc_table').attr('data-element_type');
        if ( classEl ) {
            $('body').addClass( 'lk-' + classEl );
        }
    }); 

    $('body').on('click', 'vc_ui-close-button', function() {
        $('body').removeClass('lk-vc_table');
    }); 

    // $('body').on('click', '.lk-vc-size-table', function() {
    //     var $parentWrap = $(this).closest('.vc-table-param'),
    //         $table      = $parentWrap.find('.vc-table-plugin-theme-simple'),
    //         tableCols   = $table.find('tr:first-child .vc_table_cell').size();

    //     alert( tableCols );
    // }); 

    // $('body').on('click', '.vc-upload-media', function() {

    //     var $this = $(this),
    //         galleryWindow = wp.media({
    //             title: 'Insert Image',
    //             library: {type: 'image'},
    //             multiple: false,
    //             button: {text: 'Insert Image'},
    //         });
            
    //     galleryWindow.on('select', function() {
    //         var imgUrl          = $('.media-sidebar [data-setting="url"] input').val(),
    //             imgAlt          = $('.media-sidebar [data-setting="title"] input').val(),
    //             $currentCell    = $this.closest('.wpb_el_type_table_param').find('.vc_table_cell.current .vc_table_content'),
    //             currentCellText = $currentCell.text();
            
    //         // $currentCell.text( currentCellText + '<img src="'+ imgUrl +'" alt="'+ imgAlt +'">' );
    //         $currentCell.text( currentCellText + 'teeeeeext' );
    //     });
    //     galleryWindow.open();

    // });

    window.vc_table_param_parse_value = function(value) {
        var parsed = [];
        if(_.isString(value) && value.length) {
            _.each(value.split("|"), function(data) {
                var split = data.split(',');
                parsed.push(_.map(split, function(string){
                    var attr_search = string.match(/^\[([^\]]*)\]/),
                        cell = new String(window.decodeURIComponent(string.replace(/^\[[^\]]*\]/, '')));
                    cell.cell_attributes = _.isArray(attr_search) ? attr_search[1].split(';') : [];
                    return cell;
                }));
            });
        }
        return parsed;
    };
    window.vc_table_parse_cell_style = function(attr) {
        var css_style = [],
            css_class = ['vc_table_cell'],
            border_styles = ['border_left', 'border_right', 'border_top', 'border_bottom', 'borders_all'];
        _.each(attr, function(value){
            if(value==='b') {
                css_style.push('font-weight: bold;');
            } else if(value==='u') {
                css_style.push('text-decoration: underline;');
            } else if(value==='i') {
                css_style.push('font-style: italic;');
            } else if(value==='s') {
                css_class.push('vc_stroked');
            } else if(value.match(/px$/)) {
                css_style.push('font-size:' + value + ';');
                css_style.push('line-height:' + value + ';')
            } else if(value.match(/^c/)) {
                css_style.push('color: ' + value.replace(/^c/, '') + ';');
            } else if(value.match(/^bg/)) {
                css_style.push('background-color:' + value.replace(/^bg/, '') + ';');
            } else if(_.indexOf(border_styles, value) > -1) {
                css_class.push('vc_cell_' + value);
            } else if(value.match(/^align\-/)) {
                css_style.push('text-align:' + value.replace(/^align\-/,'') + ';');
            } else if(value.match(/^valign\-/)) {
                css_style.push('vertical-align:' + value.replace(/^valign\-/) + ';');
            }
        }, this);
        return {
            css_class: css_class,
            css_style: css_style
        };
    };
    window.vc_table_get_cell_style = function(attr) {
        if(_.isEmpty(attr)) return '';
        var settings = vc_table_parse_cell_style(attr);
        return ' class="' + settings.css_class.join(' ') + '"' + (settings.css_style.length ? ' style="' + settings.css_style.join('') + '"' : '');
    };
	vcTable.param = {
		table_param:{
			render: function (param, value) {
				var data = vc_table_param_parse_value(value),
					html_back = '',
					custom_css_class = '';
				if(!_.isUndefined(this.model.get('params').vc_table_theme) && !_.isEmpty(this.model.get('params').vc_table_theme)) {
					custom_css_class = ' vc-table-plugin-theme-' + this.model.get('params').vc_table_theme;
				}
				if(data.length) {
					html_back = '<table class="wpb_vc_table' + custom_css_class +'">' + _.reduce(data, function(memo, row, index){
							return memo + '<tr' + (index === 0 ? ' class="vc-th"' : '') +'>' + _.reduce(row, function(memo, cell) {
									return memo + '<td'+ vc_table_get_cell_style(cell.cell_attributes) +'><div class="vc_table_content">' + (_.isEmpty(cell) ? '&nbsp;' : $("<div/>").text(cell).html()) + '</div></td>';
								}, '', this) + '</tr>';
						}, '') + '</table>';
				}
				return html_back;
			}
		},
		table_theme:{

		}
	};
    _.extend(vc.atts, vcTable.param);

    // $('body').on('click', '.vc_table_cell', function() {
    //     $(this).trigger('dbclick');
    // });

    // $('.vc_table_cell.fill').on('change', function() {
    //     alert(1);
    // }); 

})(window.jQuery, window._);