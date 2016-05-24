<?php
// username
$lang['username'] = '用户名';
$lang['user_management'] = '用户管理';
$lang['user_listing'] = '用户列表';
$lang['forgot_username'] = '找回密码';
$lang['forgot_username_title'] = '找回密码';
$lang['forgot_username_subject'] = '您的用户名';
$lang['forgot_username_message'] = ",\r\n\r\nSomeone (probably you) requested to send this account info:\r\n\r\nYour username: ";
$lang['forgot_username_success'] = 'A username has been sent to your e-mail address.';
$lang['send_username'] = '发送用户名';

// password
$lang['password'] = '密码';
$lang['old_password'] = "旧密码";
$lang['new_password'] = "新密码";
$lang['confirm_password'] = '确认密码';
$lang['change_password'] = '更换密码';
$lang['reset_password'] = '重置密码';
$lang['change_password_success'] = '密码更改成功。';
$lang['change_password_failed'] = '无法更改密码。';


//confirmation message
$lang['confirm_message'] = '您确定要提交此表？';
$lang['delete_message'] = '您确定要删除此记录？';
$lang['reset_message'] = '您确定要重置密码？';


$lang['forgot_password'] = '找回密码';
$lang['renew_password_title'] = '忘记密码';
$lang['forgot_password_subject'] = '要求重置密码';
$lang['forgot_password_message'] = ",\r\n\r\n您的密码重置过程已启动。请点击以下链接，并通过电子邮件接收您的新密码。\r\n\r\n";
$lang['forgot_password_success'] = '密码的链接已发送到您的电子邮件地址。';
$lang['send_password'] = '发送密码';
$lang['reset_password_subject'] = '新密码已创建';
$lang['reset_password_message'] = ",\r\n\r\n您的新密码为: ";
$lang['reset_password_success'] = '新密码发送到您的电子邮件地址。';
$lang['reset_password_failed_db'] = '无法重置密码。';
$lang['reset_password_failed_token'] = '安全验证已失败。';
$lang['edit_password'] = '更改密码';


// remember me
$lang['remember_me'] = 'Remember me';
$lang['date_registered'] = 'Date registered';

// resend activation
$lang['resend_activation'] = 'Resend activation link';
$lang['resend_activation_subject'] = 'Activation required - resend';
$lang['resend_activation_message'] = ",\r\n\r\nsomeone (probably you) requested to resend your activation link. To activate your account please visit the link below (or copy-paste into your browser). ";
$lang['resend_activation_success'] = 'Activation e-mail has been resent - please check the link in your mailbox to activate your membership.';

// login
$lang['login'] = '登入';
$lang['login_incorrect'] = '登入错误';
$lang['login_disabled'] = '登入已被禁用';
$lang['max_login_attempts_reached'] = '你已多次尝试登入。若要解锁您的帐户，请联系我们。';
$lang['last_login'] = '上次登入';
$lang['logout'] = '登出';

// register
$lang['unable_to_register'] = 'Unable to register - please try again later.';
$lang['disable_registration'] = "Disable member registration";
$lang['required_fields'] = '(All fields are required)';
$lang['membership_subject'] = 'Activation required';
$lang['membership_message'] = ",\r\n\r\nThank you for registering with us. To activate your account please visit the link below (or copy-paste into your browser).";
$lang['membership_success'] = 'Account created - please check the link in your mailbox to activate your membership.';
$lang['membership_failed_db'] = 'Unable to register - please try again later.';

// RecaptchaV2
$lang['recaptchav2_response'] = "I am not a robot";

// account
$lang['create_account'] = 'Create account';
$lang['is_account_active'] = '这个户口未激活。';
$lang['activate_account'] = 'Please activate your account by clicking the link in the e-mail you received.';
$lang['account_updated'] = 'Updated your profile.';
$lang['account_not_updated'] = 'Could not update your account.';
$lang['account_active'] = 'Account is already active.';
$lang['account_activated'] = 'Account already activated.';
$lang['account_created'] = 'Account has been created.';
$lang['account_not_found'] = 'Account not found.';
$lang['account_is_banned'] = "Account is banned. You can contact us for extra inquiries regarding this status to find out more.";
$lang['account_is_inactive'] = "Account has been deactived. Please contact Admin.";
$lang['account_access_denied'] = 'Access has been denied for this account.';
$lang['account_unknown_error'] = "Unknown error.";
$lang['account_activation_link_expired'] = "Your activation link has expired. Please <a href=\"". base_url() ."auth/resend_activation\">click here to request a new activation link</a>.";
$lang['account_has_been_made_active'] = "Your account was activated.";
$lang['success_activation'] = "Congrats! Your account is now activated";

// email
$lang['email_address'] = '电子邮件地址';
$lang['your_email'] = '您的电子邮件地址';
$lang['send_activation_email'] = 'Send activation e-mail';

// profile
$lang['first_name'] = 'First name';
$lang['last_name'] = 'Last name';
$lang['full_name'] = '全名';
$lang['role'] = '职位';
$lang['job_title'] = '职位';
$lang['leader'] = ' 领导人';
$lang['report_to'] = '负责人';
$lang['phone'] = '电话号码';
$lang['remarks'] = '评语';
$lang['status'] = '状态';
$lang['nickname'] = '昵称';
$lang['dob'] = '出生日期';
$lang['emergency_name'] = '紧急联系人';
$lang['emergency_contact'] = '紧急联系人姓名';
$lang['relationship'] = '关系';


$lang['personal_details'] = 'Personal details';
$lang['change_email'] = 'Change e-mail address';
$lang['password_required_for_changes'] = 'Enter your password before updating profile';
$lang['update_profile'] = 'Update profile';
$lang['current_password'] = 'Current password';
// $lang['new_password'] = 'New password';
$lang['new_password_again'] = 'New password again';
$lang['send_copy_to_email'] = 'Send a copy of your new password to your e-mail?';
$lang['update_password'] = 'Update password';
$lang['my_profile'] = 'My profile';
$lang['profile_subject'] = 'Your new password';
$lang['profile_message'] = ",\r\n\r\nYour new password is: ";
$lang['delete_account_now'] = "Delete account";
$lang['permanently_delete_account'] = 'Permanently delete account - action can\'t be undone!';

// form validation library
$lang['is_valid_email'] = 'Please enter a correct e-mail address.';
$lang['is_valid_password'] = 'The password field must contain at least one of these characters: $.[]|()?*+{}@#! AND must contain at least one number.';
$lang['is_valid_both_password'] = '新密码不能与旧密码相同。';
$lang['is_valid_new_password'] = '您的新密码字段至少包含一个大写、小写、符号与数字。';
$lang['is_valid_confirm_password'] = '您的确认密码字段至少包含一个大写、小写、符号与数字。';
$lang['is_valid_new_password'] = '';
$lang['is_valid_username'] = 'The username field can only contain a-z A-Z 0-9 _ and - characters.';
$lang['is_db_cell_available'] = 'That %s already exists in our database.';
$lang['is_db_cell_available_by_id'] = 'That %s already exists in our database.';
$lang['check_captcha'] = 'Verification code is incorrect (reCaptcha).';
$lang['is_member_password'] = 'Your password is incorrect';
$lang['is_valid_time'] = "时间格式不正确。";

// e-mail greetings
$lang['email_not_found'] = '找不到电子邮件地址。';
$lang['email_greeting'] = '您好';

// access
$lang['no_access'] = '进入拒绝';
$lang['no_access_text'] = '无权查看此页!';

// Oauth2
$lang['invalid_state'] = "Invalid state.";
$lang['no_provider_found'] = "No provider found in DB in oauth2 method.";
$lang['invalid_token'] = 'Invalid or expired token.';
$lang['load_userdata_failed'] = "Could not load userdata.";
$lang['email_not_returned'] = "No email was returned. For some providers making your email public will help.";
$lang['refresh_token_failed'] = 'Unable to refresh token, please try again.';
$lang['oauth2_finish_account_creation'] = "Finish account creation";
$lang['oauth2_not_active'] = 'Account is inactive - please contact an admin.';

// img folder
$lang['create_imgfolder_failed'] = "Problem creating image directory.";

// messaging
$lang['message_error_heading'] = "Please verify the following:";
$lang['message_success_heading'] = "成功!!";

// adminpanel
$lang['enter_search_data'] = 'Please enter some search data.';
$lang['admin_noban'] = 'Not allowed to ban main administrator account.';
$lang['admin_noactivate'] = 'Not allowed to deactivate main administrator account.';
$lang['member_updated'] = 'Member with username %s and ID %s updated.';
$lang['toggle_ban'] = "Member with username %s ";
$lang['toggle_active'] = "Member with username %s ";
$lang['main_not_found'] = 'Theme file not found: %s.';
$lang['controller_not_found'] = 'Controller %s.php not found.';
$lang['settings_update'] = 'Settings successfully updated.';
$lang['sessions_cleared'] = 'Session successfully deleted.';
$lang['sessions_not_cleared'] = 'Nothing to clear.';
$lang['banned'] = "banned.";
$lang['unbanned'] = "unbanned.";
$lang['activated'] = ".激活";
$lang['deactivated'] = "停用.";
$lang['site_disabled'] = 'Site has been disabled.';
$lang['add_member'] = '添加会员';
$lang['add_user'] = '添加用户';
$lang['member_detail'] = 'Member detail';
$lang['backup_and_export'] = 'Backup & export';
$lang['dashboard'] = 'Dashboard';
$lang['export_e-mail_text_title'] = 'Members list';
$lang['backup_e-mail_text_title'] = 'Database backup';
$lang['backup_e-mail_text'] = "The database file is attached as zip file.";
$lang['export_title'] = "Export members list";
$lang['backup_title'] = "Backup your database";
$lang['search'] = "搜索";
$lang['search_member'] = "Search member";
$lang['search_user'] = "搜索用户";
$lang['search_record'] = "搜索记录";
$lang['edit_record'] = "更改记录";

$lang['submit_by'] = "提交人";
$lang['submit_time'] = "提交时间";
$lang['submit_time_from'] = "提交时间（从）";
$lang['submit_time_to'] = "提交时间 (至）";
$lang['total_members'] = "Total members";
$lang['list_members'] = 'List members';
$lang['viewing_member'] = 'Viewing member';
$lang['send_copy'] = 'E-mail member about profile updates made here.';
$lang['save_member_data'] = 'Save member data';
$lang['provider_name'] = 'Name';
$lang['client_id'] = 'Client ID';
$lang['client_secret'] = 'Client secret';
$lang['provider_enabled'] = 'Enabled';
$lang['oauth_providers'] = 'OAuth providers';
$lang['add_provider'] = 'Add provider';
$lang['provider_subtitle'] = 'The name must be exactly the same as the provider for example "Google", not "google+".';
$lang['provider_delete'] = 'Delete';
$lang['provider_save'] = 'Save';
$lang['provider_name'] = 'Name';
$lang['provider_client_id'] = 'Client ID';
$lang['provider_client_secret'] = 'Client secret';
$lang['provider_success_add'] = 'New provider added.';
$lang['membership_edited'] = "Your account has been edited by us, please visit your profile to view the changes. In case we have changed your password you will not be able to log on: in that case, use the reset password procedure. \r\n Kind regards - the admin";
$lang['membership_edited_subject'] = 'Your account info was changed';

// backup & export
$lang['backup_text'] = "This e-mail will be sent to the admin e-mail entered in site settings.";
$lang['backup_warning1'] = "WARNING 1: for very large databases this might not be possible and you will have to export directly from the MySQL command line.";
$lang['backup_warning2'] = "WARNING 2: you might want to take your MySQL server offline before backing up. Disable site login before doing this.";
$lang['members_export_success'] = 'The members export has been sent.';
$lang['members_export_failed'] = 'The members export has failed!';
$lang['database_export_success'] = 'The database export has been sent.';
$lang['database_export_failed'] = 'The database export has failed!';

// Settings
$lang['settings'] = "设置";
$lang['site_settings'] = "站点设置";
$lang['system_settings'] = "系统设置";
$lang['shift_setting'] = "班次设置";
$lang['product_setting'] = "产品设置";
$lang['edit_shift'] = "更改班次设置";
$lang['edit_product'] = "更改产品设置";
$lang['add_product'] = "添加新产品";
$lang['shift'] = "班次";
$lang['product'] = "产品";
$lang['category'] = "类别";
$lang['working_shift'] = "工作班次";
$lang['working_hour'] = "工作时间";
$lang['reset'] = "重置";
$lang['save'] = "储存";
$lang['product_type'] = "产品类别";
$lang['morning'] = "早班";
$lang['afternoon'] = "中班";
$lang['night'] = "晚班";
$lang['saving'] = "存储当中。。。";
$lang['resetting'] = "重置当中。。。";
$lang['remark'] = "备注";
$lang['example'] = "例如:12:00";
$lang['action'] = "功能";
$lang['add_new'] = "添加";
$lang['number'] = "序";
$lang['system'] = "系统";
$lang['site_language'] = "网站语言";
$lang['site_title'] = "网站标题";
$lang['live_person'] = "线人";
$lang['consumer_key'] = "消费者钥";
$lang['consumer_secret'] = "消费者秘密";
$lang['access_token'] = "进入象征";
$lang['access_token_secret'] = "进入象征秘密";
$lang['add_live_person'] = "添加线人";
$lang['account_id'] = "账户ID"; 




$lang['clear_sessions_title'] = "Clear your sessions";
$lang['clear_sessions'] = "Clear sessions";
$lang['general_settings_title'] = "General settings";
$lang['save_all_settings'] = "Save all settings";
// $lang['site_title'] = "Site title";
$lang['site_title_p'] = 'The site title appears in the title bar as it is used in the <code>&lt;title&gt;</code> tag. Can be a maximum of 60 characters long.';
$lang['disable_whole_app'] = "Disable whole application";
$lang['disable_whole_app_p'] = "Deny access to all pages, both public and private. The main administrator account will still be able to log in.</p>";
$lang['disabled_text'] = "Text to display when website is disabled:";
$lang['enable_remember_me'] = "Enable remember me";
$lang['enable_remember_me_p'] = "Allow the remember me functionality to be used on the login page (based on cookies).";
$lang['disable_login_access'] = "Disable login access";
$lang['disable_login_access_p'] = "Turn off login ability for all members except the main administrator account.";
$lang['max_login_attempts'] = "Maximum login attempts";
$lang['max_login_attempts_p'] = "Security measure to disallow account access after this many failed login attempts (only works for non-OAuth2 accounts as it is based on the username).";
$lang['post_login_page'] = "Post-login display page";
$lang['post_login_page_p'] = "The page to display right after logging in - should be a controller that extends Private_Controller that resides in application/controllers/private.";
$lang['enable_install_page'] = "Enable install page";
$lang['enable_install_page_p'] = "Turn on the installation page, is used to recreate the main administrator account.";
$lang['members_per_page'] = "Members per page";
$lang['members_per_page_p'] = "The number of members per page to display on the list members page.";
$lang['admin_email'] = "Administrator e-mail account";
$lang['admin_email_p'] = "Primary application e-mail address to be used for sending e-mails - by default the same as the main administrator e-mail.";
$lang['active_theme'] = "Currently active theme";
$lang['active_theme_p'] = "Allows for change of admin folder by selecting the corresponding theme folder name.";
$lang['adminpanel_theme'] = "Theme for this adminpanel";
$lang['adminpanel_theme_p'] = "Use the exact theme folder name here.";
$lang['cookie_expiration'] = "Cookie expiration";
$lang['cookie_expiration_p'] = "Cookies set will receive this number in seconds as their future expiry time.";
$lang['password_link_expiration'] = "Password link expiration";
$lang['password_link_expiration_p'] = "Make the reset password activation link expire in this many seconds in the future.";
$lang['activation_link_expiration'] = "Activation link expiration";
$lang['activation_link_expiration_p'] = "Make the account activation link expire in this many seconds in the future.";
$lang['mail_settings_title'] = "Mail settings";
$lang['sendmail_path'] = "Path to sendmail";
$lang['sendmail_path_p'] = "For most servers this is /usr/sbin/sendmail";
$lang['smtp_host'] = "SMTP host";
$lang['smtp_port'] = "SMTP port";
$lang['smtp_user'] = "SMTP user";
$lang['smtp_password'] = "SMTP password";
$lang['smtp_encrypt'] = "Will be encrypted before saving to database.";
$lang['recaptcha_settings_title'] = "reCAPTCHA V2 settings";
$lang['enable_recaptcha'] = "Enable reCAPTCHA V2";
$lang['enable_recaptcha_p'] = "Turn on recaptcha site-wide to better protect the membership module.";
$lang['site_key'] = "Site key";
$lang['site_secret'] = "Site secret";
$lang['disable_registration_p'] = "Turn off the ability for new people to register on the site.";
$lang['registration_disabled'] = 'Registration has been disabled.';
$lang['login_attempts_trigger'] = "reCAPTCHA V2 login attempts trigger";
$lang['login_attempts_trigger_p'] = "Shows a reCAPTCHA form after this many failed login attempts.";
$lang['enable_oauth'] = "Enable OAuth2 globally";
$lang['enable_oauth_p'] = "Disable or enable the social login integration completely.";

//Roles Page
$lang['active'] = "有效";
$lang['inactive'] = "无效";
$lang['role_name'] = "职位名称";
$lang['status'] = "状态";
$lang['add_role'] = "添加职位";
$lang['submit'] = "提交";
$lang['cancel'] = "取消";
$lang['role'] = "职位";
$lang['permissions'] = "权限";
$lang['roles_permissions'] = "职位和权限管理";
$lang['show_all'] = "显示全部";

//Role Page  msg
$lang['deactivated_error'] = "由于职位还有下属，所以无法停用";
$lang['existed_error'] = "职位已存在";
$lang['add_success'] = "成功添加职位";
$lang['unable_add'] = "无法添加职位";


//performance report
$lang['performance_report'] = "业绩报告";
$lang['daily_qa'] = "每日QA";
$lang['monthly_qa'] = "每月QA";
$lang['total_record'] = "记录数量";
$lang['ops_monthly'] = "每月OPS";
$lang['log_in_out'] = "登录/注销";
$lang['qa_evaluation'] = "QA评估";
$lang['operation_utilization'] = "利用操作";
$lang['pending'] = "待处理导入";
$lang['confirm_import'] = "确认导入";
$lang['import_done'] = "已完成导入";
$lang['import'] = "导入";
$lang['export'] = "导出";
$lang['template'] = "模板";
$lang['yes'] = "是";
$lang['no'] = "否";
$lang['quantity'] = "量";
$lang['import_date'] = "导入日期";
$lang['import_by'] = "被导入";
$lang['update_date'] = "更新日期";
$lang['update_by'] = "被更新";
$lang['typing_test'] = "打字测试";
$lang['monthly_assessment'] = "月度考核";

//Header
// $lang['logged_in'] = "登入为：";


//Roster management
$lang['roster'] = "值班列表";
$lang['roster_search'] = "值班搜索";
$lang['roster_management'] = "值班列表管理";
$lang['new_roster'] = "新值班";
$lang['month'] = "月份";
$lang['monthly'] = "月刊";
$lang['schedule'] = "值班";
$lang['week'] = "周";
$lang['date'] = "日期";
$lang['name'] = "名";
$lang['designation'] = "职位";
$lang['day_of_week_short']['sunday'] = "周日";
$lang['day_of_week_short']['monday'] = "周一";
$lang['day_of_week_short']['tuesday'] = "周二";
$lang['day_of_week_short']['wednesday'] = "周三";
$lang['day_of_week_short']['thursday'] = "周四";
$lang['day_of_week_short']['friday'] = "周五";
$lang['day_of_week_short']['saturday'] = "周六";
$lang['day_of_week']['sunday'] = "星期日";
$lang['day_of_week']['monday'] = "星期一";
$lang['day_of_week']['tuesday'] = "星期二";
$lang['day_of_week']['wednesday'] = "星期三";
$lang['day_of_week']['thursday'] = "星期四";
$lang['day_of_week']['friday'] = "星期五";
$lang['day_of_week']['saturday'] = "星期六";

//member details
$lang['user_details'] = "用户详细信息";
$lang['useupdateile'] = "用户档案";
$lang['user_ids'] = "用户 IDs";
$lang['leave_details'] = "假日信息";

//others (buttons etc)
$lang['expand'] = "扩大";
$lang['collapse'] = "折叠";
$lang['to'] = "至";

//Permissions
$lang['module_name'] = "组件名";
$lang['add'] = "添加";
$lang['edit'] = "更改";
$lang['delete'] = "删除";
$lang['view'] = "View";

//Operation
$lang['operation'] = "Operation";
$lang['shift_report'] = "Shift Report";
$lang['information_update'] = "Information Update";
$lang['time_sheet'] = "Time Sheet";
$lang['question_type'] = "Question Type";
$lang['question_content'] = "Question Content";

//page 404
$lang['page_not_found'] = "找不到网页";
$lang['error_404'] = "错误404：找不到网页";
$lang['return_to_home'] = "请点击这里返回到主页。";