	<div class="panel panel-default" data-extra="<% post.extra %>" ng-hide="loading" ng-repeat="post in posts">
		<div class="panel-heading">
			<% post.title %>
			<a class="pull-right" href="<% post.url %>" target="_blank" rel="nofollow"><% post.source %></a>
			<div class="clearfix"></div>
		</div>
		<div class="panel-body">
			<div class="panel-text panel-text-short" ng-bind-html="post.content"></div>
			<div class="showmore-container" ng-if="post.content.length > 250">
				<a class="btn btn-default btn-block btn-showmore">Show More</a>
			</div>
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