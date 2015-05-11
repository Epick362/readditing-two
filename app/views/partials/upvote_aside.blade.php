<div class="upvote-wrapper ng-cloak hidden-sm hidden-xs" ng-if="post.author">
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