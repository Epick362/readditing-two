	<div infinite-scroll="{{ $function or 'reddit.nextPage()' }}" infinite-scroll-disabled='reddit.busy' infinite-scroll-distance='1'>
		<div class="panel panel-default" ng-class="(post.nsfw) ? 'nsfw' : ''" ng-repeat="post in reddit.posts">
			<div class="upvote-wrapper hidden-sm hidden-xs" ng-if="post.author">
				<div class="upvote-container text-center">
					<!-- Upvote -->
					<div ng-if="post.likes == null || post.likes == false">
						<a href="" class="btn btn-upvote lg" ng-click="vote(post, 't3', 1)" analytics-on analytics-category="Upvote" analytics-label="Up"><i class="fa fa-arrow-up"></i></a>
					</div>
					<div ng-if="post.likes == true">
						<a href="" class="btn btn-upvote lg active" ng-click="vote(post, 't3', 0)" analytics-on analytics-category="Upvote" analytics-label="Un"><i class="fa fa-arrow-up"></i></a>
					</div>

					<!-- Downvote -->
					<div ng-if="post.likes == null || post.likes == true">
						<a href="" class="btn lg btn-downvote" ng-click="vote(post, 't3', -1)" analytics-on analytics-category="Downvote" analytics-label="Down"><i class="fa fa-arrow-down"></i></a>
					</div>
					<div ng-if="post.likes == false">
						<a href="" class="btn lg btn-downvote active" ng-click="vote(post, 't3', 0)" analytics-on analytics-category="Downvote" analytics-label="Un"><i class="fa fa-arrow-down"></i></a>
					</div>

					<p style="margin-top:5px"><% post.score %></p>

					<div>
					@if(Session::has('user'))
						<span ng-if="!post.saved">
							<a ng-click="save(post, 't3', 1)" class="btn btn-default btn-xs" href="" analytics-on analytics-category="Save">Save</a>
						</span>
						<span ng-if="post.saved">
							<a ng-click="save(post, 't3', 0)" class="btn btn-link btn-xs active" href="" analytics-on analytics-category="Unsave">Unsave</a>
						</span>
					@endif
					</div>
				</div>
			</div>
			<div class="panel-heading">
				<a class="title" href="{{ URL::to('r') }}/<% post.subreddit %>/comments/<% post.id %>" target="_blank"><% post.title %></a>
				<a class="pull-right" href="<% post.url %>" target="_blank" rel="nofollow"><% post.source %></a>
				<div class="clearfix"></div>
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
						<span ng-if="post.subreddit == channel">
							By 
							<a ng-href="{{ URL::to('u') }}/<% post.author %>">
								<% post.author %>
							</a> 
						</span>
						<span ng-if="post.subreddit != channel">
							<a href="{{ URL::to('r') }}/<% post.subreddit %>">
								<% post.subreddit %> 
							</a>
						</span>
					</div>
					<div class="col-xs-4 text-center">
						<a href="{{ URL::to('r') }}/<% post.subreddit %>/comments/<% post.id %>#comments" target="_blank" analytics-on analytics-category="Load Comments"><i class="fa fa-comment"></i> <% post.comments %> comments</a>
					</div>
					<div class="col-xs-4 text-right">
						<!--<span am-time-ago="post.created" am-preprocess="unix"></span> -->

						<!-- Facebook Share Button -->
						<a class="btn btn-share btn-sm facebook" analytics-on analytics-event="Share" analytics-category="Facebook" href="http://www.facebook.com/sharer/sharer.php?u={{ URL::to('r') }}/<% post.subreddit %>/comments/<% post.id %>&title=<% post.title %>" 
						onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-facebook"></i></a> 

						<!-- Twitter Share Button -->
						<a class="btn btn-share btn-sm twitter" analytics-on analytics-event="Share" analytics-category="Twitter" href="http://twitter.com/home?status=<% post.title %>+{{ URL::to('r') }}/<% post.subreddit %>/comments/<% post.id %>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-twitter"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div ng-show="reddit.busy">
		@include('partials.loading')
	</div>