	<div infinite-scroll="{{ $function or 'reddit.nextPage()' }}" infinite-scroll-disabled='reddit.busy' infinite-scroll-distance='1'>
		<div class="panel panel-default" ng-class="(post.nsfw) ? 'nsfw' : ''" ng-repeat="post in reddit.posts">
			<div class="upvote-wrapper hidden-sm hidden-xs" ng-if="post.author">
				<div class="upvote-container">
					<span ng-if="!post.likes">
						<a href="" class="btn btn-upvote lg" ng-click="vote(post, 't3', 1)" analytics-on analytics-category="Upvote" analytics-label="Up"><i class="fa fa-arrow-up"></i></a>
					</span>
					<span ng-if="post.likes">
						<a href="" class="btn btn-upvote lg active" ng-click="vote(post, 't3', 0)" analytics-on analytics-category="Upvote" analytics-label="Un"><i class="fa fa-arrow-up"></i></a>
					</span>
					<p class="text-center" ng-class="{'text-alternate': post.likes}" style="margin-top:5px"><% post.score %></p>
				</div>
			</div>
			<div class="panel-heading">
				<a class="title" href="{{ URL::to('r') }}/<% post.subreddit %>/comments/<% post.id %>"><% post.title %></a>
			</div>
			<div ng-show="post.nsfw && !nsfw" class="panel-body">
				<a href="" ng-click="setNSFW()" class="nsfw" analytics-on analytics-category="NSFW" analytics-label="Turn on">
					<div class="title">&nbsp;NSFW</div>
					Click to show
				</a>
			</div>
			<div ng-show="!post.nsfw || nsfw" class="panel-body" show-more ng-bind-html="post.content">

			</div>
			<div class="panel-body hidden-lg hidden-md" ng-if="post.author">
				<div class="row">
					<div class="col-xs-12 text-center">
						@if(Session::has('user'))
						<span ng-if="!post.likes">
							<a href="" class="btn btn-upvote btn-xs" ng-click="vote(post, 't3', 1)" analytics-on analytics-category="Upvote" analytics-label="Up"><i class="fa fa-arrow-up"></i></a>
							<small class="text-alternate"><% post.score %> upvotes</small>
						</span>
						<span ng-if="post.likes">
							<a href="" class="btn btn-upvote btn-xs active" ng-click="vote(post, 't3', 0)" analytics-on analytics-category="Upvote" analytics-label="Un"><i class="fa fa-arrow-up"></i></a>
							<small class="text-alternate"><% post.score %> upvotes</small>
						</span>		
						@else	
							<small class="text-alternate"><i class="fa fa-arrow-up"></i> <% post.score %> upvotes</small>
						@endif
					</div>
				</div>
			</div>
			<div class="panel-footer" ng-if="post.author">
				<div class="row">
					<div class="col-xs-4">
						<a ng-href="{{ URL::to('u') }}/<% post.author %>">
							<% post.author %>
						</a> 
						<span am-time-ago="post.created" am-preprocess="unix"></span>
					</div>
					<div class="col-xs-4 text-center">
						<a href="" ng-click="comments(post)" analytics-on analytics-category="Load Comments"><i class="fa fa-comment-o"></i> <% post.comments %> comments</a>
					</div>
					<div class="col-xs-4 text-right">
						@if(Session::has('user'))
							<span ng-if="!post.saved">
								<a ng-click="save(post, 't3', 1)" href="" analytics-on analytics-category="Save"><i class="fa fa-save"></i> Save</a>
							</span>
							<span ng-if="post.saved">
								<a ng-click="save(post, 't3', 0)" class="active" href="" analytics-on analytics-category="Unsave"><i class="fa fa-save"></i> Unsave</a>
							</span>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- LOADING =============================================== -->
	<div class="spinner" ng-show="reddit.busy">
		<div class="bounce1"></div>
		<div class="bounce2"></div>
	</div>