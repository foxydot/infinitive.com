<div id="breadcrumbs">
	<div class="breadcrumbs">
	<?php
	if(function_exists('bcn_display'))
	{
	    $bcn = bcn_display(TRUE);
        if('msd_casestudy' == get_post_type() || is_tax('msd_practice-area')){
            $bcn = preg_replace('| &gt; <a title="Go to Blog." href="http://(.*?)/blog/">Blog</a>|i', '', $bcn);
        }
        print $bcn;
	}
	?>
	</div>
	<div class="functions">
		<ul>
			<li class="share st_sharethis_custom" displayText="Share">Share</li>
			<li class="print">Print</li>
			<li class="email">Email</li>
		</ul>
	</div>
</div>
<div class="clear"></div>