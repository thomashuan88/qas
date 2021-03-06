// waitForFinalEvent: set individual timers based on a randomly generated ID
// -------------------------------------------------------------------------------------------------------------
var waitForFinalEvent = (function() {
    var timers = {};
    return function (callback, ms, uniqueId) {
        if (!uniqueId) {
            uniqueId = "Don't call this twice without a uniqueId";
        }
        if (timers[uniqueId]) {
            clearTimeout (timers[uniqueId]);
        }
        timers[uniqueId] = setTimeout(callback, ms);
    };
})();


!function ($) {

    $(function() {


        'use strict';

        // scoped vars
        var $app                 = $(".wrap");                    // outter div
        var $navWrap             = $("#demo1");                   // sidemenu wrapper
        var $narrowTrigger       = $("#js-narrow-menu");          // button that makes the menu narrow or regular size
        var $hiddenTrigger       = $("#js-showhide-menu");        // button which hides or shows the sidemenu
        var $narrowNotIcon       = "fa-bars";             // icon to display when sidemenu is not narrow
        var $narrowIcon          = "fa-ellipsis-v";            // icon to display when sidemenu is narrow
        var $hiddenNotIcon       = "fa-eye";                      // icon to display when sidemenu is not hidden
        var $hiddenIcon          = "fa-eye-slash";                // icon to display when sidemenu is hidden
        var $breakPoint          = 768;                           // breakpoint for sidemenu to show or hide on window.resize
        var $extraMenuTrigger    = $("#js-extramenu");            // button for the extra menu that pops over content on the right (or left on rtl design)
        var $extraMenu           = $("#extramenu");               // the extra menu container that pops over content on the side

        var $infoContent         = $("#info-content");
        var $infoContentSelector = $('.js-info-tab-selector');


        // --> LocalStorage checks
        // -------------------------------------------------------------------------------------------------------------
        // check localStorage for aside
        if (typeof localStorage !== 'undefined' && localStorage !== null) {
            if (localStorage.getItem("asideNarrow") == "yep") {
                $app.addClass("aside-narrow");
                $narrowTrigger.find("i").removeClass($narrowNotIcon).addClass($narrowIcon);
            }

            if (localStorage.getItem("asideHidden") == "yep") {
                $app.addClass("aside-hidden");
                $hiddenTrigger.find("i").addClass($hiddenNotIcon).removeClass($hiddenIcon);
                $narrowTrigger.hide();
            }
        }

        // check localStorage for extramenu
        if (typeof localStorage !== 'undefined' && localStorage !== null) {
            if (localStorage.getItem("extraMenu") == "yep") {
                $extraMenu.addClass("shown");
            }
        }


        // narrow menu trigger
        // -------------------------------------------------------------------------------------------------------------
        $narrowTrigger.on("click", function() {

            var $_this = $(this);

            if ($app.hasClass("aside-narrow")) {
                // add aside-narrow class to wrapper
                $app.removeClass("aside-narrow");
                // update localStorage with new asideNarrow value
                localStorage.setItem("asideNarrow", "nope");
                // change the icon on the trigger itself
                $_this.find("i").removeClass($narrowIcon).addClass($narrowNotIcon);
                // turn off all open menus if any
                $navWrap.navgoco('toggle', false);
                // rebuild navigation: makes sure proper events are set
                $navWrap.navgoco('reset');
            }else{
                // remove aside-narrow class from wrapper
                $app.addClass("aside-narrow");
                // update localStorage with new asideNarrow value
                localStorage.setItem("asideNarrow", "yep");
                // change the icon on the trigger itself
                $_this.find("i").removeClass($narrowNotIcon).addClass($narrowIcon);
                // turn off all open menus if any
                $navWrap.navgoco('toggle', false);
                // rebuild navigation: makes sure proper events are set
                $navWrap.navgoco('reset');
            }
        });

        // hidden menu trigger
        // -------------------------------------------------------------------------------------------------------------
        $hiddenTrigger.on("click", function() {

            var $_this = $(this);

            if ($app.hasClass("aside-hidden")) {
                // remove aside-hidden class from wrapper
                $app.removeClass("aside-hidden");
                // switch icon
                $_this.find("i").removeClass($hiddenNotIcon).addClass($hiddenIcon);
                // hide narrow trigger
                $narrowTrigger.show();
                // update localstorage
                localStorage.setItem("asideHidden", "nope");
            }else{
                // add aside-hidden class to wrapper
                $app.addClass("aside-hidden");
                // switch icon
                $_this.find("i").addClass($hiddenNotIcon).removeClass($hiddenIcon);
                // hide narrow trigger
                $narrowTrigger.hide();
                // update localstorage
                localStorage.setItem("asideHidden", "yep");
            }
        });


        // extramenu trigger
        // -------------------------------------------------------------------------------------------------------------
        $extraMenuTrigger.on("click", function() {
            if ($extraMenu.hasClass("shown")) {
                $("#extramenu-content").hide();
                // do not show menu because it's visible and we need to hide it
                $extraMenu.removeClass("shown");
                localStorage.removeItem("extraMenu");
            }else{

                // menu is hidden, show it
                $extraMenu.addClass("shown");
                localStorage.setItem("extraMenu", "yep");

            }

            // Transition-end trigger for boxed layouts, is not triggered with fluid layouts because we don't use the html container in those themes.
            $extraMenu.one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend',
                function(e) {
                    if ($extraMenu.hasClass("shown")) {
                        $("#extramenu-content").show();
                    }
                }
            );
        });

        // show extramenu content when visible
        if ($extraMenu.hasClass('shown')) {
            $("#extramenu-content").show();
        }else{
            $("#extramenu-content").hide();
        }


        // change triggers depending on screen width (used below)
        // -------------------------------------------------------------------------------------------------------------
        function hiddenOnBreakPoint() {
            //console.log($(window).width());
            if ($('body').width() < $breakPoint) {

                // check localStorage and adjust triggers accordingly
                //if (typeof localStorage !== 'undefined' && localStorage !== null) {
                if (localStorage.getItem("asideHidden") == "nope" || typeof localStorage !== 'undefined') {
                    // add aside-hidden to wrapper
                    $app.addClass('aside-hidden');
                    // trigger
                    $hiddenTrigger.find("i").addClass($hiddenNotIcon).removeClass($hiddenIcon);
                    $narrowTrigger.hide();
                    // storage
                    localStorage.setItem("asideHidden", "yep");
                }
            }else{

                // check localStorage and adjust triggers accordingly
                if (localStorage.getItem("asideHidden") == "yep") {
                    // remove class aside-hidden from wrapper
                    $app.removeClass('aside-hidden');
                    // trigger
                    $hiddenTrigger.find("i").removeClass($hiddenNotIcon).addClass($hiddenIcon);
                    $narrowTrigger.show();
                    // storage
                    localStorage.setItem("asideHidden", "nope");
                }
            }
        }


        // resize verification with hammer protection
        // -------------------------------------------------------------------------------------------------------------
        $(window).resize(function() {
            waitForFinalEvent(function() {
                //console.log("resize");
                hiddenOnBreakPoint();
            }, 250, "hiddenOnBreakPoint");
        });


        // launch the navigation menu (custom Navgoco version)
        // -------------------------------------------------------------------------------------------------------------
        if ($navWrap.length > 0) {
            $navWrap.navgoco({
                caretClassCollapsed: 'fa fa-angle-down',
                caretClassExpanded: 'fa fa-angle-up',
                accordion: true,
                openClass: 'open',
                save: true,
                cookie: {
                    name: 'sidemenuCiMembership',
                    expires: false,
                    path: '/'
                },
                slide: {
                    duration: 200,
                    easing: 'swing'
                }
            });
        }


        // tab menu switch control for sidebar (generic: add/remove menu tabs as you please)
        // -------------------------------------------------------------------------------------------------------------
        $infoContentSelector.on('show.bs.tab', function (e) {
            $infoContentSelector.removeClass('active in'); // remove all active and in classes from them tabs
            $(this).addClass('active in'); // set the current tab active

            localStorage.setItem("js-aside-info-active-tab", $(this).attr('id'));
        });

        if (typeof localStorage !== 'undefined' && localStorage !== null) {
            $infoContentSelector.removeClass('active in');
            $("#" + localStorage.getItem("js-aside-info-active-tab")).addClass('active in');

            $infoContent.find(".tab-pane.active").removeClass('active in');

            $infoContent.find(".tab-pane." + localStorage.getItem("js-aside-info-active-tab")).addClass('active in');
        }


        // select all functionality for manipulating multiple items at one go
        // -------------------------------------------------------------------------------------------------------------
        $(".js-select-all-members").on('change', function() {
            var c = this.checked;
            $(':checkbox').prop('checked',c);
        });
        // verify on each checkbox change whether everything is checked or not and change the select-all button accordingly
        $(".list_members_checkbox").on('change', function() {
            $(".js-select-all-members").prop("checked", $('.list_members_checkbox:checked').length == $('.list_members_checkbox').length);
        });


        // launch the Slimscroll plugin for dropdowns
        // -------------------------------------------------------------------------------------------------------------
        if ($('.scroll').length > 0) {
            $('.scroll').slimscroll(
                {
                    distance: '0',
                    color: '#b9b9b9',
                    railVisible: true,
                    railColor: '#ccc',
                    size: '5px',
                    height: '220px'
                }
            );
        }


        /* ---------- Adminpanel bootbox (alerts when clicking buttons on list members page)
         ------------------------------------------------------------------------------------------------ */

        var myBootbox = function($target) {
            $($target).click(function() {
                $("input[type=submit]", $(this).parents("form")).removeAttr("clicked");
                $(this).attr("clicked", "true");
            });
        };

        myBootbox("form#mass_action_form input[type=submit]");

        $("form#mass_action_form button").on("click", function(evt) {

            var $target = $(this).attr('name');

            evt.preventDefault();
            bootbox.confirm("Warning: <br>" + $(this).data("title"), function(confirmed) {
                if (confirmed) {
                    $("input#mass_action").val($target);
                    $("#mass_action_form").submit();
                }
            });
        });


        // Parsley frontend validation
        // -------------------------------------------------------------------------------------------------------------
        var parsleyFactory = function($form, $button) {
            var $parsley = $form.parsley();
            $button.on('click', function(e) {
                if ($parsley.isValid()) {
                    $parsley.destroy();
                    e.preventDefault();
                    bootbox.confirm(confirm_message, function (confirmed) {
                        if (confirmed) {
                            //$(this).button('loading');
                            $form.submit();
                        } else {
                            $parsley = $form.parsley();
                        }
                    });
                }else{
                    bootbox.alert(require_message);
                    $(this).button("reset");
                }
            });

        };

        // Parsley login form
        // var $loginForm = $("#login_form");
        // if ($loginForm.length) {
        //     parsleyFactory( $loginForm, $("#login_submit") );
        // }
        var $adduserForm = $("#add_user_form");
        if ($adduserForm.length) {
            parsleyFactory( $adduserForm, $("#add_user_submit") );
        }

        // Parsley register form
        var $registerForm = $("#register_form");
        if ($registerForm.length) {

            parsleyFactory( $registerForm, $("#register_submit") );
        }

        // Parsley forgot password form
        var $renewPasswordForm = $("#forgot_password_form");
        if ($renewPasswordForm.length) {
            parsleyFactory( $renewPasswordForm, $("#renew_password_submit") );
        }

        // Parsley retrieve username form
        var $retrieveUsernameForm = $("#retrieve_username_form");
        if ($retrieveUsernameForm.length) {
            parsleyFactory( $retrieveUsernameForm, $("#retrieve_username_submit") );
        }

        // Parsley resend activation form
        var $resendActivationForm = $("#resend_activation_form");
        if ($resendActivationForm.length) {
            parsleyFactory( $resendActivationForm, $("#resend_activation_submit") );
        }

        // Parsley resend activation form
        var $oauth2FinalizeForm = $("#oauth2_finalize_form");
        if ($oauth2FinalizeForm.length) {
            parsleyFactory( $oauth2FinalizeForm, $("#oauth2_finalize_submit") );
        }

        // Parsley shift report insert form
        var shift_report_insert_form = $("#shift_report_insert_form");
        if (shift_report_insert_form.length) {
            parsleyFactory( shift_report_insert_form, $("#shift_report_insert_submit") );
        }

        // Parsley shift report edit form
        var shift_report_follow_up_insert_form = $("#shift_report_follow_up_insert_form");
        if (shift_report_follow_up_insert_form.length) {
            parsleyFactory( shift_report_follow_up_insert_form, $("#shift_report_follow_up_insert_submit") );
        }

        // Parsley shift report follow up insert form
        var shift_report_edit_form = $("#shift_report_edit_form");
        if (shift_report_edit_form.length) {
            parsleyFactory( shift_report_edit_form, $("#shift_report_edit_submit") );
        }

        // Parsley shift report follow up edit form
        var shift_report_follow_up_edit_form = $("#shift_report_follow_up_edit_form");
        if (shift_report_follow_up_edit_form.length) {
            parsleyFactory( shift_report_follow_up_edit_form, $("#shift_report_follow_up_edit_submit") );
        }

        // Parsley information update insert form
        var information_update_insert_form = $("#information_update_insert_form");
        if (information_update_insert_form.length) {
            parsleyFactory( information_update_insert_form, $("#information_update_insert_submit") );
        }

        // Parsley information update edit form
        var information_update_edit_form = $("#information_update_edit_form");
        if (information_update_edit_form.length) {
            parsleyFactory( information_update_edit_form, $("#information_update_insert_submit") );
        }

        // Parsley information update details insert form
        var information_update_details_insert_form = $("#information_update_details_insert_form");
        if (information_update_details_insert_form.length) {
            parsleyFactory( information_update_details_insert_form, $("#information_update_details_insert_submit") );
        }

        // Parsley information update details edit form
        var information_update_details_edit_form = $("#information_update_details_edit_form");
        if (information_update_details_edit_form.length) {
            parsleyFactory( information_update_details_edit_form, $("#information_update_details_edit_submit") );
        }

        // Parsley time sheet insert form
        var time_sheet_insert_form = $("#time_sheet_insert_form");
        if (time_sheet_insert_form.length) {
            parsleyFactory( time_sheet_insert_form, $("#time_sheet_insert_submit") );
        }

        // Parsley time sheet edit form
        var time_sheet_edit_form = $("#time_sheet_edit_form");
        if (time_sheet_edit_form.length) {
            parsleyFactory( time_sheet_edit_form, $("#time_sheet_edit_submit") );
        }

        // Parsley question type insert form
        var question_type_insert_form = $("#question_type_insert_form");
        if (question_type_insert_form.length) {
            parsleyFactory( question_type_insert_form, $("#question_type_insert_submit") );
        }

        // Parsley question type edit form
        var question_type_edit_form = $("#question_type_edit_form");
        if (question_type_edit_form.length) {
            parsleyFactory( question_type_edit_form, $("#question_type_edit_submit") );
        }

        // Parsley question content insert form
        var question_content_insert_form = $("#question_content_insert_form");
        if (question_content_insert_form.length) {
            parsleyFactory( question_content_insert_form, $("#question_content_insert_submit") );
        }

        // Parsley question content insert form
        var question_content_edit_form = $("#question_content_edit_form");
        if (question_content_edit_form.length) {
            parsleyFactory( question_content_edit_form, $("#question_content_edit_submit") );
        }

        //Parsley shift setting edit form
        var shift_setting_edit_form = $("#shift_setting_edit_form");
        if (shift_setting_edit_form.length) {
            parsleyFactory( shift_setting_edit_form, $("#shift_setting_edit_submit") );
        }

        //Parsley product setting add form
        var product_setting_add_form = $("#product_setting_add_form");
        if (product_setting_add_form.length) {
            parsleyFactory( product_setting_add_form, $("#product_setting_add_submit") );
        }

        //Parsley product setting add form
        var product_setting_edit_form = $("#product_setting_edit_form");
        if (product_setting_edit_form.length) {
            parsleyFactory( product_setting_edit_form, $("#product_setting_edit_submit") );
        }

        //Parsley live person setting add form
        var live_person_setting_add_form = $("#live_person_setting_add_form");
        if (live_person_setting_add_form.length) {
            parsleyFactory( live_person_setting_add_form, $("#live_person_setting_add_submit") );
        }

        //Parsley live person setting edit form
        var live_person_setting_edit_form = $("#live_person_setting_edit_form");
        if (live_person_setting_edit_form.length) {
            parsleyFactory( live_person_setting_edit_form, $("#live_person_setting_edit_submit") );
        }

        //Parsley change password form
        var change_password_form = $("#change_password_form");
        if (change_password_form.length) {
            parsleyFactory( change_password_form, $("#change_password_submit") );
        }

        //Parsley general setting form
        var general_setting_form = $("#general_setting_form");
        if (general_setting_form.length) {
            parsleyFactory( general_setting_form, $("#general_setting_submit") );
        }

        //Parsley mail setting form
        var mail_setting_form = $("#mail_setting_form");
        if (mail_setting_form.length) {
            parsleyFactory( mail_setting_form, $("#mail_setting_submit") );
        }


       


        var $add_role_form = $("#add_role_form");
        if ($add_role_form.length) {
            parsleyFactory( $add_role_form, $("#add_role_save") );
        }



        // profile picture upload
        // -------------------------------------------------------------------------------------------------------------
        if ($('#fileupload').length) {
            var url = CI.base_url + 'tools/upload/upload_profile_picture';
            $('#fileupload').fileupload({
                url: url,
                dataType: 'json',
                disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator.userAgent),
                maxFileSize: 50000,
                acceptFileTypes: /^image\/(jpe?g|png)$/i,
                submit: function () {
                    $('#progress').removeClass('hidden');
                    $('#files').text('');
                },
                add: function(e, data) {
                    var uploadErrors = [];
                    var acceptFileTypes = /^image\/(jpe?g|png)$/i;
                    if(data.originalFiles[0]['type'].length && !acceptFileTypes.test(data.originalFiles[0]['type'])) {
                        uploadErrors.push('Not an accepted file type.');
                    }
                    if(data.originalFiles[0]['size'].toString().length > 0 && data.originalFiles[0]['size'] > 50000) {
                        uploadErrors.push('Filesize is too big.');
                    }
                    if(uploadErrors.length > 0) {
                        $('#files').text(uploadErrors.join("\n"));
                    } else {
                        data.submit();
                    }
                },
                done: function (e, data) {
                    $.each(data.result.files, function (index, file) {
                        var $output = '';
                        if (file.error != 0) {
                            $output = file.error;
                        }
                        var d = new Date();
                        var extension = file.name.substr( (file.name.lastIndexOf('.') +1) );
                        $('#progress').addClass('hidden');
                        $('#progress .progress-bar').css('width', '0%');
                        $('#js_profile_image').attr('src', CI.base_url + 'assets/img/members/'+ CI.username + '/profile.'+ extension +'?' + d.getTime());
                        $('#files').text($output);
                    });
                },
                progressall: function (e, data) {
//                console.log(data);
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .progress-bar').css(
                        'width',
                        progress + '%'
                    );
                },
                fail: function (e, data) {
                    $('#files').text('File upload is down. Please try again later.');
                }
            }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
        }


        // adminpanel text on search button -> list members page
        // -------------------------------------------------------------------------------------------------------------
        $("#js-search").on('click', function() {
            if ($("#search_wrapper").hasClass("in")) {
                var lang_expand = $('#lang_expand').val();
                $("#js-search-text").html('<i class="fa fa-expand pd-r-5"></i> '+lang_expand);
            }else{
                var lang_collapse = $('#lang_collapse').val();
                $("#js-search-text").html('<i class="fa fa-compress pd-r-5"></i> '+lang_collapse);
            }
        });


        /* ---------- other
         ------------------------------------------------------------------------------------------------ */

        // confirm delete
        $(".js-confirm-delete").on('click', function(){
            if(confirm('Are you sure to delete?')) {
                $(this).button('loading');
                return true;
            }else{
                return false;
            }
        });

    });

}(window.jQuery);

$(window).load(function(e){

    // let's show our hidden body after everything is done
    var $pageContainer = $('body');
    // $pageContainer.css('display', 'none'); //comment out to stop the blinking page effect
    $pageContainer.css('visibility', 'inherit');
    // $pageContainer.fadeIn(400);

    // workaround for removing #_-_ from url during Facebook authentication
    if (window.location.hash == '#_=_') {
        window.location.hash = ''; // for older browsers, leaves a # behind
        history.pushState('', document.title, window.location.pathname); // nice and clean
        e.preventDefault(); // no page reload
    }
});



//Parsley validation on upload file size
window.Parsley.addValidator('maxFileSize', {
  validateString: function(_value, maxSize, parsleyInstance) {
    if (!window.FormData) {
      alert('You are making all developpers in the world cringe. Upgrade your browser!');
      return true;
    }
    var files = parsleyInstance.$element[0].files;
    return files.length != 1  || files[0].size <= maxSize * 1024;
  },
  requirementType: 'integer',
});