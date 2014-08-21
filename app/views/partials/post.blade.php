	<div infinite-scroll='reddit.nextPage()' infinite-scroll-disabled='reddit.busy' infinite-scroll-distance='1'>
		<div class="panel panel-default" show-more data-extra="<% post.extra %>" ng-repeat="post in reddit.posts">
			<div class="panel-heading">
				<% post.title %>
				<a class="pull-right" href="<% post.url %>" target="_blank" rel="nofollow"><% post.source %></a>
				<div class="clearfix"></div>
			</div>
			<div class="panel-body" ng-bind-html="post.content">
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-4">
						<a href="#"><% post.author %></a> in <a href="#"><% post.subreddit %></a> 
					</div>
					<div class="col-sm-4 text-center">
						<a href="#" class="btn-showcomments"><i class="fa fa-comment-o"></i> <% post.comments %> comments</a>
					</div>
					<div class="col-sm-4 text-right">
					@if(Session::has('user'))
						<a href="#" class="btn-postAction" data-toggle="tooltip" data-action="save" title="Save"><i class="fa fa-save"></i></a>
						<a href="#" class="btn-postAction" data-toggle="tooltip" data-action="report" title="Report"><i class="fa fa-flag"></i></a>
						<a href="#" class="btn-postAction" data-toggle="tooltip" data-action="hide" title="Hide"><i class="fa fa-eye"></i></a>
					@endif
						<a href="#" data-toggle="tooltip" data-placement="top" title="Tweet this"><i class="fa fa-twitter"></i></a>
						<a href="#" data-toggle="tooltip" data-placement="top" title="+ this"><i class="fa fa-google-plus"></i></a>
						<a href="#" data-toggle="tooltip" data-placement="top" title="Like this"><i class="fa fa-facebook"></i></a>					
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- LOADING =============================================== -->
	<div class="loading" ng-show="reddit.busy">
		<div class="ball-outer"></div>
		<div class="ball-inner"></div>
	</div>