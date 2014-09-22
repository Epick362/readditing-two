	<div infinite-scroll='reddit.nextPage()' infinite-scroll-disabled='reddit.busy' infinite-scroll-distance='1'>
		<div class="panel panel-default" ng-class="(post.nsfw) ? 'nsfw' : ''" data-extra="<% post.extra %>" ng-repeat="post in reddit.posts">
			<div class="upvote-wrapper" ng-if="post.author">
				<div class="upvote-container">
					<span ng-if="!post.likes">
						<a href="" class="btn btn-upvote lg" ng-click="vote(post, 't3', 1)"><i class="fa fa-arrow-up"></i></a>
					</span>
					<span ng-if="post.likes">
						<a href="" class="btn btn-upvote lg active" ng-click="vote(post, 't3', 0)"><i class="fa fa-arrow-up"></i></a>
					</span>
					<p class="text-center" ng-class="{'text-alernate': post.likes}" style="margin-top:5px"><% post.score %></p>
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
						<a href=""><% post.author %></a> in <a href="{{ URL::to('r') }}/<% post.subreddit %>"><% post.subreddit %></a> 
					</div>
					<div class="col-sm-4 text-center">
						<a href="" ng-click="comments(post)"><i class="fa fa-comment-o"></i> <% post.comments %> comments</a>
					</div>
					@if(Session::has('user'))
					<div class="col-sm-4 text-right">
						<span ng-if="!post.saved">
							<a ng-click="save(post, 't3', 1)" href=""><i class="fa fa-save"></i> Save</a>
						</span>
						<span ng-if="post.saved">
							<a ng-click="save(post, 't3', 0)" class="active" href=""><i class="fa fa-save"></i> Unsave</a>
						</span>
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