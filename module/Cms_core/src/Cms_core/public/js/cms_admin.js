/* CMS_ADMIN.js */

//Load data for datagrid
function getGridData(grid_id){
    var rows = [];
    $.ajax({
        url: $(grid_id).attr('grid_url'),//eg. /admin/article/grid
        data:{listType:$(grid_id).attr('list_type')},
        type: 'post',
        success: function(data) {
            $.each(data.data,function(key, value){
                rows.push(value);
            })
            $(grid_id).datagrid('loadData', rows);
        },
        error: function(xhr) {
            console.log('Ajax request error');
        }
    })
}

//pager filter for datagrid
function pagerFilter(data){
    if (typeof data.length == 'number' && typeof data.splice == 'function'){	// is array
        data = {
            total: data.length,
            rows: data
        }
    }
    var dg = $(this);
    var opts = dg.datagrid('options');
    var pager = dg.datagrid('getPager');
    pager.pagination({
        onSelectPage:function(pageNum, pageSize){
            opts.pageNumber = pageNum;
            opts.pageSize = pageSize;
            pager.pagination('refresh',{
                pageNumber:pageNum,
                pageSize:pageSize
            });
            dg.datagrid('loadData',data);
        }
    });
    if (!data.originalRows){
        data.originalRows = (data.rows);
    }
    var start = (opts.pageNumber-1)*parseInt(opts.pageSize);
    var end = start + parseInt(opts.pageSize);
    data.rows = (data.originalRows.slice(start, end));
    return data;
}

//=======================================
// CMS popup modal: class definition
var CMS_popup_modal = function(){
    this._content_id;
    this.open = function(content_id){
        this._content_id = content_id;//content element ID
        $('#popupmodal_background').attr('content', this._content_id);
        $('#popupmodal_background').fadeIn(220,function(){$('#'+$('#popupmodal_background').attr('content')).toggle("drop")});
    }
    this.close = function(){
        $('#'+this._content_id).toggle("drop",{}, 400, function(){$('#popupmodal_background').fadeOut(220)});
    }
}
var popupModal = new CMS_popup_modal();
// CMS popup modal: class definition(END)
//=======================================

//=======================================
// General Function: Popup return message
var returnMessage = function(selector, message){
    $(selector).html(message).css('display','block').delay(3000).fadeOut(800);
}
// General Function: Popup return message(END)
//=======================================

$(function(){
    $('#cms_grid').datagrid({
        loadFilter:pagerFilter,
        onSortColumn:function(sort,order){
            alert(sort+":"+order)
        },
        onLoadSuccess:function(){
            //Ajax functoin: delete/enable/erase/restore
            $('a.ajax').click(function(e){
                e.preventDefault();
                var action = $(this).attr('action');
                var confirmMsg = $(this).attr('confirm');
                if(confirmMsg && !confirm(confirmMsg)) return;
                $.ajax({
                    url: $(this).attr('href'),
                    type: 'get',
                    success: function(data) {
                        getGridData('#cms_grid');
                    },
                    error: function(xhr) {
                        console.log('Ajax request error');
                    }
                })
            })
        }
    });//initial grid
    if($('#cms_grid').length) getGridData('#cms_grid');//load data
    
    //Initial side widget menu
    $('.sideWidget').tabSlideOut({
        tabHandle: '.handle',                     //class of the element that will become your tab
        pathToTabImage: '/img/widget_icon.png', //path to the image for the tab //Optionally can be set using css
        imageHeight: '32px',                     //height of tab image           //Optionally can be set using css
        imageWidth: '32px',                       //width of tab image            //Optionally can be set using css
        tabLocation: 'left',                      //side of screen where tab lives, top, right, bottom, or left
        speed: 300,                               //speed of animation
        action: 'click',                          //options: 'click' or 'hover', action to trigger animation
        topPos: '80px',                          //position from the top/ use if tabLocation is left or right
        leftPos: '20px',                          //position from left/ use if tabLocation is bottom or top
        fixedPosition: false                      //options: true makes it stick(fixed position) on scroll
    });
    //Initial side widget menu(END)
        
    //Generate slug on text input
    $('#cms_title').keyup(function(){
        var Text = $(this).val();
        Text = Text.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'')
        $("#cms_url").val('/'+Text);	
    });
    
    $('#submitorcancelbutton').click(function(){
        window.location = $(this).val();
    })
    
    //SEO save button
    $('form#seo_form #submitbutton').click(function(){
        var seoobject = $('#seo_form input[name=object]').val();
        var seoobj_id = $('#seo_form input[name=obj_id]').val();
        var seo_title = $('#seo_form input[name=seo_title]').val();
        var seo_description = $('#seo_form input[name=seo_description]').val();
        var seo_keywords = $('#seo_form input[name=seo_keywords]').val();
        $.ajax({
            url: '/admin/seo/save',
            data:{object:seoobject,
                obj_id:seoobj_id,
                seo_title:seo_title,
                seo_description:seo_description,
                seo_keywords:seo_keywords},
            type: 'post',
            success: function(data) {
                returnMessage('.seo .returnMessage', data.message);
            },
            error: function(xhr) {
                console.log('Ajax request error');
            }
        })
    })
   
    //Generic open popup modal
    $('.open-modal').click(function(e){
        e.preventDefault();
        var url = $(this).attr('href')+'?embed=1';
        var container_id = $(this).attr('cont');
        $.ajax({
            url: url,
            data:{},
            type: 'get',
            success: function(data) {
                $('#'+container_id).html(data);
                //Re-enable close button
                $('.close_modal').click(function(e){
                    popupModal.close();
                })
                //Re-enable close button(END)
                popupModal.open(container_id);
            },
            error: function(xhr) {
                console.log('Ajax request error');
            }
        })
    })
    $('#popupmodal_background').click(function(){popupModal.close();})
    
    //Active node listing
    $('.node').each(function(){
        var theNodeTab = $(this);
        loadNodeRecords(theNodeTab);
    })
    
    //Switch to specific tab
    var urlHas = window.location.hash;
    $('.easyui-tabs').tabs('select',urlHas.substring(1,100));
    
    //Load nest sortable
    //Load nest sortable(END)
    
    //Active datepicker, when css-class='datepicker'
    $(".datepicker").datepicker({ dateFormat: "yy-mm-dd" });
    //Active datepicker(END)
    
    //Hide easy-ui dialog(default)
    $(".easyui-dialog").dialog('close');
    
    //WYSIWYG editor -- redactor
    $('.redactor').redactor({
        minHeight: 220
    });

});

var loadNodeRecords = function(theNodeTab){
    $.ajax({
        url: '/admin/node/grid'+theNodeTab.attr('rel'),
        data:{},
        type: 'get',
        success: function(data) {
            theNodeTab.html(data);
            //jquery ui sortable
            console.log(theNodeTab.attr('rel')+" hello");
            theNodeTab.children("#sortable").sortable();
            theNodeTab.children("#sortable").disableSelection();
            theNodeTab.find('#save_order').click(function(e){
                e.preventDefault();
                var result = theNodeTab.children("#sortable").sortable('toArray', {attribute: 'rel'});
                $.ajax({
                    url: '/admin/node/saveorder',
                    data:{listing:result},
                    type: 'post',
                    success: function(data) {
                        returnMessage('span.returnMessage', data.message);
                    },
                    error: function(xhr) {
                        console.log('Ajax request error');
                    }
                })
            })
            //Delete node in article
            theNodeTab.find('.erase_node').click(function(e){
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('href'),
                    data:{id:$(this).attr('rel')},
                    type: 'post',
                    success: function(data) {
                        loadNodeRecords(theNodeTab);
                    },
                    error: function(xhr) {
                        console.log('Ajax request error');
                    }
                })
            })
            //Enable/disable node in article
            theNodeTab.find('.enable_node').click(function(e){
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('href'),
                    data:{id:$(this).attr('rel')},
                    type: 'post',
                    success: function(data) {
                        loadNodeRecords(theNodeTab);
                    },
                    error: function(xhr) {
                        console.log('Ajax request error');
                    }
                })
            })
        },
        error: function(xhr) {
            console.log('Ajax request error');
        }
    })
}