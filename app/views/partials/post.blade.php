	<div infinite-scroll='reddit.nextPage()' infinite-scroll-disabled='reddit.busy' infinite-scroll-distance='1'>
		<div class="panel panel-default" data-extra="<% post.extra %>" ng-repeat="post in reddit.posts">
			<div class="upvote-wrapper">
				<div 
					og-kudos 
					og-kudos-logged="{{ Session::has('user') ? '1' : '' }}" 
					og-kudos-complete="<% post.likes %>" 
					og-kudos-id="<% post.id %>" 
					og-kudos-count="<% post.ups %>" 
					og-kudos-done="vote(post.id, 1)" 
					og-kudos-undone="vote(post.id, 0)"
				></div>
			</div>
			<div class="panel-heading">
				<% post.title %>
				<a class="pull-right" href="<% post.url %>" target="_blank" rel="nofollow"><% post.source %></a>
				<div class="clearfix"></div>
			</div>
			<div class="panel-body" show-more ng-bind-html="post.content">
			</div>
			<div class="panel-footer" ng-if="post.author">
				<div class="row">
					<div class="col-sm-4">
						<a href=""><% post.author %></a> in <a href="{{ URL::to('r') }}/<% post.subreddit %>"><% post.subreddit %></a> 
					</div>
					<div class="col-sm-4 text-center">
						<a href="#" class="btn-showcomments"><i class="fa fa-comment-o"></i> <% post.comments %> comments</a>
					</div>
					@if(Session::has('user'))
					<div class="col-sm-4 text-right">
						<a href="" tooltip="Save"><i class="fa fa-save"></i></a>
						<a href="" tooltip="Report"><i class="fa fa-flag"></i></a>
						<a href="" tooltip="Hide"><i class="fa fa-eye"></i></a>		
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>


	<!-- LOADING =============================================== -->
	<div class="loading" ng-show="reddit.busy">
		<div class="ball-outer"></div>
		<div class="ball-inner"></div>
	</div>