<div class="media-body">
	<div class="pull-right visible-lg visible-md"><small class="text-muted" am-time-ago="comment.created" am-preprocess="unix"></small></div>
	<h4 class="media-heading">
		<a ng-class="{'active': post.author == comment.author}" ng-href="{{ URL::to('') }}/u/<% comment.author %>"><% comment.author %></a> 
		@if(Session::has('user'))
			<span ng-if="!comment.likes">
				<a href="" class="btn btn-upvote btn-xs" ng-click="vote(comment, 't1', 1)" analytics-on analytics-event="Upvote - comment"><i class="fa fa-arrow-up"></i></a>
				<small class="text-alternate"><% comment.score %></small>
			</span>
			<span ng-if="comment.likes">
				<a href="" class="btn btn-upvote btn-xs active" ng-click="vote(comment, 't1', 0)" analytics-on analytics-event="UnUpvote - comment"><i class="fa fa-arrow-up"></i></a>
				<small class="text-alternate"><% comment.score %></small>
			</span>
		@else
			<small class="text-alternate"><i class="fa fa-arrow-up"></i> <% comment.score %></small>
		@endif
	</h4>
	<div class="clearfix"></div>
	<div ng-bind-html="comment.body"></div>
	@if(Session::has('user'))
	<div ng-if="comment.id">
		<a href="" class="btn btn-link btn-xs" reply-form analytics-on>Reply</a>
		<a ng-if="!comment.saved" href="" class="btn btn-link btn-xs" ng-click="save(comment, 't1', 1)" analytics-on analytics-event="Save - comment">Save</a>
		<a ng-if="comment.saved" href="" class="btn btn-link btn-xs active" ng-click="save(comment, 't1', 0)" analytics-on analytics-event="Unsave - comment">Unsave</a>
		<a class="btn btn-link btn-xs" href="https://www.reddit.com/gold?goldtype=gift&amp;months=1&amp;thing=t1_<% comment.id %>" target="_blank">Give Gold</a>
	</div>
	@endif
	<div class="replyForm"></div>
	<div class="media" ng-repeat="comment in comment.replies" ng-include="'comment.html'"></div>
</div>