(function($){
    // Uploader
    $('#j-panel-form').on('click', '.upload-btn', function(e) {
        e.preventDefault();
        var uploader, id = $(this).attr('id');
        if (uploader) {
            uploader.open();
        }else{
            uploader = wp.media.frames.file_frame = wp.media({
                title: '选择文件',
                button: {
                    text: '选择文件'
                },
                multiple: false
            });
            uploader.on('select', function() {
                var attachment = uploader.state().get('selection').first().toJSON();
                var inputId = id.replace(/_upload/i,'');
                $('#'+inputId).val(attachment.url);
            });
            uploader.open();
        }
    }).on('click', '.toggle', function(){
        var $label = $(this);
        if($label.hasClass('active')){
            $label.removeClass('active');
            $label.next().val(0);
        }else{
            $label.addClass('active');
            $label.next().val(1);
        }
    }).on('click', '.wpcom-panel-nav li', function(){
        var $el = $(this), $item = $('.wpcom-panel-item');
        $('.wpcom-panel-nav li').removeClass('active');
        $el.addClass('active');
        $item.removeClass('active');
        $item.eq($el.index()).addClass('active');
        var Days = 365;
        var exp = new Date();
        exp.setTime(exp.getTime() + Days*24*60*60*1000);
        document.cookie = "mobx_panel_nav="+ $el.index() + ";expires=" + exp.toGMTString()+";path=/";
        if($el.hasClass('more-themes') || $el.hasClass('theme-active')){
            $('.wpcom-panel-submit').hide();
        }else{
            $('.wpcom-panel-submit').show();
        }
    }).on('change', '.toggle-wrap input', function(){
        var $this = $(this);
        if($this.val()==1){
            $this.parent().find('.toggle').addClass('active');
        }else{
            $this.parent().find('.toggle').removeClass('active');
        }
    }).find('.color-picker').wpColorPicker();

    $('#j-panel-form .wpcom-panel-nav li.active').trigger('click');

    if( $('#j-panel-form').length ){
        $.ajax({
            type : "get",
            url : 'http://demo.wpcom.cn/preview/wp-mobile-x.json?t='+Date.parse(new Date()),
            dataType : "jsonp",
            jsonpCallback: "callback",
            success: function(data){
                var html = '';
                if(data.length){
                    for(var i in data){
                        html += '<div class="more-theme-item">'+
                        '<a class="more-theme-img" href="'+data[i].url+'" target="_blank"><img src="'+data[i].img+'"></a>'+
                        '<a class="more-theme-title" href="'+data[i].url+'" target="_blank">'+data[i].title+'</a></div>';
                    }
                }else{
                    html = '<p style="padding: 30px 0;text-align: center;font-size: 16px;color: #999;">即将推出，敬请期待！</p>';
                }
                $('#j-panel-form .more-theme-wrap').html(html);
            },
            error: function(){
                $('#j-panel-form .more-theme-wrap').html('<p style="padding: 30px 0;text-align: center;font-size: 16px;color: #999;">即将推出，敬请期待！</p>');
            }
        });
    }


    var $panel_wrap = $('#wpcom-panel-form');
    $panel_wrap.on('click', '.j-repeat-add', function () {
        var $el = $(this).parent().prev();
        var $wrap = $el.closest('.wpcom-panel-repeat');
        var html = $el.html();
        var id = parseInt($el.data('id')) + 1;
        html = html.replace(/for="wpcom_(\S+)_(\d+)"/igm, 'for="wpcom_$1_'+id+'"');
        html = html.replace(/id="wpcom_(\S+)_(\d+)"/igm, 'id="wpcom_$1_'+id+'"');
        html = html.replace(/id="wpcom_(\S+)_(\d+)_upload"/igm, 'id="wpcom_$1_'+id+'_upload"');
        html = html.replace(/name="(\S+)\[(\d+)\](\[\])?"/igm, 'name="$1['+id+']$3"');
        if($el.find('.repeat-action').length==0){
            $('<div class="repeat-wrap" data-id="'+id+'">'+html+'<div class="repeat-action"><div class="repeat-item repeat-up j-repeat-up"><i class="dashicons dashicons-arrow-up-alt"></i></div><div class="repeat-item repeat-down j-repeat-down"><i class="dashicons dashicons-arrow-down-alt"></i></div><div class="repeat-item repeat-del j-repeat-del"><i class="dashicons dashicons-no-alt"></i></div></div></div>').insertAfter($el);
        }else{
            $('<div class="repeat-wrap" data-id="'+id+'">'+html+'</div>').insertAfter($el);
        }
        var $new_dowm = $wrap.find('[data-id="'+id+'"]');
        $new_dowm.find('input[type=text]').val('');
        $new_dowm.find('textarea').val('');

        var $cp = $new_dowm.find('.wp-picker-container');
        if($cp.length){
            for(var i=0;i<$cp.length;i++){
                $($cp[i]).replaceWith($($cp[i]).find('.color-picker'));
            }
        }
        $new_dowm.find('.color-picker').wpColorPicker();

    }).on('click', '.j-repeat-del', function () {
        $(this).closest('.repeat-wrap').remove();
    }).on('click', '.j-repeat-up,.j-repeat-down', function () {
        var $el = $(this);

        var $this = $el.closest('.repeat-wrap');
        var $prevEl = $this.prev();
        var preID = $prevEl.data('id');
        var thisID = $this.data('id');

        if($el.hasClass('j-repeat-down')){
            $prevEl = $this.next();
            if(!$prevEl.hasClass('repeat-wrap')) return;
            preID = $prevEl.data('id');
        }

        var preVals = {};
        $prevEl.find('input,textarea,select').each(function(i, item){
            var $item = $(item);
            if($item.attr('type')!='checkbox' && $item.attr('type')!='radio') {
                var preName = $item.attr('name');
                if (preName) {
                    var name = preName.replace('[' + preID + ']', '[' + thisID + ']');
                    preVals[name] = $item.val();
                    $item.val($this.find('[name="' + name + '"]').val()).trigger('change');
                }
            }
        });
        $prevEl.find('input:checkbox:checked,input:radio:checked').each(function(i, item) {
            var $item = $(item);
            var preName = $item.attr('name');
            if (preName) {
                var name = preName.replace('[' + preID + ']', '[' + thisID + ']');
                preVals[name] = preVals[name] ? preVals[name] : [];
                preVals[name].push($item.val());
            }
        });

        var thisVals = [];
        $this.find('input:checkbox:checked,input:radio:checked').each(function(i, item) {
            var $item = $(item);
            var name = $item.attr('name');
            if (name) {
                var preName = name.replace('[' + thisID + ']', '[' + preID + ']');
                thisVals[preName] = thisVals[preName] ? thisVals[preName] : [];
                thisVals[preName].push($item.val());
            }
        });

        $prevEl.find('input:checkbox,input:radio').each(function(i, item){
            var $item = $(item);
            var name = $item.attr('name');
            if(name){
                $item.prop('checked', false);
                if($.inArray($item.val(), thisVals[name])>=0) {
                    $item.prop('checked', true).trigger('change');
                }
            }
        });

        $this.find('input, textarea, select').each(function(i, item){
            var $item = $(item);
            if($item.attr('type')!='checkbox' && $item.attr('type')!='radio') {
                $item.val(preVals[$item.attr('name')]).trigger('change');
            }
        });

        $this.find('input:checkbox,input:radio').each(function(i, item){
            var $item = $(item);
            var name = $item.attr('name');
            if(name){
                $item.prop('checked', false);
                if($.inArray($item.val(), preVals[name])>=0) {
                    $item.prop('checked', true).trigger('change');
                }
            }
        });
    });


    $('#j-check-version').click(function(){
        var $label = $(this);
        $label.html('检查中...');
        $.getJSON(ajaxurl, { action : 'mobx_check_version'}, function(data){
            var $html = '<span class="check-version">最新版本：<span style="color: green;">'+data.version+'</span>，<a href="https://www.wpcom.cn/help/62.html" target="_blank">查看主题在线更新教程</a></span>';
            if(data.version==data.current){
                $html = '<span class="check-version">最新版本：<span style="color: green;">'+data.version+'</span>';
            }
            $label.parent().append($html);
            $label.hide();
        });
    });


    // 分类按选择排序
    var $cat = $('.j-cat-sort');
    var cat_array = {};
    if($cat.length){
        for(var i=0;i<$cat.length;i++){
            var $name = $($cat[i]).data('name');
            cat_array[$name] = {};
            cat_array[$name]['y'] = [];
            cat_array[$name]['n'] = [];
            $($cat[i]).find('label').each(function (a, v) {
                if($(v).find('input').is(':checked')){
                    cat_array[$name]['y'].push({id: $(v).find('input').val(), name: $.trim($(v).text())});
                }else{
                    cat_array[$name]['n'].push({id: $(v).find('input').val(), name: $.trim($(v).text())});
                }
            });
        }
    }
    cats_render(cat_array);

    $cat.on('change', 'input', function () {
        var $this = $(this);
        var $name = $this.closest('.j-cat-sort').data('name');
        var checked = $this.is(':checked');
        for(var z=0;z<cat_array[$name][checked ? 'n' : 'y'].length;z++){
            if(cat_array[$name][checked ? 'n' : 'y'][z] && cat_array[$name][checked ? 'n' : 'y'][z].id==$this.val()){
                delete cat_array[$name][checked ? 'n' : 'y'][z];
            }
        }
        cat_array[$name][checked ? 'y' : 'n'].push({id:$this.val(), name: $.trim($this.parent().text())});
        cats_render(cat_array);
    });


    function cats_render(cat_array){
        for(var x in cat_array){
            var $el = $('[data-name="'+x+'"]');
            var $html = '';
            for(var b = 0;b<cat_array[x]['y'].length;b++){
                if(cat_array[x]['y'][b] && cat_array[x]['y'][b]['name']) $html += '<label class="checkbox-inline"><input name="'+x+'[]" checked type="checkbox" value="'+cat_array[x]['y'][b]['id']+'"> '+cat_array[x]['y'][b]['name']+'</label>';
            }
            for(var c = 0; c<cat_array[x]['n'].length; c++){
                if(cat_array[x]['n'][c] && cat_array[x]['n'][c]['name']) $html += '<label class="checkbox-inline"><input name="'+x+'[]" type="checkbox" value="'+cat_array[x]['n'][c]['id']+'"> '+cat_array[x]['n'][c]['name']+'</label>';
            }
            $el.html($html);
        }
    }

})(jQuery);