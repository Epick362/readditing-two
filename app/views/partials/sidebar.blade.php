<div class="sidebar">
	@yield('sidebar')

	@include('partials.popular')

	@include('ads.sidebar')

	<div class="panel panel-default">
		<div class="panel-heading">
			Donate
		</div>
		<div class="panel-body">
			<p>Please help me pay for server costs. Even a little helps.</p>
			<center>
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="JJ9RFDX4GMFM8">
				<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
				</form>
			</center>
		</div>
	</div>

	@include('partials.featured')

	<small class="text-muted">This site is not affiliated with <a href="https://reddit.com" target="_blank" rel="nofollow">reddit.com</a> in any way.</small>
</div>