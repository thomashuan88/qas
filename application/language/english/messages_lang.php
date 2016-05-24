<?php
// username
$lang['username'] = 'Username';
$lang['user_management'] = 'User Management';
$lang['user_listing'] = 'User Listing';
$lang['forgot_username'] = 'Retrieve username';
$lang['forgot_username_title'] = 'Retrieve username';
$lang['forgot_username_subject'] = 'Your username';
$lang['forgot_username_message'] = ",\r\n\r\nSomeone (probably you) requested to send this account info:\r\n\r\nYour username: ";
$lang['forgot_username_success'] = 'A username has been sent to your e-mail address.';
$lang['send_username'] = 'Send username';

// password
$lang['password'] = 'Password';
$lang['old_password'] = "Old Password";
$lang['new_password'] = "New Password";
$lang['confirm_password'] = 'Confirm Password';
$lang['change_password'] = 'Change Password';
$lang['reset_password'] = 'Reset Password';
$lang['change_password_success'] = 'Password changed successfully.';
$lang['change_password_failed'] = 'Unable to change password.';


//confirmation message
$lang['confirm_message'] = 'Are you sure that you want to submit this form?';
$lang['delete_message'] = 'Are you sure that you want to delete this record?';
$lang['reset_message'] = 'Are you sure that you want to reset password?';



$lang['forgot_password'] = 'Retrieve password';
$lang['renew_password_title'] = 'Forgot password';
$lang['forgot_password_subject'] = 'Reset password requested';
$lang['forgot_password_message'] = ",\r\n\r\nThe password reset procedure was initiated. Please click the link below and receive a new password via e-mail.\r\n\r\n";
$lang['forgot_password_success'] = 'A password link has been sent to your e-mail address.';
$lang['send_password'] = 'Send password';
$lang['reset_password_subject'] = 'New password created';
$lang['reset_password_message'] = ",\r\n\r\nYour new password is: ";
$lang['reset_password_success'] = 'A new password was sent to your e-mail address.';
$lang['reset_password_failed_db'] = 'Unable to reset password.';
$lang['reset_password_failed_token'] = 'Security token verification failed.';
$lang['edit_password'] = 'Edit password';

// remember me
$lang['remember_me'] = 'Remember me';
$lang['date_registered'] = 'Date registered';

// resend activation
$lang['resend_activation'] = 'Resend activation link';
$lang['resend_activation_subject'] = 'Activation required - resend';
$lang['resend_activation_message'] = ",\r\n\r\nsomeone (probably you) requested to resend your activation link. To activate your account please visit the link below (or copy-paste into your browser). ";
$lang['resend_activation_success'] = 'Activation e-mail has been resent - please check the link in your mailbox to activate your membership.';

// login
$lang['login'] = 'Log in';
$lang['login_incorrect'] = 'Login incorrect.';
$lang['login_disabled'] = 'Login has been disabled.';
$lang['max_login_attempts_reached'] = 'Max login attempts hard ceiling reached. Please contact us to unlock your account.';
$lang['last_login'] = 'Last login';
$lang['logout'] = 'Logout';

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
$lang['is_account_active'] = 'This account is inactive.';
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
$lang['email_address'] = 'E-mail address';
$lang['your_email'] = 'Your e-mail address';
$lang['send_activation_email'] = 'Send activation e-mail';

// profile
$lang['first_name'] = 'First name';
$lang['last_name'] = 'Last name';
$lang['full_name'] = 'Full name';
$lang['role'] = 'Role';
$lang['job_title'] = 'Job Title';
$lang['leader'] = 'Leader';
$lang['report_to'] = 'Report to';
$lang['phone'] = 'Phone Number';
$lang['remarks'] = 'Remarks';
$lang['status'] = 'Status';
$lang['nickname'] = 'Nickname';
$lang['dob'] = 'Date of Birth';
$lang['emergency_name'] = 'Emergency Name';
$lang['emergency_contact'] = 'Emergency Contact';
$lang['relationship'] = 'Relationship';


$lang['personal_details'] = 'Personal details';
$lang['change_email'] = 'Change e-mail address';
$lang['password_required_for_changes'] = 'Enter your password before updating profile';
$lang['update_profile'] = 'Update profile';
$lang['current_password'] = 'Current password';
$lang['new_password'] = 'New password';
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
$lang['is_valid_password'] = 'The password field must contain at least one uppercase,lowercase, symbol and number';
$lang['is_valid_both_password'] = 'New password cannot be same as old password.';
$lang['is_valid_new_password'] = 'The New Password field must contain at least one uppercase,lowercase, symbol and number.';
$lang['is_valid_confirm_password'] = 'The Confirm Password field must contain at least one uppercase,lowercase, symbol and number.';
$lang['is_valid_username'] = 'The username field can only contain a-z A-Z 0-9 _ . and - characters.';
$lang['is_db_cell_available'] = 'The %s already exists in our database.';
$lang['is_db_cell_available_by_id'] = 'That %s already exists in our database.';
$lang['check_captcha'] = 'Verification code is incorrect (reCaptcha).';
$lang['is_member_password'] = 'Your password is incorrect';
$lang['is_valid_time'] = "Time format is incorrect.";


// e-mail greetings
$lang['email_not_found'] = 'E-mail address not found.';
$lang['email_greeting'] = 'Hello';

// access
$lang['no_access'] = 'Access denied';
$lang['no_access_view'] = 'You are not authorized to view this page.';
$lang['no_access_add_record'] = 'You are not authorized to add new record.';
$lang['no_access_view_record'] = 'You are not authorized to add this record.';
$lang['no_access_edit_record'] = 'You are not authorized to edit this record.';
$lang['no_access_delete_record'] = 'You are not authorized to delete this record.';

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
$lang['message_success_heading'] = "Success!!";

// adminpanel
$lang['enter_search_data'] = 'Please enter some search data.';
$lang['admin_noban'] = 'Not allowed to ban main administrator account.';
$lang['admin_noactivate'] = 'Not allowed to deactivate main administrator account.';
$lang['member_updated'] = 'Member with username %s updated.';
$lang['toggle_ban'] = "Member with username %s ";
$lang['toggle_active'] = "Member with username %s ";
$lang['main_not_found'] = 'Theme file not found: %s.';
$lang['controller_not_found'] = 'Controller %s.php not found.';
$lang['settings_update'] = 'Settings successfully updated.';
$lang['sessions_cleared'] = 'Session successfully deleted.';
$lang['sessions_not_cleared'] = 'Nothing to clear.';
$lang['banned'] = "banned.";
$lang['unbanned'] = "unbanned.";
$lang['activated'] = "activated.";
$lang['deactivated'] = "deactivated.";
$lang['site_disabled'] = 'Site has been disabled.';
$lang['add_member'] = 'Add member';
$lang['add_user'] = 'Add user';
$lang['member_detail'] = 'Member detail';
$lang['backup_and_export'] = 'Backup & export';
$lang['dashboard'] = 'Dashboard';
$lang['export_e-mail_text_title'] = 'Members list';
$lang['backup_e-mail_text_title'] = 'Database backup';
$lang['backup_e-mail_text'] = "The database file is attached as zip file.";
$lang['export_title'] = "Export members list";
$lang['backup_title'] = "Backup your database";
$lang['id'] = "ID";
$lang['follow_up'] = "Follow up";
$lang['follow_up_by'] = "Follow up by";
$lang['search'] = "Search";
$lang['search_member'] = "Search member";
$lang['search_user'] = "Search User";
$lang['search_record'] = "Search Record";
$lang['edit_record'] = "Edit Record";

$lang['submit_by'] = "Submit by";
$lang['submit_time'] = "Submit time";
$lang['submit_time_from'] = "Submit time (From)";
$lang['submit_time_to'] = "Submit time (To)";
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
$lang['add_new'] = 'Add New';
$lang['product'] = 'Product';
$lang['provider_subtitle'] = 'The name must be exactly the same as the provider for example "Google", not "google+".';
$lang['provider_delete'] = 'Delete';
$lang['provider_save'] = 'Save';
$lang['provider_name'] = 'Name';
$lang['provider_client_id'] = 'Client ID';
$lang['provider_client_secret'] = 'Client secret';
$lang['provider_success_add'] = 'New provider added.';
$lang['membership_edited'] = "Your account has been edited by us, please visit your profile to view the changes. In case we have changed your password you will not be able to log on: in that case, use the reset password procedure. \r\n Kind regards - the admin";
$lang['membership_edited_subject'] = 'Your account info was changed';
$lang['search_shift_report'] = 'Search Shift Report';
$lang['search_time_sheet'] = 'Search time sheet';
$lang['search_question_content'] = 'Search Question Content';
$lang['search_question_type'] = 'Search Question Type';
$lang['shift_report'] = 'Shift Report';
$lang['shift_report_insert'] = 'Add shift report';
$lang['shift_report_edit'] = 'Edit shift report';
$lang['shift_report_follow_up'] = 'Follow up shift report';
$lang['shift_report_follow_up_insert'] = 'Insert follow up report';
$lang['total_shift_reports'] = 'Total shift reports';
$lang['total_follow_up_reports'] = 'Total follow up reports';
$lang['total_time_sheet'] = 'Total time sheets';
$lang['total_question_type'] = 'Total question types';
$lang['total_question_content'] = 'Total question contents';
$lang['information_update'] = 'Information Update';
$lang['time_sheet'] = 'Time Sheet';
$lang['time_sheet_insert'] = 'Insert time Sheet';
$lang['time_sheet_details'] = 'Time Sheet details';
$lang['question_type'] = 'Question Type';
$lang['question_type_insert'] = 'Add question Type';
$lang['question_type_edit'] = 'Edit question Type';
$lang['question_content'] = 'Question Content';
$lang['question_content_insert'] = 'Add question Content';
$lang['question_content_edit'] = 'Edit question Content';
$lang['submit_by'] = 'Submit by';
$lang['submit_time'] = 'Submit time';
$lang['player_name'] = 'Player name';
$lang['group'] = 'Group';
$lang['shift'] = 'Shift';
$lang['category'] = 'Category';
$lang['sub_category'] = 'Sub-Category';
$lang['finish_time'] = 'Finish time';
$lang['last_update_time'] = 'Last update time';
$lang['content'] = 'Content';
$lang['action'] = 'Action';
$lang['no_result'] = 'No results found.';
$lang['no_option'] = 'No option found.';
$lang['delete_success'] = 'Record delete successfully.';
$lang['delete_failure'] = 'Record fail to delete.';
$lang['insert_success'] = 'Record add successfully.';
$lang['insert_failure'] = 'Record fail to add.';
$lang['update_success'] = 'Record update successfully.';
$lang['update_failure'] = 'Record fail to update.';
$lang['invalid_data'] = 'Invalid data.';
$lang['invalid_post_data'] = 'Invalid post data.';
$lang['select'] = 'Please select';
$lang['back'] = 'Back';

// backup & export
$lang['backup_text'] = "This e-mail will be sent to the admin e-mail entered in site settings.";
$lang['backup_warning1'] = "WARNING 1: for very large databases this might not be possible and you will have to export directly from the MySQL command line.";
$lang['backup_warning2'] = "WARNING 2: you might want to take your MySQL server offline before backing up. Disable site login before doing this.";
$lang['members_export_success'] = 'The members export has been sent.';
$lang['members_export_failed'] = 'The members export has failed!';
$lang['database_export_success'] = 'The database export has been sent.';
$lang['database_export_failed'] = 'The database export has failed!';

// Settings
$lang['settings'] = "Settings";
$lang['system_settings'] = "System Settings";
$lang['shift_setting'] = "Shift Setting";
$lang['product_setting'] = "Product Setting";
$lang['edit_shift'] = "Edit Shift Setting";
$lang['edit_product'] = "Edit Product Setting";
$lang['add_product'] = "Add New Product";
$lang['shift'] = "Shift";
$lang['working_shift'] = "Working Shift";
$lang['working_hour'] = "Working Hour";
$lang['site_settings'] = 'Site settings';
$lang['reset'] = "Reset";
$lang['save'] = "Save";
$lang['product'] = "Product";
$lang['product_type'] = "Product Type";
$lang['saving'] = "Saving...";
$lang['resetting'] = "resetting...";
$lang['morning'] = "Morning";
$lang['afternoon'] = "Afternoon";
$lang['night'] = "Night";
$lang['remark'] = "Remark";
$lang['example'] = "Example: 12:00";
$lang['action'] = "Action";
$lang['number'] = "No";
$lang['system'] = "System";
$lang['site_language'] = "Site Language";
$lang['site_title'] = "Site Title";

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
$lang['active'] = "Active";
$lang['inactive'] = "Inactive";
$lang['role_name'] = "Role Name";
$lang['no_num'] = "No";
$lang['status'] = "Status";
$lang['add_role'] = "Add Role";
$lang['submit'] = "Submit";
$lang['cancel'] = "Cancel";
$lang['role'] = "Role";
$lang['permissions'] = "Permissions";
$lang['roles_permissions'] = "Roles & Permissions";
$lang['show_all'] = "Show All";

//Role Page error msg
$lang['deactivated_error'] = "This role is unable to inactive due to another user role exists";
$lang['existed_error'] = "Role existed";
$lang['add_success'] = "Role added successfully.";
$lang['unable_add'] = "Unable to add role";


//performance report
$lang['performance_report'] = "Performance Report";
$lang['daily_qa'] = "Daily QA";
$lang['monthly_qa'] = "Monthly QA";
$lang['ops_monthly'] = "OPS Monthly";
$lang['log_in_out'] = "Log In/Out";
$lang['qa_evaluation'] = "QA Evaluation";
$lang['operation_utilization'] = "Operation Utilization";
$lang['daily_qa'] = "Daily QA";
$lang['total_record'] = "Record No";
$lang['pending'] = "Pending";
$lang['import'] = "Import";
$lang['export'] = "Export";
$lang['template'] = "Template";
$lang['yes'] = "Yes";
$lang['no'] = "No";
$lang['quantity'] = "Quantity";
$lang['import_date'] = "Import Date";
$lang['import_by'] = "Import By";
$lang['update_date'] = "Update Date";
$lang['update_by'] = "Update By";
$lang['typing_test'] = "Typing Test";
$lang['monthly_assessment'] = "Monthly Assesssment";

//Heade
// $lang['logged_in'] = "Logged in as:";


//Roster management
$lang['roster'] = "Roster";
$lang['roster_search'] = "Search Roster";
$lang['roster_management'] = "Roster Management";
$lang['new_roster'] = "New Roster";
$lang['month'] = "Month";
$lang['monthly'] = "Monthly";
$lang['schedule'] = "Schedule";
$lang['week'] = "Week";
$lang['date'] = "date";
$lang['name'] = "Name";
$lang['designation'] = "Designation";
$lang['day_of_week_short']['sunday'] = "Sun";
$lang['day_of_week_short']['monday'] = "Mon";
$lang['day_of_week_short']['tuesday'] = "Tue";
$lang['day_of_week_short']['wednesday'] = "Wed";
$lang['day_of_week_short']['thursday'] = "Thu";
$lang['day_of_week_short']['friday'] = "Fri";
$lang['day_of_week_short']['saturday'] = "Sat";
$lang['day_of_week']['sunday'] = "Sunday";
$lang['day_of_week']['monday'] = "Monday";
$lang['day_of_week']['tuesday'] = "Tuesday";
$lang['day_of_week']['wednesday'] = "Wednesday";
$lang['day_of_week']['thursday'] = "Thursday";
$lang['day_of_week']['friday'] = "Friday";
$lang['day_of_week']['saturday'] = "Saturday";

//member details
$lang['user_details'] = "User Details";
$lang['user_profile'] = "User Profile";
$lang['user_ids'] = "User IDs";
$lang['leave_details'] = "Leave Details";
$lang['user_profile'] = "User Profile";

//others (buttons etc)
$lang['expand'] = "Expand";
$lang['collapse'] = "Collapse";
$lang['to'] = "To";

//Permissions
$lang['module_name'] = "Module Name";
$lang['add'] = "Add";
$lang['edit'] = "Edit";
$lang['delete'] = "Delete";
$lang['view'] = "View";

//Operation
$lang['operation'] = "Operation";
$lang['shift_report'] = "Shift Report";
$lang['information_update'] = "Information Update";
$lang['time_sheet'] = "Time Sheet";
$lang['question_type'] = "Question Type";
$lang['question_content'] = "Question Content";

//page 404
$lang['page_not_found'] = "Page Not Found";
$lang['error_404'] = "Error 404: page not found";
$lang['return_to_home'] = "Please click HERE to return to the home page.";