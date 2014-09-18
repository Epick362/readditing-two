<div class="media-body">
	<div class="pull-right visible-lg visible-md"><small class="text-muted" am-time-ago="comment.created" am-preprocess="unix"></small></div>
	<h4 class="media-heading">
		<a href=""><% comment.author %></a> 
		@if(Session::has('user'))
			<a ng-if="!comment.liked" href="" class="btn btn-default btn-xs" ng-click="vote(comment, 't1', 1)"><i class="fa fa-arrow-up"></i> <% comment.score %></a>
			<a ng-if="comment.liked" href="" class="btn btn-link btn-xs active" ng-click="vote(comment, 't1', 0)"><i class="fa fa-arrow-up"></i> <% comment.score %></a>
		@else
			<small class="text-alternate"><i class="fa fa-arrow-up"></i> <% comment.score %></small>
		@endif
	</h4>
	<div class="clearfix"></div>
	<div ng-bind-html="comment.body"></div>
	@if(Session::has('user'))
	<div>
		<a href="" class="btn btn-link btn-xs" reply-form>Reply</a>
		<a ng-if="!comment.saved" href="" class="btn btn-link btn-xs" ng-click="save(comment, 't1', 1)">Save</a>
		<a ng-if="comment.saved" href="" class="btn btn-link btn-xs active" ng-click="save(comment, 't1', 0)">Unsave</a>
		<a class="btn btn-link btn-xs" href="https://www.reddit.com/gold?goldtype=gift&amp;months=1&amp;thing=t1_<% comment.id %>" target="_blank">Give Gold</a>
	</div>
	@endif
	<div class="replyForm"></div>
	<div class="form-group">
		<textarea class="form-control" rows="3"></textarea>
		<button class="btn btn-primary">Send</button>
	</div>
	<div ng-if="comment.replies.length > 0" class="media" ng-repeat="comment in comment.replies" ng-include="'comment.html'"></div>
</div>