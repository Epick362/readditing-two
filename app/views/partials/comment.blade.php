<div ng-controller="CollapseController" class="media-body clearfix">
	<div class="pull-right visible-lg visible-md"><small class="text-muted" am-time-ago="comment.created" am-preprocess="unix"></small></div>

	<h4 class="media-heading">
		<!-- Hiding comments -->
		<a ng-show="!isCollapsed" ng-click="isCollapsed = !isCollapsed" href=""><i class="fa fa-caret-up"></i></a>
		<a ng-show="isCollapsed" ng-click="isCollapsed = !isCollapsed" href=""><i class="fa fa-caret-down"></i></a>

		<!-- Author, score -->
		<a ng-class="{'active': post.author == comment.author}" ng-href="{{ URL::to('') }}/u/<% comment.author %>"><% comment.author %></a> 
		@if(Session::has('user'))
			<span ng-if="!comment.likes">
				<a href="" class="btn btn-upvote btn-xs" ng-click="vote(comment, 't1', 1)" analytics-on analytics-category="Upvote Comment" analytics-label="Up"><i class="fa fa-arrow-up"></i></a>
				<small class="text-alternate"><% comment.score %></small>
			</span>
			<span ng-if="comment.likes">
				<a href="" class="btn btn-upvote btn-xs active" ng-click="vote(comment, 't1', 0)" analytics-on analytics-category="Upvote Comment" analytics-label="Un"><i class="fa fa-arrow-up"></i></a>
				<small class="text-alternate"><% comment.score %></small>
			</span>
		@else
			<small class="text-alternate"><i class="fa fa-arrow-up"></i> <% comment.score %></small>
		@endif
	</h4>

	<!-- Comment content -->
	<div collapse="isCollapsed" ng-bind-html="comment.body"></div>

	<!-- Comment Actions -->
	@if(Session::has('user'))
	<div collapse="isCollapsed" ng-if="comment.id">
		<a href="" class="btn btn-link btn-xs" reply-form analytics-on>Reply</a>
		<a ng-if="!comment.saved" href="" class="btn btn-link btn-xs" ng-click="save(comment, 't1', 1)" analytics-on analytics-category="Save Comment">Save</a>
		<a ng-if="comment.saved" href="" class="btn btn-link btn-xs active" ng-click="save(comment, 't1', 0)" analytics-on analytics-category="Unsave Comment">Unsave</a>
		<a class="btn btn-link btn-xs" href="https://www.reddit.com/gold?goldtype=gift&amp;months=1&amp;thing=t1_<% comment.id %>" target="_blank">Give Gold</a>
	</div>
	@endif

	<div collapse="isCollapsed" class="replyForm"></div>

	<!-- Comment Replies -->
	<div collapse="isCollapsed" class="media" ng-repeat="comment in comment.replies" ng-include="'comment.html'"></div>
</div>