// Bind scripts after DOM loaded
$(document).ready(function () {
    // init
    init_view();
});

/**
 * Init View
 */
function init_view() {
    $.ajax({
        type: 'GET', //defaults to GET
        url: 'backend/actions.php',
        cache: false,
        //headers:{},
        dataType: 'application/json', //defaults to text/html
        complete: function (resp) {
            //console.log('HTTP RESP : ',resp);
            if (resp.status == 200) {
                try {
                    resp = JSON.parse(resp.responseText);

                    if (resp.error > 0)
                        alert(resp.message);
                    else
                        $('div#body').html(resp.html);

                } catch (error) {
                    console.log(error);
                }
            }

        }
    });
}

/**
 * Load Streaming
 */
function load_streaming() {
    $.ajax({
        type: 'GET', //defaults to GET
        url: 'backend/actions.php?action=load_streaming',
        cache: false,
        //headers:{},
        dataType: 'application/json', //defaults to text/html
        complete: function (resp) {
            //console.log('HTTP RESP : ',resp);
            if (resp.status == 200) {
                try {
                    resp = JSON.parse(resp.responseText);

                    if (resp.error > 0)
                        alert(resp.message);
                    else
                        $('div#stream_listing').html(resp.html);

                } catch (error) {
                    console.log(error);
                }
            }

        }
    });
}


/**
 * Get Stream
 */
function get_stream(video_id) {
    $.ajax({
        type: 'GET', //defaults to GET
        url: 'backend/actions.php?action=get_stream&video_id=' + video_id,
        cache: false,
        //headers:{},
        dataType: 'application/json', //defaults to text/html
        complete: function (resp) {
            //console.log('HTTP RESP : ',resp);
            if (resp.status == 200) {
                try {
                    resp = JSON.parse(resp.responseText);

                    if (resp.error > 0)
                        alert(resp.message);
                    else
                        $('div#stream_listing').html(resp.html);

                } catch (error) {
                    console.log(error);
                }
            }

        }
    });
}

/**
 * Load Chat
 */
function load_chat(video_id) {
    // disable chat form
    //$('form[name=chat_form] input[name=submit]').attr('disabled');
    $.ajax({
        type: 'GET', //defaults to GET
        url: 'backend/actions.php?action=load_chat&video_id=' + video_id,
        cache: false,
        //headers:{},
        dataType: 'application/json', //defaults to text/html
        complete: function (resp) {
            //console.log('HTTP RESP : ',resp);
            if (resp.status == 200) {
                try {
                    resp = JSON.parse(resp.responseText);

                    if (resp.error > 0)
                        alert(resp.message);
                    else {
                        $('div#chat_box').html(resp.html);
                        // enable chat submit
                        //$('form[name=chat_form] input[name=submit]').removeAttr('disabled');
                        // if has chat, remove be_first div
                        if ($('div#chat_box div#chat_box').length > 0)
                            $('div#chat_box div#be_first').remove();

                        // if got stream, update stats
                        if(resp.stream != null) {
                            $('span#message_count').text(resp.stream.chat_count);
                            $('span#user_count').text(resp.stream.chat_user_count);
                        }
                    }

                } catch (error) {
                    console.log(error);
                }
            }

        }
    });
}



/**
 * Post Chat
 */
function post_chat(video_id) {
    var chat_form = 'form[name=chat_form]';
    // disable chat form
    $(chat_form + ' input[name=submit]').attr('disabled');
    $.ajax({
        type: 'POST', //defaults to GET
        url: 'backend/actions.php?action=post_chat&video_id=' + video_id,
        cache: false,
        data: $(chat_form).serialize(),
        //headers:{},
        dataType: 'application/json', //defaults to text/html
        complete: function (resp) {
            //console.log('HTTP RESP : ',resp);
            if (resp.status == 200) {
                try {
                    resp = JSON.parse(resp.responseText);

                    if (resp.error > 0)
                        alert(resp.message);
                    else {
                        // empty form
                        $(chat_form).trigger('reset');
                        // load chat
                        $('div#chat_box').html(resp.html);
                        // enable chat submit
                        $(chat_form + ' input[name=submit]').removeAttr('disabled');
                        // load chat
                        load_chat(video_id);
                        // if got stream, update stats
                        if(resp.stream != null) {
                            $('span#message_count').text(resp.stream.chat_count);
                            $('span#user_count').text(resp.stream.chat_user_count);
                        }
                    }

                } catch (error) {
                    console.log(error);
                }
            }

        }
    });
}