<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div align="center" style="padding-top: 100px;">
	<div align="center" class="disco_cat">
		<table>
			<tr>
				<td><div align="center"><img src="<?php print base_url(); ?>assets/img/daftpunktocat-thomas.gif" style="height:150px;"></div></td>
				<td>
					<div id="error">
					    <div class="alert" align="center">
					        <h3 style="color:#DC2828;"><span class="fa fa-warning"></span>&nbsp;&nbsp;<?php print $this->lang->line('no_access'); ?></h3>
					        <p><?php print $this->lang->line('no_access_view'); ?></p>
					    </div>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>
