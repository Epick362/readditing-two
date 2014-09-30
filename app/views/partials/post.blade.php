	<div infinite-scroll="{{ $function or 'reddit.nextPage()' }}" infinite-scroll-disabled='reddit.busy' infinite-scroll-distance='1'>
		<div class="panel panel-default" ng-class="(post.nsfw) ? 'nsfw' : ''" ng-repeat="post in reddit.posts">
			<div class="upvote-wrapper" ng-if="post.author">
				<div class="upvote-container">
					<span ng-if="!post.likes">
						<a href="" class="btn btn-upvote lg" ng-click="vote(post, 't3', 1)" analytics-on analytics-event="Upvote"><i class="fa fa-arrow-up"></i></a>
					</span>
					<span ng-if="post.likes">
						<a href="" class="btn btn-upvote lg active" ng-click="vote(post, 't3', 0)" analytics-on analytics-event="UnUpvote"><i class="fa fa-arrow-up"></i></a>
					</span>
					<p class="text-center" ng-class="{'text-alternate': post.likes}" style="margin-top:5px"><% post.score %></p>
				</div>
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
						<a ng-href="{{ URL::to('u') }}/<% post.author %>"><% post.author %></a> in <a href="{{ URL::to('r') }}/<% post.subreddit %>"><% post.subreddit %></a> 
					</div>
					<div class="col-sm-4 text-center">
						<a href="" ng-click="comments(post)"><i class="fa fa-comment-o"></i> <% post.comments %> comments</a>
					</div>
					<div class="col-sm-4 text-right">
						@if(Session::has('user'))
							<span ng-if="!post.saved">
								<a ng-click="save(post, 't3', 1)" href="" analytics-on analytics-event="Save"><i class="fa fa-save"></i> Save</a>
							</span>
							<span ng-if="post.saved">
								<a ng-click="save(post, 't3', 0)" class="active" href="" analytics-on analytics-event="Unsave"><i class="fa fa-save"></i> Unsave</a>
							</span>
						@endif
						<span>
							<a href="{{ URL::to('r') }}/<% post.subreddit %>/comments/<% post.id %>"><i class="fa fa-share"></i> Permalink</a>
						</span>
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