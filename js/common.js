/* Common theme functions required throughout executing various tasks
 *  Author : Salman Khimani */
var Common = function (options) {

    // Variables
    var Window = $(window);
    var Body = $('body');

    return {
        /**
         * Initialize
         *
         * @param options
         */
        init: function (options) {

            // Set Default Options
            var defaults = {
                app_rel_url: "", // app relative url
                ajax_call_timeout: 10000, // default timeout
                ajax_response_silent: 0, // silent response
                // Setting this true will reopen the left sidebar
                // when the right sidebar is closed
                timeline_ajax_active: 0, // Timeline ajax queue
            };

            // Extend Default Options.
            var options = $.extend({}, defaults, options);

            // Call Core Functions
            //console.log("getBaseUrl()", getBaseUrl());
        },
        /**
         * Get Base Url
         *
         * @returns {RegExpExecArray | null}
         */
        getBaseUrl: function () {
            var re = new RegExp(/^.*\//);
            return re.exec(window.location.href);
        },
        /**
         * Redirect
         *
         * @param url
         */
        redirect: function (url) {
            document.location = url;
            return;
        },
        /**
         * Redirect Top
         *
         * @param url
         */
        redirectTop: function (url) {
            window.top.location = url;
            return;
        },
        /**
         * Do Scroll
         *
         * @param target
         * @param newSpeed
         * @param moreMargin
         */
        doScroll: function (target, newSpeed, moreMargin) {
            var newSpeed = (!newSpeed || newSpeed == null) ? 1000 : newSpeed;
            var moreMargin = (!moreMargin || moreMargin == null) ? 0 : moreMargin;
            var targetOffset = $('#' + target).offset().top;
            $('html,body').animate({scrollTop: (targetOffset + moreMargin)}, newSpeed);
        },
        /**
         * Get parameter value from url
         * @param url
         * @param param
         * @returns {string | null}
         */
        getParamValue: function (url, param) {
            return new URL(url).searchParams.get(param);
        },
        /**
         * Ajax Multipurpose Function
         * Can be used for Validation, Callbacks, Loading Contents, etc
         *
         * @param params
         * @param formElem
         * @param spinnerElem
         * @param method_type
         * @returns {boolean}
         */
        jsonValidate: function (params, formElem, spinnerElem, method_type) {
            var form = null;
            var base_self = this;

            if (formElem && formElem != '') {

                var form_name = $(formElem).attr("name");

                if (typeof setSelect2MultiValue !== 'undefined')
                    setSelect2MultiValue(form_name);

                var form = $(formElem).serialize();
            }

            // set spinner active if given
            if (spinnerElem && spinnerElem != '') {
                $(spinnerElem).show();
            }
            // set spinner active if given
            if (method_type && method_type != '') {
                method_type = method_type;
            } else {
                method_type = "post";
            }
            method_type = method_type.toUpperCase();

            $.ajax({
                type: method_type, //defaults to GET
                url: params, //defaults to window.location
                //contentType:'application/json', //defaults to application/x-www-form-urlencoded
                cache: false,
                //headers:{},
                timeout: this.ajax_call_timeout,
                dataType: 'application/json', //defaults to text/html
                data: form, //Can be a Key/Value pair string or object. If it's an object, $.serialize is called to turn it into a Key/Value pair string
                complete: function (resp) {
                    // set spinner inactive if given
                    if (spinnerElem && spinnerElem != '') {
                        $(spinnerElem).hide();
                    }
                    //console.log('HTTP RESP : ',resp);
                    if (resp.status != 200) {
                        if (base_self.ajax_response_silent == 0) {
                            if (resp.status == 0) {
                                if (typeof jAlert !== 'undefined')
                                    jAlert('Internet Timeout. Please try again');
                                else
                                    alert('Internet Timeout. Please try again');
                            }
                            else if (resp.status == 404 || resp.status == 500) {
                                if (typeof jAlert !== 'undefined')
                                    jAlert('Error : ' + resp.statusText + '. We are trying to fix it soon. Thanks for your patience...');
                                else
                                    alert('Error : ' + resp.statusText + '. We are trying to fix it soon. Thanks for your patience...');
                            }
                            else {
                                if (typeof jAlert !== 'undefined')
                                    jAlert(resp.statusText);
                                else
                                    alert(resp.statusText);
                            }
                        } else {
                            console.log("response status : " + resp.status + " (" + resp.statusText + ")");
                        }
                    }
                    else {
                        var data = $.parseJSON(resp.responseText);

                        // put html/text in targetElement
                        if (data.target_elem) {
                            // html
                            if (data.html) {
                                $(data.target_elem).html(data.html);
                            }
                            // append HTML
                            if (data.prepend_html) {
                                $(data.target_elem).prepend(data.prepend_html);
                            }
                            // append HTML
                            if (data.append_html) {
                                $(data.target_elem).append(data.append_html);
                            }
                            // before HTML
                            if (data.before_html) {
                                $(data.target_elem).before(data.before_html);
                            }
                            // after HTML
                            if (data.after_html) {
                                $(data.target_elem).after(data.after_html);
                            }
                            // text
                            if (data.text) {
                                $(data.target_elem).text(data.text);
                            }
                            // add Class
                            if (data.add_class) {
                                $(data.target_elem).addClass(data.add_class);
                            }
                            // remove Class
                            if (data.remove_class) {
                                $(data.target_elem).removeClass(data.remove_class);
                            }
                            // prettyPrint
                            if (data.pretty_json) {
                                if (typeof library !== 'undefined')
                                    $(data.target_elem).html(library.json.prettyPrint(JSON.parse(data.pretty_json)));
                                else
                                    $(data.target_elem).html(data.pretty_json);
                            }
                            // jsonEditor
                            if (data.json_editor) {
                                // empty first
                                $(data.target_elem).empty();

                                // set in json editor OR target element
                                if (typeof JSONEditor !== 'undefined') {
                                    // create the editor
                                    var container = $(data.target_elem).get(0);
                                    var options = {
                                        mode: 'code',
                                        //modes: ['code', 'text', 'tree'], // allowed modes
                                        onError: function (err) {
                                            alert(err.toString());
                                        },
                                        onModeChange: function (newMode, oldMode) {
                                            //console.log('Mode switched from', oldMode, 'to', newMode);
                                        }
                                    };
                                    var editor = new JSONEditor(container, options);
                                    editor.set($.parseJSON($.trim(data.json_editor)));
                                } else {
                                    $(data.target_elem).html(data.json_editor);
                                }

                            }

                        }

                        // field text
                        if (data.fld_text) {
                            // remove previous errors
                            $('div[class*="' + data.fld_class + '"]').remove();
                            var errHtml = '<div class="' + data.fld_class + '">' + data.fld_text + '</div>';
                            $(data.focus_elem).parent('div').filter(":first").append(errHtml);
                        }

                        // focus Element
                        if (data.focus_elem) {
                            $(data.focus_elem).focus();
                        }

                        // scroll focus Element
                        if (data.scroll_focus) {
                            this.doScroll(data.scroll_focus);
                        }

                        // set redirection
                        if (data.redirect) {
                            base_self.redirect(data.redirect);
                        }
                        // set top redirection
                        if (data.redirect_top) {
                            base_self.redirectTop(data.redirect_top);
                        }
                        // set refresh
                        if (data.refresh) {
                            window.location.reload();
                        }
                        // set top refresh
                        if (data.refresh_top) {
                            window.top.location.reload();
                        }
                        // jsAlert
                        if (data.js_alert) {
                            jAlert(data.js_alert, (data.js_alert_title ? data.js_alert_title : 'Error'));
                        }
                        // callback
                        if (data.callback) {
                            eval(data.callback);
                        }
                        // trigger
                        if (data.trigger) {
                            if (data.trigger.elem != "" && data.trigger.event != "") {
                                $(data.trigger.elem).trigger(data.trigger.event);
                            }
                        }
                    }

                }
            });

            return false;
        },

    }

}();

/** Salman Function Ends */