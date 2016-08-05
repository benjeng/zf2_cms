var _filemanager_trigger;
$(function(){
    function renderFolders(){
        $('.easyuitree').tree({
            url:'/admin/filemanager/loadfolder',
            onClick:function(node){
                $('#current').html(node.id);
                switch(node.attributes.type){
                    case "folder":
                        $('#renamefolder').val(node.text);
                        break;
                    case "file":
                        $('#message').html(node.attributes.size);
                        $('#thumb').attr('src',"/tmp" + node.id);
                        $('#renamefolder').val();
                        break;
                }

            }
        });
        loadFolderlist();
    }

    $('#reload').click(function(){
        $('.easyuitree').tree('reload');
        loadFolderlist();
    })
    
    function loadFolderlist(){
        $.ajax({
            url: '/admin/filemanager/loadfolderlist',
            type: 'post',
            success: function(data) {
                $('#movefolder').empty();
                $.each(data, function(i,item) {
                    $('#movefolder').append( '<option value="'
                        + item
                        + '">'
                        + item
                        + '</option>' ); 
                });
            },
            error: function(xhr) {
                console.log('Ajax request error');
            }
        })
    }

    //create folder
    $('#filemanager_container #create').click(function(){
        var current = $('#current').html();
        var newName = $('#createfolder').val();
        $.ajax({
            url: '/admin/filemanager/createfolder',
            data:{current_name:current, create_name:newName},
            type: 'post',
            success: function(data) {
                if(data.status==1){
                    $('#createfolder').val('');
                    $('.easyuitree').tree('reload');
                }
                $('#message').html(data.message);
            },
            error: function(xhr) {
                console.log('Ajax request error');
            }
        })
    })

    //delete folder
    $('#filemanager_container #drop').click(function(){
        var current = $('#current').html();
        $.ajax({
            url: '/admin/filemanager/deletefolder',
            data:{current_name:current},
            type: 'post',
            success: function(data) {
                if(data.status==1){
                    $('#current').html('/');
                    $('.easyuitree').tree('reload');
                }
                $('#message').html(data.message);
            },
            error: function(xhr) {
                console.log('Ajax request error');
            }
        })
    })

    //rename folder
    $('#filemanager_container #rename').click(function(){
        var current = $('#current').html();
        var newName = $('#renamefolder').val();
        $.ajax({
            url: '/admin/filemanager/renamefolder',
            data:{current_name:current, newname:newName},
            type: 'post',
            success: function(data) {
                if(data.status==1){
                    $('#current').html('/');
                    $('#renamefolder').val('');
                    $('.easyuitree').tree('reload');
                }
                $('#message').html(data.message);
            },
            error: function(xhr) {
                console.log('Ajax request error');
            }
        })
    })

    //move folder/files
    $('#filemanager_container #move').click(function(){
        var current = $('#current').html();
        var newPath = $('#movefolder').val();
        $.ajax({
            url: '/admin/filemanager/movefolder',
            data:{current_name:current, newpath:newPath},
            type: 'post',
            success: function(data) {
                if(data.status==1){
                    $('#current').html('/');
                    $('#renamefolder').val('');
                    $('#reload').trigger('click');
                }
                $('#message').html(data.message);
            },
            error: function(xhr) {
                console.log('Ajax request error');
            }
        })
    })
    
    //Hide filemanager
    $('#filemanager_container #close').click(function(){
        popupModal.close();//Close filemanager
    });
    
    $('.filemanager-open').bind('click',function(){
        renderFolders();
        popupModal.open('filemanager_container');
        _filemanager_trigger = $(this);
    })
    $('.filemanager-unset').bind('click',function(){
        $(this).parent().find("input[type=hidden]").val();
        $(this).parent().find("span").html('');
    })
    $('.filemanager-preview').bind('click',function(){//Click on preview button, load the image and open the dialog
        var fileUrl = $(this).parent().find("input[type=hidden]").val();
        $("#dlg_preview").html("<center><img src='/tmp"+fileUrl+"' style='margin:10px' height=240></center>");
        $(".easyui-dialog").dialog('open');
    })
    
    //Pick file
    $('#filemanager_container #pick').click(function(){
        var pickfile = $('#filemanager_container #current').html();
        _filemanager_trigger.parent().find('span').html(pickfile);
        _filemanager_trigger.parent().find('input[type=hidden]').val(pickfile);
        popupModal.close();//Close filemanager
    });
    //Unset
    
    //Uploader (PLUPLOAD)
    $('#filemanager_container #upload').click(function(){
        $("#filemanager_container #pluploader").toggle();
        loadUploader();
    })
    function loadUploader(){
        $("#filemanager_container #pluploader").pluploadQueue({
            // General settings
            runtimes : 'gears,silverlight,browserplus,html5',
            url : '/admin/filemanager/upload',
            max_file_size : '10mb',
            chunk_size : '10mb',
            unique_names : true,

            // Resize images on clientside if we can
            resize : {width : 1500, height : 1500, quality : 100},

            // Specify what files to browse for
            filters : [
                {title : "Image files", extensions : "jpg,gif,png"},
                {title : "Zip files", extensions : "zip"},
                {title : "PDF files", extensions : "pdf"},
                {title : "Office files", extensions : "doc,xls"}
            ],
            init : {
            }
        });
        var _uploader = $("#filemanager_container #pluploader").pluploadQueue();
        _uploader.bind('FileUploaded', function(up, file, info) {
            if(up.total.queued == 0) {
                $("#filemanager_container #pluploader").toggle();
                _uploader.destroy();
                $('#reload').trigger('click');
            }
        });
    }
    //Uploader (PLUPLOAD)(END)
    
    //Click at blank area of the tree to go to default place
    $('#filemanager_container #tree').click(function(){
        $('#message').html("");
        $('#thumb').attr('src',"/img/filemanager_default.jpg");
        $('#renamefolder').val("");
        $('#current').html('/');
    })
});
